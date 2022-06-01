(function ($) {
  Drupal.behaviors.lli_custom_module = {
    attach: function (context, settings) {

        $('.form-item-attributes-field-belt-color select' ,context).change(function () {


          var allPanels = $('.variationlist .accordion').children('.content').hide();
          allPanels.slideUp('easeInExpo');
          $('.variationlist .accordion').children('.content-title').removeClass('active');
        });

    }

  };
}(jQuery));