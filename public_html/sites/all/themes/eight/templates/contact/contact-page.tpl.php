<?php if(arg(0) == 'contact'){ ?>
<div id="address_map_contact" class="map-wrapper"></div>
<div class="row mt-60">
    <div class="col-md-6 mb-md-50">
        <?php print check_markup($contact_info['value'],$contact_info['format']) ?>
    </div>
    <div class="col-md-6">
        <h2 class="mt-0 mb-30">Send a message</h2>
        <div class="widget-contact-form pb-0">
            <!-- contact-form-->
            <div id="feedback-form-errors" role="alert" class="alert alert-danger alt alert-dismissible fade in">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button><i class="alert-icon border flaticon-exclamation-mark1"></i><strong>Error Message!</strong><br>
                <div class="message"></div>
            </div>
            <div class="email_server_responce"></div>
            <div class="form contact-form alt clearfix">
               <?php print drupal_render_children($form); ?>
            </div>

        </div>
    </div>
</div>
<?php } else{ ?>
    <?php print render($form); ?>
<?php } ?>
