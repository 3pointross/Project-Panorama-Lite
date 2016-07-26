<?php

function psp_project_part($atts) {

    extract( shortcode_atts(
            array(
                'id' 		=> 	'',
                'display' 	=> 	'',
                'style' 	=> 	'',
				'phases'	=>	''
            ), $atts )
    );

    $project = get_post($id);

    if($project):

        $output = '<div id="psp-projects" class="psp-part-project">';

        if($display == 'overview') {

            $output .= psp_essentials($id,'psp-shortcode','none');

        } elseif ($display == 'documents') {

            $output .= '<div id="psp-essentials" class="psp-shortcode"><div id="project-documents">';

            $output .= psp_documents($id,'psp-shortcode');

            $output .= '</div></div>';

        } elseif ($display == 'progress') {

            $output .= psp_total_progress($id,'psp-shortcode',$style);

        } elseif ($display == 'phases') {
        	
			$output .= '<div class="psp-shortcode">' . psp_phases($id,'psp-shortcode') . '</div>';
			
        }

        $output .= '</div>';

        psp_front_assets(1);

        return $output;

    else:

        return '<p>'.__('No project with that ID','psp_projects').'</p>';


    endif;

}

add_shortcode('project_status_part','psp_project_part');


function psp_single_project($atts) {
    extract( shortcode_atts(
            array(
                'id' => '',
                'overview' => '',
                'progress' => '',
                'milestones' => '',
				'phases'	=>	''
            ), $atts )
    );

    // If attributes are not set, let's use defaults.

    if($overview == '')
        $overview = 'yes';

    if($progress == '')
        $progress == 'yes';

    if($milestones == '')
        $milestones = 'condensed';
	
	if($phases == '')
		$phases == 'yes';


    $project = get_post($id);
    if($project):

        $psp_shortcode = '
		<div id="psp-projects" class="psp-single-project">

				<h1>'.$project->post_title.'</h1>';

        // Is the overview to be displayed?

        if($overview == 'yes') {

            $psp_shortcode .= psp_essentials($id,'psp-shortcode');

        }

        if($progress == 'yes') {

            // Display the progress bar

            $psp_shortcode .= psp_total_progress($id,'psp-shortcode',$milestones);

        }
		
		if($phases == 'yes') { 
		
			// Display phases
			
			$psp_shortcode .= psp_phases($id,'psp-shortcode');
			
		}

        $psp_shortcode .= '</div>';

        psp_front_assets(1);

        return $psp_shortcode;

    else:

        return '<p>'.__('No project with that ID','psp_projects').'</p>';


    endif;

}

add_shortcode('project_status','psp_single_project');

