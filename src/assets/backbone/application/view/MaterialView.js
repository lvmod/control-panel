var MaterialView = Backbone.View.extend({
    template: 'material-template',
    collection: undefined,

    events: {
    },
    initialize: function (options) {
        this.options = options || {};
    },
    render: function () {
        TemplateManager.render(this, this.template, {material: this.options.material, basePath: this.options.basePath}, function (context, template, data) {
           
        });
        return this;
    },
});
