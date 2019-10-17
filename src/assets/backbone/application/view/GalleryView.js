var GalleryView = Backbone.View.extend({
    template: 'gallery-template',
    collection: undefined,
    options: undefined,
    events: {
        "click .multimedia-add": "multimediaAdd",
        "click .multimedia-remove": "multimediaRemove",
    },
    initialize: function (options) {
        this.$el = this.$el || $(".gallery-box");
        this.options = options || {};
        this.baseUrl = this.options.baseUrl;
        this.files = [];
        if (this.baseUrl) {
            if (!this.baseUrl.endsWith("/")) {
                this.baseUrl += "/";
                this.files = $.getJSONSync(this.baseUrl);
                this.filePath = this.options.filePath || $.getJSONSync("/control/files/basepath").path;
            }
        } else {
            console.error("Для объекта GalleryView не задан baseUrl");
        }

        this.render();
    },
    render: function () {
        TemplateManager.render(this, this.template, { files: this.files, filePath: this.filePath || "" }, function (context, template, data) {
            context.$('.dnd-on').draggable({
                containment: ".dnd-containment",
                revert: true,
                revertDuration: 0,
                opacity: 0.2,
                zIndex: 10000
            });
            context.$(".dnd-panel-left,.dnd-panel-right").droppable({
                accept: ".dnd-on",//принимаем только чёрного
                over: function (event, ui)//если фигура над клеткой- выделяем её границей
                {
                    $(this).addClass('hover');
                    // ui.draggable.addClass('dnd-opacity');
                },
                out: function (event, ui)//если фигура ушла- снимаем границу
                {
                    $(this).removeClass('hover');
                    // ui.draggable.removeClass('dnd-opacity');
                },
                drop: function (event, ui)//если бросили фигуру в клетку
                {
                    $(this).removeClass('hover');//убираем выделение
                    // ui.draggable.removeClass('dnd-opacity');

                    $li = $(this).closest('li');
                    if (!$li.get(0)) {
                        return;
                    }

                    var leftSort = $li.data("left-sort");
                    var leftId = $li.data("left-id");
                    var currentSort = $li.data("current-sort");
                    var rightSort = $li.data("right-sort");
                    var rightId = $li.data("right-id");
                    var multimediaId = ui.draggable.data("id");
                    var multimediaSort = undefined;
                    if ($(this).hasClass("dnd-panel-left")) {
                        if (leftId === multimediaId) {
                            return;
                        }

                        if (!leftSort) {
                            multimediaSort = currentSort - 1;
                        } else {
                            multimediaSort = (leftSort + currentSort) / 2;
                        }
                    } else if ($(this).hasClass("dnd-panel-right")) {
                        if (rightId === multimediaId) {
                            return;
                        }

                        if (!rightSort) {
                            multimediaSort = currentSort + 1;
                        } else {
                            multimediaSort = (currentSort + rightSort) / 2;
                        }
                    }

                    if (multimediaId !== undefined && multimediaSort !== undefined) {
                        $("div.overlay").css('display', 'block');
                        $.getJSON(context.baseUrl + "set-sort/" + multimediaId + "/" + multimediaSort,
                            function (data) {
                                if (data.error) {
                                    alert(data.error);
                                } else {
                                    if(!context.files) {
                                        $("div.overlay").css('display', 'none');
                                        return;
                                    }

                                    $.each(context.files, function(idx, item) {
                                        if(item.id === multimediaId) {
                                            item.pivot.sort = multimediaSort;
                                            return false; 
                                        }
                                    });

                                    context.files.sort(function(a, b) {
                                        return a.pivot.sort - b.pivot.sort
                                    });
                                    
                                    // context.files = data;
                                    context.render();
                                }
                                $("div.overlay").css('display', 'none');
                            }, function (xhr) {
                                alert("Ошибка перемещения");
                                $("div.overlay").css('display', 'none');
                            }
                        );
                    }
                }
            });

            var items = [];

            context.$('.box-body .preview-box').each(function (idx) {
                $el = $(this);
                $el.data('idx', idx);
                $el.css('cursor', 'pointer');
                var src = $el.data('src');
                if (src) {
                    items.push({
                        src: src,
                        title: $el.data('alt')
                    });
                }
            });

            //Отменяем клик если было перемещение мыши после mousedown
            //Это нужно что бы не включался предпросмотр, если мы делаем перемещение drag and drop
            context.$('.box-body .preview-box')
                .on('mousedown', function () {
                    $(this).data("couldBeClick", true);
                })
                .on('mousemove', function () {
                    $(this).data("couldBeClick", false);
                })
                .on('click', function () {
                    if ($(this).data("couldBeClick")) {
                        var idx = $(this).data('idx') || 0;
                        $.magnificPopup.open({
                            items: items,
                            type: 'image',
                            gallery: {
                                enabled: true
                            },
                            closeBtnInside: false,
                            fixedContentPos: true,
                        }, idx);
                    }
                });
        });
        return this;
    },
    multimediaAdd: function () {
        var context = this;
        if (!context.baseUrl) {
            console.error("Для объекта GalleryView не задан baseUrl");
            return;
        }

        var fm = new FileManagerDialogView({
            single: true,
            viewer: "image",
            success: function (files) {
                if (files && files.length) {
                    var data = files.map(function (item) { return item.id });
                    $.ajax({
                        url: context.baseUrl + "store",
                        type: 'post',
                        dataType: 'json',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function (data) {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                context.files = data;
                                context.render();
                            }
                        },
                        error: function (xhr) {
                            alert("Ошибка добавления файлов");
                        },
                    });
                }
            }
        });
    },
    multimediaRemove: function (e) {
        var context = this;
        var id = $(e.currentTarget).data("id");
        if (!id) {
            return;
        }

        $.getJSON(context.baseUrl + "delete/" + id, function (data) {
            if (data.error) {
                alert(data.error);
            } else {
                context.files = data;
                context.render();
            }
        }, function (xhr) {
            alert("Ошибка удаления файла");
        });
    },
});
