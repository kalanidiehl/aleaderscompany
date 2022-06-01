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
<div class="contact_box">
    <div class="contact_card">
        <div class="left_side">
          <?php
          print $fields['field_address_name_line']->content;
          print $fields['field_address_organisation_name']->content;
          print $fields['mail']->content;
          print $fields['field_mobile_phone']->content;
          print $fields['field_additional_phone']->content;
          print "<div class='field-content'>Skype: <a href='skype://" . $row->field_field_skype_id[0]['raw']['value'] . "'>" . $row->field_field_skype_id[0]['raw']['value'] . "</a></div>";

          ?>
        </div>
        <div class="right_side">
          <?php print $fields['picture']->content ?>

        </div>
    </div>
    <div class="coaching_info mt-20 text-center">
        Coaching Hours Remaining
        <div>
            <input id="uid" value="<?php print $row->uid?>" disabled hidden>
            <button id="subtract-time-button"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>
            <input type="number"
                   name="coaching_hours"
                   value="<?php print number_format((float) $row->field_field_coaching_hours[0]['raw']['value'], 2, '.', '') ?>"
                   disabled id="coaching_hours">
            <button id="add-time-button"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
            <div id="saved"></div>
        </div>


    </div>
    <div class="text-center mt-20">
      <?php
      print "<a href='/node/add/meeting-request?uid=" . $row->uid . "'><button class='cws-button'>Schedule Meeting</button></a>";

      ?>

    </div>

</div>



