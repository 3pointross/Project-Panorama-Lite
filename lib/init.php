<?php

	/* Init.php

	Master file, builds everything.

	*/


	// Include Advanced Custom Fields - NOTE: Premium "Repeater Field" Add-on is NOT to be used or distributed outside of this plugin per original copyright information from ACF - http://www.advancedcustomfields.com/resources/getting-started/including-lite-mode-in-a-plugin-theme/

if( file_exists( dirname(__FILE__) . '/pro/init.php' ) ) {

	define('PSP_PLUGIN_TYPE','professional');
	define('PSP_PLUGIN_DIR','project-panorama');

} else {

	define('PSP_PLUGIN_TYPE','lite');
	define('PSP_PLUGIN_DIR','project-panorama-lite');

}

global $acf;

if( !$acf ) {

	add_filter('acf/settings/path', 'psp_acf_settings_path');
	add_filter('acf/settings/dir', 'psp_acf_settings_dir');
	add_filter('acf/settings/show_admin', '__return_false');

	include_once( PSP_PLUGIN_DIR . '/lib/acf/master/acf.php' );

}


function psp_acf_settings_path( $path ) {

    // update path
    $path = PSP_PLUGIN_DIR . '/lib/acf/master';

    // return
    return $path;

}


// 2. customize ACF dir

function psp_acf_settings_dir( $dir ) {

    // update path
    $dir = PSP_PLUGIN_DIR . '/acf/';

    // return
    return $dir;

}


if( file_exists( dirname(__FILE__) . '/pro/init.php' ) ) {

    require_once('pro/init.php');

    if(!class_exists('acf_field_repeater')) {

        include_once('acf/repeater/acf-repeater.php');

	}


} else {

    require_once('lite/init.php');

}

if(!function_exists('duplicate_post_is_current_user_allowed_to_copy')) {
    include_once('clone/duplicate-post.php');
}

include_once('acf/slider/acf-slider.php');
require_once('data_model.php');
require_once('custom_templates.php');
require_once('view.php');
require_once('front_end.php');
require_once('custom_comments.php');
require_once('helper.php');
require_once('shortcodes.php');
