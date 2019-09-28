var BasicImageView = Backbone.View.extend({
    template: 'basic-image-template',
    collection: undefined,
    options: undefined,
    events: {
        "click .multimedia-add": "multimediaAdd",
        "click .multimedia-add-file-input": "multimediaAddFileInput",
        "click .multimedia-remove": "multimediaRemove",
        "change #fileInputBaseImage": "fileInputBaseImageChange",
    },
    initialize: function (options) {
        this.$el = this.$el || $(".article-files-box");
        this.options = options || {};
        this.options.inputName = this.options.inputName || 'multimedia';
        this.model = new FileModel({ id: this.options.id });
        if (this.model.id) {
            this.listenTo(this.model, 'change', this.render);
            this.listenTo(this.model, 'sync', this.render);
            this.model.fetch();
        }

        this.render();
    },
    render: function () {
        TemplateManager.render(this, this.template, { imageUrl: this.options.imageUrl, image: this.model.toJSON(), multimediaInputName: this.options.multimediaInputName, urlInputName: this.options.urlInputName }, function (context, template, data) {

        });
        return this;
    },
    fmRefresh: function () {
        this.model.fetch();
    },
    multimediaAdd: function () {
        var context = this;
        var fm = new FileManagerDialogView({
            single: true, viewer: "image", success: function (files) {
                if (files && files.length) {
                    file = files[0];
                    if (file && !file.get("isfolder")) {
                        context.model = file;
                        context.options.imageUrl = "";
                        context.render();
                    }
                }
            }
        });
    },
    multimediaRemove: function (evt) {
        var context = this;

        context.model = new FileModel({});
        context.options.imageUrl = "";

        context.render();
    },
    multimediaAddFileInput: function () {
        $('#fileInputBaseImage').trigger('click');
    },
    fileInputBaseImageChange: function (e) {
        var context = this;
        var files = e.currentTarget.files;
        if (!files) {
            return;
        }
        var data = [];
        if (files && files.length) {
            var file = files[0];
            if (file) {
                formData = new FormData();
                formData.append('file', file);
                formData.append('type', context.options.materialType);
                formData.append('id', context.options.materialId);
                $.ajax({
                    url: '/control/files/upload-material',
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data) {
                        if (data && data.url) {
                            context.options.imageUrl = data.url;
                            context.model = new FileModel({});
                            context.render();
                        } else {
                            var message = "Ошибка загрузки изображения";
                            if (data && data.error) {
                                message = data.error;
                            }
                            alert(message);                           
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Ошибка загрузки изображения: " + textStatus);
                    },
                });
            }
        }
    }
});
