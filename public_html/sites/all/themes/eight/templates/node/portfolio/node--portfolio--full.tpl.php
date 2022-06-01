
<section class="page-section portfolio-item mb-0 pt-0 pb-60">
    
    <?php print render($content['field_media_portfolio']) ?>
  
    <div class="row">
        <div class="col-sm-8">
            <h2><?php print $title ?></h2>
            <div class="divider gray left mini"></div>
            <?php print render($content['field_body_portfolio']) ?>
        </div>
        <div class="col-sm-4 project-details">
            <h2><?php print t('Project Details') ?></h2>
            <div class="divider gray left mini"></div>
            <div class="description"><?php print t('Author:') ?> <span><?php print ucfirst($name) ?></span></div>
            <?php if(isset($content['field_category_portfolio'])): ?>
            <div class="description"><?php print render($content['field_category_portfolio']) ?></div>
            <?php endif; ?>
            <div class="description"><?php print t('Date:') ?> <span><?php print format_date($created,'custom','d M, Y');?></span></div>
            <?php if(isset($content['field_tags_portfolio'])): ?>
            <div class="description">
               <?php print render($content['field_tags_portfolio']) ?>
            </div>
            <?php endif; ?>
            <?php if(isset($content['field_link_portfolio'])): ?>
               <div class="description"><?php print render($content['field_link_portfolio']) ?></div>
            <?php endif; ?>
            <?php if(isset($content['field_rate_porfolio'])): ?>
            <div class="description">
                <!--
                Rate:
                <div class="span-alt">
                    <div class="star-rating"><span style="width:90%"></span></div>
                </div>
                -->
                <?php print render($content['field_rate_porfolio']) ?>
            </div>
            <?php endif; ?>
            <div class="description">
                <?php print t('Social:') ?>
                <span>
                    <a href="#" class="social fa fa-facebook"></a>
                    <a href="#" class="social fa fa-twitter"></a>
                    <a href="#" class="social fa fa-google-plus"></a>
                    <a href="#" class="social fa fa-linkedin"></a>
                    <a href="#" class="social fa fa-pinterest-square"></a>
                </span>
            </div>
        </div>
    </div>
</section>

<?php if(isset($content['comments'])): ?>
    <hr class="style-2 " />
    <?php print render($content['comments']); ?>
<?php endif; ?>