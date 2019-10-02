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
        this.article = $.getJSONSync("/control/article/api/fillbaseimage");
        this.staticArticle = $.getJSONSync("/control/static/article/api/fillbaseimage");
    },
    render: function () {
        TemplateManager.render(this, this.template, {basePath: this.basePath, news: this.news, article: this.article, staticArticle: this.staticArticle}, function (context, template, data) {
            PluginsManager.iCheck(context);
        });
        return this;
    },
    events: {
        "click .tr-materials-news": "trMaterialNewsClick",
        "click .tr-materials-article": "trMaterialArticleClick",
        "click .tr-materials-static-article": "trMaterialStaticArticleClick",
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
    trMaterialArticleClick: function(e) {
        var context = this;
        var i = $(e.currentTarget).data("i");

        if(context.article && context.article.data && context.article.data[i]) {
            var fm = new MaterialView({material: context.article.data[i], basePath: context.basePath});
            Utils.showSimpleModalBackboneView(fm, context.article.data[i].title, function () {
            }, null, { allowCancel: false });
        }
    },
    trMaterialStaticArticleClick: function(e) {
        var context = this;
        var i = $(e.currentTarget).data("i");

        if(context.staticArticle && context.staticArticle.data && context.staticArticle.data[i]) {
            var fm = new MaterialView({material: context.staticArticle.data[i], basePath: context.basePath});
            Utils.showSimpleModalBackboneView(fm, context.staticArticle.data[i].title, function () {
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
