var MaterialsDialogView = Backbone.View.extend({
    template: 'materials-dlg-template',

    initialize: function (options) {
        this.options = options || {};
        this.render();
    },
    render: function () {
        if (!this.historyEnable) {
            TemplateManager.render(this, this.template, {}, function (context, template, data) {
                var fm = new MaterialsView({id: "0", single: context.options.single, viewer: context.options.viewer});
                Utils.showSimpleModalBackboneView(fm, "Выбор материала", function () {
                    if (_.isFunction(context.options.success)) {
                        var material = fm.material();
                        if(material) {
                            console.log("Нужно сохранить вот это: ", material);
                        }
                        // context.options.success.apply(this, []);
                    }
                }, null, { cancelText: "Отмена", allowCancel: true });
                context.filesView = fm;
            });
        }
        return this;
    }

});
