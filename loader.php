<?php
/*
Plugin Name: BuddyPress Group Branding 
Plugin URI: https://github.com/hnla/buddypress-group-branding
Description: Provides the ability to brand BP Groups with a Sponsor with custom homepage
Version: 0.9
Revision Date: 03/5/2013
Requires at least: WP 3.4 BP 1.7.*
Tested up to: WP 3.4.1, BP 1.7
License: (Example: GNU General Public License 3.0 (GPL) http://www.gnu.org/licenses/gpl.html)
Author: Hugo Ashmore 
Author URI: http://nettropia.co.uk
Network: true
Text Domain: bgb-branding
*/

/*******************************************************************************
Copyright 2012  Hugo Ashmore  (email : hugo.ashmore@gmail.com)
-------------------------------------------------------------

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*******************************************************************************/

// Deactivate the plugin if not meeting version requirements
function requires_wordpress_version() {
	global $wp_version, $plugin_dir;

	$plugin_data = get_plugin_data( __FILE__, false );
 
	if ( version_compare($wp_version, "3.3", "<" ) ) {
		if( is_plugin_active($plugin_dir) ) {
			deactivate_plugins( $plugin_dir );
			wp_die( "'".$plugin_data['Name']."' requires WordPress 3.3 or higher! Deactivating Plugin.<br /><br />Back to <a href='".admin_url()."plugins.php'>WordPress Plugins</a>." );
		}
	}
}
add_action( 'admin_init', 'requires_wordpress_version' );

 
// Define a constant that can be checked to see if the component is installed or not.
define( 'BGB_IS_ACTIVE', 1 );

// Define a constant that will hold the current version number of the component
// This can be useful if you need to run update scripts or do compatibility checks in the future
define( 'BGB_VERSION', '0.9' );

// Define a constant that we can use to construct file paths throughout the component
define( 'BGB_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'BGB_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
 
// Define a constant that will hold the database version number that can be used for upgrading the DB
define ( 'BGB_DB_VERSION', '0.9' );

// Setup language file directory
if ( file_exists( dirname( __FILE__ ) . '/languages/' . get_locale() . '.mo' ) )
	load_textdomain( 'bgb-branding', dirname( __FILE__ ) . '/bp-group-branding/languages/' . get_locale() . '.mo' );

/* Put setup procedures to be run when the plugin is activated in the following function */

function bgb_activate() {
 // we have no real actions to run at startup at this time.
	// this is wrong we run to early to test this condition & path wrong?
	if ( !is_plugin_active( 'buddypress/bp-loader.php' ) ) {
	}
}
register_activation_hook( __FILE__, 'bgb_activate' );

/* On deacativation, clean up anything your component has added. */
function bgb_deactivate() {
	// We are not deleting any options at this point in time.
}
register_deactivation_hook( __FILE__, 'bgb_deactivate' );

require(BGB_PLUGIN_DIR_PATH . 'bgb.php' );

?>
