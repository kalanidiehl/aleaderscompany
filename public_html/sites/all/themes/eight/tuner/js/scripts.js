/**/
/* on load event */
/**/
"use strict";
(function($){
function is_mobile_device () {
	if ( ( $(window).width()<767) || (navigator.userAgent.match(/(Android|iPhone|iPod|iPad)/) ) ) {
		return true;
	} else {
		return false;
	}
}
	
$(document).ready( function (){
	var theme_eight = Drupal.settings.theme_eight;

	if ( !is_mobile_device () && theme_eight.checkbox_style != 0 ) {
		$('body').append('<div id="tuner" class="tuner"> <div class="colors"> <p>Color Skin</p> <div id="color-1" class="color-picker" data-color="#'+theme_eight.color_page+'" style="background-color:#'+theme_eight.color_page+';"></div></div><div class="layout-style"><p>Layout Style</p><div class="page-style wide ">Wide</div><div class="page-style boxed">Boxed</div></div><i id="tuner-switcher" class="flaticon-cogwheels10"></i> </div> <div id="tuner-style-1" class="tuner-style" style="display: none;"> /* Colors for: main color */   input[type="number"], p a, ins, ul.icon-style li .list-icon, h2 span, h3 span, .inner-nav ul li a:hover, .inner-nav ul li a.active, .mobile_nav ul li a:hover, .mobile_nav ul.mn-sub li a:hover, .site-top-panel .lang-wrap .icon-lang, .breadcrumbs .breadcrumbs-item a:hover, .cws-button, .cws-button.alt:hover, .cws-button.white:hover, .cws-icon.main-color, .cws-icon.border-icon, .cws-icon.border-icon.alt:hover, .service-item:hover .cws-icon.border-icon.alt, .service-item.opacity:hover h3, .cws-icon.type-3:hover:before, .cws-icon.type-3.alt:before, .service-item:hover .cws-icon.type-3:before, .cws-social:hover:before, .service-center-icon .cws-icon, .accordion.style-3 dt.active i.accordion-icon:before, .accordion.style-4 dt.active i.accordion-icon:before, .toggle dt.active i.accordion-icon:before, .accordion.style-4 dt i.accordion-icon:before, .toggle dt i.accordion-icon:before, .toggle dt.active, .call-out-box.with-icon i, .alert.alert-info .alert-icon, .alert.alert-info .close, .counter-block .counter-icon, .counter-block .counter, .pic .links .link-icon.alt, .carousel-container .carousel-nav .prev:hover, .carousel-container .carousel-nav .next:hover, .comment-container .button-reply, .widget-footer .recent-item h4, .widget-footer address h4, .blog-item .blog-item-data .blog-title a, .nav-blog .prev:hover, .nav-blog .next:hover, .blog-date .date .month, .widget-search form .search-submit:hover, .widget-subscribe form .submit:hover, .widget-title i, .widget-categories ul li:hover, .widget-archive ul li:hover, .widget-categories ul li:hover:before, .widget-categories ul li:hover a, .widget-archive ul li:hover:before, .widget-archive ul li:hover a, .widget-tes-item .author-info .name, .ui-datepicker-calendar thead th, .project-details .description .link, .project-details .description .social:hover, #list-or-grid .switch-button.active, .product .price-review .button-groups, .size-filter .size:hover, .size-filter .size.active, input[type="checkbox"]:before, .shipping .amount, .woocommerce-shipping-fields #ship-to-different-address label, abbr, .contact-address p span, .twitter-1 .twitt-icon,.widget-footer address strong { color: #<span>cws_theme_main#</span>; }      .twitter-1 .twitt-icon, ul.style-3 li:before, .cws-button, .cws-icon.only-border, .cws-icon.border-icon:hover, .cws-icon.border-icon.alt, .service-item:hover .cws-icon.border-icon, .cws-icon.type-3:after, .cws-icon.type-3.alt:hover, .cws-icon.type-3.alt:hover:after, .service-item:hover .cws-icon.type-3.alt, .service-item:hover .cws-icon.type-3.alt:after, .cws-social:hover, .accordion dt.active i.accordion-icon, .toggle dt.active i.accordion-icon, .accordion.style-2 dt i.accordion-icon, .accordion.style-2 dt.active, .accordion.style-4 dt i.accordion-icon, .toggle dt i.accordion-icon, .accordion.style-4 dt.active, .toggle dt.active, .toggle.style-2 dt.active, .call-out-box.with-icon i, .alert.alert-info, .alert.alert-info.alt, .counter-block, .pricing-tables, .tabs .tabs-btn:hover, .tabs .tabs-btn.active, .pic .links .link-icon.alt, .pagination li a:hover, .pagination li a:focus, .carousel-container .carousel-nav .prev:hover, .carousel-container .carousel-nav .next:hover, .author img, .widget-search form .search-submit, .widget-subscribe form .submit, .widget-tags .tag:hover, .widget-tes-item .avatar-author, .carousel-pag.main-color .owl-page.active, .pagiation-carousel.main-color .owl-page.active, .contact-form .cws-button, .contact-form .cws-button:hover, .avatar-author, .filter-button.active, .filter-button:hover, #list-or-grid .switch-button.active, .price_slider .ui-slider-handle:before, .size-filter .size:hover, .size-filter .size.active,.tuner { border-color: #<span>cws_theme_main#</span>; }     ul.style-3 li:before, .inner-nav .mobile_menu_switcher, .main-nav:not(.transparent) .inner-nav.desktop-nav.switch-menu .menu-bar .ham, .main-nav:not(.transparent) .inner-nav.desktop-nav.switch-menu .menu-bar .ham:before, .main-nav:not(.transparent) .inner-nav.desktop-nav.switch-menu .menu-bar .ham:after, .cws-button:hover, .cws-button.alt, .cws-icon.border-icon:hover, .cws-icon.border-icon.alt, .service-item:hover .cws-icon.border-icon, .cws-icon.type-3:after, .cws-icon.type-3.alt:hover:after, .service-item:hover .cws-icon.type-3.alt:after, .service-bg-icon:before, .service-center-icon:before, .accordion dt.active i.accordion-icon:before, .toggle dt.active i.accordion-icon:before, .accordion dd, .toggle dd, .accordion.style-2 dt i.accordion-icon:before, .accordion.style-2 dt i.accordion-icon:after, .accordion.style-2 dt.active, .toggle.style-2 dt.active, .alert.alert-info.alt, .counter-block.alt, .pricing-tables .header-pt, .skill-bar .bar span, .tabs .tabs-btn:hover, .tabs .tabs-btn.active, .divider, .pic .hover-effect, .pagination li a:hover, .pagination li a:focus, .blog-date .date:before, .widget-search form .search-submit, .widget-subscribe form .submit, .widget-categories ul li:hover a span, .widget-archive ul li:hover a span, .widget-tags .tag:hover, .widget-social .social-icon, .carousel-pag.main-color .owl-page.active, .pagiation-carousel.main-color .owl-page.active, .ui-datepicker-header, .contact-form .cws-button:hover, .message-form .cws-button:hover, .filter-button.active, .filter-button:hover, .product .action, .price_slider .ui-slider-range, .color-filter a.main-color,.mn-sub li:hover,.mn-sub li.active,.tuner i,.pic .links .link-icon.alt:hover { background-color: #<span>cws_theme_main#</span>; }     .border-t, .map-full-width.border-t { border-top-color: #<span>cws_theme_main#</span>; }.accordion dd:before, .toggle dd:before, .border-b{ border-bottom-color: #<span>cws_theme_main#</span>; }.call-out-box { border-left-color: #<span>cws_theme_main#</span>; } .pic .links .link-icon.alt { box-shadow:0 0 0 1px #<span>cws_theme_main#</span>;-webkit-box-shadow:0 0 0 1px #<span>cws_theme_main#</span>; -moz-box-shadow:0 0 0 1px #<span>cws_theme_main#</span>;}</div><style id="cws-cp-1">');

		if(theme_eight.layout_style != undefined) {
			$('body').addClass(theme_eight.layout_style);

			$('.page-style.'+theme_eight.layout_style).addClass('active');
		}

		jQuery('#tuner-switcher').on('click', function()
		{
			jQuery('#tuner').toggleClass('tuner-visible');
		});

		jQuery('.color-picker').each( function(){
			var el = jQuery(this);
			var def_color = el.data( 'color' );
			var id = el.attr('id');
			var matches = /color-(\d+)/.exec( id );
			if ( matches != null ){
				var index = matches[1];
				var tuner_id = 'tuner-style-' + index;
				var style_id = 'cws-cp-' + index;
				var tuner_el = jQuery( '#' + tuner_id );
				var style_el = jQuery( '#' + style_id );
				tuner_el.find('span').text(theme_eight.color_page);
				tuner_el.find('span.darknest').text(theme_eight.color_page);
				style_el.text(tuner_el.text());
				if ( tuner_el.length && style_el.length ){
					
					el.ColorPicker({
						color: def_color,
						onShow: function(colpkr)
						{
							jQuery(colpkr).fadeIn(300);
							return false;
						},
						onHide: function(colpkr)
						{
							jQuery(colpkr).fadeOut(300);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							el.css('background-color', '#' + hex);
							tuner_el.find('span').text(hex);
							tuner_el.find('span.darknest').text(cws_Hex2RGBwithdark(hex,1.14));
							style_el.text(tuner_el.text());
						}
					});
				}

			}
		});
		$("html").addClass("t-pattern-1");
		jQuery('#tuner').on('click', '.patterns li', function()
		{
			jQuery(".tuner .patterns li").removeClass('active');
			jQuery(this).addClass("active");
			var body_el, body_cls, matches, old_pattern, new_pattern_index, new_pattern;
			body_el = jQuery('html');
			body_cls = body_el.attr('class');
			matches = /t-pattern-(\d+)/.exec( body_cls );
			if ( matches != null ){
				old_pattern = matches[0];
				body_el.removeClass(old_pattern);
			}
			new_pattern_index = jQuery(this).data('pattern');
			new_pattern = "t-pattern-" + new_pattern_index;
			body_el.addClass(new_pattern);
		});
		jQuery('#tuner').on('click', '.page-style', function() {
			$('.tuner .page-style').removeClass('active');
			$(this).addClass("active");
			if ( $(this).hasClass("boxed") ) {
				$("body").addClass("boxed");
			} else {
				$("body").removeClass("boxed");
			}
			width_sticky ();
			$(window).resize(function(){
				width_sticky();
			})
		})
	}
});
function width_sticky () {
	if ( $("body").hasClass("boxed") ) {
		var width_body = $("body").innerWidth();
		$("body.boxed .sticky-menu").css({"width":width_body+"px"});
	} else {
		$("body .sticky-menu").css({"width":"100%","left":"0"});
	}
}
function cws_Hex2RGBwithdark(hex,coef_color) {

  var coef_color = coef_color == undefined ? 1 : coef_color;
  var hex = hex.replace("#", "");

  var color = '';

  if (hex.length == 3) {
   color = Math.round(hexdec(hex.substr(0,1))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(1,1))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(2,1))/coef_color);
  }else if(hex.length == 6){
   color = Math.round(hexdec(hex.substr(0,2))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(2,2))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(4,2))/coef_color);
  }
  return color;
 }
 function hexdec(hex_string) {
  hex_string = (hex_string + '')
  .replace(/[^a-f0-9]/gi, '');
  return parseInt(hex_string, 16);
 }
}(jQuery));
