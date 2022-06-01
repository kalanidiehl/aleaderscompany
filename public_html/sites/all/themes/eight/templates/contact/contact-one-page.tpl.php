<div class="page-section pb-0">
<div class="container">
    <h2 class="title-section mt-0 mb-0 text-center">Contact Us</h2>
    <div class="divider mt-20 mb-25"></div>
    <p class="text-center">Curabitur at lacus ac velit ornare lobortis. Curabitur a felis in nunc fringilla tristique. Morbi mattis ullamcorper velit. Phasellus gravida semper<br> nisi. Nullam vel sem. Pellentesque libero tortor, tincidunt et, tincidunt eget, semper nec, quam.</p>
    <div class="row mt-60">
        <div class="col-md-6 mb-md-50">
            <?php if(isset($contact_info)): ?>
                <?php print check_markup($contact_info['value'],$contact_info['format']) ?>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
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
                <!-- /contact-form-->
            </div>
        </div>
    </div>
</div>
<div  id="address_map_contact" class="map-full-width map-wrapper mt-60 border-t map-wrapper"></div>
</div>