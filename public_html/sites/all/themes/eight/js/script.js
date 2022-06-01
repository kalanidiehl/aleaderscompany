(function($){



"use strict"; // start of use strict


/**/
/* fix mobile hover */
/**/


$(document).ready(function() {
  add_button_menu();
  mobile_menu_controller_init ();
    /**/
    /*  Tabs  */
    /**/
    $(".tabs .tabs-btn").on( 'click', function() {
        var idBtn = ($(this).attr("data-tabs-id"));
        var containerList = $(this).parents(".tabs").find(".container-tabs");
        var f = $(".tabs [data-tabs-id=cont-"+idBtn+"]");

        $(f).addClass("active").siblings(".container-tabs").removeClass('active');
        $(containerList).fadeOut( 0 );
        $(f).fadeIn( 300 );
        $(this).addClass("active").siblings(".tabs-btn").removeClass('active');
    });
});
$(window).ready(function() {
    scroll_top ();
    init_classic_menu();
    init_accordion();
    cws_page_focus();
    init_twitter_carusel();
    init_fancy();
    search_open ()
    if($(".cws_prlx_section").length) {
      $( ".cws_prlx_section" ).cws_prlx();
    }
    init_add_cart ();
    init_color_filter ();
    menu_bar ();
    sticky_set ();
    video_img();
    cws_touch_events_fix ();
    if($('.isotope-grid').length) {
        init_isotop ();
    }
    //*** Comment *****/
    if($('.comment-list .comment').length > 0 ){
        $('.comment-list .comment').each(function(i,e){
            i++;
            var this_comment = $(this);
            this_comment.find('.user-picture img').addClass('color-'+i);

        });
    }
    
})

$(window).resize(function() {
  if($('.isotope-grid').length) {
    init_isotop ();
  }
  sticky_set ();
})


function cws_touch_events_fix (){
  if ( is_mobile_device() ){
    jQuery( ".container" ).on( "mouseenter", ".hover-effect, .product .pic", function (e){
      e.preventDefault();
      jQuery( this ).trigger( "hover" );
    });
    jQuery( ".main-nav" ).on( "hover", ".mobile_nav .button_open, .mobile_nav li > a", function ( e ){
      e.preventDefault();
      jQuery( this ).trigger( "click" );
    });
  }
}

function search_open () {
    $('.search-header a').on('click', function (){
      $('.search-header').addClass('open-search');
      if($('.main-nav').hasClass('transparent')) {
        $('.main-nav').addClass('v-hidden')
      }
      return false;
    })
    $('.search-header .close-button').on('click', function() {
      $('.search-header').removeClass('open-search');
      $('.main-nav').removeClass('v-hidden');
    })
}

function menu_bar () {
  $(".menu-bar").on( 'click', function(){
    $(".inner-nav.switch-menu").toggleClass("items-visible");
    return false;
  })
}

function sticky_set () {
  if(is_mobile_device ()) {
    $(".js-stick").unstick();
    $(".main-nav").removeClass('small-height');
  } else if (!($('.sticky-wrapper').length)) {
    $(".js-stick").sticky({
        topSpacing: 0
    });
  }
}


// menu
function init_classic_menu() {
	var mobile_nav = $(".mobile_nav .mobile_menu_switcher");
    var desktop_nav = $(".desktop-nav");

    // Navbar sticky


    height_line($(".inner-nav.desktop-nav > ul > li > a"), $(".main-nav"));


    mobile_nav.css({
        "width": $(".main-nav").height() + "px"
    });

    // Transpaner menu

    if ($(".main-nav").hasClass("transparent")) {
        $(".main-nav").addClass("js-transparent");
    }

    $(window).scroll(function() {
        if($(".main-nav").hasClass('js-transparent')) {
          if ($(window).scrollTop() > 10) {
              $(".js-transparent").removeClass("transparent");
              //$(".main-nav, .nav-logo-wrap .logo, .mobile-nav").addClass("small-height");
          } else {
              $(".js-transparent").addClass("transparent");
              //$(".main-nav, .nav-logo-wrap .logo, .mobile-nav").removeClass("small-height");
          }
        }
        if ($('.sticky-wrapper').length) {
          if ($('.sticky-wrapper').hasClass('is-sticky')) {
              $(".js-transparent").removeClass("transparent");
              //$(".main-nav, .nav-logo-wrap .logo, .mobile-nav").addClass("small-height");
          } else {
              $(".js-transparent").addClass("transparent");
              //$(".main-nav, .nav-logo-wrap .logo, .mobile-nav").removeClass("small-height");
          }
        }
        
        


    });

    // Mobile menu toggle

    mobile_nav.on('click', function() {

        if (desktop_nav.hasClass("js-opened")) {
            desktop_nav.slideUp("slow", "easeOutExpo").removeClass("js-opened");
            $(this).removeClass("active");
        } else {
            desktop_nav.slideDown("slow", "easeOutQuart").addClass("js-opened");
            $(this).addClass("active");

            // Fix for responsive menu
            if ($(".main-nav").hasClass("not-top")) {
                $(window).scrollTo(".main-nav", "slow");
            }

        }

    });

    desktop_nav.find("a:not(.mn-has-sub)").on('click', function() {
        if (mobile_nav.hasClass("active")) {
            desktop_nav.slideUp("slow", "easeOutExpo").removeClass("js-opened");
            mobile_nav.removeClass("active");
        }
    });


    // Sub menu

    var mnHasSub = $(".mn-has-sub");
    var mnThisLi;

    $(".mobile-on .mn-has-sub").find(".fa:first").removeClass("fa-angle-right").addClass("fa-angle-down");

    mnHasSub.on('click', function() {

        if ($(".main-nav").hasClass("mobile-on")) {
            mnThisLi = $(this).parent("li:first");
            if (mnThisLi.hasClass("js-opened")) {
                mnThisLi.find(".mn-sub:first").slideUp(function() {
                    mnThisLi.removeClass("js-opened");
                    mnThisLi.find(".mn-has-sub").find(".fa:first").removeClass("fa-angle-up").addClass("fa-angle-down");
                });
            } else {
                $(this).find(".fa:first").removeClass("fa-angle-down").addClass("fa-angle-up");
                mnThisLi.addClass("js-opened");
                mnThisLi.find(".mn-sub:first").slideDown();
            }

            return false;
        } else {

        }

    });
    
    $(window).resize(function(){
      nav_hover();
    })
    nav_hover();
    function nav_hover() {
      if( !($('.inner-nav').hasClass('.mobile_nav')) ) {
        $(".mn-has-sub").parent("li").on({
          mouseenter: function() {

              if (!($(".main-nav").hasClass("mobile-on"))) {

                  $(this).find(".mn-sub:first").stop(true, true).fadeIn("fast");
              }

          },
          mouseleave: function() {

              if (!($(".main-nav").hasClass("mobile-on"))) {

                  $(this).find(".mn-sub:first").stop(true, true).delay(100).fadeOut("fast");
              }

          }
        });  
      }
      
    }
  
    

}



// Function for block height 100%
function height_line(height_object, height_donor){
    height_object.height(height_donor.height());
    height_object.css({
        "line-height": height_donor.height() + "px"
    });
    $('.inner-nav.desktop-nav').css('opacity', '1')
}

// Accordion
function init_accordion () {
    $(".accordion").each(function() {
        var allPanels = $(this).children('.content').hide();
        //allPanels.first().slideDown("easeOutExpo");
        //$(this).children('.content-title').first().addClass("active");

        $(this).children('.content-title').on('click', function(){

          if ($(this).hasClass("active")) {
            allPanels.slideUp("easeInExpo");
            $(this).removeClass("active");
          }
          else {
            var current = $(this).next(".content");
            $(this).parent().children('.content-title').removeClass("active");
            $(this).addClass("active");
            allPanels.not(current).slideUp("easeInExpo");
            //allPanels.slideUp("easeInExpo");
            $(this).next().slideDown("easeOutExpo");
          }
            
            return false;
            
        });
    })
    
}

    
// Is Visible
function is_visible (el){
    var w_h = $(window).height();
    var dif = $(el).offset().top - $(window).scrollTop();

    if ((dif > 0) && (dif<w_h)){
        return true;

    } else {
        return false;
    }
}

/**/
/* mobile device detect */
/**/
function is_mobile_device () {
  if ( ( $(window).width()<767) || (navigator.userAgent.match(/(Android|iPhone|iPod|iPad)/) ) ) {
    return true;
  } else {
    return false;
  }
}

/**/
/* mobile video img */
/**/
function video_img(){
  if (is_mobile_device ()) {
    var img_url = $('.row_bg_video').attr('data-img-url');


    $('.row_bg_video').css({
      'background-image': 'url('+img_url+')'
    })
    $('.row_bg_video').children().hide();
  }
}


/**/
/* Twitter carousel */
/**/
function init_twitter_carusel () {
  if($('.twitter-1').length) {
     $('.twitter-1').tweet({
        username: 'Creative_WS',
        count: 3,
        loading_text: 'loading twitter feed...',
        template: "<i class='fa fa-twitter twitt-icon'></i><p><a href='{user_url}'>@{screen_name}</a>{join}{text}<br>{time}</p>"
    });
     $('.twitter-1.full-screen .tweet_list').addClass("carousel-pag main-color");
    var owl_pag = $('.carousel-pag')
    jQuery(owl_pag).each(function (){
      jQuery(this).owlCarousel({
        itemsCustom : [
        [0, 1],
        [479, 1],
        [738, 1],
        [980, 1],
        [1170, 1], 
      ],
        navigation: false,
        pagination: true,
      });
    });
  }
   
}


/**/
/* fancybox */
/**/
function init_fancy () {
  if ($(".fancy").length) {
    $(".fancy").fancybox();
    $('.fancybox').fancybox({
      helpers: {
        media: {}
      }
    });
  }
}


/**/
/* calendar */
/**/
if ($("#calendar").length) {
  $('#calendar').datepicker({
    prevText: '<i class="fa fa-angle-left"></i>',
    nextText: '<i class="fa fa-angle-right"></i>',
    firstDay: 1,
    dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ]
  });
}


    /**/
    /********   Carousel Latest Blog   *********/
    /**/
    var owl_single = $('.views-blog-slide .owl-three-pag')
    jQuery(owl_single).each(function (){
        jQuery(this).owlCarousel({
            itemsCustom : [
                [0, 1],
                [479, 1],
                [738, 2],
                [980, 2],
                [1170, 3],
            ],
            navigation: false,
            pagination: true,
        });
    });

    /*****
     *     Carousel Recent Porfolio ****
     */

    var cws_slide = $('.owl-slide-col');
    jQuery(cws_slide).each(function () {
        if(jQuery(this).hasClass('three-column')) {
            jQuery(this).owlCarousel({
                itemsCustom: [
                    [0, 1],
                    [479, 1],
                    [738, 2],
                    [980, 2],
                    [1170, 3],
                ],
                navigation: false,
                pagination: true,
            })
        }
        if(jQuery(this).hasClass('four-column')){
            jQuery(this).owlCarousel({
                itemsCustom: [
                    [0, 1],
                    [479, 1],
                    [738, 2],
                    [980, 2],
                    [1170, 4],
                ],
                    navigation: false,
                    pagination: true,
            })
        }
    });
    //var owl_porfolio = $('.v')
    /**/
/* isotop */
/**/
function init_isotop () {
  var $container = $('.isotope-grid');

  
  $('.filter-buttons').on('click', 'a', function() {
    $('.isotope-grid').isotope(
    {
      filter: $(this).data('filter'),
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false,
        }
    });
    $(this).addClass('active').siblings().removeClass('active');

    return false;
  });
}




