<?php
/**
 * Plugin Name:       Ultimate Solutions Plugin
 * Plugin URI:        https://ahmed-gamal.com
 * Description:       Reusable Plugin for custom post type, meta data and custom api route
 * Version:           1.0.0
 * Author:            Ahmed Gamal
 * Author URI:        https://ahmed-gamal.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
    exit;
}

define( 'CUSTOM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


require_once( CUSTOM_PLUGIN_DIR . 'custom-post-type.php' );
require_once( CUSTOM_PLUGIN_DIR . 'settings-page.php' );
require_once( CUSTOM_PLUGIN_DIR . 'Custom_Controller_Class.php' );