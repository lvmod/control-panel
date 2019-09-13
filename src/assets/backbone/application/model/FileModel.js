var FileModel = Backbone.Model.extend({
    urlRoot : '/filemanager/file',
//    isNew: function () {
//        return false;
//    },
//    url: function () {
//        return "/filemanager/file/" + this.get('id');
//    },
    defaults: {
//        id: "",
        default_preview: "/images/PNG/Filetypes/Grey/Stroke/@2x/icon-74-document-file-jpg@2x.png",
        deleted: "0",
        description: "",
        external_url: "",
        file_name: "",
        isfolder: "",
        name: "",
        parent: "0",
        type: "",
        type_display: "",
        type_id: "",
        type_makepreview: "",
        type_name: ""
    },
    initialize: function (data, options) {
//        this.set("_id", UID.generate());
    }
});