/**/
/* add to cart */
/**/
function init_add_cart () {
  $('.add-to-cart').on('click', function(){
    $(this).parents(".price-review").addClass("added");
    setTimeout($(this).hide() , 300)
    $(this).siblings().show();
    return false;
  })
}


/**/
/* active color filter */
/**/
function init_color_filter () {
  $('.color-filter a, .size-filter a').on('click', function(){
    $(this).addClass('active').siblings().removeClass('active');
    return false;
  })
}




/* shop */

if ( $("#ship-to-different-address-checkbox").length ) {
  $("#ship-to-different-address-checkbox").on('click', show_address)
  show_address()
}

function show_address () {
  if ( document.getElementById("ship-to-different-address-checkbox").checked ) {
    $(".shipping_address").show();
  } else {
    $(".shipping_address").hide();
  }
}
if ( $(".woocommerce-checkout").length ) {
  $(".input-radio").on('click', function(){
    $(".payment_box.payment_method_paypal").slideUp(400);
    $(".payment_box.payment_method_bacs").slideUp(400);
    $(".payment_box.payment_method_cheque").slideUp(400);
    switch (true) {
      case document.getElementById("payment_method_bacs").checked:
        $(".payment_box.payment_method_bacs").slideDown(400)
        break
      case document.getElementById("payment_method_cheque").checked:
        $(".payment_box.payment_method_cheque").slideDown(400)
        break
      case document.getElementById("payment_method_paypal").checked:
        $(".payment_box.payment_method_paypal").slideDown(400)
        break
    }
  })
  
}



