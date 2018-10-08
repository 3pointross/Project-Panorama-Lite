<?php

/* Custom Single.php for project only view */
global $post, $doctype;

?>
<!DOCTYPE html>
<html <?php language_attributes( $doctype ); ?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php $client = get_field('client'); ?>
    <title><?php the_title(); ?> | <?php echo $client; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if(get_field('hide_from_search_engines',$post->ID)): ?>
        <meta name="robots" content="noindex, nofollow">
    <?php endif; ?>

    <?php // wp_head(); Removed for visual consistency ?>

    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/project-panorama-lite/assets/css/psp-frontend.css?ver=1.2.5">
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/project-panorama-lite/assets/css/psp-custom.css.php">

	<script src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/jquery.js?ver=1.2.5"></script>
    <script src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/psp-frontend-lib.min.js?ver=1.2.5"></script>
    <script src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/psp-frontend-behavior.js?ver=1.2.5"></script>

    <?php wp_localize_script( 'script_handle', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php'))); ?>

    <!--[if lte IE 9]>
    <script src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/html5shiv.min.js"></script>
    <script src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/js/css3-mediaqueries.js"></script>
    <![endif]-->
    <!--[if IE]>
    <link rel="stylesheet" type="text/css" src="<?php echo plugins_url(); ?>/project-panorama-lite/assets/css/ie.css">
    <![endif]-->

    <?php do_action('psp_head'); ?>

</head>
<body class="psp-standalone-page">

    <div id="psp-projects" class="psp-standard-template">

        <?php do_action('psp_the_header'); ?>

        <div id="overview" class="psp-comments-wrapper">

			<?php if( (get_option('psp_logo') != '' ) && (get_option('psp_logo') != 'http://') ): ?>
				<div class="psp-login-logo">
					<img src="<?php echo get_option('psp_logo'); ?>">
				</div>
            <?php endif; ?>

            <div id="psp-login">
                <?php if( !post_password_required() ): ?>

                    <h2><?php _e('This Project Requires a Login','psp_projects'); ?></h2>

                    <?php
                    if( !is_user_logged_in() ):
                        echo panorama_login_form();
                    else:
                        echo '<p>' . __( 'You don\'t have permission to access this project', 'psp_projects' ) . '</p>';
                    endif; ?>

                <?php endif; ?>

                <?php
                if( post_password_required() && !current_user_can('publish_psp_projects') ): ?>

                    <h2><?php esc_html_e('This Project is Password Protected','psp_projects'); ?></h2>

                    <?php echo get_the_password_form(); ?>

                <?php endif; ?>

            </div> <!--/#psp-login-->
        </div> <!--/#overview-->
    </div> <!--/#psp-project-->

    <?php wp_footer(); ?>

</body>
</html>
