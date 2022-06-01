<?php $voc =  taxonomy_vocabulary_machine_name_load('category_portfolio');
$tree_cateory = taxonomy_get_tree($voc->vid,0)
?>
<div class="isotop-container">
    <?php if(isset($tree_cateory)): ?>
    <div class="container">
        <div class="filter-buttons mb-40">
            <a href="#" data-filter="*" class="filter-button color-2 active"><?php print t('All') ?></a>
        <?php foreach($tree_cateory as $tid => $term): ?>
            <a href="#" data-filter="<?php print '.item-'.$term->tid ?>" class="filter-button  color-2 "><?php print $term->name ?></a>
        <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="isotope-grid full-width-isotope row">
        <?php foreach ($rows as $id => $row):?>
            <?php

            $list_term = $view->result[$id]->field_field_category_portfolio;
            foreach($list_term as $key => $term){

               $terms[$id][] = 'item-'.$term['raw']['tid'];
            }
            ?>
            <div <?php if ($classes_array[$id]) { print ' class="pic isotope-item ' .implode(' ',$terms[$id]).' ' . $classes_array[$id] .'"';  } ?>>

                <?php print $row ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>