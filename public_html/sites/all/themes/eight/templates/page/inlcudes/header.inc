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
    <nav class="main-nav js-stick small-height ">
        <div class="full-wrapper relative clearfix container">

            <div class="nav-logo-wrap local-scroll">
                <a href="https://aleaderscompany.com" class="logo"><!-- <?php //print base_path() ?> -->
                    <img src="<?php print $logo ?>" alt="<?php print $site_name ?>">
                   <!-- <img src=" print  file_create_url($logo_mobile->uri);?>" alt=" print $site_name ?>"  class="sticky-logo"> -->
                </a>
            </div>
            <?php if(isset($page['navigation'])): print render($page['navigation']); endif; ?>
        </div>
    </nav>
</header>
<!-- ! header page-->