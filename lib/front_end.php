<?php

// ==============
// = Front End  =
// ==============

/* Register and enque styling and javascript */

// Frontend Style and Behavior

function psp_front_styles($add_psp_scripts = null) {

	if((get_post_type() == 'psp_projects') || ($add_psp_scripts == 1)):
		wp_register_style( 'psp-frontend', plugins_url().'/'.PSP_PLUGIN_DIR.'/assets/css/psp-frontend.css', false, '1.0' );
		wp_enqueue_style( 'psp-frontend' );
	endif;

}

function psp_front_scripts($add_psp_scripts = null) {

	wp_register_script( 'psp-frontend-behavior', plugins_url().'/'.PSP_PLUGIN_DIR.'/assets/js/psp-frontend-behavior.js', array( 'jquery' ), '1.0', false );
	wp_register_script( 'snap-svg', plugins_url(). '/'.PSP_PLUGIN_DIR.'/assets/js/snap.svg-min.js',array('jquery'), '1.0', false);
	wp_register_script( 'psp-pizza', plugins_url(). '/'.PSP_PLUGIN_DIR.'/assets/js/pizza.js',array('jquery','snap-svg'), '1.0', false);
	wp_register_script( 'psp-smooth-scroll', plugins_url().'/'.PSP_PLUGIN_DIR.'/assets/js/jquery.smooth-scroll.min.js', array( 'jquery' ), '1.0', false );

	if((get_post_type() == 'psp_projects') || ($add_psp_scripts == 1)):
		wp_enqueue_script('jquery');
		wp_enqueue_script('snap-svg');
		wp_enqueue_script('psp-pizza');
		wp_enqueue_script( 'psp-smooth-scroll' );
		wp_enqueue_script( 'psp-frontend-behavior' );
	endif;

}

// Admin Style and Behavior

function psp_admin_styles() {

	wp_register_style( 'psp-admin', plugins_url().'/'.PSP_PLUGIN_DIR.'/assets/css/psp-admin.css', false, '1.0' );

	wp_enqueue_style( 'psp-admin' );

	wp_enqueue_style('jquery-ui-custom', plugins_url().'/'.PSP_PLUGIN_DIR.'/assets/css/jquery-ui-custom.css');

}
function psp_admin_scripts() {

	wp_enqueue_media();

	wp_register_script( 'psp-admin-behavior', plugins_url().'/'.PSP_PLUGIN_DIR.'/assets/js/psp-admin-behavior.js', array( 'jquery' ), '1.0', false );

	wp_enqueue_script( 'psp-admin-behavior' );
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_script('jquery-ui-slider');
}

// Enqeue All
add_action( 'admin_enqueue_scripts', 'psp_admin_styles' );
add_action( 'wp_enqueue_scripts', 'psp_front_styles',100);
add_action( 'wp_enqueue_scripts', 'psp_front_scripts' );
add_action( 'admin_enqueue_scripts', 'psp_admin_scripts' );
