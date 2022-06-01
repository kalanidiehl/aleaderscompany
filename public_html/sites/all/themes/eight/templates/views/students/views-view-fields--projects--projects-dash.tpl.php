<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT
 *   output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field.
 *   Do not use var_export to dump this object, as it can't handle the
 *   recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to
 *   use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<div class="full-width">
<?php
if ((isset($fields['timestamp'])) || ($fields['new_comments']->raw > 0)) {
  print "<div class='updated'><i class=\"fa fa-star\" aria-hidden=\"true\"></i>&nbsp".$fields['title']->content."</div>";
  $updated = true;
}
else {
  print $fields['title']->content;
}
?>
</div>
<div class="full-width font-small">
<?php

print 'Comments: '.$fields['comment_count']->raw;
if ($fields['new_comments']->raw > 0) {
  print ' - ' . $fields['new_comments']->content;
}
if ($fields['comment_count']->raw > 0) {
  print ' | Last Comment: ' . $fields['last_comment_timestamp']->content;
}
if ($fields['field_project_goal_type']->content != 'Not Applicable') {
  print "<span class='goal-type'>".$fields['field_project_goal_type']->content."</span>";
}


?>
</div>
