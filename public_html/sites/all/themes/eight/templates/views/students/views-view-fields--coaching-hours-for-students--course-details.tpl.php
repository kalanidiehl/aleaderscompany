<?php
$course_link = '';
if (isset($row->field_opigno_class_courses[0]['rendered']['#item']['target_id'])) {
  $course_link = '/node/' . $row->field_opigno_class_courses[0]['rendered']['#item']['target_id'];
}

?>
<?php
$belt_color = strtolower(str_replace(' ', '_', $row->field_field_belt_color[0]['rendered']['#markup']));
?>
<div class="belt-bg <?php print $belt_color ?>">

    <a href="<?php print $course_link ?>">




      <?php

      if (isset($row->field_opigno_class_courses[0]['rendered']['#label'])) {
        print $row->field_opigno_class_courses[0]['rendered']['#label'];
      }
      ?>


    </a>
    Coach: <?php print $fields['colorbox']->content;?>


    </div>

