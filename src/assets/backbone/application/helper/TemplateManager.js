window.TemplateManager = {
  listResolutionMedia: "(max-width: 530px)",
  templates: {},
  templatesRaw: {},
  getRaw: function (id, action) {
      var template = this.templatesRaw[id];
      if (template) {
          action(template);
      } else {
          var conteiner = this.templatesRaw;
          $.get("/vendor/control-panel/backbone/application/template/" + id + ".html", function (template) {
              var tmpl = template;
              conteiner[id] = tmpl;
              action(tmpl);
          });
      }
  },
  get: function (id, action) {
      var template = this.templates[id];
      if (template) {
          action(template);
      } else {
          template = $.getSync("/vendor/control-panel/backbone/application/template/" + id + ".html");
          if (!template) {
              console.error("Ошибка загрузки шаблона " + id);
              return;
          }
          var tmpl = _.template(template);
          this.templates[id] = tmpl;
          action(tmpl);
      }
  },
  render: function (context, name, data, callback) {
      this.get(name, function (template) {
          if (context.html) {
              context.html(template(data));
          } else {
              context.$el.html(template(data));
          }

          if (context.trigger) {
              context.trigger("inject-template-done", context);
          }

          if (callback) {
              if (context.trigger) {
                  context.trigger("before-render-callback", context);
              }

              callback(context, name, data);

              if (context.trigger) {
                  context.trigger("after-render-callback", context);
              }
          }

          if (context.trigger) {
              context.trigger("render-done", context);
          }
      });
  },
  /**
   * При выполнении условия query, вызывается cbMatches, иначе cbNotMatches
   * @param Backbone.View view 
   * @param String query медиа тег вида "(max-width: 700px)"
   * @param function cbMatches
   * @param function cbNotMatches
   * @returns Backbone.View
   */
  media: function (view, query, cbMatches, cbNotMatches) {
      var check = function (x) {
          if (x.matches) {
              if (cbMatches && typeof (cbMatches) === "function") {
                  cbMatches.apply(view);
              }
          } else {
              if (cbNotMatches && typeof (cbNotMatches) === "function") {
                  cbNotMatches.apply(view);
              }
          }
      }
      //Удаляем обработчик события смены разрешения, если такой уже есть
      if (view.media && view.media.mediaRemoveListener) {
          view.media.mediaRemoveListener();
      }

      var checkAndRender = function (x) {
          check(x);
          view.render();
      };

      //Создаем новый объект matchMedia, и подписываемся на события
      view.media = window.matchMedia(query);
      check(view.media);
      view.media.addListener(checkAndRender);
      //Добовляем в функцию уничтожения обработчика события
      view.media.mediaRemoveListener = function () {
          view.media.removeListener(checkAndRender);
      };
      return view;
  },
  /**
   * Проверяет выполнение условия медиа запроса
   * @param String query медиа тег вида "(max-width: 700px)"
   * @returns boolean
   */
  check: function (query) {
      return window.matchMedia(query).matches;
  },
  checkListResolution: function () {
      return TemplateManager.check(TemplateManager.listResolutionMedia);
  }
};