/**/
/* mobile menu */
/**/
function mobile_menu_controller_init (){
  window.mobile_nav = {
    "is_mobile_menu" : false,
    "nav_obj" : jQuery(".inner-nav>ul").clone(),
    "level" : 1,
    "current_id" : false,
    "next_id" : false,
    "prev_id" : "",
    "animation_params" : {
      "vertical_start" : 300,
      "vertical_end" : 0,
      "horizontal_start" : 0,
      "horizontal_end" : 270,
      "speed" : 300
    }
  }
  if ( false ){
    set_mobile_menu();
  }
  else{
    mobile_menu_controller();
    jQuery(window).resize( function (){
      mobile_menu_controller();
    });
  }
  mobile_nav_switcher_init ();
}

function mobile_nav_switcher_init (){
  var nav_container = jQuery("nav .inner-nav"); 
  jQuery(document).on("click", "nav .inner-nav.mobile_nav .mobile_menu_switcher", function (){
    var nav = get_current_nav_level();
    var cls = "opened";
    if ( nav_container.hasClass(cls) ){
      nav.stop().animate( {"margin-top": window.mobile_nav.animation_params.vertical_start + "px","opacity":0}, window.mobile_nav.animation_params.speed, function (){
        nav_container.removeClass(cls);
      })
    }
    else{
      nav_container.addClass(cls);
      nav.stop().animate( {"margin-top": window.mobile_nav.animation_params.vertical_end + "px","opacity":1}, window.mobile_nav.animation_params.speed );
    }
  }); 
}

