<?php if(!empty($attributes_shortcode)): ?>
    <div <?php print $attributes_shortcode ?>>
<?php endif; ?>
    <div class="comments">
        <div class="comment-list">
            <div class="comment-container <?php print !empty($container_class) ? $container_class : '' ?> clearfix">
                <div class="author">
                    <?php if(isset($file_image) && !empty($file_image)): ?>
                        <img src="<?php print file_create_url($file_image->uri)  ?>" alt="<?php print $file_image->alt ?>" <?php print !empty($image_class) ? 'class="'.$image_class.'"' : '' ?> />
                    <?php endif; ?>
                    <div class="author-name <?php print !empty($class_author) ? $class_author : '' ?>"><?php print !empty($author_name) ? $author_name : '' ?></div>
                </div>
                <div class="comment-text">
                    <?php if(!empty($description)): ?>
                    <div class="description">
                        <p><?php print $description ?></p>
                    </div>
                    <?php endif; ?>

                    <a href="<?php print !empty($link) ? $link : '#' ?>" class="button-reply <?php print !empty($class_link) ? $class_link : '' ?>">
                        <?php print !empty($text_link) ? $text_link : '' ?>
                        <?php if(!empty($icon_link)): ?>
                         <i class="<?php print $icon_link ?>"></i>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php if(!empty($attributes_shortcode)): ?>
    </div>
<?php endif; ?>