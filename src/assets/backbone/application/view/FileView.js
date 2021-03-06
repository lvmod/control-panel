var FileView = Backbone.View.extend({
  template: 'file-template',
  tagName: 'tr',
  collection: undefined,
  events: {
    "click .fm-clickable ": "fmClick",
    "click .file-link-btn": "fileLinkClick"
  },
  initialize: function (options) {
    if (!this.model) {
      this.model = new FileModel(options.data);
    }
    if (this.model) {
      this.listenTo(this.model, 'change', this.render);
    }
  },
  render: function () {
    TemplateManager.render(this, this.template, this.model.toJSON(), function (context, template, data) {
      PluginsManager.iCheck(context);
    });
    return this;
  },
  fmClick: function () {
    this.trigger("fm-click", this.model.toJSON());
  },
  fileLinkClick: function () {
    var context = this;

    var view = new FileLinkModal({parentView: context, model: context.model});
    Utils.showSimpleModalBackboneView(view, "Связи", function () {
      view.save();
    }, null, { dialogClass: "", cancelText: "Отмена", allowCancel: true });

  },
});
