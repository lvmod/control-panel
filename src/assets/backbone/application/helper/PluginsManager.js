PluginsManager = {
    Sortable: function (context) {
        $('.sortable', context.$el).sortable({
            items: '.sortable-item',
            // hoverClass: 'sortable-item-hovered',
            // handle: 'p.assembly-title'
        });
    },
    Editable: function (context, object, field) {
        $('.' + object + '-' + field, context.$el).editable({
            type: 'textarea',
            placement: 'bottom',
            send: 'never',
            unsavedclass: null,
            success: function (response, newValue) {
                context.model.set(field, newValue);
            }
        });
    },
    iCheck: function (context) {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"]', context.$el).iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
    },
    iCheckDestroy: function(context) {
        $('input[type="checkbox"]', context.$el).iCheck('destroy');
    },
    iCheckBtnAll: function (context) {
        //Enable check and uncheck all functionality
        $(".checkbox-toggle", context.$el).click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $("input[type='checkbox']", context.$el).iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                //Check all checkboxes
                $("input[type='checkbox']", context.$el).iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });
    },
    Isotope: function functionName(context) {
        // Isotope filters
        //-----------------------------------------------
        // if ($('.isotope-container',context).length>0 || $('.masonry-grid',context).length>0 || $('.masonry-grid-fitrows',context).length>0) {
        // $(window).load(function() {
        // $('.masonry-grid',context).isotope({
        //   itemSelector: '.masonry-grid-item',
        //   layoutMode: 'masonry'
        // });
        $('.masonry-grid-fitrows').isotope({
            itemSelector: '.masonry-grid-item',
            layoutMode: 'fitRows'
        });

        // $('.isotope-container',context).fadeIn();
        // var $container = $('.isotope-container').isotope({
        //   itemSelector: '.isotope-item',
        //   layoutMode: 'masonry',
        //   transitionDuration: '0.6s',
        //   filter: "*"
        // });
        // filter items on button click
        // $('.filters',context).on( 'click', 'ul.nav li a', function() {
        //   var filterValue = $(this).attr('data-filter');
        //   $(".filters").find("li.active").removeClass("active");
        //   $(this).parent().addClass("active");
        //   $container.isotope({ filter: filterValue });
        //   return false;
        // });
        // });
        // };

    }
}
