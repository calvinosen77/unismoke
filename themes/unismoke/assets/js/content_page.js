var pageModule = (function($) {
	function sideMenu(){
		$('.aside-menu .content-category h3').click(function(){
	        if($(window).width()<768){
	            if(!$(this).parent().hasClass('open')) {
	                $(this).parents('.aside-menu').find('.open .acc-submenu').slideUp();
	                $(this).parents('.aside-menu').find('.open').removeClass('open');
	                $(this).parent().addClass('open');
	                $(this).parent().find('.acc-submenu').slideDown();
	            }
	            else {
	                $(this).parent().removeClass('open');
	                $(this).parent().find('.acc-submenu').slideUp();
	            }
	        }
	    });
	}
	
	return {
		sideMenu: sideMenu
    };
    
})(jQuery);

$(document).ready(function(){
	pageModule.sideMenu();
});