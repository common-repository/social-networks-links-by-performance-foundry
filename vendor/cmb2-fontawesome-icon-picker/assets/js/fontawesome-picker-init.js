
jQuery(document).ready(function($) {
	'use strict';
	
	$('.fontawesome-icon-select').iconpicker({
		hideOnSelect: true
	});

	$('.cmb-repeat').on('DOMNodeInserted', function(e) {
		
		if ( $(e.target).is('.cmb-row') ) {
			
			$('.fontawesome-icon-select').iconpicker({
				hideOnSelect: true
			});
		
		}
	});

}); // End Ready
