<?php
/**
 * @file
 * Tool template file. Renders the tool on the tools page.
 * Available variables:
 *  - $machine_name (filtered)
 *  - $name (filtered)
 *  - $path (escaped)
 *  - $description (escaped)
 *  - $tool (array containing any information the tool module defines. Unfiltered).
 */
?>
<div class="opigno-tool opigno-<?php print str_replace('_', '-', $machine_name); ?>-tool col-xs-12 col-lg-4 col-md-6">
    <div class="wrapper opigno-tool-block col-md-12 col-lg-12 col-xs-12">
        <div class="opigno-tool-icon">
            <h4 class="opigno-tool-name">
              <?php if (!empty($path)): ?>
                <?php print l($name, $path, ['attributes' => ['class' => ['opigno-tool-link']]]); ?>
              <?php else: ?>
                <?php print $name; ?>
              <?php endif; ?>
            </h4>
        </div>
        <p class="opigno-tool-description"><?php print $description; ?></p>
    </div>
</div>