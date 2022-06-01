<div class="portfolio-item text-center">
    <div class="pic">
        <img src="<?php print $fields['field_media_portfolio']->content ?>"
             alt="<?php print $fields['title']->content ?>">
        <div class="hover-effect alt"></div>
        <div class="links ">
            <a href="<?php print $fields['field_media_portfolio_1']->content ?>"
               class="link-icon color-4 alt flaticon-magnifying-glass84 fancy"></a>
            <a href="<?php print $fields['path']->content ?>"
               class="link-icon alt color-4 flaticon-return13"></a>
        </div>
    </div>
    <h3 class="portfolio-title"><a
                href="<?php print $fields['path']->content ?>"><?php print $fields['title']->content;?></a>
    </h3>
    <p class="description"></p>
    <div><?php print $fields['field_sumary_portfolio']->content;?></div>
</div>