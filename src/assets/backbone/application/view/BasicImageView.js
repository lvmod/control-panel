var BasicImageView = Backbone.View.extend({
    template: 'basic-image-template',
    collection: undefined,
    options: undefined,
    events: {
        "click .multimedia-add": "multimediaAdd",
        "click .multimedia-remove": "multimediaRemove",
    },
    initialize: function (options) {
        this.$el = this.$el || $(".article-files-box");
        this.options = options || {};

        this.model = new FileModel({id: this.options.id});
        if (this.model.id) {
            this.listenTo(this.model, 'change', this.render);
            this.listenTo(this.model, 'sync', this.render);
            this.model.fetch();
        }

        this.render();
    },
    render: function () {
        TemplateManager.render(this, this.template, { image: this.model.toJSON() }, function (context, template, data) {
            
        });
        return this;
    },
    fmRefresh: function () {
        this.model.fetch();
    },
    multimediaAdd: function () {
        var context = this;
        var fm = new FileManagerDialogView({single: true, viewer: "image", success: function(files){
            if(files && files.length) {
                file = files[0];
                if(file && !file.get("isfolder")) {
                    context.model = file;
                    context.render();
                }
            }
        }});
    },
    multimediaRemove: function (evt) {
        var context = this;

        context.model = new FileModel({});
        context.render();
    }
});
