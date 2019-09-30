var MaterialsView = Backbone.View.extend({
    template: 'materials-template',
    collection: undefined,

    events: {
    },
    initialize: function (options) {
        this.options = options || {};
        
        this.basePath = $.getJSONSync("/control/files/basepath");
        if(this.basePath && this.basePath.path) {
            this.basePath = this.basePath.path;
        } else {
            this.basePath = "";
        }

        this.news = $.getJSONSync("/control/news/api/fillbaseimage");
    },
    render: function () {
        TemplateManager.render(this, this.template, {news: this.news, basePath: this.basePath}, function (context, template, data) {
            PluginsManager.iCheck(context);
        });
        return this;
    },
    events: {
        "click .tr-materials-news": "trMaterialNewsClick",
        'ifClicked .checkbox-material': "checkboxClick",
    },
    checkboxClick: function(e) {
        this.$(".checkbox-material").iCheck('uncheck');
    },
    trMaterialNewsClick: function(e) {
        var context = this;
        var i = $(e.currentTarget).data("i");

        if(context.news && context.news.data && context.news.data[i]) {
            var fm = new MaterialView({material: context.news.data[i], basePath: context.basePath});
            Utils.showSimpleModalBackboneView(fm, context.news.data[i].title, function () {
            }, null, { allowCancel: false });
        }
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
