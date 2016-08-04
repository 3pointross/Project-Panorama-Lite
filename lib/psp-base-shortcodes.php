<?php

/* Display Current Projects */

function psp_current_projects($atts) {

    extract( shortcode_atts(
            array(
                'type' => 'all',
                'status' => 'all',
                'access' => 'all',
                'count' => '10',
				'sort'	=> 'default',
				'order'	=> 'ASC'
            ), $atts )
    );

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$cuser = wp_get_current_user();
	$cid = $cuser->ID;

	unset($meta_args);
	unset($status_args);

	// Determine the sorting

	if($sort == 'start') {

		$meta_sort = 'start_date';
		$order_by = 'meta_value';

	} elseif ($sort == 'end') {

		$meta_sort = 'end_date';
		$order_by = 'meta_value';

	} elseif ($sort == 'title') {

		$meta_sort = NULL;
		$order_by = 'title';

	} else {

		$meta_sort = 'start_date';
		$order_by = 'menu_order';

	}

	// Set the initial arguments

    $args = array(
        'post_type' 		=> 'psp_projects',
        'paged'				=> $paged,
        'posts_per_page'	=> $count,
		'meta_key' 			=>	$meta_sort,
		'orderby'			=>	$order_by,
		'order'				=>	$order
    );

    // If a type has been selected, add it to the argument

    if((!empty($type)) && ($type != 'all')) {
        $tax_args = array('psp_tax' => $type);
        $args = array_merge($args,$tax_args);

    }

	if($status == 'active') {
		$status_args = array('tax_query' => array(
			array(
				'taxonomy'	=>	'psp_status',
				'field'		=>	'slug',
				'terms'		=>	'completed',
				'operator'	=>	'NOT IN'
				)
			)
		);

		$args = array_merge($args,$status_args);

	}

	if($status == 'completed') {
		$status_args = array('tax_query' => array(
			array(
				'taxonomy'	=>	'psp_status',
				'field'		=>	'slug',
				'terms'		=>	'completed',
				)
			)
		);

		$args = array_merge($args,$status_args);

	}


    if($access == 'user') {

		// Just restricting access, not worried about active or complete

        if(!current_user_can('manage_options')) {

            $cuser = wp_get_current_user();
            $cid = $cuser->ID;

            $meta_args = array(
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'allowed_users_%_user',
                        'value' => $cid
                    ),
                    array(
                        'key' => 'restrict_access_to_specific_users',
                        'value' => ''
                    )
                ),
				'has_password' => false
            );

			$args = array_merge($args,$meta_args);

		}

    }

    $projects = new WP_Query($args);

	if(($access == 'user') && (!is_user_logged_in())) { ?>
	<div id="psp-projects">
		<div id="psp-overview">

        	<div id="psp-login" class="shortcode-login">

				<h2><?php _e('Please Login to View Projects','psp_projects'); ?></h2>

				<?php echo panorama_login_form(); ?>

			</div> <!--/#psp-login-->

		</div>
	</div>
	<?php

		 psp_front_assets(1);

		return;

	}


    if($projects->have_posts()):
        ob_start();

		?>
		<div id="psp-projects">
			<table class="psp_project_list">
        		<thead>
            		<tr>
                		<th class="psp_pl_col1"><?php _e('Project','psp_projects'); ?></th>
                		<th class="psp_pl_col2"><?php _e('Progress','psp_projects'); ?></th>
                		<th class="psp_pl_col3"><?php _e('Start','psp_projects'); ?></th>
                		<th class="psp_pl_col4"><?php _e('End','psp_projets'); ?></th>
            		</tr>
            	</thead>

            <?php while($projects->have_posts()): $projects->the_post(); global $post; ?>

                <tr>
                    <td>
                        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                        <div class="psp-table-meta">
                            <p><strong><?php _e('Client','psp_projects'); ?>:</strong> <?php the_field('client'); ?><br> <strong><?php _e('Last Updated','psp_projects'); ?>:</strong> <?php the_modified_date(); ?></p>
                        </div>
                    </td>
                    <td>
                        <?php global $post; $completed = psp_compute_progress($post->ID);

                        if(!empty($completed)) {
                            echo '<p class="psp-progress"><span class="psp-'.$completed.'"><b>'.$completed.'%</b></span></p>';
                        } ?>
                    </td>
                    <td>
                        <?php psp_the_start_date($post->ID); ?>
                    </td>
                    <td>
                        <?php psp_the_end_date($post->ID); ?>
                    </td>
                </tr>

            <?php endwhile; ?>

        	</table>

        	<p><?php echo get_next_posts_link('&laquo; More Projects',$projects->max_num_pages).' '.get_previous_posts_link('Previous Projects &raquo;'); ?></p>
		</div>

        <?php psp_front_assets(1);

		// Clear out this query
		wp_reset_query();

        return ob_get_clean();

    else:

        return '<p>'.__('No projects found','psp_projects').'</p>';

    endif;

}
add_shortcode('project_list','psp_current_projects');

