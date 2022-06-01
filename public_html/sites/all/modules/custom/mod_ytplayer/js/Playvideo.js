(function($){
    if($.fn.YTPlayer) {
        function fullscreenBanner() {
            var h = $(window).height();
            $('.video-fullscreen').each(function (i) {
                $(this).height(h);
                $(this).find('.video-body').height(h);
            });
        }
        $(document).ready(fullscreenBanner());
        $(window).resize(fullscreenBanner);
        $('.mod_player').YTPlayer();
    }
}(jQuery));