jQuery(function($){
	"use strict";
	jQuery('.main-menu-navigation > ul').superfish({
		delay:       0,                            
		animation:   {opacity:'show',height:'show'},  
		speed:       'fast'                        
	});
});

function tafri_travel_resmenu_open() {
  	window.tafri_travel_resMenu=true;
	jQuery(".sidebar").addClass('menu');
}
function tafri_travel_resmenu_close() {
  	window.tafri_travel_resMenu=false;
	jQuery(".sidebar").removeClass('menu');
}

jQuery(document).ready(function () {

	window.tafri_travel_currentfocus=null;
  	tafri_travel_checkfocusdElement();
	var tafri_travel_body = document.querySelector('body');
	tafri_travel_body.addEventListener('keyup', tafri_travel_check_tab_press);
	var tafri_travel_gotoHome = false;
	var tafri_travel_gotoClose = false;
	window.tafri_travel_resMenu=false;
 	function tafri_travel_checkfocusdElement(){
	 	if(window.tafri_travel_currentfocus=document.activeElement.className){
		 	window.tafri_travel_currentfocus=document.activeElement.className;
	 	}
 	}
	function tafri_travel_check_tab_press(e) {
		"use strict";
		// pick passed event or global event object if passed one is empty
		e = e || event;
		var activeElement;

		if(window.innerWidth < 999){
			if (e.keyCode == 9) {
				if(window.tafri_travel_resMenu){
					if (!e.shiftKey) {
						if(tafri_travel_gotoHome) {
							jQuery( "#resmenu-sidebar .main-menu-navigation ul:first li:first a:first-child" ).focus();
						}
					}
					if (jQuery("a.closebtn.responsive-menu").is(":focus")) {
						tafri_travel_gotoHome = true;
					} else {
						tafri_travel_gotoHome = false;
					}

				}else{
					if(window.tafri_travel_currentfocus=="mobiletoggle"){
						jQuery( "" ).focus();
					}
				}
			}
		}
		if (e.shiftKey && e.keyCode == 9) {
			if(window.innerWidth < 999){
				if(window.tafri_travel_currentfocus=="header-search"){
					jQuery(".mobiletoggle").focus();
				}else{
					if(window.tafri_travel_resMenu){
						if(tafri_travel_gotoClose){
							jQuery("a.closebtn.responsive-menu").focus();
						}
						if (jQuery( "#resmenu-sidebar .main-menu-navigation ul:first li:first a:first-child" ).is(":focus")) {
							tafri_travel_gotoClose = true;
						} else {
							tafri_travel_gotoClose = false;
					}
				
				}else{
					if(window.tafri_travel_resMenu){
					}
				}

				}
			}
		}
	 	tafri_travel_checkfocusdElement();
	}

});

// scroll
jQuery(document).ready(function () {
	jQuery(window).scroll(function () {
	    if (jQuery(this).scrollTop() > 100) {
	        jQuery('.scrollup').fadeIn();
	    } else {
	        jQuery('.scrollup').fadeOut();
	    }
	});
	jQuery('.scrollup').click(function () {
	    jQuery("html, body").animate({
	        scrollTop: 0
	    }, 600);
	    return false;
	});
});

jQuery(function($){
	$(window).load(function() {
		$("#pre-loader").delay(1000).fadeOut("slow");
		$(".circle").delay(1000).fadeOut("slow");
	})
});

(function( $ ) {

	$(window).scroll(function(){
		var sticky = $('.sticky-header'),
		scroll = $(window).scrollTop();

		if (scroll >= 100) sticky.addClass('fixed-header');
		else sticky.removeClass('fixed-header');
	});

})( jQuery );