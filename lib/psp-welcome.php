<?php
function psp_lite_welcome_screen_activate() {
  set_transient( '_psp_lite_welcome_screen_activation_redirect', true, 30 );
}

add_action( 'admin_init', 'psp_lite_welcome_screen_do_activation_redirect' );
function psp_lite_welcome_screen_do_activation_redirect() {

  // Bail if no activation redirect
  if ( ! get_transient( '_psp_lite_welcome_screen_activation_redirect' ) ) {
    return;
  }

  // Delete the redirect transient
  delete_transient( '_psp_lite_welcome_screen_activation_redirect' );

  // Bail if activating from network, or bulk
  if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
    return;
  }

  // Redirect to bbPress about page
  wp_safe_redirect( add_query_arg( array( 'page' => 'welcome-to-project-panorama-lite' ), admin_url( 'index.php' ) ) );

}

add_action('admin_menu', 'psp_lite_welcome_screen_pages');

function psp_lite_welcome_screen_pages() {

  add_dashboard_page(
    'Welcome To Project Panorama Lite',
    'Welcome To Project Panorama Lite',
    'read',
    'welcome-to-project-panorama-lite',
    'psp_lite_welcome_screen_content'
  );

  add_dashboard_page(
    'Welcome To Project Panorama Lite',
    'Welcome To Project Panorama Lite',
    'read',
    'project-panorama-resources-lite',
    'psp_lite_resource_screen_content'
  );

}

function psp_lite_resource_screen_content() { ?>

    <div class="wrap pano-admin-wrap">

      <h2 class="nav-tab-wrapper">
        <a class="nav-tab" href="<?php echo admin_url() ?>/index.php?page=welcome-to-project-panorama"><?php esc_html_e( 'Getting Started', 'psp_projects' ); ?></a>
        <a class="nav-tab nav-tab-active" href="<?php echo admin_url() ?>/index.php?page=project-panorama-resources-lite"><?php esc_html_e( 'Resources', 'psp_projects' ); ?></a>
        <a class="nav-tab" href="https://www.projectpanorama.com/support" target="_new"><?php esc_html_e( 'Support', 'psp_projects' ); ?></a>
      </h2>

      <br>

      <h2><?php esc_html_e( 'Resources', 'psp_projects' ); ?></h2>

      <p class="panorama-admin-intro-paragraph"><?php esc_html_e( 'Need more help? Use this quick links to get to where you need to go.', 'psp_projects' ); ?></p>

      <ul>
          <li><a href="https://www.projectpanorama.com/support" target="_new"><?php esc_html_e( 'Support', 'psp_projects' ); ?></a></li>
          <li><a href="https://www.projectpanorama.com/blog" target="_new"><?php esc_html_e( 'Panorama Blog', 'psp_projects' ); ?></a></li>
      </ul>

      <h3><?php esc_html_e( 'Signup for Update Notifications', 'psp_projects' ); ?></h3>

              <!-- Begin MailChimp Signup Form -->
        <link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">
        <style type="text/css">
        	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
        	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
        	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
        </style>
        <div id="mc_embed_signup">
        <form action="//projectpanorama.us12.list-manage.com/subscribe/post?u=5464e51cf86cf8c053203f594&amp;id=9d3ac76187" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
            <div id="mc_embed_signup_scroll">
        <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
        <div class="mc-field-group">
        	<label for="mce-EMAIL">Email Address  <span class="asterisk">*</span>
        </label>
        	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
        </div>
        	<div id="mce-responses" class="clear">
        		<div class="response" id="mce-error-response" style="display:none"></div>
        		<div class="response" id="mce-success-response" style="display:none"></div>
        	</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
            <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_5464e51cf86cf8c053203f594_9d3ac76187" tabindex="-1" value=""></div>
            <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
            </div>
        </form>
        </div>
        <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
        <!--End mc_embed_signup-->

    </div>

    <?php
}

