<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package stack-slider-a-3d-imageslider
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class WP_sk_Script {
	
	function __construct() {
		
		// Action to add style at front side
		add_action( 'wp_enqueue_scripts', array($this, 'wp_sk_front_style') );
		
		// Action to add script at front side
		add_action( 'wp_enqueue_scripts', array($this, 'wp_sk_front_script') );
		
		// Action to add style in backend
		add_action( 'admin_enqueue_scripts', array($this, 'wp_sk_admin_style') );
		
		// Action to add script at admin side
		add_action( 'admin_enqueue_scripts', array($this, 'wp_sk_admin_script') );
	}

	/**
	 * Function to add style at front side
	 * 
	 * @package stack-slider-a-3d-imageslider
	 * @since 1.0.0
	 */
	function wp_sk_front_style() {
		// Registring and enqueing stack-slider css	
		
		if( !wp_style_is( 'wpos-swiper-style', 'registered' ) ) {		
			wp_register_style( 'wpos-swiper-style', WP_SK_URL.'assets/css/swiper.min.css', array(), WP_SK_VERSION );
			wp_enqueue_style( 'wpos-swiper-style');
		}
		
		// Registring and enqueing public css
		wp_register_style( 'wp-sk-public-css', WP_SK_URL.'assets/css/wp-sk-public.css', null, WP_SK_VERSION );
		wp_enqueue_style( 'wp-sk-public-css' );

	}
	
	/**
	 * Function to add script at front side
	 * 
	 * @package stack-slider-a-3d-imageslider
	 * @since 1.0.0
	 */
	function wp_sk_front_script() {
		
		if( !wp_script_is( 'wpos-swiper-jquery', 'registered' ) ) {		
			wp_register_script( 'wpos-swiper-jquery', WP_SK_URL.'assets/js/swiper.min.js', array('jquery'), WP_SK_VERSION, true );
		}		

		// Registring public script
		wp_register_script( 'wp-sk-public-js', WP_SK_URL.'assets/js/wp-sk-public.js', array('jquery'), WP_SK_VERSION, true );		
		
		
	}
	
	/**
	 * Enqueue admin styles
	 * 
	 * @package stack-slider-a-3d-imageslider
	 * @since 1.0.0
	 */
	function wp_sk_admin_style( $hook ) {

		global $post_type, $typenow;
		
		$registered_posts = array(WP_SK_POST_TYPE); // Getting registered post types

		// If page is plugin setting page then enqueue script
		if( in_array($post_type, $registered_posts) ) {
			
			// Registring admin script
			wp_register_style( 'wp-sk-admin-style', WP_SK_URL.'assets/css/wp-sk-admin.css', null, WP_SK_VERSION );
			wp_enqueue_style( 'wp-sk-admin-style' );
		}
	}

	/**
	 * Function to add script at admin side
	 * 
	 * @package stack-slider-a-3d-imageslider
	 * @since 1.0.0
	 */
	function wp_sk_admin_script( $hook ) {
		
		global $wp_version, $wp_query, $typenow, $post_type;
		
		$registered_posts = array(WP_SK_POST_TYPE); // Getting registered post types
		$new_ui = $wp_version >= '3.5' ? '1' : '0'; // Check wordpress version for older scripts
		
		if( in_array($post_type, $registered_posts) ) {

			// Enqueue required inbuilt sctipt
			wp_enqueue_script( 'jquery-ui-sortable' );

			// Registring admin script
			wp_register_script( 'wp-sk-admin-script', WP_SK_URL.'assets/js/wp-sk-admin.js', array('jquery'), WP_SK_VERSION, true );
			wp_localize_script( 'wp-sk-admin-script', 'WpSkAdmin', array(
																	'new_ui' 				=>	$new_ui,
																	'img_edit_popup_text'	=> __('Edit Image in Popup', 'swiper-slider-and-carousel'),
																	'attachment_edit_text'	=> __('Edit Image', 'swiper-slider-and-carousel'),
																	'img_delete_text'		=> __('Remove Image', 'swiper-slider-and-carousel'),
																));
			wp_enqueue_script( 'wp-sk-admin-script' );
			wp_enqueue_media(); // For media uploader
		}
	}
}

$wp_sk_script = new WP_sk_Script();

