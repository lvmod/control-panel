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
                var filesView = new FilesView({el: container, id: "0"});
                Utils.showSimpleModalBackboneView(filesView, "Укажите имя папки", function () {
                    console.log("done");
                    // filesView.save();
                }, null, { cancelText: "Отмена", allowCancel: true });
                context.filesView = filesView;
            });
        }
        return this;
    }

});
