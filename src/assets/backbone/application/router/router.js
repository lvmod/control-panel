var Router = Backbone.Router.extend({

    app: undefined,
    routes: {
        "": "done", 
        ":query": "done"
    },
    done: function (query, page) {
        var router = this;
        TemplateManager.render(this.app, this.app.template, {}, function (context, template, data) {
            var container = $('.files-container', context.$el);
            if(!query)query = 0;
            var landing = new FilesView({id: query});
            router.app.filesView = landing;
            landing.render();
            container.append(landing.el);
        });
    },
    initialize: function (options) {
        this.app = options;
    },

});