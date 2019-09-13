var ArticleFilesModel = Backbone.Model.extend({
    isNew: function () {
        return false;
    },
    url: function () {
        var table = 'null';
        var id = 0;
        if(this.options.table) table = this.options.table;
        if(this.options.id) id = this.options.id;
        return "/multimedia/view/"+table+"/" + id;
    },
    initialize: function (data, options) {
        this.options = options||{};
    }
});
