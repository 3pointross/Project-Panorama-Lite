<?php

// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_acf_slider( $version ) {
    include_once('acf-slider-v5.php');
}

add_action('acf/include_field_types', 'include_field_types_acf_slider');




// 3. Include field type for ACF4
function register_fields_acf_slider() {
    include_once('acf-slider-v4.php');
}

add_action('acf/register_fields', 'register_fields_acf_slider');



?>