function psp_archive_project_listing($projects,$page = 1) {


    if($projects->have_posts()):
        ob_start(); ?>

		<table class="psp-archive-list psp-table-pagination">
			<thead>
				<tr>
					<th><?php _e('Project','psp_projects'); ?></th>
					<th><?php _e('Progress','psp_projects'); ?></th>
					<th><?php _e('Time Elappsed','psp_projects'); ?></th>
				</tr>
			</thead>
			<tbody>
		<?php
		while($projects->have_posts()): $projects->the_post(); ?>

        	<tr class="psp-archive-list-item">

				<?php global $post; ?>

			    <?php

				$startDate = psp_text_date(get_field('start_date',$post->ID));
			    $endDate = psp_text_date(get_field('end_date',$post->ID));

				?>

				<td class="psp-ali-header">
					<a href="<?php the_permalink(); ?>">

						<span class="psp-ali-client"><?php the_field('client'); ?></span>

						<span class="psp-ali-title"><?php the_title(); ?></span>

						<span class="psp-ali-dates"><?php echo $startDate; ?> <b>&#8594;</b> <?php echo $endDate; ?></span>

					</a>
				</td>

				<td class="psp-ali-progress">

					<?php $completed = psp_compute_progress($post->ID); ?>
					<p class="psp-progress"><span class="psp-<?php echo $completed; ?>"><b><?php echo $completed; ?>%</b></span></p>

				</td>
				<td class="psp-ali-progress">
					<?php psp_the_timebar($post->ID); ?>
				</td>

			</tr> <!--/psp-archive-list-item-->

		<?php endwhile; ?>

			</tbody>
		</table>


		<?php if(!is_archive()): ?>

			<p><?php echo get_next_posts_link('<span class="psp-ajax-more-projects">&laquo; More Projects</span>',$projects->max_num_pages).' '.get_previous_posts_link('<span class="psp-ajax-prev-projects">Previous Projects &raquo;</span>'); ?></p>

		<?php endif; ?>

        <?php psp_front_assets(1);

        return ob_get_clean();

    else:

        return '<p>'.__('No projects found','psp_projects').'</p>';

    endif;

}

