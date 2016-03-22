var loginModule = (function($) {
	function init(){
		$('form').FlowupLabels({});
	}
	
	return {
		init: init
    };
    
})(jQuery);

$(document).ready(function(){
	loginModule.init();
});