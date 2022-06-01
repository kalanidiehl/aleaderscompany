<?php
if ($node->type == 'course') {

  //for some reason the access to certain fields is false, overriding them here but might be a permission issue somewhere to resolve later
  $content['field_image_product']['#access'] = TRUE;
  $content['field_vote']['#access'] = TRUE;
  $content['field_products']['#access']=TRUE;

}


$type_product = isset($content['field_type_product']) ? trim(render($content['field_type_product'])) : '';

$itemcount = count($content['field_products']["#items"]);
?>
<div class="product <?php print $type_product; ?>">
  <?php if (!empty($type_product)): ?>
      <div class="action <?php print $type_product ?>"><?php print ucwords($type_product) ?></div>
  <?php endif; ?>
    <!-- picture-->
  <?php if (isset($content['field_image_product'])): ?>
      <div class="pic">
        <?php print render($content['field_image_product'][0]) ?>
          <div class="hover-effect"></div>
          <div class="links">
              <a href="<?php print file_create_url($content['field_image_product'][0]['#item']['uri']); ?>"
                 class="link-icon flaticon-magnifying-glass84 fancy"></a>
              <a href="<?php print $link_node ?>"
                 class="link-icon flaticon-return13"></a>
          </div>
      </div>
  <?php endif; ?>
    <!-- ! picture-->
    <h3 class="product-title">
        <a href="<?php print $link_node ?>"><?php print $title ?></a>
    </h3>
    <div class="price-review">
        <div class="star-vote">
          <?php print render($content['field_vote']) ?>
        </div>

        <div class="price">
          <?php if ($itemcount == 1) {
            print render($content['product:commerce_price']);
          } ?>
        </div>

    </div>

  <?php if ($itemcount == 1): ?>
      <div class="button_add_to_cart"><?php print render($content['field_products']) ?></div>
  <?php else: ?>
      <div class="button_add_to_cart">
          <a class="colorbox-inline"
             href="?height=75%&width=33%&inline=true#addtocartpop_<?php print render($nid); ?>">
              <button class="cws-button with-icon">Add to Cart<i
                          class="flaticon-shopping-carts6"></i></button>
          </a>

          <div class="hiddenbox">
              <div id="addtocartpop_<?php print render($nid); ?>"
                   class="addtocartpop variationlist">
                  <h4><?php print $title ?></h4>
                  <div class="price">
                    <?php print render($content['product:commerce_price']); ?>
                  </div>
                <?php if ($type == 'course') { ?>

                    <div class="accordion style-1">

                        <div id="cart_prerequisites"
                             class="content-title <?php if (!isset($content['product:field_course_prerequisites'][0]))
                               print 'hiddenbox' ?>">
                        <span>
                            <i class="accordion-icon"></i>Prerequisites
                        </span>
                        </div>
                        <div class="content" style="display: none">
                          <?php print render($content['product:field_course_prerequisites']); ?>
                        </div>


                        <div id="cart_coaching"
                             class="content-title <?php if ((!isset($content['product:field_coaching_hours'][0])) && (!isset($content['product:field_course_coachmonitor'][0])))
                               print 'hiddenbox' ?>">
                        <span>
                            <i class="accordion-icon"></i>Coaching Details
                        </span>
                        </div>
                        <div class="content" style="display: none">
                          <?php print render($content['product:field_coaching_hours']); ?>
                          <?php print render($content['product:field_course_coachmonitor']); ?>
                        </div>


                        <div id="cart_focus"
                             class="content-title <?php if (!isset($content['product:field_course_focus'][0]))
                               print 'hiddenbox' ?>">
                        <span>
                            <i class="accordion-icon"></i>Focus
                        </span>
                        </div>
                        <div class="content" style="display: none">
                          <?php print render($content['product:field_course_focus']); ?>
                        </div>


                        <div id="cart_overview"
                             class="content-title <?php if (!isset($content['product:field_course_overview'][0]))
                               print 'hiddenbox' ?>">
                        <span>
                            <i class="accordion-icon"></i>Overview
                        </span>
                        </div>
                        <div class="content" style="display: none">
                          <?php print render($content['product:field_course_overview']); ?>
                        </div>


                        <div id="cart_expectations"
                             class="content-title <?php if (!isset($content['product:field_course_expectations'][0]))
                               print 'hiddenbox' ?>">
                        <span>
                            <i class="accordion-icon"></i>Expectations
                        </span>
                        </div>
                        <div class="content" style="display: none">
                          <?php print render($content['product:field_course_expectations']); ?>
                        </div>


                        <div id="cart_recertification"
                             class="content-title <?php if (!isset($content['product:field_course_recert'][0]))
                               print 'hiddenbox' ?>">
                        <span>
                            <i class="accordion-icon"></i>Recertification Details
                        </span>
                        </div>
                        <div class="content" style="display: none">
                          <?php print render($content['product:field_course_recert']); ?>
                        </div>


                    </div>
                <?php } ?>
                <?php print render($content['field_products']) ?>


              </div>
          </div>
      </div>
  <?php endif; ?>

</div>