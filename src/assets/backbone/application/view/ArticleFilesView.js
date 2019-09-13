var ArticleFilesView = Backbone.View.extend({
    template: 'article-files-template',
    collection: undefined,
    options: undefined,
    events: {
        "click .multimedia-add": "multimediaAdd",
        "click .multimedia-order-up": "multimediaOrderUp",
        "click .multimedia-order-down": "multimediaOrderDown",
        "click .multimedia-remove": "multimediaRemove"
    },
    initialize: function (options) {
        this.$el = this.$el || $(".article-files-box");
        this.options = options || {};

        this.model = new ArticleFilesModel({}, this.options);
        if (this.model) {
            this.listenTo(this.model, 'change', this.render);
            this.model.fetch();
        }
    },
    render: function () {
        TemplateManager.render(this, this.template, this.model.toJSON(), function (context, template, data) {

        });
        return this;
    },
    fmRefresh: function () {
        this.model.fetch();
    },
    multimediaAdd: function () {
        var context = this;
        showFileManagerObjectDialog(function (files) {
            var articleId = Utils.getObjectValue(context, "options.id");
            var table = Utils.getObjectValue(context, "options.table");
            if (!Utils.getObjectValue(files, 'length') || !articleId || !table) {
                console.error("Ошибка добаления файлов к статье");
                return;
            }

            //Извлекаем наибольший индекс сортировки
            var data = context.model.get("data");
            var dataLength = Utils.getObjectValue(data, 'length');
            var order_idx = 0;
            if (dataLength) {
                order_idx = data[data.length - 1].order_idx || 0;
            }


            //Подготавливаем массив файлов для отправки на сервер
            var sendFiles = [];
            for (var i = 0; i < files.length; i++) {
                if (!files[i].id)
                    continue;

                //Проверяем что файл уже не добавлен к статье
                var exitsts = false;
                if (dataLength) {
                    for (var j = 0; j < dataLength; j++) {
                        if (data[j].multimedia == files[i].id) {
                            exitsts = true;
                            break;
                        }
                    }
                }

                order_idx++;
                if (!exitsts) {
                    sendFiles.push({
                        multimedia: files[i].id,
                        article: articleId,
                        order_idx: order_idx
                    });
                }
            }

            //Отправляем на сервер
            if (sendFiles.length) {
                $(context.$el).LoadingOverlay("hide");
                $(context.$el).LoadingOverlay("show");
                $.post("/multimedia/add/" + table, {data: sendFiles}, function (data) {
                    context.model.fetch({success: function () {
                            $(context.$el).LoadingOverlay("hide");
                        }
                    });
                }, "json").fail(function () {
                    console.error("Ошибка добавления файлов к статье");
                    $(context.$el).LoadingOverlay("hide");
                });
            }
        }, function (msg) {
            console.log(msg);
        });
    },
    multimediaOrderUp: function (evt) {
        var context = this;

        var articleId = Utils.getObjectValue(context, "options.id");
        var table = Utils.getObjectValue(context, "options.table");
        if (!articleId || !table) {
            console.error("Ошибка перемещения файла");
            return;
        }

        var currentMediaId = $(evt.target).closest("tr").data("multimedia");
        if (currentMediaId) {

            //Определяем элементы для замены индексов сортировки и отправляем на сервер
            var data = context.model.get("data");
            var dataLength = Utils.getObjectValue(data, 'length');

            if (dataLength) {
                for (var j = 0; j < dataLength; j++) {
                    if (data[j].multimedia == currentMediaId) {
                        if (j > 0 && data[j].id && data[j - 1].id) {
                            //Подготавливаем данные для отправки на сервер
                            var sendData = [];
                            sendData.push(
                                    {
                                        id: data[j].id,
                                        order_idx: data[j - 1].order_idx
                                    },
                                    {
                                        id: data[j - 1].id,
                                        order_idx: data[j].order_idx
                                    }
                            );

                            //Отправляем на сервер
                            if (sendData.length) {
                                $(context.$el).LoadingOverlay("hide");
                                $(context.$el).LoadingOverlay("show");
                                $.post("/multimedia/edit/" + table, {data: sendData}, function (data) {
                                    context.model.fetch({success: function () {
                                            $(context.$el).LoadingOverlay("hide");
                                        }
                                    });
                                }, "json").fail(function () {
                                    console.error("Ошибка перемещения файла");
                                    $(context.$el).LoadingOverlay("hide");
                                });
                            }
                        }
                        break;
                    }
                }
            }
        }
    },
    multimediaOrderDown: function (evt) {
        var context = this;

        var articleId = Utils.getObjectValue(context, "options.id");
        var table = Utils.getObjectValue(context, "options.table");
        if (!articleId || !table) {
            console.error("Ошибка перемещения файла");
            return;
        }

        var currentMediaId = $(evt.target).closest("tr").data("multimedia");
        if (currentMediaId) {

            //Определяем элементы для замены индексов сортировки и отправляем на сервер
            var data = context.model.get("data");
            var dataLength = Utils.getObjectValue(data, 'length');

            if (dataLength) {
                for (var j = 0; j < dataLength; j++) {
                    if (data[j].multimedia == currentMediaId) {
                        if (j < dataLength - 1 && data[j].id && data[j + 1].id) {
                            //Подготавливаем данные для отправки на сервер
                            var sendData = [];
                            sendData.push(
                                    {
                                        id: data[j].id,
                                        order_idx: data[j + 1].order_idx
                                    },
                                    {
                                        id: data[j + 1].id,
                                        order_idx: data[j].order_idx
                                    }
                            );

                            //Отправляем на сервер
                            if (sendData.length) {
                                $(context.$el).LoadingOverlay("hide");
                                $(context.$el).LoadingOverlay("show");
                                $.post("/multimedia/edit/" + table, {data: sendData}, function (data) {
                                    context.model.fetch({success: function () {
                                            $(context.$el).LoadingOverlay("hide");
                                        }
                                    });
                                }, "json").fail(function () {
                                    console.error("Ошибка перемещения файла");
                                    $(context.$el).LoadingOverlay("hide");
                                });
                            }
                        }
                        break;
                    }
                }
            }
        }
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
