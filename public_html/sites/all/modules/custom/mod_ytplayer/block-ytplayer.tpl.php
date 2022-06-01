
<div class="<?php print $classes ?>" style="background-image: url('<?php print $thumnail ?>');">
    <div class="mod_player" data-property="{
         videoURL:'<?php print $video ?>',
         containment:'.theme-ytplayer.video-banner',
         mute:<?php print $mute; ?> ,
         autoPlay:<?php print $autoplay; ?>,
         loop:<?php print $loop; ?>,
         showControls: <?php print $showcontrols; ?>,
         showYTLogo: <?php print $showytlogo; ?>,
         }">
    </div>
    <!-- end player -->
    <?php if($text_body): ?>
    <div class="video-body">
        <div class="container">
            <div class="video-content"><?php print $text_body; ?></div>
        </div>
    </div>
    <?php endif; ?>
    <!-- end container -->
</div>
<!-- end video-banner -->

