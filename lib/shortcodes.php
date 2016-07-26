<?php

/* Display Current Projects */


function psp_current_projects($atts) {

    extract( shortcode_atts(
            array(
                'type' => 'all',
                'status' => 'all',
                'access' => 'user'
            ), $atts )
    );

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
        'post_type' => 'psp_projects',
        'paged'	=> $paged,
        'posts_per_page' => '10'
    );

    // If a type has been selected, add it to the argument

    if((!empty($type)) && ($type != 'all')) {
        $tax_args = array('psp_tax' => $type);
        $args = array_merge($args,$tax_args);

    }

    // If you want completed only

    if($status == 'active') {

        $meta_args = array(
            'meta_query' => array(
                'relation'	=> 'OR',
                array(
                    'key' => '_psp_completed',
                    'value' => '1',
                    'compare' => '!='
                ),
                array(
                    'key' => '_psp_completed',
                    'value'	=> '0',
                    'compare' => 'NOT EXISTS'
                )

            )
        );

        $args = array_merge($args,$meta_args);

    }

    if($status == 'completed') {
        $meta_args = array(
            'meta_query' => array(
                array(
                    'key' => '_psp_completed',
                    'value' => '1',
                )
            )
        );
        $args = array_merge($args,$meta_args);
    }

    if($access == 'user') {
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
                )
            );
            $args = array_merge($args,$meta_args);

        }
    }

    $projects = new WP_Query($args);

    if($projects->have_posts()):
        ob_start(); ?>

        <table class="psp_project_list">
            <thead>
            <tr>
                <th class="psp_pl_col1"><?php _e('Project','psp_projects'); ?></th>
                <th class="psp_pl_col2"><?php _e('Progress','psp_projects'); ?></th>
            </tr>
            </thead>

            <?php while($projects->have_posts()): $projects->the_post(); global $post; ?>

                <tr>
                    <td><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></td>
                    <td>
                        <?php global $post; $completed = psp_compute_progress($post->ID);

                        if(!empty($completed)) {
                            echo '<p class="progress"><span class="psp-'.$completed.'"><b>'.$completed.'%</b></span></p>';
                        } ?>
                    </td>
                </tr>

            <?php endwhile; ?>

        </table>

        <?php get_next_posts_link('&laquo; More Projects',$projects->max_num_pages).' '.get_previous_posts_link('Previous Projects &raquo;'); ?>

        <?php psp_front_styles(1);

        return ob_get_clean();

    else:

        return '<p>'.__('No projects found','psp_projects').'</p>';

    endif;

}
add_shortcode('project_list','psp_current_projects');

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
							    <th colspan="2">
							        <input type="checkbox" name="psp-user-access" id="psp-user-access" checked>
							        <label for="psp-user-access">'.__('Only display projects current user has permission to access','psp_projects').'</label>
							    </th>
							</tr>
						</table>';

    $output .= '<p><input class="button-primary" type="button" onclick="InsertPspProjectList();" value="'.__('Insert Project List','psp_projects').'"> <a class="button" onclick="tb_remove(); return false;" href="#">'.__('Cancel','psp_projects').'</a></p>';

    $output .= '</div></div>';

    echo $output;

}

function psp_buttons() {
    add_filter('mce_external_plugins','psp_add_buttons');
    add_filter('mce_buttons','psp_register_buttons');
}

function psp_add_buttons($plugin_array) {
    $plugin_array['pspbuttons'] = plugins_url(). '/'.PSP_PLUGIN_DIR.'/assets/js/psp-buttons.js';
    return $plugin_array;
}

function psp_register_buttons($buttons) {

    array_push($buttons,'currentprojects','singleproject');

    return $buttons;
}

function my_refresh_mce($ver) {
    $ver += 3;
    return $ver;
}

add_filter( 'tiny_mce_version', 'my_refresh_mce');
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


/**
 *
 * Function psp_my_projects
 *
 * Outputs the Dashboard Widget in Shortcode Format
 *
 * @return ($output) (List of projects related to a particular user)
 *
 */

function psp_my_projects() {

    /* Ensure user is logged in */

    if(is_logged_in()):

        // Get the current user
        $curuser = wp_get_current_user();

        $projects = new WP_Query(array('type' => 'psp_project'));

    else:

    endif;

}

?>