function mobile_nav_handlers_init (){
  jQuery("nav .inner-nav.mobile_nav .button_open").on( "click", function (e){
    var el = jQuery(this);
    var next_id = el.closest("li").attr("id");
    var current_nav_level = get_current_nav_level();
    var next_nav_level = get_next_nav_level( next_id );
    current_nav_level.animate( { "right": window.mobile_nav.animation_params.horizontal_end + "px", "opacity" : 0 }, window.mobile_nav.animation_params.speed, function (){
      current_nav_level.remove();
      jQuery("nav .inner-nav").append(next_nav_level);
      next_nav_level.css( { "margin-top": window.mobile_nav.animation_params.vertical_end + "px", "right": "-" + window.mobile_nav.animation_params.horizontal_end + "px", "opacity" : 0} );
      next_nav_level.animate( { "right": window.mobile_nav.animation_params.horizontal_start + "px", "opacity" : 1 }, window.mobile_nav.animation_params.speed );
      window.mobile_nav.current_id = next_id;
      window.mobile_nav.level ++;
      mobile_nav_handlers_init ();
    });
  }); 
  jQuery("nav .inner-nav.mobile_nav .back>a").on("click", function (){
    var current_nav_level = get_current_nav_level();
    var next_nav_level = get_prev_nav_level();
    current_nav_level.animate( { "right": "-" + window.mobile_nav.animation_params.horizontal_end + "px", "opacity" : 0 }, window.mobile_nav.animation_params.speed, function (){
      current_nav_level.remove();
      jQuery("nav .inner-nav").append(next_nav_level);
      next_nav_level.css( { "margin-top": window.mobile_nav.animation_params.vertical_end + "px", "right": window.mobile_nav.animation_params.horizontal_end + "px", "opacity" : 0} );
      next_nav_level.animate( { "right": window.mobile_nav.animation_params.horizontal_start + "px", "opacity" : 1 }, window.mobile_nav.animation_params.speed );
      window.mobile_nav.level --;
      mobile_nav_handlers_init ();
    });
    return false;   
  });
}

function get_current_nav_level (){
  var r = window.mobile_nav.level < 2 ? jQuery( "nav .inner-nav>ul" ) : jQuery( "nav .inner-nav ul" );
  r.find("ul").remove();
  return r; 
}

