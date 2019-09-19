var FilesView = Backbone.View.extend({
    template: 'files-template',
    collection: undefined,

    events: {
        "click .upload-file": "uploadFile",
        "click .create-folder": "createFolder",
        "click .fm-refresh": "fmRefresh",
        "click .delete-file": "deleteFile"
    },
    initialize: function (options) {
        this.model = new FilesModel(options);
        if (this.model) {
            this.listenTo(this.model, 'change', this.render);
            this.listenTo(this.model, 'sync', this.render);
            //            if (this.model.get('name') !== "") {
            this.model.fetch();
            //            }
        }
    },
    render: function () {
        TemplateManager.render(this, this.template, this.model.toJSON(), function (context, template, data) {
            PluginsManager.iCheckBtnAll(context);
            context.collection = new FileCollection(data.files);
            var index = 0;
            var filePath = context.model.get('filePath');
            var filePathMin = context.model.get('filePathMin');

            context.collection.each(function (item) {
                item.set('real_file_path', item.get('file_name'));
                if (filePath) {
                    item.set('real_file_path', filePath + item.get('file_name'));
                }

                if (item.get('type').makepreview > 0 && filePathMin) {
                    item.set('default_preview', filePathMin + item.get('file_name'));
                }
                var container = $('.object-container', context.$el);
                var view = new FileView({ model: item });
                view.render();
                container.append(view.el);

                //Подпись на события связанных с действиями над одним файлом. 
                //И если эти события должны приводит к изменению коллекции, то изменять коллекцию
                context.listenTo(view, 'fm-click', function (file) {
                    if (file.isfolder == 1) {
                        if (window.fmApp && window.fmApp.historyEnable && window.fmRouter) {
                            window.fmRouter.navigate("" + file.id, { trigger: true });
                        } else {
                            context.model.set("id", file.id);
                            this.model.fetch();
                        }
                    }
                });
            });
            context.listenTo(context.collection, 'change sort remove', function () {
                context.model.set("files", [], { silent: true });
                context.model.set("files", context.collection.toJSON(), { silent: true });
                context.render();
            });

        });
        return this;
    },
    fmRefresh: function () {
        this.model.fetch();
    },
    createFolder: function () {
        var context = this;

        var view = new FolderNameModal({
            parentView: context, model: new FileModel({
                parent: context.model.get("id"),
                name: "",
                type: "1",
                isfolder: "1",
                description: ""
            })
        });
        Utils.showSimpleModalBackboneView(view, "Укажите имя папки", function () {
            view.save();
        }, null, { dialogClass: "", cancelText: "Отмена", allowCancel: true });
    },
    deleteFile: function () {
        var context = this;
        if (context.$("input[type='checkbox']:checked").length) {
            swal({
                title: "Удалить?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Да, удалить!",
                cancelButtonText: "Отмена"
            },
                function () {
                    context.$("input[type='checkbox']:checked").closest("td").each(function (idx, el) {
                        var deletedFileId = $(el).data("id");
                        if (deletedFileId) {
                            var file = context.collection.get(deletedFileId);
                            if (file) {
                                file.destroy({
                                    success: function (model, response, options) {
                                        if (response.error) {
                                            alert('Ошибка удаления объекта "' + file.get('name') + '". ' + response.error);
                                        } else {
                                            context.collection.remove(file);
                                        }
                                    },
                                    error: function (model, xhr, options) {
                                        alert('Ошибка удаления объекта "' + file.get('name') + '"');
                                    }
                                });

                            }
                        }
                    });
                });
        }
    },
    uploadFile: function () {                   //Загрузка файла
        var context = this;
        //Максимальный допустимый размер загружаемого файла в байтах

        var uploadMaxFilesize = this.model.get("uploadMaxFilesize");
        var uploadMaxFilesizeByte = uploadMaxFilesize.toUpperCase();

        if (uploadMaxFilesizeByte && Number.parseInt(uploadMaxFilesizeByte)) {
            if (uploadMaxFilesizeByte.indexOf('K') > 0) {
                uploadMaxFilesizeByte = Number.parseInt(uploadMaxFilesizeByte) * 1024;
            } else if (uploadMaxFilesizeByte.indexOf('M') > 0) {
                uploadMaxFilesizeByte = Number.parseInt(uploadMaxFilesizeByte) * 1024 * 1024;
            } else if (uploadMaxFilesizeByte.indexOf('G') > 0) {
                uploadMaxFilesizeByte = Number.parseInt(uploadMaxFilesizeByte) * 1024 * 1024 * 1024;
            } else if (uploadMaxFilesizeByte.indexOf('T') > 0) {
                uploadMaxFilesizeByte = Number.parseInt(uploadMaxFilesizeByte) * 1024 * 1024 * 1024 * 1024;
            } else {

            }
        } else {
            uploadMaxFilesizeByte = undefined;
        }

        var mediaType = this.model.get("mediaType");
        var mediaTypeStr = '';

        if (mediaType && mediaType.length) {
            for (var i = 0; i < mediaType.length; i++) {
                if (mediaType[i]['name']) {
                    if (!mediaTypeStr) {
                        mediaTypeStr = mediaType[i]['name'];
                    } else {
                        mediaTypeStr += ', ' + mediaType[i]['name'];
                    }
                }
            }
        }

        //Разметка модального окна
        var dialog = $('#upload-files-tmpl').tmpl();

        //Обработчик кнопки отмена 
        $('a.btn.btn-success:contains(Готово)', dialog).click(function () {
            dialog.modal('toggle');
            return false;
        });

        //Вызов диалога выбора файлов 
        $('.a-upload-file', dialog).click(function () {
            try {
                //Очистка содержимого элемента file путем его замены клонированным элементом
                $('#input-upload-file', dialog).replaceWith($('#input-upload-file', dialog).clone(true));

                $('#input-upload-file', dialog).click();
            } catch (e) {

            }

            return false;
        });

        //Возвращает миниатюру для файла
        function getPreviewImage(file) {
            if (!file) {
                return;
            }
            try {
                var previewHeight = 40;
                //Если file является изображением, то показываем миниатюру 
                if (!!file.type.match(/image.*/)) {
                    if (window.FileReader && window.Image) {
                        var reader = new FileReader();
                        var cv = document.createElement("canvas");
                        if (cv.getContext) {
                            var cvContext = cv.getContext("2d");
                            var im = new Image();
                            im.height = previewHeight;

                            reader.onload = function (e) {

                                im.onload = function (e) {
                                    cv.width = 100;
                                    cv.height = 100;

                                    cvContext.drawImage(im, 0, 0, 100, 100);
                                }
                                im.src = reader.result;

                            };

                            reader.readAsDataURL(file);

                            return im;
                        }
                    }
                } else if (!!file.type.match(/video.*/)) {
                    //                    if (window.FileReader) {
                    //                        var reader = new FileReader();
                    //                        var videoEl = $('<video height=180 controls=""></video>');
                    //
                    //                        if (videoEl) {
                    //
                    //                            reader.onload = function (e) {
                    //                                videoEl.attr('src', reader.result);
                    //                            };
                    //
                    //                            reader.readAsDataURL(file);
                    //
                    //                            return videoEl;
                    //                        }
                    //                    }

                    return '<img height=' + previewHeight + ' src="/vendor/control-panel/dist/img/PNG/Documents/Grey/Stroke/@2x/icon-54-document@2x.png">';
                } else {
                    //Если файл не является изображением или видео, то устанавливаем иконку из массива mediaType 
                    if (file.name) {
                        var fname = file.name.toLowerCase();
                        for (var k = 0; k < mediaType.length; k++) {
                            if (mediaType[k] && mediaType[k].name && mediaType[k].src) {
                                if (fname.endsWith('.' + mediaType[k].name)) {
                                    return '<img height=' + previewHeight + ' src="' + mediaType[k].src + '">';
                                }
                            }
                        }
                        return '<img height=' + previewHeight + ' src="/vendor/control-panel/dist/img/PNG/Documents/Grey/Stroke/@2x/icon-54-document@2x.png">';
                    }

                }
            } catch (e) {

            }
        }

        //Возвращает размер в кб,мб,гб... из размера в байтах
        function getSizeFromByte(size) {
            if (size) {
                size = size / 1024;
                var decimal = 10;
                size = Math.round(size * decimal) / decimal;

                var str = 'KB';

                if (size / 1024 > 1) {
                    size /= 1024;
                    size = Math.round(size * decimal) / decimal;
                    str = 'MB';
                }

                if (size / 1024 > 1) {
                    size /= 1024;
                    size = Math.round(size * decimal) / decimal;
                    str = 'GB';
                }

                if (size / 1024 > 1) {
                    size /= 1024;
                    size = Math.round(size * decimal) / decimal;
                    str = 'TB';
                }
            } else {
                size = 0;
                str = 'KB';
            }

            return { size: size, str: size + ' ' + str };

        }

        $('#input-upload-file', dialog).change(function () {
            var data = [];
            if (this.files && this.files.length) {
                for (var i = 0; i < this.files.length; i++) {
                    var file = this.files[i];

                    if (file) {
                        try {
                            var preview = getPreviewImage(file);
                        } catch (e) {

                        }

                        var size = getSizeFromByte(file.size);

                        data.push({
                            file: file,
                            name: file.name,
                            size: file.size,
                            csize: size.str,
                            type: file.type,
                            preview: preview
                        });
                    }

                }
            }

            if (data && data.length) {
                //Заполенеие таблицы и установка миниатюр
                $('tbody.files', dialog).append($('#tr-file-tmpl').tmpl(data).each(function (index, item) {
                    if (data && data[index] && data[index].preview) {
                        $('.preview', this).html(data[index].preview);
                    }

                    //Прогресс загрузки файла
                    data[index].progress = $('.progress', this);
                    //Сообщение об ошибке
                    data[index].error = $('.td-upload-error', this);
                    //Флаг успешной загрузки файла
                    data[index].check = $('.td-upload-check', this);
                    //Кнопка отмены загрузки файла
                    data[index].cancel = $('.cancel', this);
                    //Кнопка перезагрузки файла
                    data[index].reload = $('.reload', this);
                }));

                //Отправляем файлы на сервер
                for (var t = 0; t < data.length; t++) {
                    sendFile(data[t]);
                }

            }
        });

        function isValid(data) {
            if (!data || !data.file || !data.file.name) {
                return {
                    result: false,
                    message: 'Недопустимый файл'
                };
            }

            if (uploadMaxFilesizeByte && data.file.size > uploadMaxFilesizeByte) {
                return {
                    result: false,
                    message: 'Максимальный размер для файла ' + data.file.name +
                        ' составляет ' + getSizeFromByte(uploadMaxFilesizeByte).str +
                        '. На данный момент его размер ' + getSizeFromByte(data.file.size).str
                };
            }

            var isExt = false;
            var fname = data.file.name.toLowerCase();
            for (var j = 0; j < mediaType.length; j++) {
                if (mediaType[j] && mediaType[j].name) {
                    if (fname.endsWith('.' + mediaType[j].name)) {
                        isExt = true;
                        break;
                    }
                }
            }

            if (!isExt) {
                return {
                    result: false,
                    message: 'Недопустимый тип файла ' + data.file.name + '. Загружать можно только ' + mediaTypeStr
                };
            }

        }

        function printErrorMessage(data, message) {
            if (!data) {
                return;
            }
            if (data.progress) {
                $(data.progress).css('display', 'none');
            }

            if (data.check) {
                $(data.check).css('display', 'none');
            }

            if (data.error) {
                $(data.error).css('display', 'block').html(message);
            }

            if (data.cancel) {
                $(data.cancel).css('display', 'none');
            }

            if (data.reload) {
                $(data.reload).css('display', 'none');
            }
        }

        function sendFile(data) {
            if (!data || !data.file) {
                return;
            }

            var isvalid = isValid(data);
            if (isvalid && isvalid.result === false) {
                printErrorMessage(data, isvalid.message);
                return;
            }

            $(data.reload).unbind();
            $(data.cancel).unbind();

            var file = data.file;

            if (data.progress) {
                var progressBar = $('.progress-bar', data.progress);
            }

            var formData = new FormData();
            formData.append("file", file);
            var jxhr = $.ajax({
                url: '/control/files/upload/' + context.model.get("id"),
                type: 'POST',
                dataType: "json",
                xhr: function () {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // Check if upload property exists
                        myXhr.upload.addEventListener('progress',
                            function progressHandlingFunction(e) {
                                if (e.lengthComputable) {
                                    if (e.total) {
                                        var curr = (e.loaded / e.total) * 100;
                                        if (progressBar) {
                                            $(progressBar).css('width', curr + '%').html(Number.parseInt(curr) + '%');
                                        }
                                    }
                                }
                            },
                            false);
                    }
                    return myXhr;
                },
                //Ajax events
                beforeSend: function () {
                    //console.log('beforeSend', arguments);
                },
                success: function (res) {
                    if (res && res.message) {
                        printErrorMessage(data, res.message);
                    } else {
                        if (data.progress) {
                            $(data.progress).css('display', 'none');
                        }

                        if (data.error) {
                            $(data.error).css('display', 'none');
                        }

                        if (data.check) {
                            $(data.check).css('display', 'block');
                        }

                        if (data.reload) {
                            $(data.reload).css('display', 'none');
                        }

                        if (data.cancel) {
                            $(data.cancel).css('display', 'none');
                        }
                    }
                },
                error: function (res) {
                    if (data.progress) {
                        $(data.progress).css('display', 'none');
                    }

                    if (data.check) {
                        $(data.check).css('display', 'none');
                    }

                    if (data.error) {
                        $(data.error).css('display', 'block').html('Ошибка выполнения запроса или отменено пользователем');
                    }

                    if (data.cancel) {
                        $(data.cancel).css('display', 'none');
                    }

                    if (data.reload) {
                        $(data.reload).css('display', 'inline');
                    }
                },
                // Form data
                data: formData,
                //Options to tell jQuery not to process data or worry about content-type.
                cache: false,
                contentType: false,
                processData: false
            });
            //Обработчик кнопки "reload"
            if (data.reload) {
                $(data.reload).click(function () {
                    try {
                        if (data.progress) {
                            $('.progress-bar', data.progress).css('width', '0%');
                            $(data.progress).css('display', 'block');
                        }

                        if (data.check) {
                            $(data.check).css('display', 'none');
                        }

                        if (data.error) {
                            $(data.error).css('display', 'none');
                        }

                        if (data.cancel) {
                            $(data.cancel).css('display', 'inline');
                        }

                        if (data.reload) {
                            $(data.reload).css('display', 'none');
                        }

                        sendFile(data);
                    } catch (e) {

                    }

                    return false;
                });

            }

            //Обработчик кнопки "Отмена" загрузки файла
            if (data.cancel) {
                $(data.cancel).click(function () {
                    try {
                        if (jxhr) {
                            jxhr.abort();
                        }

                    } catch (e) {

                    }

                    return false;
                });

            }
        }
        //Удаление данных диалога, после закрытия
        dialog.on('hidden.bs.modal', function () {

            dialog.remove();

            context.model.fetch();
        });
        //Показываем модальное окно
        dialog.modal('show');
        return false;
    }
});
