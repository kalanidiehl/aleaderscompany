(function ($) {
  Drupal.behaviors.opigno_video_wysiwyg = {
    attach: function (context, settings) {
      $('#video-browser-page div.video-item a').click(function (){
        var nid = $(this).attr('ref');
        $('.video-item').css('background-color', 'white');
        $(this).parent().css('background-color', 'antiquewhite');
        Drupal.settings.wysiwyg.plugins.drupal.opigno_video.global.selectedId = nid;
        return false;
      });
      // dimensions
      $('.video-file-browser-dimensions').change(function (){
        Drupal.settings.wysiwyg.plugins.drupal.opigno_video.global.dimensions = $(this).val();
      });
    },
    videoBrowser: function (onSelect, data, settings, instanceId){
      // popup dialog
      var $dialog = $('<div></div>')
      .load(settings.global.url)
      .dialog({
        autoOpen: false,
        title: 'Video Browser',
        width: 640,
        height: 360
      });
      $dialog.dialog('open');
      // add button
      $dialog.dialog({
        buttons: [

        {
          text: "Ok",
          click: function() {
            $(this).dialog("close");
          }
        }
        ]
      });

      // close
      $dialog.dialog({
        close: function(event, ui) {
          var nid = Drupal.settings.wysiwyg.plugins.drupal.opigno_video.global.selectedId;
          if(nid.length)
            onSelect(nid, data, settings, instanceId);
        }
      });
    }
  };
})(jQuery);