<div id="node-<?php print $node->nid; ?>"
     class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>


  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
      <h2<?php print $title_attributes; ?>>Meeting Request Submitted</h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>


    <div class="content"<?php print $content_attributes; ?>>
        <p>Your meeting request has been submitted. Please check your email for
            a calendar invite which you can add to your personal calendar.</p>

        The details for your meeting are as follows:<br>
        <div class="field">
            <div class="field-label">Subject:</div>
            <div class="field-items"><?php print $title ?></div>
        </div>
      <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      print render($content);
      ?>
    </div>


</div>