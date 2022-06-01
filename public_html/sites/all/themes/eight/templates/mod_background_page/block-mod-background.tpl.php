<?php
$current_path = explode('/',drupal_get_path_alias());
if ($current_path[0]=='meeting'){
    $title_page = "Meeting Scheduling Request";
}
?>

<section class="breadcrumbs" id="subheader" data-speed="8"
         data-type="background"
         style="background-image: url(<?php print $img_url ?>)">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1><?php print $title_page ?></h1>

              <?php
              if ($logged_in) {
                if (($title_page == "Client Training Dashboard")|| ($title_page == "Admin Dashboard") || ($title_page == "Coach Dashboard")){
                  $user = user_load($user->uid);
                  print "Welcome back " . $user->field_address['und'][0]['first_name'] . ' ' . $user->field_address['und'][0]['last_name'];
                }
                if ($title_page == "Client Training Dashboard"){
                  print "<br>Check out the latest Developments...";
                }

              }


              ?>
            </div>
            <!-- removed breadcrumbs for now by Sascha - Aug 10 2017
            <div class="col-sm-12 text-left breadcrumbs-item">
                <!?php print $breadcrumbs; ?>
            </div>
            -->
        </div>
    </div>
</section>