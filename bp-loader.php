<?php
/*
* Load BP parts.
* Only load the component if BuddyPress is loaded and initialized. 
*/
function bgb_init() {
	// Because our loader file uses BP_Component, it requires BP 1.6 or greater.
	if ( version_compare( BP_VERSION, '1.6', '>' ) ) {
		require( BGB_PLUGIN_DIR_PATH . 'inc/bp/bp-bgb.php' );
	}
}
add_action( 'bp_include', 'bgb_init' );
?>