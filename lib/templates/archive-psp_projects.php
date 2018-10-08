<?php

/* Custom Single.php for project only view */
global $post, $doctype;

$cuser = wp_get_current_user();

?>
<!DOCTYPE html>
<html <?php language_attributes( $doctype ); ?>>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $cuser->first_name.' '.$cuser->last_name ?> <?php _e('Projects','psp_projects'); ?></title>

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
<body id="psp-projects" class="psp-standalone-page psp-dashboard-page">

		<div class="psp-grid-container-fluid">

			<div class="psp-grid-row psp-equal-column-container">

				<div id="psp-archive-content" class="psp-col-md-10 psp-pull-right">

				    <?php if((get_option('psp_logo') != '') && (get_option('psp_logo') != 'http://')) { ?>

				        <section id="psp-branding" class="wrapper">
				            <div class="psp-branding-wrapper">
				                <a href="<?php echo site_url(); ?>"><img src="<?php echo get_option('psp_logo'); ?>"></a>
				            </div>
				        </section>

				    <?php } ?>

					<div class="psp-grid-row">

						<?php
                        $projects = array(
                            'active'    =>  psp_get_all_my_projects('active'),
                            'all'       =>  psp_get_all_my_projects(),
                        );

                        $project_overview = psp_my_projects_overview( $projects['all'] ); ?>

						<ul class="psp-project-tiles cf">
							<li class="psp-col-md-3 psp-col-sm-6">
								<div class="psp-project-tile">
									<?php _e('Total','psp_projects'); ?> <strong><?php _e('Projects','psp_projects'); ?></strong> <span><?php echo $project_overview['total']; ?></span>
								</div>
							</li>
							<li class="psp-col-md-3 psp-col-sm-6">
								<div class="psp-project-tile">
									<?php _e('Active','psp_projects'); ?> <strong><?php _e('Projects','psp_projects'); ?></strong> <span><?php echo $project_overview['active']; ?></span>
								</div>
							</li>
							<li class="psp-col-md-3 psp-col-sm-6">
								<div class="psp-project-tile">
									<?php _e('Completed','psp_projects'); ?> <strong><?php _e('Projects','psp_projects'); ?></strong> <span><?php echo $project_overview['completed']; ?></span>
								</div>
							</li>
							<li class="psp-col-md-3 psp-col-sm-6">
								<div class="psp-project-tile">
									<?php _e('Unstarted','psp_projects'); ?> <strong><?php _e('Projects','psp_projects'); ?></strong> <span><?php echo $project_overview['inactive']; ?></span>
								</div>
							</li>
						</ul>

					</div>

					<div class="psp-archive-section">

						<h2 class="psp-box-title"><?php _e('Active Projects','psp_projects'); ?></h2>

						<div class="psp-archive-list-wrapper">
							<?php echo psp_archive_project_listing( $projects['active'] ); ?>
						</div>

					</div>

				</div> <!--/.psp-md-8-->

				<div id="psp-archive-menu" class="psp-col-md-2 psp-pull-left">

					<div class="psp-archive-user">

						<?php $cuser = wp_get_current_user(); ?>

						<?php echo get_avatar($cuser->ID); ?>
						<p><?php echo psp_username_by_id($cuser->ID); ?></p>

					</div> <!--/.psp-archive-user-->

					<div class="psp-archive-projects">

						<h2><?php _e('Active Projects','psp_projects'); ?></h2>

						<?php
                        if( $projects['active']->have_posts() ): ?>
							<ul class="psp-project-list">
                                <?php while( $projects['active']->have_posts() ): $projects['active']->the_post(); ?>
									<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
								<?php endwhile; ?>
							</ul>
						<?php else: ?>
							<p><em><?php _e('No active projects at this time','psp_projects'); ?></em></p>
						<?php endif; ?>

					</div>

				</div>
			</div> <!--/.psp-row-grid-->
		</div> <!--/.psp-container-->

	</div>


</body>
</html>
