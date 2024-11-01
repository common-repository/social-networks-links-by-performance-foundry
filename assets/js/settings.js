/**
 * Foundry Social Links Settings JS
 */

jQuery(document).ready(function ( $ ) {

 	'use strict';
 	var faStatus = document.getElementById('_foundry_social_networks_fa'),
 		cssStatus = document.getElementById('_foundry_social_networks_load_css');

 	show_fontawesome_select( faStatus );
 	show_color_select( cssStatus )

	$(document).on('change', cssStatus, function(event) {
		show_color_select( cssStatus );
	});

	$(document).on('change', faStatus, function(event) {
		show_fontawesome_select( faStatus );
	});
	
	function show_fontawesome_select( elem ) {
		if ( elem.checked ) {
			$('.cmb-type-fontawesome-icon').show();
			$('.cmb2-id--foundry-social-networks-load-fa').show();
			$('.cmb2-id--foundry-social-networks-fa5').show();
		} else {
			$('.cmb-type-fontawesome-icon').hide();
			$('.cmb2-id--foundry-social-networks-load-fa').hide();
			$('.cmb2-id--foundry-social-networks-fa5').hide();
		}
	}

	function show_color_select( elem ) {
		if ( elem.checked ) {
			console.log('checked');
			$('.cmb-type-colorpicker').hide();
		} else {
			$('.cmb-type-colorpicker').show();
		}
	}

}); // ready
