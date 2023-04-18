<?php
/**
 * Plugin Name: SHOPEO WeChat Official Login
 * Plugin URI: https://wordpress.org/plugins/shopeo-wechat-official-login
 * Description: WeChat Official Login
 * Author: SHOPEO
 * Version: 0.0.3
 * Author URI: https://shopeo.cn
 * License: GPL2+
 * Text Domain: shopeo-wechat-official-login
 * Domain Path: /languages
 * Requires at least: 5.9
 * Requires PHP: 8.0.2
 */


require_once 'vendor/autoload.php';

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define WECHAT_OFFICIAL_LOGIN_FILE.
if ( ! defined( 'WECHAT_OFFICIAL_LOGIN_FILE' ) ) {
	define( 'WECHAT_OFFICIAL_LOGIN_FILE', __FILE__ );
}

if ( ! defined( 'WECHAT_OFFICIAL_LOGIN_BASE' ) ) {
	define( 'WECHAT_OFFICIAL_LOGIN_BASE', plugin_basename( WECHAT_OFFICIAL_LOGIN_FILE ) );
}

if ( ! defined( 'WECHAT_OFFICIAL_LOGIN_PATH' ) ) {
	define( 'WECHAT_OFFICIAL_LOGIN_PATH', plugin_dir_path( WECHAT_OFFICIAL_LOGIN_FILE ) );
}

if ( ! function_exists( 'shopeo_wechat_official_login_activation' ) ) {
	function shopeo_wechat_official_login_activation() {

	}
}
register_activation_hook( __FILE__, 'shopeo_wechat_official_login_activation' );

if ( ! function_exists( 'shopeo_wechat_official_login_deactivation' ) ) {
	function shopeo_wechat_official_login_deactivation() {

	}
}

register_deactivation_hook( __FILE__, 'shopeo_wechat_official_login_deactivation' );

add_action( 'init', function () {
	load_plugin_textdomain( 'shopeo-wechat-official-login', false, dirname( __FILE__ ) . '/languages' );
} );

add_action( 'wp_enqueue_scripts', function () {
	$plugin_version = get_plugin_data( WECHAT_OFFICIAL_LOGIN_FILE )['Version'];
	wp_enqueue_style( 'shopeo-wechat-official-login-frontend-style', plugins_url( '/assets/css/frontend.css', WECHAT_OFFICIAL_LOGIN_FILE ), array(), $plugin_version );
	wp_style_add_data( 'shopeo-wechat-official-login-frontend-style', 'rtl', 'replace' );
	wp_enqueue_script( 'shopeo-wechat-official-login-frontend-script', plugins_url( '/assets/js/frontend.js', WECHAT_OFFICIAL_LOGIN_FILE ), array(), '0.0.1', true );
	wp_localize_script( 'shopeo-wechat-official-login-frontend-script', 'shopeo_custom_card_frontend', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	) );
} );

function shopeo_wechat_official_event( $request ) {

}

add_action( 'rest_api_init', function () {
	register_rest_route( 'shopeo-wechat-official/v1', '/event', array(
		'methods'  => WP_REST_Server::CREATABLE,
		'callback' => 'shopeo_wechat_official_event'
	) );
} );
