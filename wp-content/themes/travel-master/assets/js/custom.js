jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var loader = $('#loader');
    var loader_container = $('#preloader');
    var scroll = $(window).scrollTop();  
    var scrollup = $('.backtotop');
    var menu_toggle = $('.menu-toggle');
    var dropdown_toggle = $('.main-navigation button.dropdown-toggle');
    var nav_menu = $('.main-navigation ul.nav-menu');

/*------------------------------------------------
            PRELOADER
------------------------------------------------*/

    loader_container.delay(1000).fadeOut();
    loader.delay(1000).fadeOut("slow");

/*------------------------------------------------
            BACK TO TOP
------------------------------------------------*/

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-100px"});
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

/*------------------------------------------------
            MAIN NAVIGATION
------------------------------------------------*/

    if( $(window).width() < 767 ) {
        $('#top-bar').click(function(){
            $('#top-bar .wrapper').slideToggle();
            $('#top-bar').toggleClass('top-menu-active');
        });
    }

    menu_toggle.click(function(){
        nav_menu.slideToggle();
       $('.main-navigation').toggleClass('menu-open');
       $('.menu-overlay').toggleClass('active');
    });

    dropdown_toggle.click(function() {
        $(this).toggleClass('active');
       $(this).parent().find('.sub-menu').first().slideToggle();
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('.menu-sticky #masthead').addClass('nav-shrink');
        }
        else {
            $('.menu-sticky #masthead').removeClass('nav-shrink');
        }
    });

/*--------------------------------------------------------------
 Keyboard Navigation
----------------------------------------------------------------*/
if( $(window).width() < 1024 ) {
    $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
        if( e.which === 9 ) {
            e.preventDefault();
            $('#masthead').find('.menu-toggle').focus();
        }
    });
}
else {
    $( '#primary-menu li:last-child' ).unbind('keydown');
}

$(window).resize(function() {
    if( $(window).width() < 1024 ) {
        $('#primary-menu').find("li").last().bind( 'keydown', function(e) {
            if( e.which === 9 ) {
                e.preventDefault();
                $('#masthead').find('.menu-toggle').focus();
            }
        });
    }
    else {
        $( '#primary-menu li:last-child' ).unbind('keydown');
    }
});

/*------------------------------------------------
            SLICK SLIDER
------------------------------------------------*/

$('.featured-slider').slick({
    responsive: [{
        breakpoint: 1023,
            settings: {
            slidesToShow: 1,
            arrows: false
        }
    }]
});
$('.gallery-slider').slick({
    responsive: [{
        breakpoint: 1200,
            settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 400,
        settings: {
            slidesToShow: 1
        }
    }]
});
$('#destination-slider .destination-slider-wrapper').slick({
    responsive: [{
        breakpoint: 767,
            settings: {
            slidesToShow: 1,
            fade: false,
            arrows: true,
            dots: false
        }
    }]
});
$('.places-slider').slick();
$('.clients-feedback').slick({
    responsive: [{
        breakpoint: 1200,
            settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 992,
        settings: {
            slidesToShow: 1,
            fade: true
        }
    }]
});

/*------------------------------------------------
                TABS
------------------------------------------------*/

$('ul.tabs li').click(function(event) {
    event.preventDefault();
    
    var tab_id = $(this).attr('data-tab');

    $('ul.tabs li').removeClass('active');
    $('.tab-content').removeClass('active');

    $(this).addClass('active');
    $("#"+tab_id).addClass('active');
});

/*------------------------------------------------
                Single Trip
------------------------------------------------*/

    $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list li:nth-child(1)').attr('data-scroll', '#overview');
    $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list li:nth-child(2)').attr('data-scroll', '#trip_outline');
    $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list li:nth-child(3)').attr('data-scroll', '#trip_includes');
    $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list li:nth-child(4)').attr('data-scroll', '#trip_excludes');
    $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list li:nth-child(5)').attr('data-scroll', '#gallery');
    $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list li:nth-child(6)').attr('data-scroll', '#reviews');
    $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list li:nth-child(7)').attr('data-scroll', '#booking');
    $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list li:nth-child(8)').attr('data-scroll', '#faq');

    if( $('body').hasClass('single-itineraries') ) {
        $(".wp-travel-tab-wrapper .tab-list.resp-tabs-list li").click(function(e) {
            var section_id = $(this).attr("data-scroll");

            if( $('body').hasClass('menu-sticky') ) {
                $('html,body').animate({
                    scrollTop: $( section_id ).offset().top-190}, 
                '2000');
            }
            else {
                $('html,body').animate({
                    scrollTop: $( section_id ).offset().top - 100}, 
                '2000');
            }

            $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list').addClass('active');
        });

        var sectionPosition = $("#overview").offset().top-280;
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= sectionPosition ) {
                $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list').addClass('active');
            }
            else {
                $('.wp-travel-tab-wrapper .tab-list.resp-tabs-list').removeClass('active');
            }
        });
    }

/*------------------------------------------------
            POPUP VIDEO
------------------------------------------------*/

    $(".video-link").click(function (event) {
        event.preventDefault();
        $('.popup .widget_media_video').fadeIn();
        $('.video-overlay').addClass('active');
    });

    $(document).click(function (e) {
        var container = $(".video-link,.popup .widget_media_video");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".popup .mejs-controls .mejs-playpause-button.mejs-pause button").trigger("click");
            $('.popup .widget_media_video').fadeOut();
            $('.video-overlay').removeClass('active');            
        }
    });
    
/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});