function psp_lite_welcome_screen_content() {
  ?>
  <div class="wrap pano-admin-wrap">

    <h2 class="nav-tab-wrapper">
      <a class="nav-tab nav-tab-active" href="#getting-started"><?php esc_html_e( 'Getting Started', 'psp_projects' ); ?></a>
      <a class="nav-tab" href="<?php echo admin_url() ?>/index.php?page=project-panorama-resources-lite"><?php esc_html_e( 'Resources', 'psp_projects' ); ?></a>
      <a class="nav-tab" href="https://www.projectpanorama.com/support" target="_new"><?php esc_html_e( 'Support', 'psp_projects' ); ?></a>
    </h2>

    <br>

    <img src="<?php echo esc_url( PROJECT_PANARAMA_URI ) . '/assets/images/panorama-logo.png'; ?>" alt="<?php esc_attr_e( 'Project Panorama', 'psp_projects' ); ?>">

    <h1><?php esc_html_e( 'Welcome to Project Panorama', 'psp_projects' ); ?></h1>

    <p class="panorama-admin-intro-paragraph"><?php esc_html_e( 'Thank you for using Project Panorama! We truely believe that it can help you
    impress your clients, save time and allow you to bill more. We\'ve got some great information to help you get started.', 'psp_projects' ); ?></p>

    <h2><?php esc_html_e( 'Getting Started', 'psp_projects' ); ?></h2>

    <p><?php esc_html_e(
        'Project Panorama Lite allows you to track and communicate project progress. Dive into the key project areas that Panorama manages below:', 'psp_projects' ); ?></p>

    <ul>
        <li><a href="#overview"><?php esc_html_e( 'Overview', 'psp_projects' ); ?></a></li>
        <li><a href="#timing"><?php esc_html_e( 'Timing', 'psp_projects' ); ?></a></li>
        <li><a href="#overview"><?php esc_html_e( 'Documents', 'psp_projects' ); ?></a></li>
        <li><a href="#milestones"><?php esc_html_e( 'Milestones', 'psp_projects' ); ?></a></li>
        <li><a href="#phases"><?php esc_html_e( 'Phases', 'psp_projects' ); ?></a></li>
        <li><a href="#phases"><?php esc_html_e( 'Discussions', 'psp_projects' ); ?></a></li>
    </ul>

    <hr class="pano-admin-hr">

    <h3 id="overview"><?php esc_html_e( 'Overview', 'psp_projects' ); ?></h3>

    <p><?php esc_html_e( 'All projects have important details that must be communicated to stakeholders in order to be relevant.'); ?>

    <hr class="pano-admin-hr">

    <img src="<?php echo esc_url( PROJECT_PANARAMA_URI ) . '/assets/images/getting-started/milestones.jpg'; ?>" class="demo-image">

    <h3 id="milestones"><?php esc_html_e( 'Milestones', 'psp_projects' ); ?></h3>

    <p><?php esc_html_e(
        'Milestones are events that happen in predictable times throughout a project. They can coinside with phases, but they don\'t always.
        Some projects phases don\'t happen sequentially, thus the phases can be indpenendant. The most common use of milestones is billing.
        When a project has been completed to a specific point, you issue a new bill.', 'psp_projects'
    ); ?></p>

    <p><?php esc_html_e( 'Milestones will automatically be indicated as completed once project progress meets or passes their location.', 'psp_projects' ); ?></p>

    <hr class="pano-admin-hr">

    <img src="<?php echo esc_url( PROJECT_PANARAMA_URI ) . '/assets/images/getting-started/phases.png'; ?>" class="demo-image">

    <h3 id="phases"><?php esc_html_e( 'Phases', 'psp_projects' ); ?></h3>

    <p><?php esc_html_e(
        'Phases are the core segments of a project. If you think about any project it can be broken down into specific segments. For example: plan, execute, review. Each phase has
        key tasks associated with them which when completed contribute to the overall completion of the project.', 'psp_projects' ); ?></p>

    <p><?php esc_html_e(
        'You can also have discussion on phases, keeping key communication specific to the relevant area.', 'psp_projects'
    ); ?></p>

    <hr class="pano-admin-hr">

  </div>
  <?php
}

add_action( 'admin_head', 'psp_lite_welcome_screen_remove_menus' );

function psp_lite_welcome_screen_remove_menus() {

    remove_submenu_page( 'index.php', 'welcome-to-project-panorama-lite' );
    remove_submenu_page( 'index.php', 'project-panorama-resources-lite' );

}
