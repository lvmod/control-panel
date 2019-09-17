var FileView = Backbone.View.extend({
  template: 'file-template',
  tagName: 'tr',
  collection: undefined,
  events: {
    "click .fm-clickable ": "fmClick",
    "click .file-link-btn": "fileLInkClick"
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
  fileLInkClick: function () {
    var context = this;

    var view = new FileLinkModal({ model: context.model });
    Utils.showSimpleModalBackboneView(view, "Связи", function (model, response, options) {});
    // var modal = new Backbone.BootstrapModal({
    //   content: view,
    //   title: 'Связи',
    //   okText: "Сохранить",
    //   cancelText: "Отмена",
    //   animate: true
    // }).open(function () {
    //   var name = $('#folder-name', view.$el).val();
    //   var folder = new FileModel({
    //     //                id: "1",
    //     parent: context.model.get("id"),
    //     name: name,
    //     type: "1",
    //     isfolder: "1",
    //     description: ""
    //   });

    //   folder.save({}, {
    //     success: function (model, response, options) {
    //       if (response.error) {
    //         alert(response.error);
    //       } else {
    //         //Можно делать fetch, но будут перезапрашиваться все данные с сервера, 
    //         //быстрее добавить в коллекцию один вставляемый элемент и перерисовать
    //         //                        context.model.fetch();
    //         context.collection.add(response, { silent: true });


    //         context.model.set("files", [], { silent: true });
    //         context.model.set("files", context.collection.toJSON(), { silent: true });
    //         context.render();
    //       }
    //     },
    //     error: function (model, xhr, options) {
    //       alert("Ошибка создания папки");
    //     }
    //   });
    // });

    // //Утанавливаем z-index иначе текущий диалог 
    // //всплывает за открытими диалогами summernote
    // modal.$el.css('z-index', 1500);

    // //Удаление данных диалога, после закрытия
    // modal.$el.on('hidden.bs.modal', function () {
    //   modal.remove();
    // });

  },
});