function get_next_nav_level ( next_id ){
  var r = window.mobile_nav.nav_obj.find( "#" + next_id ).children("ul").first().clone();
  r.find("ul").remove();
  return r;
}

function get_prev_nav_level (){
  var r = {};
  if ( window.mobile_nav.level > 2 ){
    r = window.mobile_nav.nav_obj.find( "#" + window.mobile_nav.current_id ).parent("ul").parent("li");
    window.mobile_nav.current_id = r.attr("id");
    r = r.children("ul").first();
  }
  else{
    r = window.mobile_nav.nav_obj;
    window.mobile_nav.current_id = false;
  }
  r = r.clone();
  r.find("ul").remove();
  return r;
}

function mobile_menu_controller (){
  if ( is_mobile() && !window.mobile_nav.is_mobile_menu ){
    set_mobile_menu ();
    
  }
  else if ( !is_mobile() && window.mobile_nav.is_mobile_menu ){
    reset_mobile_menu ();
  }
}

function set_mobile_menu (){
  var nav = get_current_nav_level();
  $("nav .inner-nav").addClass("mobile_nav");
  $(".sticky-menu").addClass("mobile");
  $(".inner-nav").removeClass("scrolling, desktop-nav");
  nav.css( { "margin-top":window.mobile_nav.animation_params.vertical_start+"px" } );
  window.mobile_nav.is_mobile_menu = true;
  mobile_nav_handlers_init ();
}

function reset_mobile_menu (){
  
  var nav = get_current_nav_level();
  $("nav .inner-nav").removeClass("mobile_nav opened").addClass('desktop-nav');
  $(".sticky-menu").removeClass("mobile");
  nav.removeAttr("style");
  window.mobile_nav.is_mobile_menu = false;
  nav.remove();
  reset_mobile_nav_params ();
}

function reset_mobile_nav_params (){
  jQuery("nav .inner-nav").append(window.mobile_nav.nav_obj.clone());
  window.mobile_nav.level = 1;
  window.mobile_nav.current_id = false;
  window.mobile_nav.next_id = false;
}
function is_mobile (){
  if ( ( $(window).width()<980) || (navigator.userAgent.match(/(Android|iPhone|iPod|iPad)/) ) ) {
    return true;
  } else {
    return false;
  }
}

function add_button_menu() {
  var v = $('nav .inner-nav>ul').find("li");
  for (var p=0;p<$('nav .inner-nav>ul').find("li").length;p++) {
    $(v[p]).attr('id','menu-item-'+p);
  }
  $('nav .inner-nav').append("<i class='mobile_menu_switcher'></i>");
  $('nav .inner-nav>ul ul').each(function(){
    var x = document.createElement('li');
    $(x).attr("class","back");
    x.innerHTML = "<a href='#'>back</a>";
    this.insertBefore( x, this.firstElementChild );
  })
  $('nav .inner-nav>ul').each(function(){
    var n = document.createElement("li");
    n.innerHTML = "Menu";
    $(n).attr("class","header-menu");
    this.insertBefore( n, this.firstElementChild );
  })
  $('nav .inner-nav li').each(function(){
    if ( $(this).children("ul").length > 0 ) {
      $(this).append("<span class='button_open'></span>");
    };
  })
}
/* \mobile menu */

function cws_page_focus(){
 document.getElementsByTagName('html')[0].setAttribute('data-focus-chek', 'focused');
 
 window.addEventListener('focus', function() {
    document.getElementsByTagName('html')[0].setAttribute('data-focus-chek', 'focused');
 });

 window.addEventListener('blur', function() {
    document.getElementsByTagName('html')[0].removeAttribute('data-focus-chek');
 });
}

/**/
/* scroll-top */
/**/
function scroll_top (){
  $('#scroll-top').on( 'click', function() {
      $('html, body').animate({scrollTop: 0});
      return false;
  });
  if( $(window).scrollTop() > 700 ) {
    $('#scroll-top').fadeIn();
  } else {
    $('#scroll-top').fadeOut();
  } 
  $(window).scroll(function(){
    if( $(window).scrollTop() > 700 ) {
      $('#scroll-top').fadeIn();
    } else {
      $('#scroll-top').fadeOut();
    } 
  })
 
}

}(jQuery));