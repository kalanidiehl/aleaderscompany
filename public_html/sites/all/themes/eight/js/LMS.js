/**
 * @file
 * Define theme JS logic.
 */

;
(function($, Drupal, window, undefined) {

  Drupal.settings.eight = Drupal.settings.eight || {};

  Drupal.behaviors.eight = {

    attach: function(context) {


      if ($('#opigno-group-progress').length) // use this if you are using id to check
      {
        $("#second-sidebar #content").addClass("has-group-progress");
        $("#second-sidebar #tabs").addClass("has-group-progress");
        $("#second-sidebar .action-links").addClass("has-group-progress");
      }


      // Make messages dismissable.
      $('div.messages', context).each(function() {
        var $message = $(this),
          $dismiss = $('span.messages-dismiss', this);
        if ($dismiss.length && !$dismiss.hasClass('js-processed')) {
          $dismiss.click(function() {
            $message.hide('fast', function() {
              $message.remove();
            });
          }).addClass('js-processed');
        }
      });

      // Show the number of unread messages.
      if (typeof Drupal.settings.eight.unreadMessages !== 'undefined' && Drupal.settings.eight.unreadMessages) {
        var $messageLink = $('#main-navigation-item-messages', context);
        if ($messageLink.length && !$messageLink.hasClass('js-processed')) {
          $messageLink.find('a').prepend('<span id="messages-num-unread">' + Drupal.settings.eight.unreadMessages + '</span>');
          $messageLink.addClass('js-processed');
        }
      }

      // Make the entire tool "block" clickable for a better UX.
      $('.opigno-tool-block', context).each(function() {
        var $this = $(this);
        if (!$this.hasClass('js-processed')) {
          $this.click(function() {
            window.location = $this.find('a.opigno-tool-link').attr('href');
          }).addClass('js-processed');
        }
      });


    }
  };

})(jQuery, Drupal, window);
