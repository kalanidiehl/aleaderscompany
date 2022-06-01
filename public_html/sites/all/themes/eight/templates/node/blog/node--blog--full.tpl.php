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

$date_post = array_combine(array('day','month','year'),explode(" ",format_date($created,'custom','d M Y')));
$user_node = user_load($uid);

?>
<div class="blog-item">
    <?php if(isset($content['field_media_blog'])): ?>
        <div class="blog-media"><?php print render($content['field_media_blog']) ?></div>
    <?php endif; ?>
    <div class="blog-item-data clearfix">
        <div class="blog-date">
            <div class="date">
                <div class="date-cont">
                    <span class="day"><?php print $date_post['day'] ?></span>
                    <span title="March" class="month">
                        <span><?php print $date_post['month'] ?></span>
                    </span>
                    <span class="year"><?php print $date_post['year'] ?></span>
                    <i class="springs"></i>
                </div>
            </div>
        </div>
        <h2 class="blog-title"><?php print $title ?></h2>
        <div class="divider gray"></div>
        <p class="post-info">
            <?php print t('by') ?> <span class="posr-author"><?php print $name ?> </span>
            <?php if($content['field_category_blog']):  ?>
                <i>|</i>in
                <?php print render($content['field_category_blog']) ?>
            <?php endif; ?>
            <i>|</i><?php print $comment_count ?> <span><?php print t('comments') ?></span></p>
    </div>
    <?php if(isset($content['field_body_blog'])): ?>
        <div class="blog-item-body">
            <?php print render($content['field_body_blog']) ?>
        </div>
    <?php endif ?>
    <div class="blog-item-foot clearfix">
        <div class="row">
            <?php if(isset($flippy)): ?>
            <div class="col-md-6 nav-blog">
                <?php print $flippy ?>
            </div>
            <?php endif; ?>
            <?php if(isset($content['field_tags_blog'])): ?>
            <div class="col-md-6 tags-blog">
                <?php print render($content['field_tags_blog']); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<hr class="style-2" />
<div class="admin-about clearfix mt-60 mb-60">
    <div class="avatar-author"><?php print $user_picture ?></div>
    <div class="admin-info">
        <h2 class="admin-name"><a href="#"><span><?php print t('About') ?></span> <?php print $name ?></a></h2>
        <?php print $user_node->field_about_user[LANGUAGE_NONE][0]['safe_summary'] ?>
        <p> <a href="#" class="cws-social flaticon-facebook55"></a><a href="#" class="cws-social flaticon-twitter1"></a><a href="#" class="cws-social fa fa-google-plus"></a><a href="#" class="cws-social flaticon-social-network106"></a><a href="#" class="cws-social flaticon-pinterest3"></a></p>
    </div>
</div>

<?php if(isset($content['comments'])): ?>
<hr class="style-2" />
    <?php print render($content['comments']); ?>
<?php endif; ?>

