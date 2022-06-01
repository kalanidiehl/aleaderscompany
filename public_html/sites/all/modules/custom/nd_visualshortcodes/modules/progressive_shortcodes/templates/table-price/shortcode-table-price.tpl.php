
<?php if(!empty($attributes_shortcode)): ?>
<div <?php print $attributes_shortcode ?>>
    <?php endif; ?>
    <div class="pricing-tables <?php ($featured == true) ? 'active' : '' ?> <?php print !empty($table_class) ? $table_class : '' ?>">
        <?php if(isset($title) && !empty($title)): ?>
            <div class="header-pt">
                <h3><?php print $title ?></h3>
            </div>
        <?php endif; ?>
        <div class="price-pt">
            <?php if(isset($currency_label) && !empty($currency_label)): ?>
                <sup><?php print $currency_label ?></sup>
            <?php endif; ?>

            <?php if(strpos($price,'.') !== false){ ?>
                <?php $slip_price = explode('.',$price); ?>
                <?php print trim($slip_price[0]) ?>
                <sup><?php print '.'.$slip_price[1] ?></sup>
            <?php } else{ ?>
                <?php print trim($price) ?>
            <?php } ?>
            <?php if(isset($date_price) && !empty($date_price)): ?>
                <sub><?php print $date_price ?></sub>
            <?php endif; ?>
        </div>
        <?php if(isset($description) && !empty($description)): ?>
            <div class="desc">
                <?php print $description ?>
            </div>
        <?php endif; ?>
        <?php if(isset($rows) && !empty($rows)): ?>
            <ul class="pricing-list">
                <?php foreach($rows as $key => $row): ?>
                    <li <?php print ($row['active_row'] == true) ? 'class="active"' : ''  ?>>
                        <?php if(isset($row['icon_row']) && !empty($row['icon_row'])){ ?>
                            <i class="list-icon <?php print $row['icon_row'] ?>"></i>
                        <?php } ?>
                        <?php print !empty($row['title_row']) ? $row['title_row'] : '' ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if(isset($read_more_text) && !empty($read_more_text)): ?>
            <a href="<?php print !empty($read_more_link) ? $read_more_link : '#' ?>" class="cws-button small <?php print !empty($read_more_class) ? $read_more_class : '' ?>"><?php print $read_more_text ?></a>
        <?php endif; ?>
    </div>
    <?php if(!empty($attributes_shortcode)): ?>
</div>
<?php endif; ?>