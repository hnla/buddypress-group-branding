<?php
/**
* Include our files
* @package 
* @since
* @version
*/

/*
* Intialise styles & call include files.
* /

	/*
	* Here be our scripts & styles - if any
	*/
/*global $current_screen;
function what_screen() {
global $current_screen;
var_dump($current_screen->post_type);
}
add_action('admin_notices', 'what_screen');
*/
if( !is_admin()  ) {
	/**
	* @ToDo: add checks for various theme dir locations for stylesheets
	*/
	function bgb_styles() {
		if( bp_is_group() ) {
			$file_exists = file_exists( get_stylesheet_directory() . 'css/bgb-styles.css');
			//var_dump($file_exists);
			if( $file_exists ) :
				wp_enqueue_style( 'bgb-styles',  get_stylesheet_directory_uri() . '/bgb-styles.css', array() );
			else:
				wp_enqueue_style( 'bgb-styles',  plugins_url('css/bgb-styles.css', __FILE__), array() );
			endif;
		}
	}
}
add_action( 'wp_enqueue_scripts', 'bgb_styles' );

if( is_admin() ){

	function bgb_admin_styles() {
	global $current_screen;
		if('bgb_sponsors' !== $current_screen->post_type )
			return;
			wp_enqueue_style('bgb-admin-styles', plugins_url('css/admin/bgb-admin-styles.css', __FILE__), array() );
	}
	add_action('admin_enqueue_scripts', 'bgb_admin_styles');

}

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