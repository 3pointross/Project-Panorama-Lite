<?php

function panorama_admin_notice() {

		global $current_user;
        $user_id = $current_user->ID;

	    if(!get_user_meta($user_id,'panorama_ignore_notice')) {

            ?>

            <div class="updated">

				<p><img src="<?php echo PROJECT_PANARAMA_URI; ?>/assets/images/panorama-logo.png" alt="Project Panorama"></p>
                <p>Like Project Panorama? Did you know we have a <a href="http://www.projectpanorama.com" target="_new">full featured premium version?</a> Check it out, you might just like it. | <a href="?panorama_nag_ignore=0">Hide Notice</a></p>

            </div>
        <?php }
}

add_action('admin_notices', 'panorama_admin_notice');

add_action('admin_init','panorama_nag_ignore');
function panorama_nag_ignore() {
    global $current_user;
    $user_id = $current_user->ID;
    /* If user clicks to ignore the notice, add that to their user meta */
    if ( isset($_GET['panorama_nag_ignore']) && '0' == $_GET['panorama_nag_ignore'] ) {
        update_user_meta($user_id, 'panorama_ignore_notice', 'true');
    }
}

function panorama_install_acf() {

    global $acf, $current_user;
    $user_id = $current_user->ID;

    if((!get_user_meta($user_id,'panorama_acf_ignore')) && (ACF_LITE == 'true')):
        ?>

        <div class="updated">
            <p>Project Panorama Lite uses <a href="<?php echo admin_url(); ?>plugin-install.php?tab=search&s=advanced+custom+fields&plugin-search-input=Search+Plugins">Advanced Custom Fields plugin</a>. While Panorama functions without ACF, we recommend you <a href="<?php echo admin_url(); ?>plugin-install.php?tab=plugin-information&plugin=advanced-custom-fields&TB_iframe=true&width=600&height=550" class="thickbox">install your own version</a> to ensure you can easily upgrade. | <a href="?panorama_acf_ignore=0">Hide This Notice</a></p>

        </div>
    <?php
    endif;


}


add_action('admin_notices','panorama_install_acf');
add_action('admin_notices','panorama_admin_notice');

add_action('admin_init','panorama_acf_ignore');
function panorama_acf_ignore() {
    global $current_user;
    $user_id = $current_user->ID;
    if(isset($_GET['panorama_acf_ignore']) && '0' == $_GET['panorama_acf_ignore']) {
        update_user_meta($user_id, 'panorama_acf_ignore','true');
    }
}
