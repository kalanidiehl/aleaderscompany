<?php

/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
//check if this a course object
if ($node->type == 'course') {
  $short_description = $body[0]['safe_summary'];
  $long_description = $body[0]['safe_value'];
  //for some reason the access to certain fields is false, overriding them here but might be a permission issue somewhere to resolve later
  $content['field_image_product']['#access'] = TRUE;
  $content['field_vote']['#access'] = TRUE;
  $content['field_products']['#access'] = TRUE;
}
else {
  $short_description = $content['field_sumary_product'];
  $long_description = $content['field_body_product'];
}
?>
<div class="main single-product">
    <div class="row">
        <!-- images of product-->
        <div class="images col-md-5">
            <!-- picture-->
          <?php print render($content['field_image_product']) ?>
            <!-- ! picture-->
        </div>
        <!-- ! images of product-->
        <!-- main description product-->
        <div class="summary col-md-7">
            <!-- title product-->
            <!--<h2 class="product-title mt-0"><!?php print $title ?></h2>
            <!-- ! title product-->
            <!--<div class="divider mini gray left"></div>-->
            <div class="review-status">
                <div class="star-vote"><?php print render($content['field_vote']) ?></div>
                <div class="count-review"><?php print t('!count Reviews', ['!count' => $comment_count]) ?></div>
                <!--<div class="status-product in-stock">< ?php print t('In stock')?></div>-->
            </div>
            <div class="price">
              <?php print render($content['product:commerce_price']); ?>
                <!-- $100.00<span class="old-price">$120.00</span> -->
            </div>
            <hr class="mt-10 mb-10">
            <p class="description-product"><?php print render($short_description) ?></p>
            <hr class="mt-10 mb-10">
            <div class="addtocart-nopop">
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
              <?php if (isset($content['product:field_amazon_url'])): ?>

                  <br>
                  <a href="<?php print render($content['product:field_amazon_url']['#items'][0]['url']); ?>"
                     target="_blank">
                      <button class="cws-button">Buy from Amazon</button>
                  </a>
              <?php endif; ?>
            </div>
            <hr class="mt-10 mb-10">
            <div class="mb-0 post-number"><?php print render($content['product:sku']) ?></div>


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
        </div>
        <!-- tabs keeper-->
        <div class="tabs-keeper">
            <div data-tabs-id="cont-tabs1" class="container-tabs active">
              <?php print render($long_description) ?>
            </div>

            <div data-tabs-id="cont-tabs2" class="container-tabs">
              <?php print render($content['comments']) ?>
            </div>

        </div>
        <!-- /tabs keeper-->
    </div>
    <!-- /tabs-->
</div>