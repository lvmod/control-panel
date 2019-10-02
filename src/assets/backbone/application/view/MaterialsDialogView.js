var MaterialsDialogView = Backbone.View.extend({
    template: 'materials-dlg-template',

    initialize: function (options) {
        this.options = options || {};
        this.render();
    },
    render: function () {
        if (!this.historyEnable) {
            TemplateManager.render(this, this.template, {}, function (context, template, data) {
                var mview = new MaterialsView({id: "0", single: context.options.single, viewer: context.options.viewer});
                Utils.showSimpleModalBackboneView(mview, "Выбор материала", function () {
                    if (_.isFunction(context.options.success)) {
                        var material = mview.material();
                        if(material) {
                            context.options.success.apply(context, [material]);
                        }
                    }
                }, null, { cancelText: "Отмена", allowCancel: true });
                context.filesView = mview;
            });
        }
        return this;
    }

});
