var GalleryView = Backbone.View.extend({
    template: 'gallery-template',
    collection: undefined,
    options: undefined,
    events: {
        "click .multimedia-add": "multimediaAdd",
        "click .multimedia-remove": "multimediaRemove",
    },
    initialize: function (options) {
        this.$el = this.$el || $(".gallery-box");
        this.options = options || {};
        this.baseUrl = this.options.baseUrl;
        if (this.baseUrl) {
            if (!this.baseUrl.endsWith("/")) {
                this.baseUrl += "/";
                this.files = $.getJSONSync(this.baseUrl);
                this.filePath = this.options.filePath||$.getJSONSync("/control/files/basepath").path;
            }
        } else {
            console.error("Для объекта GalleryView не задан baseUrl");
        }

        this.render();
    },
    render: function () {
        TemplateManager.render(this, this.template, {files: this.files, filePath: this.filePath||""}, function (context, template, data) {
            var items = [];
			context.$('.box-body .preview-box').each(function(idx) {
                $el = $(this);
				$el.data('idx', idx);
                $el.css('cursor', 'zoom-in');
				var src = $el.data('src');
				if(src) {
					items.push({
						src: src,
						title: $el.data('alt')
					});
				}
			});

			context.$('.box-body .preview-box').click(function() {
				var idx = $(this).data('idx')||0;
				$.magnificPopup.open({
					items: items,
					type: 'image',
					gallery: {
						enabled: true
					},
					closeBtnInside: false,
					fixedContentPos: true,
				}, idx);
			});
        });
        return this;
    },
    fmRefresh: function () {
        this.model.fetch();
    },
    multimediaAdd: function () {
        var context = this;
        if (!context.baseUrl) {
            console.error("Для объекта GalleryView не задан baseUrl");
            return;
        }

        var fm = new FileManagerDialogView({
            single: true,
            viewer: "image",
            success: function (files) {
                if (files && files.length) {
                    var data = files.map(function(item){return item.id});
                    $.ajax({
                        url: context.baseUrl+"store",
                        type: 'post',
                        dataType: 'json',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function (data) {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                context.files = data;
                                context.render();
                            }
                        },
                        error: function (xhr) {
                            alert("Ошибка добавления файлов");
                        },
                    });
                }
            }
        });
    },
    multimediaRemove: function (e) {
        var context = this;
        var id = $(e.currentTarget).data("id");
        if (!id) {
            return;
        }

        $.getJSON(context.baseUrl+"delete/"+id, function(data) {
            if (data.error) {
                alert(data.error);
            } else {
                context.files = data;
                context.render();
            }
        }, function (xhr) {
            alert("Ошибка удаления файла");
        });
    },
});
