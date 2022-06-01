<!-- footer-->
<?php $current_path = explode('/',drupal_get_path_alias());
$print_footer=TRUE;

?>



<footer class="footer <?php if(!$print_footer){ print "small-footer"; }?>"  >
  <?php if($print_footer):?>
    <div class="container">
        <div class="row cws-multi-col">
            <div class="col-md-3 first-col col-sm-6 mb-md-50">
                <!--
                <div class="widget-footer text">
                    <h3>About</h3>
                    <div class="divider"></div>
                    <p>Ut tincidunt nisl sapien, eget gravida quama vestibulum vitae. Ut ultrices purus quis tinci dunt rutrum proin commodo ipsum.</p>
                    <p>Vestibulum vitae nisl quis elit tristique egesi tas eget sed nisi. Etiam mi sapien, luctus ac tempor quis, varius eu neque.</p>
                </div>-->
                <?php if($page['footer_first']): ?>
                    <?php print render($page['footer_first']) ?>
                <?php endif; ?>
            </div>
            <div class="col-md-2 col-sm-6 mb-md-50">
                <?php if(isset($page['footer_second'])): print render($page['footer_second']); endif; ?>
            </div>
            <div class="col-md-2 col-sm-6 mb-sm-50">
                <?php if(isset($page['footer_third'])): print render($page['footer_third']); endif; ?>
            </div>
            <div class="col-md-2 col-sm-6">
                <?php if(isset($page['footer_four'])): print render($page['footer_four']); endif; ?>
            </div>
            <div class="col-md-2 col-sm-6">
                <?php if($page['footer_five']): ?>
                    <?php print render($page['footer_five']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
  <?php endif;?>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-sm-12" style="text-align:center;">
                   <?php if(isset($page['copyright'])): print render($page['copyright']); endif; ?>
                </div>
                <!--<div class="col-sm-4 text-right">
                    <?php if(isset($page['social_footer'])): print render($page['social_footer']); endif; ?>
                </div>-->
            </div>
        </div>
    </div>

</footer>

