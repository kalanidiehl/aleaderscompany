<?php include_once 'inlcudes/header.inc' ?>
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

