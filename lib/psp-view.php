<?php

/**
 * Call the psp_essentials function and echo it to the screen. Adds it to the page using the psp_the_essentials hook
 *
 *
 * @param NULL
 * @return NULL
 **/

add_action('psp_the_essentials','psp_echo_essentials');
function psp_echo_essentials( $id ) {

    global $post;

    $id = ( isset( $id ) ? $id : $post->ID );

    echo psp_essentials( $id );

}

/**
 * Outputs all the overview information to the page
 *
 *
 * @param $id, int post ID. $style string, $docs string
 * @return HTML output
 **/

function psp_essentials( $id, $style = null, $docs = null ) {

    ob_start();

	include( psp_template_hierarchy( '/parts/overview.php' ) );

    return ob_get_clean();

}


/**
 * Outputs a doughnut chart of all project progress
 *
 *
 * @param $id (current post ID)
 * @return HTML output
 **/

function psp_short_progress($id) {

    include(psp_template_hierarchy('/parts/short-progress.php'));

}

/* Use an action to add the progress indicator to the template */
add_action('psp_the_progress','psp_echo_total_progress');
function psp_echo_total_progress() {

    global $post;

	echo psp_total_progress($post->ID);

}

function psp_total_progress($id,$style = null,$options = null) {

    ob_start();

    include(psp_template_hierarchy('/parts/milestones.php'));

    return ob_get_clean();

}

function psp_get_phase_completion($tasks,$id) {

    $completed = 0;
    $task_count = 0;
    $task_completion = 0;

    if(get_field('phases_automatic_progress',$id)) {

        foreach($tasks as $task) {
            $task_count++;
            $task_completion += $task['status'];
        }

        if($task_count >= 1) {
            $completed += ceil($task_completion / $task_count);
        } elseif ($task_count == 1) {
            $completed = 0;
        } else {
            $completed += $task_completion;
        }

        return $completed;

    }

}

function psp_get_phase_completed($id) {

    $completed = 0;
    $tasks = 0;
    $task_completion = 0;
    $completed_tasks = 0;

    $phase_details = array();

    if(get_field('phases_automatic_progress',$id)) {

        while(has_sub_field('tasks',$id)) {
            $tasks++;
            $task_completion += get_sub_field('status');
            if(get_sub_field('status') == '100') { $completed_tasks++; }
        }

        if($tasks >= 1) { $completed += ceil($task_completion / $tasks); } elseif ($tasks == 1) { $completed = 0; } else { $completed += $task_completion; }

    } else {

        while(has_sub_field('tasks',$id)) {
            $tasks++;
            $task_completion += get_sub_field('status');
            if(get_sub_field('status') == '100') { $completed_tasks++; }
        }

        $completed = get_sub_field('percent_complete');
    }

    array_push($phase_details,$completed,$tasks,$completed_tasks);

    return $phase_details;

}



add_action('psp_the_phases','psp_echo_phases');
function psp_echo_phases() {

    global $post;
    echo psp_phases($post->ID);

}

function psp_phases($id, $style = null, $taskStyle = null) {

    ob_start();

	if(PSP_PLUGIN_TYPE == 'lite') {

		include(psp_template_hierarchy('parts/phases-lite.php'));

	} else {

		include(psp_template_hierarchy('/parts/phases.php'));

	}

    return ob_get_clean();

}

function panorama_login_form() {

    $panorama_form = wp_login_form(array('redirect' => $_SERVER["REQUEST_URI"]));

    return $panorama_form;

}


/**
 *
 * Function psp_task_table
 *
 * Returns a table of tasks which can be open, complete or all
 *
 * @param $post_id (int), $shortcode (BOOLEAN), $taskStyle (string)
 * @return $output
 *
 */

function psp_task_table($post_id,$shortcode = null, $taskStyle = null) {

    $output = '
    <table class="psp-task-table">
            <tr>
                <th class="psp-tt-tasks">'.__('Task','psp_projects').'</th>
                <th class="psp-tt-phase">'.__('Phase','psp_projects').'</th>';

    if($taskStyle != 'complete') {
        $output .= '<th class="psp-tt-complete">'.__('Completion','psp_projects').'</th>';
    }

    $output .= '</tr>';

    while(has_sub_field('phases',$post_id)):

        $phaseTitle = get_sub_field('title');

        while(has_sub_field('tasks',$post_id)):

            $taskCompleted = get_sub_field('status');

            // Continue if you want to show incomplete tasks only and this task is complete
            if(($taskStyle == 'incomplete') && ($taskCompleted == '100')) { continue; }

            // Continue if you want to show completed tasks and this task is not complete
            if(($taskStyle == 'complete') && ($taskCompleted != '100')) { continue; }

            $output .= '<tr><td>'.get_sub_field('task').'</td><td>'.$phaseTitle.'</td>';

            if($taskStyle != 'complete') { $output .= '<td><span class="psp-task-bar"><em class="status psp-'.get_sub_field('status').'"></em></span></td></tr>'; }

        endwhile;

    endwhile;

    $output .= '</table>';

    return $output;

}

