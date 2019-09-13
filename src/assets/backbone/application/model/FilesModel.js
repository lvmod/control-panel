var FilesModel = Backbone.Model.extend({
    isNew: function () {
        return false;
    },
    url: function () {
        return "/filemanager/view/id/" + this.get('id');
    },
    defaults: {
        filePath: "",
        filePathMin: "",
        id: "0",
        files: [], 
        path: [],
        mediaType: [],
        uploadMaxFilesize: ""
    },
    initialize: function (data, options) {
        
    }
});
