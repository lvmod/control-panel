var FileModel = Backbone.Model.extend({
    urlRoot : '/control/files/file',
//    isNew: function () {
//        return false;
//    },
//    url: function () {
//        return "/control/files/file/" + this.get('id');
//    },
    defaults: {
//        id: "",
        default_preview: "",
        deleted: "0",
        description: "",
        external_url: "",
        file_name: "",
        isfolder: "",
        name: "",
        parent: "",
        parent_id: "0",
        type: "",
        type_id: "",
    },
    initialize: function (data, options) {
//        this.set("_id", UID.generate());
    }
});
