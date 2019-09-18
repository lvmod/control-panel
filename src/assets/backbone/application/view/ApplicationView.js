var ApplicationView = Backbone.View.extend({
    el: $("#application"),
    template: 'application-template',

    render: function () {
        if (!this.historyEnable) {
            TemplateManager.render(this, this.template, {}, function (context, template, data) {
                var container = $('.files-container', context.$el);
                var landing = new FilesView({el: container, id: "0"});
                context.filesView = landing;
            });
        }
        return this;
    }

});
