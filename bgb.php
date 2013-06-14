<?php
/**
* Include our files
* @package 
* @since
* @version
*/

/*
* These functions are run regardless of whether BP is activated and contain calls for our
* various register functions for CPT & metadata 
*/

	require( BGB_PLUGIN_DIR_PATH . 'inc/bgb-cpt.php' );

	if( is_admin() ) {
	require( BGB_PLUGIN_DIR_PATH . 'inc/bgb-metaboxes.php' );
	require( BGB_PLUGIN_DIR_PATH . 'inc/bgb-metadata-save.php' );
	}
	
/*
* Load BP parts.
* Only load the component if BuddyPress is loaded and initialized. 
*/
function bp_bgb_init() {
	// Because our loader file uses BP_Component, it requires BP 1.6 or greater.
	if ( version_compare( BP_VERSION, '1.6', '>' ) ) {
		require( BGB_PLUGIN_DIR_PATH . 'inc/bp/bp-bgb.php' );
	}
}
add_action( 'bp_include', 'bp_bgb_init' );