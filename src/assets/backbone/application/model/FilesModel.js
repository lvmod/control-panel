var FilesModel = Backbone.Model.extend({
    filter: "",
    isNew: function () {
        return false;
    },
    url: function () {
        return "/control/files/view/" + this.get('id')+this.filter;
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
        if(options.type) {
            this.filter = "?type="+options.type;
        } else if(options.viewer) {
            this.filter = "?viewer="+options.viewer;
        }
    }
});
