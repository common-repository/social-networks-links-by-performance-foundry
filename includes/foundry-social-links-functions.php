<?php
/**
 * Foundry Social Links Functions
 *
 * @version     0.1.0
 * @package 	Foundry_Social_Links/Core/Functions
 * @category    Functions
 * @author      Performance Foundry
 */

/**
 * Display Social Networks HTML
 *
 * @param  boolean $display_name Display Social Network Names.
 */
function foundry_the_social_networks( $display_name ) {
	return foundry_SL()->front_end->the_social_networks( $display_name );
}

/**
 * Get Social Networks Array
 *
 * @return array Social Networks Array
 */
function foundry_get_social_networks() {
	return foundry_SL()->front_end->get_social_networks();
}
