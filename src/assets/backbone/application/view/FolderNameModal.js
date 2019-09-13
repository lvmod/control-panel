var FolderNameModal = Backbone.View.extend({
  template: 'folder-name-modal-template',
  render: function() {
    TemplateManager.render(this,this.template,this.model.toJSON(),function(context, template, data){
        $("#folder-name",context.$el).val(context.model.get('name'));
    });
    return this;
  }
});
