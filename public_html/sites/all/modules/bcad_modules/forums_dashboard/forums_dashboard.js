(function ($) {
  Drupal.behaviors.forums_dashboard = {
    attach: function (context, settings) {
      var clickTimeout;

      $('#cohort-select-value').selectBoxIt(
          {autowidth: false}
      );

      // If changing the select field
      $('#cohort-select-value', context).change(function () {
        var cohort = $(this).val();

        $.ajax({
          url: '/ajax/coaching_summary',
          type: "POST",
          data: {cohort_id: cohort},
          success: function (response) {
            $('#coaching_summary_ajax').html(response);
            $('.colorbox-node', context).once('init-colorbox-node-processed', function () {
              $(this).colorboxNode({'launch': false});
            });
            $('.colorbox-node', context).colorbox();

          }

        });
      });
      $('#add-time-button', context).on('click', function () {
        clearTimeout(clickTimeout);

        var newVal = (parseFloat($('#coaching_hours').val(), 10) + .25).toFixed(2);
        $('#coaching_hours').val(newVal);
        var uid = $('#uid').val();

        clickTimeout = setTimeout(function () {

          console.log('update now after adding....')
          $.ajax({
            url: '/ajax/update_coaching_hours',
            type: "POST",
            data: {hours: newVal, uid:uid},
            success: function (response) {
              $('#saved').html(response);
              $('#saved').show();
              setTimeout(function () {$('#saved').fadeOut(500)},2000);

            }

          });
        }, 500)

      });
      $('#subtract-time-button', context).on('click', function () {
        clearTimeout(clickTimeout);

        var newVal = (parseFloat($('#coaching_hours').val(), 10) - .25).toFixed(2);
        $('#coaching_hours').val(newVal);
        var uid = $('#uid').val();

        clickTimeout = setTimeout(function () {
          console.log('update now after subtracting....')
          $.ajax({
            url: '/ajax/update_coaching_hours',
            type: "POST",
            data: {hours: newVal, uid:uid},
            success: function (response) {
              $('#saved').html(response);
              $('#saved').show();
              setTimeout(function () {$('#saved').fadeOut(500)},2000);
            }
          });
        }, 500)
      });
    }
  }
}(jQuery));
