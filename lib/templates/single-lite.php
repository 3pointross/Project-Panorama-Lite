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

<?php $panorama_access = panorama_check_access($post->ID); ?>

<div id="psp-projects" class="psp-standard-template">
    <?php while(have_posts()): the_post(); ?>

		<input type="hidden" id="psp-task-style" value="<?php the_field('expand_tasks_by_default',$post->ID); ?>">

        <?php do_action('psp_the_header'); ?>

        <?php if ($panorama_access == 1) : ?>

            <?php do_action('psp_before_overview'); ?>

            <section id="overview" class="wrapper psp-section">

                <?php do_action('psp_before_essentials'); ?>
                <?php do_action('psp_the_essentials'); ?>
                <?php do_action('psp_after_essentials'); ?>

            </section> <!--/#overview-->

            <?php do_action('psp_between_overview_progress'); ?>

            <section id="psp-progress" class="cf psp-section">

                <?php do_action('psp_before_progress'); ?>
                <?php do_action('psp_the_progress'); ?>
                <?php do_action('psp_after_progress'); ?>

            </section> <!--/#progress-->

            <?php do_action('psp_between_progress_phases'); ?>

            <section id="psp-phases" class="wrapper psp-section">

                <?php do_action('psp_before_phases'); ?>
                <?php do_action('psp_the_phases'); ?>
                <?php do_action('psp_after_phases'); ?>

            </section>

            <?php do_action('psp_between_phases_discussion'); ?>

            <!-- Discussion -->
            <section id="psp-discussion" class="psp-section cf">
                <div class="wrapper">
                    <div class="discussion-content">

                        <?php $commentPath = getcwd().'/psp-comment-part.php'; ?>
                        <?php comments_template($commentPath,true); ?>

                    </div>
                </div>
            </section>

        <?php endif; ?>

        <?php if($panorama_access == 0): ?>
            <div id="overview" class="psp-comments-wrapper">
			    
				<?php if((get_option('psp_logo') != '') && (get_option('psp_logo') != 'http://')) { ?>
					<div class="psp-login-logo">
						<img src="<?php echo get_option('psp_logo'); ?>">
					</div>
				<?php } ?>
				
                <div id="psp-login">
                    <?php if(($panorama_access == 0) && (get_field('restrict_access_to_specific_users'))): ?>
                        <h2><?php _e('This Project Requires a Login','psp_projects'); ?></h2>
						
                        <?php if(!is_user_logged_in()) {
                            echo panorama_login_form();
                        } else {
                            echo "<p>".__('You don\'t have permission to access this project','psp_projects')."</p>";
                        }
                        ?>
                    <?php endif; ?>
                    <?php if((post_password_required()) && (!current_user_can('manage_options'))): ?>
                        <h2><?php _e('This Project is Password Protected','psp_projects'); ?></h2>
                        <?php echo get_the_password_form(); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>


    <?php endwhile; // ends the loop ?>

</div> <!--/#psp-project-->

<?php wp_footer(); ?>
</body>
</html>
