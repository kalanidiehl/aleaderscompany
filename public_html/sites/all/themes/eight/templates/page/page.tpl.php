<?php include_once 'inlcudes/header.inc' ?>
<?php

$coursepage = FALSE;
$show_group_state = FALSE;


//if not logged in, dont display the action links and ensure columns set to wide
if (isset($variables['node'])) {
  $content_column_class = 'class="col-xs-12 col-sm-12 col-md-12"';

  if (!(og_is_member('node', $variables['node']->nid))&& $variables['node']->type=="course") {
    $action_links = NULL;
  }
  else {


    if (((isset($group_state)) && (!empty($group_state))) || ((isset($page['sidebar_second'])) && (!empty($page['sidebar_second'])))):
      $show_group_state = TRUE;
      $content_column_class = 'class="col-xs-12 col-sm-6 col-md-9"';
    endif;


    if (isset($node) && ($node->type == 'course')):
      $coursepage = TRUE;
    endif;
  }
}

?>
<?php if (isset($page['breadcrumbs'])): print render($page['breadcrumbs']); endif; ?>
<div class="container page">
    <div class="row">

      <?php if (!empty($page['sidebar_first'])): ?>
          <div class="sidebar col-xs-12 col-sm-6 col-md-3 sidebar">
            <?php print render($page['sidebar_first']); ?>
          </div>
      <?php endif; ?>

        <div <?php print $content_column_class; ?>>
          <?php if (!empty($page['highlighted'])): ?>
              <div class="highlighted"><?php print render($page['highlighted']); ?></div>
          <?php endif; ?>
          <?php print $messages; ?>
          <?php if (!empty($tabs)): ?>
            <?php print render($tabs); ?>
          <?php endif; ?>
          <?php if (!empty($page['help'])): ?>
            <?php print render($page['help']); ?>
          <?php endif; ?>
          <?php print render($title_prefix); ?>
          <?php if (!empty($title)): ?>

          <?php endif; ?>
          <?php print render($title_suffix); ?>
          <?php if (!empty($og_context_navigation)): ?>
              <div id="og-context-navigation">
                <?php print $og_context_navigation; ?>
              </div>
          <?php endif; ?>
          <?php if (!empty($action_links)):
            if (!$coursepage): ?>
                <ul class="action-links"><?php print render($action_links); ?></ul>
            <?php endif; ?>
          <?php endif; ?>
          <?php print render($page['content_top']) ?>
          <?php print render($page['content']) ?>
          <?php print render($page['content_bottom']); ?>

          <?php
          //print the action links at bottom for a course page
          if (!empty($action_links) && ($coursepage)): ?>
              <ul class="action-links"><?php print render($action_links); ?></ul>
          <?php endif; ?>
        </div>

      <?php
      // render the group state at top of the second sidebar even is sidebar is empty
      if ((empty($page['sidebar_second'])) && ($show_group_state == TRUE)): ?>
          <div class="col-xs-12 col-sm-6 col-md-3 sidebar">
            <?php print render($group_state); ?>
          </div>
      <?php endif;

      //if the sidebar isn't empty then add group state to the top
      if (!empty($page['sidebar_second'])): ?>
          <div class="col-xs-12 col-sm-6 col-md-3 sidebar">
            <?php if ($show_group_state == TRUE):
              print render($group_state);
            endif;
            print render($page['sidebar_second']); ?>
          </div>
      <?php endif; ?>
    </div>
</div>
<?php include_once 'inlcudes/footer.inc' ?>

