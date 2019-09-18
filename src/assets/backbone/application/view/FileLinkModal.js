var FileLinkModal = Backbone.View.extend({
  template: 'file-link-modal-template',
  initialize: function (options) {
    this.options = options || {};
    this.users = $.getJSONSync("/control/user/api/list");
    this.linksList = $.getJSONSync("/control/files/links/"+this.model.id);
    this.links = {};
    if(this.linksList && this.linksList.length) {
      for (var i = 0; i < this.linksList.length; ++i) {
        if(this.linksList[i]) {
          this.links[this.linksList[i].id] = this.linksList[i];
        }
      }
    }
  },

  render: function () {
    TemplateManager.render(this, this.template, { data: this.model.toJSON(), users: this.users, links: this.links }, function (context, template, data) {
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