function psp_single_project_dialog() {

    $output = '

			<script>

				function psp_full_project() {

					jQuery("#psp-full-project-table").show();
					jQuery("#psp-part-project-table").hide();

				}

				function psp_part_project() {

					jQuery("#psp-full-project-table").hide();
					jQuery("#psp-part-project-table").show();


				}

				function psp_part_change() {

					target = jQuery("#psp-part-display").val();
					jQuery("tr.psp-part-option-row").hide();
					jQuery("#psp-part-" + target + "-option").show();

				}


				jQuery(document).ready(function() {

					jQuery("#psp-full-project").attr("checked",false);
					jQuery("#psp-part-project").attr("checked",false);

					psp_part_change();

				});

			</script>
		';

    $output .= '<div class="psp-dialog" style="display:none">';
    $output .= '<div id="psp-single-project-diaglog">';
    $output .= '<h3>'.__('Insert a Project Overview','psp_projects').'</h3>';
    $output .= '<p>'.__('Select a project below to add it to your post or page.','psp_projects').'</p>';
    $output .= '<table class="form-table">';
    $output .= '<tr><th>Project</th><td>';
    $output .= '<div class="psp-loading"></div>';
    $output .= '<div id="psp-single-project-list"></div>';
    $output .= '</td></tr>';
    $output .= '<tr><th><label for="psp-display-style">Style</label></th><td><label for="psp-display-style"><input unchecked type="radio" name="psp-display-style" onClick="psp_full_project();" id="psp-full-project" value="full"> '.__('Full Project','psp_projects').'</label>&nbsp;&nbsp;&nbsp;<label for="psp-display-style"><input type="radio" unchecked name="psp-display-style" onClick="psp_part_project()" id="psp-part-project" value="part"> '.__('Portion of Project','psp_projects').'</label></td></tr>';
    $output .= '</table>';

    $output .= '<table class="form-table psp-hide-table" id="psp-full-project-table">';

    $output .= '<tr>
						<th><label for="psp-single-overview">'.__('Overview','psp_projects').'</label></th>
						<td>
							<select id="psp-single-overview">
								<option value="yes">'.__('Show Overview','psp_projects').'</option>
								<option value="no">'.__('No Overview','psp_projects').'</option>
							</select>
						</td>
					</tr>';

    $output .= '<tr>
						<th><label for="psp-single-progress">'.__('Progress Bar','psp_projects').'</label></th>
						<td>
							<select id="psp-single-progress">
								<option value="yes">'.__('Show Progress Bar','psp_projects').'</option>
								<option value="no">'.__('No Progress Bar','psp_projects').'</option>
							</select>
						</td>
					</tr>';

    $output .= '<tr>
						<th><label for="psp-single-milestones">'.__('Milestones','psp_projects').'</label></th>
						<td>
							<select id="psp-single-milestones">
								<option value="condensed">'.__('Condensed','psp_projects').'</option>
								<option value="full">'.__('Full Width','psp_projects').'</option>
								<option value="no">'.__('No Milestones','psp_projects').'</option>
							</select>
						</td>
					</tr>
					<tr>
						<th><label for="psp-single-phases">'.__('Phases','psp_projects').'</label></th>
							<td>
								<select id="psp-single-phases">
									<option value="yes">'.__('Show Phases','psp_projects').'</option>
									<option value="no">'.__('No Phases','psp_projects').'</option>
								</select>
							</td>
					</tr>
				</table>';

    $output .= '<table class="form-table psp-hide-table" id="psp-part-project-table">
						<tr>
							<th><label for="psp-part-display">'.__('Display','psp_projects').'</label></th>
							<td>
								<select id="psp-part-display" onChange="psp_part_change();">
									<option value="overview">'.__('Overview','psp_projects').'</option>
									<option value="documents">'.__('Documents','psp_projects').'</option>
									<option value="progress">'.__('Overall Progress','psp_projects').'</option>
									<option value="phases">'.__('Phases','psp_projects').'</option>
								</select>
							</td>
						</tr>
						<tr id="psp-part-progress-option" class="psp-part-option-row">
							<th><label for="psp-part-overview-progress-select">'.__('Milestones','psp_projects').'</label></th>
							<td><select id="psp-part-overview-progress-select">
									<option value="full">'.__('Full Width','psp_projects').'</option>
									<option value="condensed">'.__('Condensed','psp_projects').'</option>
									<option value="no">'.__('None','psp_projects').'</option>
								</select>
							</td>
						</tr>
					</table>
			';


    $output .= '<p><input class="button-primary" type="button" onclick="InsertPspProject();" value="'.__('Insert Project','psp_projects').'"> <a class="button" onclick="tb_remove(); return false;" href="#">'.__('Cancel','psp_projects').'</a></p>';
    $output .= '</div></div>';

    echo $output;

}

add_action('admin_footer-post.php', 'psp_single_project_dialog'); // Fired on the page with the posts table
add_action('admin_footer-edit.php', 'psp_single_project_dialog'); // Fired on the page with the posts table
add_action('admin_footer-post-new.php', 'psp_single_project_dialog'); // Fired on the page with the posts table

add_action('admin_footer-post.php', 'psp_project_listing_dialog'); // Fired on the page with the posts table
add_action('admin_footer-edit.php', 'psp_project_listing_dialog'); // Fired on the page with the posts table
add_action('admin_footer-post-new.php', 'psp_project_listing_dialog'); // Fired on the page with the posts table

add_action('wp_ajax_psp_get_projects', 'psp_ajax_project_list');


function psp_ajax_project_list() {

    $output = '<p><select id="psp-single-project-id">';

    $projectQuery = new WP_Query(array('post_type'=>'psp_projects','posts_per_page' => '-1'));
    while($projectQuery->have_posts()): $projectQuery->the_post();
        global $post;
        $output .= '<option value="'.$post->ID.'">'.get_the_title().'</option>';
    endwhile;
    $output .= '</select></p>';

    echo $output;

}