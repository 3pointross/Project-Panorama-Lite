<?php
$requires = array(
    'psp-lite-shortcodes.php',
    'psp-lite-functions.php',
    'psp-notices.php',
);
foreach( $requires as $require ) require_once($require);

add_action( 'init', 'psp_load_custom_fields' );
function psp_load_custom_fields() {

    // Load the custom fields
    require_once( 'psp-lite-fields.php' );

} ?>
