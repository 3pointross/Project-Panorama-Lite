<?php
require_once( 'psp-lite-shortcodes.php' );
require_once( 'psp-lite-functions.php' );
require_once( 'psp-notices.php' );

add_action( 'init', 'psp_load_custom_fields' );
function psp_load_custom_fields() {

    // Load the custom fields
    require_once( 'psp-lite-fields.php' );

} ?>
