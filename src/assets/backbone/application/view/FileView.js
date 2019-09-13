var FileView = Backbone.View.extend({
  template: 'file-template',
  tagName: 'tr',
  collection: undefined,
  events: {
    "click .fm-clickable " : "fmClick",
  },
  initialize: function (options) {
    if (!this.model) {
        this.model = new FileModel(options.data);
    }
    if (this.model) {
        this.listenTo(this.model,'change',this.render);
    }
  },
  render: function() {
    TemplateManager.render(this,this.template,this.model.toJSON(),function(context, template, data){
        PluginsManager.iCheck(context);
    });
    return this;
  },
  fmClick: function() {
      this.trigger("fm-click", this.model.toJSON());
  }
//  removeAssembly: function() {
//    this.trigger("assembly-remove", this.model.toJSON());
//  },
//  moveUpAssembly: function() {
//    this.trigger("assembly-up", this.model.toJSON());
//  },
//  moveDownAssembly: function() {
//    this.trigger("assembly-down", this.model.toJSON());
//  },
//  moveLeftProduct: function(product){
//    var index = -1;
//    for(i=0;i<this.collection.length;i++){
//      if(this.collection.at(i).get('_id') === product._id){
//        index = i;
//      }
//    }
//    if(index > 0){
//        var curr = this.collection.at(index);
//        var prev = this.collection.at(index-1);
//        var tmp = curr.get('order');
//        curr.set('order',prev.get('order'),{silent:true});
//        prev.set('order',tmp,{silent:true});
//        this.collection.sort();
//    }
//  },
//  moveRightProduct: function(product){
//    var index = -1;
//    for(i=0;i<this.collection.length;i++){
//      if(this.collection.at(i).get('_id') === product._id){
//        index = i;
//      }
//    }
//    if(index >= 0 && index < this.collection.length-1){
//        var curr = this.collection.at(index);
//        var next = this.collection.at(index+1);
//        var tmp = curr.get('order');
//        curr.set('order',next.get('order'),{silent:true});
//        next.set('order',tmp,{silent:true});
//        this.collection.sort();
//    }
//  },
//  openProductSelectionDialog: function(){
//    var context = this;
//    var view = new ProductSelectionModal({assembly: context.model});
//    TemplateManager.get("modal-template",function(template){
//        var modal = new Backbone.BootstrapModal({
//            content: view,
//            template: template,
//            title: 'Выбор товаров для сборки',
//            okText: "Подтвердить выбор",
//            cancelText: "Отмена",
//            dialogClass: "modal-lg",
//            animate: true
//        }).open(function(){
//            var selected = _.filter(view.collection.toJSON(), function(item){
//              return item.selected;
//            });
//            var pro = _.union(selected,context.model.get("product"));
//            context.model.set("product",pro,{silent:true});
//            context.render();
//            context.trigger("product-append", context.model.toJSON());
//        });
//    });
//  }
});
