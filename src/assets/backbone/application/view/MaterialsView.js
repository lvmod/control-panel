var MaterialsView = Backbone.View.extend({
    template: 'materials-template',
    collection: undefined,
    initialize: function (options) {
        this.options = options || {};
    },
    render: function () {
        TemplateManager.render(this, this.template, {}, function (context, template, data) {
            PluginsManager.iCheck(context);

            var news = new MaterialsPaginatorView({
                el: context.$("#news>div"),
                type: "news",
                path: "/control/news/api/fillbaseimage"
            });

            var article = new MaterialsPaginatorView({
                el: context.$("#article>div"),
                type: "article",
                path: "/control/article/api/fillbaseimage"
            });

            var staticArticle = new MaterialsPaginatorView({
                el: context.$("#static-article>div"),
                type: "static-article",
                path: "/control/static/article/api/fillbaseimage"
            });
        });
        return this;
    },
    events: {
        'ifClicked .checkbox-material': "checkboxClick",
    },
    checkboxClick: function(e) {
        this.$(".checkbox-material").iCheck('uncheck');
    },
    material: function () {
        var context = this;
        result = undefined;
        if (context.$(".checkbox-material:checked").length) {
            context.$(".checkbox-material:checked").closest("tr").each(function (idx, el) {
                var id = $(el).data("id");
                var type = $(el).data("type");
                if (id && type) {
                    result = {id: id, type: type};
                }
            });
        }
        return result;
    },
});
