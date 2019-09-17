var FolderNameModal = Backbone.View.extend({
  template: 'folder-name-modal-template',
  initialize: function (options) {
    this.options = options || {};
  },
  render: function () {
    TemplateManager.render(this, this.template, { actions: this.actions, currency: this.currency },
      function (context, template, data) {
        context.initSearchProduct();
      });

    return this;
  },
  render: function () {
    TemplateManager.render(this, this.template, this.model.toJSON(), function (context, template, data) {
      $("#folder-name", context.$el).val(context.model.get('name'));
    });
    return this;
  },

  save: function () {
    var context = this;
    this.model.set('name', this.$('#folder-name').val());
    this.model.save({}, {
      success: function (model, response, options) {
        if (response.error) {
          alert(response.error);
        } else {
          //Можно делать fetch, но будут перезапрашиваться все данные с сервера, 
          //быстрее добавить в коллекцию один вставляемый элемент и перерисовать
          //                        context.model.fetch();
          context.options.parentView.collection.add(response, { silent: true });


          context.options.parentView.model.set("files", [], { silent: true });
          context.options.parentView.model.set("files", context.options.parentView.collection.toJSON(), { silent: true });
          context.options.parentView.render();
        }
      },
      error: function (model, xhr, options) {
        alert("Ошибка создания папки");
      }
    });
  }
});