/**
 *
 * Function psp_documents
 *
 * Stores all of the psp_documents into an unordered list and returns them
 *
 * @param $post_id
 * @return $psp_docs
 *
 */

function psp_documents( $id, $style ) {

    ob_start();

	include( psp_template_hierarchy( '/parts/documents-lite.php' ) );

    return ob_get_clean();

}


/**
 *
 * Function psp_single_template_logo
 *
 * Adds the logo to the top of the Panorama single.php if the option is turned on.
 *
 * @param
 * @return
 *
 */

add_action('psp_before_overview','psp_single_template_masthead');
function psp_single_template_masthead() {

    if((get_option('psp_logo') != '') && (get_option('psp_logo') != 'http://')) { ?>

        <section id="psp-branding" class="wrapper">
            <div class="psp-branding-wrapper">
                <img src="<?php echo get_option('psp_logo'); ?>">
            </div>
        </section>

    <?php
    }
}

/**
 *
 * Function psp_the_navigation
 *
 * Adds the navigation to the Project Panorama header
 *
 * @param
 * @return
 *
 */
add_action('psp_the_navigation','psp_single_template_navigation');
function psp_single_template_navigation() { ?>

	<?php $back = get_option('psp_back'); ?>

    <nav class="nav" id="psp-main-nav">
        <ul>
            <li id="nav-menu"><a href="#">Menu</a>
                <ul>
                    <li id="nav-over"><a href="#overview"><?php _e('Overview','psp_projects'); ?></a></li>
                    <li id="nav-complete"><a href="#psp-progress"><?php _e('% Complete','psp_projects'); ?></a></li>
                    <li id="nav-milestones"><a href="#psp-phases"><?php _e('Phases','psp_projects'); ?></a></li>
                    <li id="nav-talk"><a href="#psp-discussion"><?php _e('Discussion','psp_projects'); ?></a></li>
					<?php if((isset($back)) && (!empty($back))): ?>
						<li id="nav-back"><a href="<?php echo $back; ?>"><?php _e('Back','psp_projects'); ?></a></li>
					<?php else: ?>
						<li id="nav-back"><a href="<?php echo esc_url( get_post_type_archive_link('psp_projects') ); ?>"><?php _e( 'Dashboard', 'psp_projects' ); ?></a></li>
					<?php endif;?>
                    <?php do_action('psp_menu_items'); ?>
                    <?php if(is_user_logged_in()): ?>
                        <li id="nav-logout"><a href="<?php echo wp_logout_url($_SERVER["REQUEST_URI"]); ?>"><?php _e('Logout','psp_projects'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </nav>

<?php }

/**
 *
 * Function psp_single_template_header
 *
 * Adds the header to the Project Panorama single.php template
 *
 * @param
 * @return
 *
 */
add_action('psp_the_header','psp_single_template_header');
function psp_single_template_header() {

    global $post;
    $panorama_access = panorama_check_access($post->ID);
	if($panorama_access == 1):
    ?>

    <header id="psp-title" class="cf">
        <div class="wrapper">
            <h1><?php the_title(); ?> <span><?php the_field('client',$post->ID); ?></span></h1>
            <?php if($panorama_access == 1): ?>
                <?php do_action('psp_the_navigation'); ?>
            <?php endif; ?>
        </div>
    </header>

<?php endif;

}

/**
 *
 * Function psp_add_dashboard_widgets
 *
 * Defines the dashboard widget slug, title and display function
 *
 * @param
 * @return
 *
 */

function psp_add_dashboard_widgets() {

    // Make sure the user has the right permissions

    if(current_user_can('publish_psp_projects')) {

        wp_add_dashboard_widget(
            'psp_dashboard_overview',         // Widget slug.
            'Projects',         // Title.
            'psp_dashboard_overview_widget_function' // Display function.
        );

    }

}
add_action( 'wp_dashboard_setup', 'psp_add_dashboard_widgets' );

/**
 *
 * Function psp_dashboard_overview_widget_function
 *
 * Echo's the output of psp_populate_dashboard_widget
 *
 * @param
 * @return contents of psp_populate_dashboard_widget
 *
 */

function psp_dashboard_overview_widget_function() {

    echo psp_populate_dashboard_widget();

}


/**
 *
 * Function psp_populate_dashboard_widget
 *
 * Gathers the dashboard content and returns it in a variable
 *
 * @param
 * @return (variable) ($output)
 *
 */

function psp_populate_dashboard_widget() {

    $projects = get_posts(array('post_type' => 'psp_projects','posts_per_page' => '-1'));
    $total_projects = count($projects);
    $taxonomies = get_terms('psp_tax','fields=count');
    $recent = new WP_Query(array('post_type' => 'psp_projects','posts_per_page' => '10', 'orderby' => 'modified','order' => 'DESC','post_status' => 'publish'));

    // Calculate the number of completed projects

    $completed_projects = 0;
    $not_started =0;
    $active = 0;

    foreach($projects as $project):

        if(get_post_meta($project->ID,'_psp_completed',true) == '1')
            $completed_projects++;
        if(psp_compute_progress($project->ID) == 0)
            $not_started++;
        else
            $active++;
    endforeach;

    $percent_complete = floor($completed_projects/$total_projects * 100);
    $percent_not_started = floor($not_started/$total_projects * 100);
    $percent_remaining = 100 - $percent_complete - $percent_not_started;

	ob_start(); ?>

	<div class="psp-chart">
		<canvas id="psp-dashboard-chart" width="100%" height="150"></canvas>
	</div>

	<script>

        jQuery(document).ready(function() {

			var chartOptions = {
				responsive: true
			}

            var data = [
                {
                    value: <?php echo $percent_complete; ?>,
                    color: "#2a3542",
                    label: "Completed"
                },
                {
                    value: <?php echo $percent_remaining; ?>,
                    color: "#3299bb",
                    label: "In Progress"
                },
                {
                    value: <?php echo $percent_not_started; ?>,
                    color: "#666666",
                    label: "Not Started"
                }
            ];


            var psp_dashboard_chart = document.getElementById("psp-dashboard-chart").getContext("2d");

            new Chart(psp_dashboard_chart).Doughnut(data,chartOptions);

        });

	</script>


			<ul data-pie-id="psp-dashboard-chart" class="dashboard-chart-legend">
				<li data-value="<?php echo $percent_not_started; ?>"><span><?php echo $percent_not_started; ?>% <?php _e('Not Started','psp_projects'); ?></span></li>
				<li data-value="<?php echo $percent_remaining; ?>"><span><?php echo $percent_remaining; ?>% <?php _e('In Progress','psp_projects'); ?></span></li>
				<li data-value="<?php echo $percent_complete; ?>"><span><?php echo $percent_complete; ?>% <?php _e('Complete','psp_projects'); ?></span></li>
			</ul>

			 <ul class="psp-projects-overview">
					<li><span class="psp-dw-projects"><?php echo $total_projects; ?></span> <strong><?php _e('Projects','psp_projects'); ?></strong> </li>
					<li><span class="psp-dw-completed"><?php echo $completed_projects; ?></span> <strong><?php _e('Completed','psp_projects'); ?></strong></li>
					<li><span class="psp-dw-active"><?php echo $active; ?></span> <strong><?php _e('active','psp_projects'); ?></strong></li>
					<li><span class="psp-dw-types"><?php echo $taxonomies; ?></span> <strong><?php _e('Types','psp_projects'); ?></strong></li>
			  </ul>

			  <hr>

			 <h4><?php _e('Recently Updated','psp_projects'); ?></h4>
			 <table class="psp-dashboard-widget-table">
				<tr>
					<th><?php _e('Project','psp_projects'); ?></th>
					<th><?php _e('Progress','psp_projects'); ?></th>
					<th><?php _e('Updated','psp_projects'); ?></th>
					<th>&nbsp;</th>
				</tr>

    			<?php while($recent->have_posts()): $recent->the_post(); global $post; ?>
        			<tr>
					   <td><a href="<?php echo get_edit_post_link(); ?>"><?php the_title(); ?></a></td>
					   <td>
						   <?php
						   $completed = psp_compute_progress($post->ID);

						   	if($completed > 10): ?>
          						<p class="psp-progress"><span class="psp-<?php echo $completed; ?>"><strong>%<?php echo $completed; ?></strong></span></p>
							<?php else: ?>
            					<p class="psp-progress"><span class="psp-<?php echo $completed; ?>"></span></p>
        					<?php endif; ?>
  					  </td>
					  <td class="psp-dwt-date"><?php echo get_the_modified_date("m/d/Y"); ?></td>
					  <td class="psp-dwt-date"><a href="<?php the_permalink(); ?>" target="_new" class="psp-dw-view"><?php _e('View','psp_projects'); ?></a></td>
				</tr>
    			<?php endwhile; ?>
		</table>

	<?php
    return ob_get_clean();

} ?>
