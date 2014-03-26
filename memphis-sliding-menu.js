function memphis_sliding_menu() {
	jQuery('.memphis-sliding-menu li:has(ul)').addClass("has-sub");
	jQuery('.memphis-sliding-menu a div').click(function(event) { msm_toogle_menu(this, event); });
	//jQuery('.memphis-sliding-menu ul li').click(function(event) { event.preventDefault(); });
	jQuery( document ).ready(function() {
		var current_ul = jQuery(".memphis-sliding-menu").find(".current_page_item").parent();
		mphs_show_current_menu(current_ul);
		menus.reverse();
		for(var i=0; i < menus.length; i++ ) {
			jQuery(menus[i]).delay(300).show();
			jQuery('.current_page_item').children('ul').delay(300).show();
			jQuery('.current_page_item').closest('li').addClass('active');
			jQuery('.current_page_ancestor').closest('li').addClass('active');
		}
	});
}

var menus = [];
function mphs_show_current_menu(menu_item) {
	var depth = jQuery(menu_item).parents().length;
	if (jQuery(menu_item).is('ul')) {
		//jQuery(menu_item).show();
		menus.push(menu_item);
		if (jQuery(menu_item).parent().parent().is('ul') && depth != 8) {
			mphs_show_current_menu(jQuery(menu_item).parent().parent());
		}
	}
}

function msm_toogle_menu(menu_item, event) {
	event.preventDefault();
	var checkElement = $(menu_item).parent().next();
	var depth = jQuery(checkElement).parents().length;
	if(depth == 8) {
		jQuery('.memphis-sliding-menu li').removeClass('active');
		jQuery(menu_item).closest('li').addClass('active');	
	
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			$(menu_item).closest('li').removeClass('active');
			checkElement.slideUp('normal');
		}
	
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('.memphis-sliding-menu ul ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
		}
	} else {
		if (jQuery(menu_item).closest('li').hasClass('active')) { $(menu_item).closest('li').removeClass('active'); checkElement.slideUp('normal'); }
		else { $(menu_item).closest('li').addClass('active'); checkElement.slideDown('normal'); }
			
		
	}
}