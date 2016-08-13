<?php

/**
 * Plugin Name: Project Panorama Lite
 * Plugin URI: http://www.projectpanorama.com
 * Description: A project management and project visualization plugin designed to impress your clients, save time and allow you to bill more.
 * Version: 1.2.8
 * Author: 37 MEDIA
 * Author URI: http://www.projectpanorama.com
 * License: GPL2
 * Text Domain: psp_projects
 */

/**
 * If Panorama Pro isn't enabled...
 */

if( !function_exists( 'psp_initalize_application' ) ) {

    include_once( 'lib/psp-init.php' );
    include_once( 'psp-license.php' );

}

$constants = array(
    'PROJECT_PANARAMA_URI'  => plugins_url( '', __FILE__ ),
    'PROJECT_PANARAM_DIR'   => __DIR__,
    'PSP_VER'               => '1.2.8'
);

foreach( $constants as $constant => $val ) {

    if( !defined( $constant ) ) {
        define( $constant, $val );
    }

}

// ================
// = Localization =
// ================

add_action('plugins_loaded', 'psp_localize_init');
function psp_localize_init() {
    load_plugin_textdomain('psp_projects', false, dirname(plugin_basename(__FILE__)) . '/languages');
}


// ============================
// = Plugin Update Management =
// ============================


function psp_check_database() {

    $psp_database_version = get_option('psp_database_version');

    if($psp_database_version != '2') {
        psp_database_notice();
    }

}

/**
 * Nag to pay the bills
 *
 *
 * @param
 * @return NULL
 **/

// add_action('admin_notices', 'psp_lite_notice');
function psp_lite_notice() {

    if( get_option( 'psp_lite_notice' ) != 1 ) {
        ?>
            <div class="updated">

                <p><img src="<?php echo PROJECT_PANARAMA_URI; ?>/assets/images/panorama-logo.png" alt="Project Panorama"></p>
                <p><?php _e('Like Project Panorama Lite? We have a full featured premium version that you might like even better!','psp_projects'); ?> <a href="http://www.projectpanorama.com" target="_new"><?php _e('Check it out here.','psp_projects'); ?> | <a href="<?php echo site_url(); ?>/wp-admin/index.php?psp_no_lite_notice=0"><?php _e('No thanks!','psp_projects'); ?></a>.</p>

            </div>
    <?php

	}

}

add_action( 'admin_init', 'psp_check_lite_notice' );
function psp_check_lite_notice() {

    if ( isset($_GET[ 'psp_no_lite_notice' ] ) && '0' == $_GET[ 'panorama_ignore_db'] ) {
        update_option( 'psp_no_lite_notice', 1 );
    }

}
