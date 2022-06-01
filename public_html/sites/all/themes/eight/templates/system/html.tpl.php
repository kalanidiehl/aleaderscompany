<?php

/**
 * @file
 * Implementation to display a single Drupal page while offline.
 *
 * All the available variables are mirrored in page.tpl.php.
 *
 * @see template_preprocess()
 * @see template_preprocess_maintenance_page()
 * @see bartik_process_maintenance_page()
 */


?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1" />
    <?php print $head; ?>
    <?php if($is_front) {
      print '<title>Lean Leadership Institute</title>';
    } else {
      print '<title>' . $head_title . '</title>';
    }?>
    <?php print $styles; ?>
    <?php print $scripts; ?>

</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
<?php print $page_top; ?>
<?php print $page; ?>
<?php print $page_bottom; ?>

<div id="scroll-top"><i class="fa fa-angle-up"></i></div>


</body>

</html>