<?php



	function psp_essentials($id,$style = null,$docs = null) { 
		
		
		$psp_essentials = '<div id="psp-essentials" class="'.$style.'">
				<div id="psp-description" class="cf">
				
					<div class="summary">
						<h4>'.__('Project Description','psp_projects').'</h4>
				
						'.get_field('project_description',$id).'
					</div>
				
					<div class="project-timing">';
						
						$startDate = get_field('start_date',$id); $endDate = get_field('end_date',$id); 
						
						if (($startDate) || ($endDate)): 
						
						$psp_essentials .= '<h4>'.__('Project Timing','psp_projects').'</h4>';

							$s_year = substr($startDate,0,4);
							$s_month = substr($startDate,4,2);
							$s_day = substr($startDate,6,2);

							$e_year = substr($endDate,0,4);
							$e_month = substr($endDate,4,2);
							$e_day = substr($endDate,6,2);
							
							$months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

						$psp_essentials .= '<ul class="timing">';
							if($startDate): 
								$psp_essentials .= '
							<li><strong>'.__('Start Date','psp_projects').'</strong> 
								<span class="cal">
									<span class="month">'.$months[$s_month - 1].'</span>
									<span class="day">'.$s_day.'</span>
								</span>
							</li>';
							endif;
							if($endDate):
							$psp_essentials .= '
								<li><strong>'.__('End Date','psp_projects').'</strong>
								<span class="cal">
									<span class="month">'.$months[$e_month - 1].'</span>
									<span class="day">'.$e_day.'</span>
								</span>
							</li>';
							endif;
						$psp_essentials .= '</ul>';

				
				endif;
				$psp_essentials .= '</div></div>';
				
				if($docs != 'none'):
			
					$psp_essentials .= '<div id="project-documents" class="'.$style.'">
					
						<h4>'.__('Documents','psp_projects').'</h4>';

                        if(PSP_PLUGIN_TYPE == 'professional') {

    						if(get_field('documents',$id)) {
	    					    $psp_essentials .= psp_documents($id);
                            } else {
		    					$psp_essentials .= '<p>'.__("No documents at this time.").'</p>';
                            }

                        } else {

                            $documents_text = get_field('documents2');
                            if(!empty($documents_text)) {
                                $psp_essentials .= $documents_text;
                            } else {
                                $psp_essentials .= '<p>'.__("No documents at this time.").'</p>';
                            }

                        }

					$psp_essentials .= '</div>';
				
				endif;
				
			$psp_essentials .= '</div> <!--/#psp-essentials--> ';
	
		return $psp_essentials;
		
	}



	function psp_total_progress($id,$style = null,$options = null) { 
		
		$psp_progress = '
		<div class="'.$style.'">
		
			<h2>'.__("Overall Project Completion","psp_projects").'</h2>
			
			<div class="psp-holder"></div>';
						
			$completed = psp_compute_progress($id); 
				  
				if((get_field('display_milestones',$id)) && ($options != 'no')):
					$frequency = get_field('milestone_frequency',$id);
					
					if(get_field('milestone_frequency',$id) == 'quarters') { $first = '25'; $second = '50'; $third = '75'; $fourth = '100'; } else { $first = '20'; $second = '40'; $third = '60'; $fourth = '80'; }
			
			?> 
				<?php if($options != 'condensed'): 
				$psp_progress .= '
				<ul class="top-milestones cf psp-milestones frequency-'.$frequency.'">
					<li class="psp-'.$first.'-milestone'; if($completed >= $first) { $psp_progress .= ' completed'; } $psp_progress .= '">
						<div>
							<h4>'.get_field('25%_title',$id).'</h4>
							<p>'.get_field('25%_description',$id).'</p>
							<span>'.$first.'%</span>
						</div>
					</li>
					<li class="psp-'.$third.'-milestone'; if($completed >= $third) { $psp_progress .= ' completed'; } $psp_progress .= '">
						<div>
							<h4>'.get_field('75%_title',$id).'</h4>
							<p>'.get_field('75%_description',$id).'</p>
							<span>'.$third.'%</span>
						</div>
					</li>
				</ul>';
				 	endif;
			endif;
			
			$startDate = get_field('start_date',$id); $endDate = get_field('end_date',$id);
			
			$psp_progress .= '<p class="progress"><span class="psp-'.$completed.'"><b>'.$completed.'%</b></span></p>';
			
			
			if((get_field('display_milestones',$id)) && ($options != 'no')): 
				if($options != 'condensed'): 
				$psp_progress .= '<ul class="bottom-milestones cf psp-milestones frequency-'.$frequency.'">
					<li class="psp-'.$second.'-milestone'; if($completed >= $second) { $psp_progress .= ' completed'; } $psp_progress .='">
						<div>
							<span>'.$second.'%</span>
							<h4>'.get_field('50%_title',$id).'</h4>
							<p>'.get_field('50%_description',$id).'</p>
						</div>
					</li>';
					
					if($frequency == 'fifths'):
					
					$psp_progress .= '<li class="psp-'.$fourth.'-milestone'; if($completed >= $fourth) { $psp_progress .= ' completed'; } $psp_progress .= '">
						<div>
							<span>'.$fourth.'%</span>
							<h4>'.get_field('100%_title',$id).'</h4>
							<p>'.get_field('100%_description',$id).'</p>
						</div>
					</li>';
					
					endif;
					
				$psp_progress .= '</ul>';
				
				endif; 
			
			endif; 
			
			if((get_field('display_milestones',$id))  && ($options != 'no')):
			$psp_progress .= '<div class="progress-table '.$style.' milestone-options-'.$options.'">
				<table class="progress-table">
					<tr>
						<th class="psp-milestones '; if($completed >= $first) { $psp_progress .= 'completed'; } $psp_progress .= '"><span>'.$first.'%</span></th>
						<td>
							<h4>'.get_field('25%_title',$id).'</h4>
							<p>'.get_field('25%_description',$id).'</p>
						</td>
					</tr>
					<tr>
						<th class="psp-milestones '; if($completed >= $second) { $psp_progress .= 'completed'; } $psp_progress .= '"><span>'.$second.'%</span></th>
						<td>
							<h4>'.get_field('50%_title',$id).'</h4>
							<p>'.get_field('50%_description',$id).'</p>
						</td>
					</tr>
					<tr>
						<th class="psp-milestones '; if($completed >= $third) { $psp_progress .= 'completed'; } $psp_progress .= '"><span>'.$third.'%</span></th>
						<td>
							<h4>'.get_field('75%_title',$id).'</h4>
							<p>'.get_field('75%_description',$id).'</p>
						</td>
					</tr>';
				 	if($frequency == 'fifths'):
					$psp_progress .= '<tr>
						<th class="psp-milestones '; if($completed >= $fourth) { $psp_progress .= 'completed'; } $psp_progress .= '"><span>'.$fourth.'%</span></th>
						<td>
							<h4>'.get_field('100%_title',$id).'</h4>
							<p>'.get_field('100%_description',$id).'</p>
						</td>
					</tr>';
					endif;
					
				$psp_progress .=' </table>
			</div>'; 
			endif;
					
		$psp_progress .= '</div>';
			
		return $psp_progress;
		
	}

	function psp_phases($id, $style = null, $taskStyle = null) { 
		
		if($style == 'psp-shortcode') { 
			$psp_phases = '<div class="psp-shortcode-phases">';
		 } else { 
			$psp_phases = '<div class="psp-row">';
		 }
			
		 $i = 0; $c = 0; while(has_sub_field('phases',$id)): $i++; $c++; 
		
		 if(($i %2 == 1) && ($style != 'psp-shortcode')) { $psp_phases .= '</div><div class="psp-row">'; } 
		 
					if($c == 1) { 
						$color = 'blue';
						$chex = '#3299BB';
					} elseif ($c == 2) { 
						$color = 'teal';
						$chex = '#4ECDC4';
					} elseif ($c == 3) { 
						$color = 'green';
						$chex = '#CBE86B';
					} elseif ($c == 4) { 
						$color = 'pink';
						$chex = '#FF6B6B';
					} elseif ($c == 5) { 
						$color = 'maroon';
						$chex = '#C44D58';
						$c = 0;
					}
									
			
		$psp_phases .= '<div class="psp-phase color-'.$color.'">';
				
					
		$completed = 0;
		$tasks = 0;
		$task_completion = 0; 
		$completed_tasks = 0;
				
				if(get_sub_field('auto_progress')) { 
					
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
				
				$remaining = 100 - $completed;
			
		$psp_phases .= '<h3><span class="psp-top-complete">'.$completed.'% <b>'.__('Complete','psp_projects').'</b></span> '.get_sub_field('title').'</h3>

					<div class="psp-phase-overview cf">

						<div class="psp-chart">
							<div id="chart-'.$i.'"></div>
							<ul data-pie-id="chart-'.$i.'" class="psp-chart-legend">';
							if($completed != 0) { 
							  	$psp_phases .= '<li data-value="'.$completed.'"><span></span> '.$completed.'% '.__('Completed','psp_projects').'</li>';
						    } else { 
								$psp_phases .= '<li data-value="'.$completed.'" class="completed-datapoint"><span></span> '.$completed.'% '.__('Completed','psp_projects').'</li>'; 
							}
							if(($remaining != 100) && ($remaining != 0)) { 
								$psp_phases .= '<li data-value="'.$remaining.'"><span></span>'.$remaining.'% '.__('Remaining','psp_projects').'</li>';
						    }
		$psp_phases .=	'</ul>
						</div>
						<div class="psp-phase-info">

                            <h5>'.__('Description','psp_projects').'</h5>
							
							'.get_sub_field('description').'
							
							
						</div>
					</div> <!-- tasks is '.$taskStyle.'-->


				<div class="psp-task-list-wrapper">
				';
				
				
				if((get_sub_field('tasks',$id)) && ($taskStyle != 'no')):


                    $taskList = psp_populate_tasks($id,$taskStyle);

                    if(get_sub_field('tasks',$id)) {

                        if($taskStyle == 'complete') {

                          $taskbar = '<span>'.$taskList[1].' '.__('completed tasks').'</span>';

                        } elseif ($taskStyle == 'incomplete') {

                          $taskbar = '<span>'.$taskList[1].' '.__('open tasks').'</span>';

                        } else {

                            $remaing_tasks = $tasks - $completed_tasks;
                            $taskbar = '<span>'.$completed_tasks.' '.__('of','psp_projects').' '.$tasks.' '.__('completed','psp_projects').'</span>';
                        }

                    } else {

                        $taskbar = 'None assigned';

                    }



					$psp_phases .= '<h4><a href="#" class="task-list-toggle">'.$taskbar.__('Tasks','psp_projects').'</a></h4>
								    <ul class="psp-task-list">'.$taskList[0].'</ul>';
				endif;
			$psp_phases .= '</div>
			            </div> <!--/.psp-task-list-->
			';
		endwhile; 
		$psp_phases .= '</div>';
	
	return $psp_phases;
		
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
	 
		 $output = '<table class="psp-task-table">
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
	 
	 function psp_documents($post_id) { 
	 
		$psp_docs = '<ul id="psp-documents">';
		
		while(has_sub_field('documents',$post_id)): 
			$file = get_sub_field('file');
			
			$psp_docs .= '<li>
				<p class="psp-doc-title">
					<a href="'.$file['url'].'"><strong>'.get_sub_field('title').'</strong></a>
					<span class="doc-status status-'.get_sub_field('status').'">'.get_sub_field('status').'</span>
					<span class="description">'.get_sub_field('description').'</span>
			</li>';
		endwhile;
		
		$psp_docs .= '</ul>';
			
		return $psp_docs;
	 
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

	 	wp_add_dashboard_widget(
	                  'psp_dashboard_overview',         // Widget slug.
	                  'Projects',         // Title.
	                  'psp_dashboard_overview_widget_function' // Display function.
	         );	
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
        $recent = new WP_Query(array('post_type' => 'psp_projects','posts_per_page' => '5', 'orderby' => 'modified','order' => 'DESC'));

        // Calculate the number of completed projects

        $completed_projects = 0;
        $active = 0;

        foreach($projects as $project):
            if(get_post_meta($project->ID,'_psp_completed',true) == '1')
                $completed_projects++;
            else
                $active++;
        endforeach;

        $output = '

			 <ul class="psp-projects-overview">
			 		<li><span class="psp-dw-projects">'.$total_projects.'</span> <strong>'.__('Projects','psp_projects').'</strong> </li>
		 		    <li><span class="psp-dw-completed">'.$completed_projects.'</span> <strong>'.__('Completed','psp_projects').'</strong></li>
		 		    <li><span class="psp-dw-active">'.$active.'</span> <strong>'.__('active','psp_projects').'</strong></li>
		 			<li><span class="psp-dw-types">'.$taxonomies. '</span> <strong>'.__('Types','psp_projects').'</strong></li>
			  </ul>

			  <hr>

			 <h4>'.__('Recently Updated','psp_projects').'</h4>
			 <table class="psp-dashboard-widget-table">
			 	<tr>
					<th>'.__('Project','psp_projects').'</th>
					<th>'.__('Progress','psp_projects').'</th>
					<th>'.__('Updated','psp_projects').'</th>
					<th>&nbsp;</th>
				</tr>
			  ';

        while($recent->have_posts()): $recent->the_post();
            global $post;
            $output .= '<tr>
			 		       <td><a href="'.get_edit_post_link().'">'.get_the_title().'</td><td>';

            $completed = psp_compute_progress($post->ID);

            if($completed > 10) {
                $output .= '<p class="progress"><span class="psp-'.$completed.'"><strong>%'.$completed.'</strong></span></p>';
            } else {
                $output .= '<p class="progress"><span class="psp-'.$completed.'"></span></p>';
            }
            $output .= '</td><td class="psp-dwt-date">'.get_the_modified_date("m/d/Y").'</td><td class="psp-dwt-date"><a href="'.get_permalink().'" target="_new" class="psp-dw-view">'.__('View','psp_projects').'</a></td>
				</tr>';
        endwhile;

        $output .= '</table>';

        return $output;

    }

?>