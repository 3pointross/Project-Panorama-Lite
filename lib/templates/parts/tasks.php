<?php
  
/**
 * Builds a list of tasks and returns an array of list items and task count
 *
 *
 * @param integer $id post ID
 * @param string $taskStyle (optional) for shortcodes, the type of tasks to return
 * @return array including a collection of tasks in list format and a count of items
 **/


    /* Setup Variables */
    $taskList = array();
	$count = 0;
	$task_id = 0;
	global $post;
    
	/* Get Settings */
	$overall_auto = get_field('automatic_progress',$id); $phase_auto = get_field('phases_automatic_progress',$id);
	
	$output = '';

    // Loop through all the tasks.
    while(has_sub_field('tasks',$id)):

        $taskCompleted = get_sub_field('status');

        // Continue if you want to show incomplete tasks only and this task is complete
        if(($taskStyle == 'incomplete') && ($taskCompleted == '100')) { continue; }

        // Continue if you want to show completed tasks and this task is not complete
        if(($taskStyle == 'complete') && ($taskCompleted != '100')) { continue; }

        $count++;
		
        // If the user can edit, display a link
        if((psp_can_edit_task($post->ID, $phase_id, $task_id)) && (get_post_type() == 'psp_projects')) {
            $link = '<a href="#edit-task-'.$task_id.'" class="task-edit-link"><b class="fa fa-pencil"></b> '.__('update','psp_projects').'</a> <a href="#" class="complete-task-link" data-target="'.$task_id.'"><b class="fa fa-check"></b> '.__('complete','psp_projects').'</a>';
        } else {
            $link = null;
        }

        // If the task is completed, add a class
        if ($taskCompleted == '100') { $task_class = 'complete'; } else { $task_class = 'null'; }
		
		$assigned = get_sub_field('assigned');
		if((!empty($assigned)) && ($assigned != 'unassigned') && ($assigned != 'null')) {
			$user = get_userdata($assigned);			
			$assigned = '<b class="psp-assigned-to">'.psp_username_by_id($user->ID).'</b> ';
		} else { 
			$assigned = NULL;
		}

        $output .= '<li class="'.$task_class.' task-item task-item-'.$task_id.'" data-progress="'.get_sub_field('status',$id).'">';
        $output .= '<strong>'.get_sub_field('task').' '.$assigned.' '.$link.'</strong> <span><em class="status psp-'.get_sub_field('status',$id).'"></em></span>';
        if((psp_can_edit_task($post->ID, $phase_id, $task_id)) && (get_post_type() == 'psp_projects')) {
            $output .= '<div id="edit-task-'.$task_id.'" class="task-select">
                                <form method="post" action="'.get_permalink($id).'" class="task-update-form">
                                
								<input type="hidden" name="psp-phase-id" value="'.$phase_id.'">
                                <input type="hidden" name="psp-task-id" value="'.$task_id.'">
                                <input type="hidden" name="psp-project-id" value="'.$id.'">
								
								<input type="hidden" name="psp-phase-auto" value="'.$phase_auto[0].'">
								<input type="hidden" name="psp-overall-auto" value="'.$overall_auto[0].'">
								
                                <select id="edit-task-select-'.$task_id.'" rel="'.$task_id.'">
                                    <option value="'.get_sub_field('status',$id).'">'.get_sub_field('status',$id).'%</option>
                                    <option value="0">0%</option>
                                    <option value="10">10%</option>
                                    <option value="20">20%</option>
                                    <option value="30">30%</option>
                                    <option value="40">40%</option>
                                    <option value="50">50%</option>
                                    <option value="60">60%</option>
                                    <option value="70">70%</option>
                                    <option value="80">80%</option>
                                    <option value="90">90%</option>
                                    <option value="100">100%</option>
                                </select>
                                <input type="submit" name="save" value="save" class="task-save-button">
                                </form>
                            </div>';
        }
        $output .= '</li>';

        $task_id++;

    endwhile;

    array_push($taskList,$output);
    array_push($taskList,$count);
