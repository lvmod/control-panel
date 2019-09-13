var FileCollection = Backbone.Collection.extend({
  url: function(){
    return "/";
  },
  model: FileModel,
  comparator: function(item) {
      return item.get("order");
  }
});
