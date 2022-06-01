<?php
/*This is the page that is displayed when a user is already part of the LMS and is actually already enrolled in the course
It takes over the display from the node--products--full

*/

$short_description = $body[0]['safe_summary'];
$long_description = $body[0]['safe_value'];
$course_message=NULL;

$elements['field_image_product']['#access']=TRUE;
$elements['field_vote']['#access'] = TRUE;

if (og_is_member('node', $variables['node']->nid)) {
  $course_message = "You are currently enrolled in this course";
}


//print the context navigation if its available
if (!empty($og_context_navigation)): ?>
    <div id="og-context-navigation">
      <?php print $og_context_navigation; ?>
    </div>
<?php endif; ?>

<div class="main single-product course_member">
    <div class="row">
        <!-- images of product-->
        <?php if (isset($course_message)){?>
        <div class="col-sm-12">
            <div class="course_member_status"><?php
              print $course_message;
              ?></div>
        </div>
        <?php } ?>
        <div class="images col-md-5">
            <!-- picture-->
          <?php print render($elements['field_image_product']) ?>
            <!-- ! picture-->
        </div>
        <!-- ! images of product-->
        <!-- main description product-->
        <div class="summary col-md-7">

            <div class="review-status">
                <div class="star-vote"><?php print render($elements['field_vote']) ?></div>
                <div class="count-review"><?php print t('!count Reviews', ['!count' => $comment_count]) ?></div>
                <!--<div class="status-product in-stock">< ?php print t('In stock')?></div>-->
            </div>

            <hr class="mt-10 mb-10">
            <p class="description-product"><?php print render($short_description) ?></p>

        </div>
        <!-- ! main description product-->
    </div>
    <div class="clearfix"></div>
    <!-- tabs-->
    <div class="tabs">
        <div class="block-tabs-btn clearfix">
            <div data-tabs-id="tabs1" class="tabs-btn active">DETAILS</div>
            <div data-tabs-id="tabs2"
                 class="tabs-btn"><?php print t('Reviews (!count)', ['!count' => $comment_count]) ?></div>
            <div data-tabs-id="tabs3" class="tabs-btn">CURRICULUM</div>
            <div data-tabs-id="tabs4" class="tabs-btn">FAQ</div>
        </div>
        <!-- tabs keeper-->
        <div class="tabs-keeper">
            <div data-tabs-id="cont-tabs1" class="container-tabs active">
              <?php print render($long_description) ?>
            </div>

            <div data-tabs-id="cont-tabs2" class="container-tabs">
              <?php print render($elements['comments']) ?>
            </div>
            <div data-tabs-id="cont-tabs3" class="container-tabs">
              <?php if(isset($field_curriculum['und'][0]['value'])) {
              print $field_curriculum['und'][0]['value']; } else
                  print "Currently Unavailable.  Check back soon";?>
            </div>
            <div data-tabs-id="cont-tabs4" class="container-tabs">
              <?php if(isset($field_curriculum['und'][0]['value'])) {
                print $field_faqs['und'][0]['value']; } else
                print "Currently Unavailable.  Check back soon";?>
            </div>
        </div>
        <!-- /tabs keeper-->
    </div>
    <!-- /tabs-->
</div>