var FileManagerDialogView = Backbone.View.extend({
    template: 'file-manager-template',

    initialize: function (options) {
        this.options = options || {};
        this.render();
    },
    render: function () {
        if (!this.historyEnable) {
            TemplateManager.render(this, this.template, {}, function (context, template, data) {
                var container = $('.files-container', context.$el);
                var fm = new FilesView({id: "0", single: context.options.single, type: context.options.type, viewer: context.options.viewer});
                Utils.showSimpleModalBackboneView(fm, "Выбор файлов", function () {
                    if (_.isFunction(context.options.success)) {
                        context.options.success.apply(this, [fm.files()]);
                    }
                }, null, { cancelText: "Отмена", allowCancel: true });
                context.filesView = fm;
            });
        }
        return this;
    }

});
