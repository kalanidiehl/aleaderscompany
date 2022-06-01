<?php
/**
 * @file
 * Default theme implementation of an Instagram image link.
 *
 * Available variables:
 * - post: The entire data array returned from the Instagram API request.
 * - href: The url to the Instagram post page.
 * - src: The source url to the instagram image.
 * - width: The display width of the image.
 * - height: The display height of the image.
 */
?>
<div class="gallery-item">
  <div class="pic">
    <img  alt="<?php print drupal_html_id('image-instagram') ?>"  style="float: left; margin: 0 5px 5px 0px; width: <?php print $width ?>px; height: <?php print $height ?>px;" src="<?php print $src ?>">
    <div class="hover-effect alt">
      <div class="links"><a href="<?php print $src ?>" data-rel="group1" class="link-icon alt flaticon-magnifying-glass84 fancy"></a></div>
    </div>
  </div>
</div>

