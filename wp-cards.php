<?php
/*
Plugin Name: WP Cards
Plugin URI: http://davidscotttufts.com/wp-cards/
Description: Allows for theme developers to add "cards" to their theme's homepage and header
Version: 1.0
Author: David S. Tufts
Author URI: http://davidscotttufts.com/
Text Domain: card design
License: GPL2
*/

/*	Copyright 2011	David S. Tufts	(email : david.tufts@rocketwood.com)

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License, version 2, as
		published by the Free Software Foundation.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA	02110-1301	USA
*/

// Global plugin settings
$wp_cards_query_stack = array();
add_action( 'plugins_loaded', 'wp_cards_load_textdomain' );
add_action( 'widgets_init', 'wp_cards_widgets_register');

define( 'WPCARDSPATH', dirname( __FILE__ ) );
define( 'REQUEST_URI', $_SERVER['REQUEST_URI'] );

/** Run activation when the plugin is activated */
register_activation_hook(__FILE__, 'wp_cards_activation');

/** Run deactivation when the plugin is deactivated */
register_deactivation_hook(__FILE__, 'wp_cards_deactivation');

if ( function_exists('register_sidebar') ) {
	$default_sidebar = array(
		'id' => 'card_staging',
		'name' => 'Card Staging Area',
		'before_widget' => '', 
		'after_widget' => '', 
		'before_title' => '',
		'after_title' => ''
	);
	register_sidebar( $default_sidebar );
	register_sidebar( array_merge( $default_sidebar, array( 'id' => 'header_jumbotron_cards', 'name' => 'Header Jumbotron Cards') ) );
	register_sidebar( array_merge( $default_sidebar, array( 'id' => 'home_page_cards', 'name' => 'Home Page Cards') ) );
}

if ( ! is_admin() ) {
	// Adds WP Cards specific Styles and Scripts
	add_action( 'wp_enqueue_scripts', 'wp_cards_enqueue_scripts' );
}

function wp_cards_activation() {

}

function wp_cards_deactivation() {

}

function wp_cards_load_textdomain() {
	load_plugin_textdomain( 'wp_cards', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

function wp_cards_enqueue_scripts() {
	wp_enqueue_style('wp-cards', plugins_url( 'wp-cards/includes/css/components.css' ), false, wp_cards_auto_version('/css/components.css', true), 'screen');
}

function wp_cards_auto_version( $url, $plugin_dir = true ) {
	if ( $plugin_dir ) {
		$file_path = plugin_dir_path( __FILE__ ) . 'includes';
	} else {
		$file_path = $_SERVER['DOCUMENT_ROOT'];
	}

	return filemtime( $file_path.$url );
}

function wp_cards_widgets_register() {
	$paths = array(
		plugin_dir_path( __FILE__ ) . 'cards/',
		get_template_directory() . '/cards/',
		get_stylesheet_directory() . '/cards/'
	);

	foreach ( $paths as $path ) {
		if ( is_dir( $path ) && $dir = opendir( $path ) ) {
			while ( ( $file = readdir( $dir ) ) !== false ) {
				if ( preg_match( '/card-(.*)\.php/', $file, $match ) ) {
					$class = sprintf( 'wp_cards_%s_widget', str_replace( '-', '_', $match[1] ) );
					include_once $path . $file;
					register_widget( $class );
				}
			}

			closedir( $dir );
		}
	}
}

/**
 * Query Stack Section
 *
 * This section holds functions for managing nested queries
 */

function wp_cards_query($query) {
	global $wp_cards_query_stack;

	// push current query object onto stack
	$wp_cards_query_stack[] =& $GLOBALS['wp_query'];

	// nullify global query object pointer
	unset($GLOBALS['wp_query']);

	// assign global pointer to new query object
	$GLOBALS['wp_query'] =& new WP_Query();

	// initialize new global query state
	$results = $GLOBALS['wp_query']->query($query);

	return $results;
}

function wp_cards_reset_query() {
	global $wp_cards_query_stack;

	// nullfiy global query object pointer
	unset($GLOBALS['wp_query']);

	// pop previous query object from stack
	// and assign global pointer to it
	if ( ! empty($wp_cards_query_stack) ) {
		$index = (count($wp_cards_query_stack) - 1);

		$GLOBALS['wp_query'] =& $wp_cards_query_stack[$index];

		// pop previous query object from stack
		array_pop($wp_cards_query_stack);
	}

	// restore previous global query state
	wp_reset_postdata();
}

function wp_cards_boolean( $value = null, $default = false ) {
	// Ensure that the default is a boolean value
	if ( ! is_bool( $default ) )
		$default = wp_cards_boolean( $default );

	if ( is_null( $value ) ) {
		return $default;
	} elseif ( is_string( $value ) ) {
		$true_strings  = array( 'true',  'enable' );
		$false_strings = array( 'false', 'disable' );

		$lower_value = strtolower( $value );

		if ( in_array( $lower_value, $true_strings ) )
			return true;
		elseif ( in_array( $lower_value, $false_strings ) )
			return false;

		return (bool) trim( $value );
	} elseif ( is_scalar( $value ) ) {
		return (bool) $value;
	}

	return $default;
}

?>