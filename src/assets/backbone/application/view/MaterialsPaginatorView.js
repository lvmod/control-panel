var MaterialsPaginatorView = Backbone.View.extend({
    template: 'materials-paginator-template',
    initialize: function (options) {
        this.options = options || {};
        this.type = this.options.type;
        this.path = this.options.path;
        this.baseMediaPath = $.getJSONSync("/control/files/basepath");
        if (this.baseMediaPath && this.baseMediaPath.path) {
            this.baseMediaPath = this.baseMediaPath.path;
        } else {
            this.baseMediaPath = "";
        }

        this.model = new Backbone.Model;
        this.model.url = this.path;
        this.model.fetch();

        this.listenTo(this.model, 'sync', this.render);
    },
    render: function () {
        TemplateManager.render(this, this.template, {type: this.type, baseMediaPath: this.baseMediaPath, materials: this.model.toJSON() }, function (context, template, data) {
            PluginsManager.iCheck(context);
        });
        return this;
    },
    events: {
        "click .tr-materials": "trMaterialClick",
        'ifClicked .checkbox-material': "checkboxClick",
        "click .materials-page-link": "materialsPageLinkClick"
    },
    checkboxClick: function (e) {
        this.$(".checkbox-material").iCheck('uncheck');
    },
    trMaterialClick: function (e) {
        var context = this;
        var i = $(e.currentTarget).data("i");
        
        if (context.model) {
            var data = context.model.get("data");
            if (data && data[i]) {
                var fm = new MaterialView({ material: data[i], basePath: context.baseMediaPath });
                Utils.showSimpleModalBackboneView(fm, data[i].title, function () {
                }, null, { allowCancel: false });
            }
        }
    },
    materialsPageLinkClick: function (e) {
        var context = this;
        var page = $(e.target).data("page");
        if (!page) {
            return false;
        }

        var urlObject = new URL(window.location.origin + context.path);
        urlObject.searchParams.set("page", page);
        context.model.url = urlObject.pathname + urlObject.search;
        context.model.fetch();
    }
});
