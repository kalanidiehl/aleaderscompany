<?php
$node = node_load($row->node_og_membership_nid);
if ($node->certificate['node_settings']['manual']['manual'] == '-1') {
  $certificate = 'inactive';
}
elseif (opigno_quiz_app_course_class_passed($node->nid)) {
  $certificate = 'download';
}
else {
  $certificate = 'active';
}
?>

<div class="title">
  <?php print($fields['title_1']->content); ?>
</div>

<div class="course_image">
  <?php print($fields['field_image_product']->content);// print the inmage ?>
</div>
<div class="content-bottom">
    <div class="progression">

      <?php if ($view->render_field('course_class_progress', $view->row_index) == "100") { ?>
          <span class="background" style="width: 100%; background: green"></span>
          <span class="text">Completed</span>
      <?php } else { ?>
          <span class="background"
                style="width:<?php print $view->render_field('course_class_progress', $view->row_index) ?>%;"></span>
          <span class="text">
      <?php print t('progress:') ?> <?php print $view->render_field('course_class_progress', $view->row_index) ?>
              %
    </span>
      <?php } ?>

    </div>
    <div class="pictogram">
      <?php if ($view->render_field('course_class_progress', $view->row_index) != 100): ?>
        <?php if ($view->render_field('course_class_progress', $view->row_index)): ?>
              <a href="<?php print url('node/' . $row->node_og_membership_nid . '/resume') ?>"
                 class="link-button take"><?php print t('Continue') ?></a>
        <?php else: ?>
              <a href="<?php print url('node/' . $row->node_og_membership_nid . '/resume') ?>"
                 class="link-button take"><?php print t('Start') ?></a>
        <?php endif; ?>
      <?php elseif ($certificate == 'inactive'): ?>
          <span class="link-button inactive-certificate"></span>
      <?php elseif ($certificate == 'active'): ?>
          <span class="link-button active-certificate"></span>
      <?php else: ?>
          <a href="<?php print url('node/' . $row->node_og_membership_nid . '/certificate') ?>"
             class="link-button download-certificate"></a>
      <?php endif; ?>
    </div>
</div>
