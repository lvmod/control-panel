TemplateManager = {
  templates: {},
  templatesRaw: {},
  getRaw: function(id, action){
    var template = this.templatesRaw[id];
    if (template) {
      action(template);
    } else {
      var conteiner = this.templatesRaw;
      $.get("/vendor/control-panel/backbone/application/template/" + id + ".html", function(template){
        var tmpl = template;
        conteiner[id] = tmpl;
        action(tmpl);
      });
    }
  },
  get: function(id, action){
    var template = this.templates[id];
    if (template) {
      action(template);
    } else {
      var conteiner = this.templates;
      $.get("/vendor/control-panel/backbone/application/template/" + id + ".html", function(template){
        var tmpl = _.template(template);
        conteiner[id] = tmpl;
        action(tmpl);
      });
    }
  },
  render: function(context, name, data, callback){
    this.get(name, function(template){
      context.$el.html(template(data));
      if(callback){
        callback(context, name, data);
      }
    });
  }
}
