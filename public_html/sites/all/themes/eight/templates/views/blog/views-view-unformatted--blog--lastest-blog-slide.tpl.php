<div class="carousel-container hover-item views-blog-slide">
    <div class="row">
        <div class="owl-three-pag pagiation-carousel main-color carousel-hover">
            <?php foreach ($rows as $id => $row):?>
            <div<?php if ($classes_array[$id]) { print ' class="blog-item blog-box small ' . $classes_array[$id] .'"';  } ?>>
                <?php print $row; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>