var FileLinkModal = Backbone.View.extend({
  template: 'file-link-modal-template',
  initialize: function (options) {
    this.options = options || {};
    this.users = $.getJSONSync("/control/user/api/list");
  },

  render: function () {
    TemplateManager.render(this, this.template, { data: this.model.toJSON(), users: this.users }, function (context, template, data) {
      context.$('.select2').select2();
    });
    return this;
  },

  save: function () {
    var context = this;
    var users = this.$('#users').val();
    if (!users) {
      users = [];
    }

    $.ajax({
      url: '/control/files/links/' + context.model.id,
      type: 'post',
      dataType: 'json',
      contentType: 'application/json',
      success: function (data) {
        if (data.error) {
          alert(data.error);
        } else {
          
        }
      },
      error: function (xhr) {
        alert("Ошибка создания связи");
      },
      data: JSON.stringify({ users: users })
    });
  }
});
