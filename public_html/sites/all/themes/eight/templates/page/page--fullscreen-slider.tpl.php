<!-- header page-->
<header>    
    <?php if(!empty($page['top_sticky_left']) || !empty($page['top_sticky_right'])): ?>
        <div class="site-top-panel">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <?php if(isset($page['top_sticky_left'])): print render($page['top_sticky_left']); endif; ?>
                    </div>
                    <div class="col-sm-6">
                        <?php if(isset($page['top_sticky_right'])): print render($page['top_sticky_right']); endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <nav class="main-nav transparent stick-fixed ">
        <div class="full-wrapper relative clearfix container">

            <div class="nav-logo-wrap local-scroll">
                <a href="<?php print base_path() ?>" class="logo">
                    <img src="<?php print $logo ?>" alt="<?php print $site_name ?>">
                    <img src="<?php print  file_create_url($logo_mobile->uri);?>" alt="<?php print $site_name ?>"  class="sticky-logo">
                </a>
            </div>
            <?php if(isset($page['navigation'])): print render($page['navigation']); endif; ?>
        </div>
    </nav>
</header>
<!-- ! header page-->
<?php if(isset($page['breadcrumbs'])): print render($page['breadcrumbs']); endif; ?>

<div class="row">
    <?php if (!empty($page['sidebar_first'])): ?>
        <div class="sidebar col-xs-12 col-sm-6 col-md-3 sidebar">
            <?php print render($page['sidebar_first']); ?>
        </div>
    <?php endif; ?>

    <div <?php print $content_column_class; ?>>
        <?php if (!empty($page['highlighted'])): ?>
            <div class="highlighted"><?php print render($page['highlighted']); ?></div>
        <?php endif; ?>
        <div class="container">
            <?php print $messages; ?>
            <?php if (!empty($tabs)): ?>
                    <?php print render($tabs); ?>
            <?php endif; ?>
            <?php if (!empty($page['help'])): ?>
                <?php print render($page['help']); ?>
            <?php endif; ?>
            <?php print render($title_prefix); ?>
            <?php if (!empty($title)): ?>

            <?php endif; ?>
            <?php print render($title_suffix); ?>
            <?php if (!empty($action_links)): ?>
                <ul class="action-links"><?php print render($action_links); ?></ul>
            <?php endif; ?>
        </div>
        <?php print render($page['content_top'])?>
        <?php print render($page['content']) ?>
        <?php print render($page['content_bottom']); ?>
    </div>

    <?php if (!empty($page['sidebar_second'])): ?>
        <div class="col-xs-12 col-sm-6 col-md-3 sidebar">
            <?php print render($page['sidebar_second']); ?>
        </div>
    <?php endif; ?>
</div>

<?php include_once 'inlcudes/footer.inc' ?>

