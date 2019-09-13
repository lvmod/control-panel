var ApplicationView = Backbone.View.extend({
    el: $("#application"),
    template: 'application-template',

    render: function () {
        if (!this.historyEnable) {
            TemplateManager.render(this, this.template, {}, function (context, template, data) {
                var container = $('.files-container', context.$el);
                var landing = new FilesView({id: "0"});
                context.filesView = landing;
                landing.render();
                container.append(landing.el);
            });
        }
        return this;
    }

});