function psp_project_listing_dialog() {

    $psp_taxes = get_terms('psp_tax');
    $psp_tax_list = '';

    foreach($psp_taxes as $tax) {
        $psp_tax_list .= '<option value="'.$tax->slug.'">'.$tax->name.'</option>';
    }

    $output = '
			<div class="psp-dialog" style="display:none">
					<div id="psp-project-listing-dialog">
						<h3>'.__('Project Listing','psp_projects').'</h3>
						<p>'.__('Select from the options below to output a list of projects.','psp_projects').'</p>
						<table class="form-table">
							<tr>
								<th><label for="psp-project-taxonomy">'.__('Project Type','psp_projects').'</label></th>
								<td>
									<select id="psp-project-taxonomy" name="psp-project-taxonomy">
										<option value="all">Any</option>
										'.$psp_tax_list.'
									</select>
								</td>
							</tr>
							<tr>
								<th><label for="psp-project-status">'.__('Project Status','psp_projects').'</label></th>
								<td>
									<select id="psp-project-status" name="psp-project-status">
										<option value="all">'.__('All','psp_projects').'</option>
										<option value="active">'.__('Active','psp_projects').'</option>
										<option value="completed">'.__('Completed','psp_projects').'</option>
									</select>
								</td>
							</tr>
							<tr>
								<th><label for="psp-project-sort">'.__('Order By','psp_projects').'</label></th>
								<td>
									<select id="psp-project-sort" name="psp-project-sort">
										<option value="none">'.__('Creation Date','psp_projects').'</option>
										<option value="start">'.__('Start Date','psp_projects').'</option>
										<option value="end">'.__('End Date','psp_projects').'</option>
										<option value="title">'.__('Title','psp_projects').'</option>
									</select>
								</td>
							</tr>
							<tr>
							    <th><label for="psp-project-count">'.__('Projects to show','psp_projects').'</label></th>
                                <td>
                                    <select id="psp-project-count" name="psp-project-count">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="-1">All</option>
                                    </select>
                                </td>
							</tr>
						</table>';

    $output .= '<p><input class="button-primary" type="button" onclick="InsertPspProjectList();" value="'.__('Insert Project List','psp_projects').'"> <a class="button" onclick="tb_remove(); return false;" href="#">'.__('Cancel','psp_projects').'</a></p>';

    $output .= '</div></div>';

    echo $output;

}

function psp_buttons() {

	// Make sure the buttons are enabled

	if((get_option('psp_disable_js') === '0') || (get_option('psp_disable_js') == NULL)) {

		add_filter('mce_external_plugins','psp_add_buttons');
    	add_filter('mce_buttons','psp_register_buttons');
	}

}

function psp_add_buttons($plugin_array) {
    $plugin_array['pspbuttons'] = plugins_url(). '/'.PSP_PLUGIN_DIR.'/assets/js/psp-buttons.js';
    return $plugin_array;
}

function psp_register_buttons($buttons) {

    array_push($buttons,'currentprojects','singleproject');

    return $buttons;
}

function psp_refresh_mce($ver) {
    $ver += 3;
    return $ver;
}

add_filter( 'tiny_mce_version', 'psp_refresh_mce');
add_action('init','psp_buttons');


/**
 *
 * Function psp_dashboard_shortcode
 *
 * Outputs the Dashboard Widget in Shortcode Format
 *
 * @param (variable) ($atts) Attributes from the shortcode - currently none
 * @return ($output) (Content from psp_populate_dashboard_widget() )
 *
 */

function psp_dashboard_shortcode($atts) {

    $output = '<div class="psp-dashboard-widget">'.psp_populate_dashboard_widget().'</div>';
    return $output;

}

add_shortcode('panorama_dashboard','psp_dashboard_shortcode');

add_shortcode( 'before-milestone', 'psp_before_milestone_shortcode' );
function psp_before_milestone_shortcode( $atts, $content = NULL ) {

    return '<div class="psp-before-milestone">' . wpautop( $content ) . '</div>';

}

add_shortcode( 'after-milestone', 'psp_after_milestone_shortcode' );
function psp_after_milestone_shortcode( $atts, $content = NULL ) {

    return '<div class="psp-after-milestone">' . wpautop( $content ) . '</div>';
}

add_shortcode( 'before-phase', 'psp_before_phase' );
function psp_before_phase( $atts, $content = NULL ) {

	return '<div class="psp-before-phase">' . $content . '</div>';

}

add_shortcode( 'during-phase', 'psp_during_phase' );
function psp_during_phase( $atts, $content = NULL ) {

	return '<div class="psp-during-phase">' . $content . '</div>';

}

add_shortcode( 'after-phase', 'psp_after_phase' );
function psp_after_phase( $atts, $content = NULL ) {

	return '<div class="psp-after-phase">' . $content . '</div>';

}
