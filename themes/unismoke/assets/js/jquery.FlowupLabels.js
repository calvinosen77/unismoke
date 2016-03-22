(function($) {
	$.fn.FlowupLabels = function( options ){
	
		var defaults = {
        		// Useful if you pre-fill input fields or if localstorage/sessionstorage is used. 
				feature_onLoadInit:	true,
				// Class names used for focus and populated statuses
				class_focused: 		'focused',
				class_populated: 	'populated'
			},
			settings = $.extend({}, defaults, options);
  
  
		return this.each(function(){
			var $scope  = $(this);
    
			$scope.on('focus.flowupLabelsEvt', '.with-ph', function() {
				$(this).closest('.form-group').addClass(settings.class_focused);
			})
			.on('blur.flowupLabelsEvt', '.with-ph', function() {
				var $this = $(this);
				
				if ($this.val().length) {
					$this.closest('.form-group')
						.addClass(settings.class_populated)
						.removeClass(settings.class_focused);
				} 
				else {
					$this.closest('.form-group')
						.removeClass(settings.class_populated + ' ' + settings.class_focused);
				}
			});
        
    
			// On page load, make sure it looks good
			if (settings.feature_onLoadInit) {
				$scope.find('.with-ph').trigger('blur.flowupLabelsEvt');
			}
		});
	};
})( jQuery );
