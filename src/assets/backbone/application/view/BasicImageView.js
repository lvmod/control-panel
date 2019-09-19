var BasicImageView = Backbone.View.extend({
    template: 'basic-image-template',
    collection: undefined,
    options: undefined,
    events: {
        "click .multimedia-add": "multimediaAdd",
        "click .multimedia-remove": "multimediaRemove",
    },
    initialize: function (options) {
        this.$el = this.$el || $(".article-files-box");
        this.options = options || {};

        this.model = new ImageFileModel({id: this.options.id});
        if (this.model.id) {
            this.listenTo(this.model, 'change', this.render);
            this.listenTo(this.model, 'sync', this.render);
            this.model.fetch();
        }

        this.render();
    },
    render: function () {
        TemplateManager.render(this, this.template, { image: this.model.toJSON() }, function (context, template, data) {
            
        });
        return this;
    },
    fmRefresh: function () {
        this.model.fetch();
    },
    multimediaAdd: function () {
        var context = this;
        var fm = new FileManagerDialogView({id: "0"});

        // showFileManagerObjectDialog(function (files) {
        //     var articleId = Utils.getObjectValue(context, "options.id");
        //     var table = Utils.getObjectValue(context, "options.table");
        //     if (!Utils.getObjectValue(files, 'length') || !articleId || !table) {
        //         console.error("Ошибка добаления файлов к статье");
        //         return;
        //     }

        //     //Извлекаем наибольший индекс сортировки
        //     var data = context.model.get("data");
        //     var dataLength = Utils.getObjectValue(data, 'length');
        //     var order_idx = 0;
        //     if (dataLength) {
        //         order_idx = data[data.length - 1].order_idx || 0;
        //     }


        //     //Подготавливаем массив файлов для отправки на сервер
        //     var sendFiles = [];
        //     for (var i = 0; i < files.length; i++) {
        //         if (!files[i].id)
        //             continue;

        //         //Проверяем что файл уже не добавлен к статье
        //         var exitsts = false;
        //         if (dataLength) {
        //             for (var j = 0; j < dataLength; j++) {
        //                 if (data[j].multimedia == files[i].id) {
        //                     exitsts = true;
        //                     break;
        //                 }
        //             }
        //         }

        //         order_idx++;
        //         if (!exitsts) {
        //             sendFiles.push({
        //                 multimedia: files[i].id,
        //                 article: articleId,
        //                 order_idx: order_idx
        //             });
        //         }
        //     }

        //     //Отправляем на сервер
        //     if (sendFiles.length) {
        //         $(context.$el).LoadingOverlay("hide");
        //         $(context.$el).LoadingOverlay("show");
        //         $.post("/multimedia/add/" + table, {data: sendFiles}, function (data) {
        //             context.model.fetch({success: function () {
        //                     $(context.$el).LoadingOverlay("hide");
        //                 }
        //             });
        //         }, "json").fail(function () {
        //             console.error("Ошибка добавления файлов к статье");
        //             $(context.$el).LoadingOverlay("hide");
        //         });
        //     }
        // }, function (msg) {
        //     console.log(msg);
        // });
    },
    multimediaRemove: function (evt) {
        var context = this;

        var articleId = Utils.getObjectValue(context, "options.id");
        var table = Utils.getObjectValue(context, "options.table");
        if (!articleId || !table) {
            console.error("Ошибка удаления файла");
            return;
        }

        var currentMediaId = $(evt.target).closest("tr").data("multimedia");
        if (currentMediaId) {

            var data = context.model.get("data");
            var dataLength = Utils.getObjectValue(data, 'length');

            if (dataLength) {
                for (var j = 0; j < dataLength; j++) {
                    if (data[j].multimedia == currentMediaId) {
                        if (data[j].id) {
                            $(context.$el).LoadingOverlay("hide");
                            $(context.$el).LoadingOverlay("show");
                            $.getJSON("/multimedia/delete/" + table + "/" + data[j].id, function (data) {
                                context.model.fetch({success: function () {
                                        $(context.$el).LoadingOverlay("hide");
                                    }
                                });
                            }).fail(function () {
                                console.error("Ошибка удаления файла");
                                $(context.$el).LoadingOverlay("hide");
                            });
                        }
                        break;
                    }
                }
            }

        }
    }
});
