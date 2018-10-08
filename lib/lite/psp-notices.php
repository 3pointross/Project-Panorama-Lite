<?php
add_action( 'admin_notices', 'panorama_admin_notice' );
function panorama_admin_notice() {

    global $pagenow, $typenow, $current_user;

    $views = array(
        'post.php',
        'post-new.php'
    );

    if ( ( in_array( $pagenow, $views ) ) && ( $typenow == 'psp_projects' ) ) {

        $user_id = $current_user->ID;
        if( !get_user_meta( $user_id, 'panorama_ignore_notice_new' ) ) {

            ?>

            <div class="updated">

                <p><img src="<?php echo PROJECT_PANARAMA_URI; ?>/assets/images/panorama-logo.png" alt="Project Panorama" height="50"></p>
                <p>Like Project Panorama? Did you know we have a <a href="http://www.projectpanorama.com" target="_new">full featured premium version?</a>. <strong>Use coupon code <code>litemeup</code> to save 10%.</strong> | <a href="?panorama_nag_ignore=0">Hide Notice</a></p>

            </div>
        <?php }
    }
}

function panorama_nag_ignore() {

    global $current_user;
    $user_id = $current_user->ID;

    /* If user clicks to ignore the notice, add that to their user meta */
    if ( isset( $_GET['panorama_nag_ignore'] ) && '0' == $_GET['panorama_nag_ignore'] ) {

        add_user_meta( $user_id, 'panorama_ignore_notice_new', 'true', true );

    }

}

add_action( 'add_meta_boxes', 'psp_add_promotional_metabox' );
function psp_add_promotional_metabox() {

    add_meta_box( 'psp_lite_promotional_sidebar', __( 'Project Panorama', 'psp_projects' ), 'psp_promotional_metabox', 'psp_projects', 'side' );

}

function psp_promotional_metabox() { ?>

    <p><img src="<?php echo PROJECT_PANARAMA_URI; ?>/assets/images/panorama-logo.png" alt="Project Panorama" height="50"></p>
    <p>Like Project Panorama? <a href="http://www.projectpanorama.com" target="_new">Did you know we have a full featured premium version?</a>. <strong>Use coupon code <code>litemeup</code> to save 10%.</strong></p>

<?php }
