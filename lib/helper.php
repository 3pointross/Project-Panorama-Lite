<?php

/**
 * helper_functions.php
 * A library of helper and utility functions for Project Panorama
 *
 * @author Ross Johnson
 * @copyright 3.7 MEDIA
 * @license GNU GPL version 3 (or later) {@see license.txt}
 * @package panorama
 **/

/**
 * Builds a list of tasks and returns an array of list items and task count
 *
 *
 * @param integer $id post ID
 * @param string $taskStyle (optional) for shortcodes, the type of tasks to return
 * @return array including a collection of tasks in list format and a count of items
 **/

    function psp_populate_tasks($id,$taskStyle) {

        $taskList = array();
        $count = 0;

        while(has_sub_field('tasks',$id)):
            $taskCompleted = get_sub_field('status');

            // Continue if you want to show incomplete tasks only and this task is complete
            if(($taskStyle == 'incomplete') && ($taskCompleted == '100')) { continue; }

            // Continue if you want to show completed tasks and this task is not complete
            if(($taskStyle == 'complete') && ($taskCompleted != '100')) { continue; }

            $count++;

            $output .= '<li class="';
            if ($taskCompleted == '100') { $output .= 'complete'; }
            $output .= '"><strong>'.get_sub_field('task').'</strong> <span><em class="status psp-'.get_sub_field('status',$id).'"></em></span></li>';
        endwhile;

        array_push($taskList,$output);
        array_push($taskList,$count);

        return $taskList;


    }

    /**
     * Computes the total project progress
     *
     *
     * @param integer $id post ID
     * @return a string containing a number from 1 - 100 (percentage of completion)
     **/

    function psp_compute_progress($id) {

        if(get_field('automatic_progress',$id)) {
            $completed = 0;
            $phases = 0;
            $phase_completion = 0;
            $phase_total = 0;

            while(has_sub_field('phases',$id)) {

                if(get_sub_field('weighting')) {
                    $phases++;
                    $phase_total += 100 * get_sub_field('weight');
                } else {
                    $phases++;
                    $phase_total += 100;
                }

                if(get_sub_field('auto_progress')) {

                    $tasks = 0;
                    $task_completion = 0;

                    while(has_sub_field('tasks')) {
                        $tasks++;
                        $task_completion += get_sub_field('status');
                    }

                    if($tasks > 1) {

                        if(get_sub_field('weighting')) {

                            $phase_completion += ceil($task_completion / $tasks * get_sub_field('weight'));

                        } else {

                            $phase_completion += ceil($task_completion / $tasks);

                        }

                    } else {
                        $phase_completion += $task_completion;
                    }

                } else {
                    $phase_completion += get_sub_field('percent_complete');
                }
            }

            if($phase_total != 0) {
                return ceil($phase_completion / $phase_total * 100);
            } else {
                return '0';
            }

        } else {

            return get_field('percent_complete',$id);

        }

    }


/**
 * Checks to see if the user has access to the project, returns 1 if access is granted, 0 if false
 *
 *
 * @param integer $post_id post ID
 * @return int 1 or 0
 **/

    function panorama_check_access($post_id) {

        $access_level = get_field('restrict_access_to_specific_users',$post_id);

        if(current_user_can('manage_options')):
            return 1;
        elseif(post_password_required()):
            return 0;
        elseif(!$access_level):
            return 1;
        elseif(($access_level) && (!is_user_logged_in())):
            return 0;
        elseif(($access_level) && (is_user_logged_in())):
            $allowed_users = Array();
            $current_user = wp_get_current_user();

            while (has_sub_field('allowed_users')):

                $allowed_user = get_sub_field('user');
                array_push($allowed_users,$allowed_user['ID']);

            endwhile;

            foreach($allowed_users as $user):

                if($user == $current_user->ID) { return 1; }

            endforeach;
        else:
            return 1;
        endif;

    }


    // custom filter to replace '=' with 'LIKE'
    function psp_posts_where( $where )
    {
        $where = str_replace("meta_key = 'allowed_users_%_user'", "meta_key LIKE 'allowed_users_%_user'", $where);

        return $where;
    }

    add_filter('posts_where', 'psp_posts_where');


    /*
     * Limits what projects are available to the ones the user has access to
     *
     */

    add_filter('pre_get_posts', 'limit_psp_to_granted_users');
    function limit_psp_to_granted_users($query) {

        global $pagenow;

        // Check to see if were in the admin panel and project edit page

        if(($query->is_admin) && ($pagenow == 'edit.php') && ($_GET['post_type'] == 'psp_projects')) {

            // If the users is an admin, they can see everything
            if((!current_user_can('publish_pages')) && (psp_get_current_user_role() != 'Project Manager')) {

                // Users can see open projects and projects they have access to
                $query->set('meta_query',
                    array(
                        'relation' => 'OR',
                        array(
                            'key' => 'allowed_users_%_user',
                            'value' => $user_ID
                        ),
                        array(
                            'key' => 'restrict_access_to_specific_users',
                            'value' => ''
                        )
                    )
                );
            }

        }

    }

    /*
     * Adds two roles for users
     *
     */

    add_action( 'admin_init', 'psp_add_project_roles' );
    function psp_add_project_roles() {

        add_role('psp_project_owner',
            'Project Owner',
            array(
                'read' => true,
                'edit_posts' => false,
                'delete_posts' => false,
                'publish_posts' => false,
                'upload_files' => true,
/*                'edit_psp_project' => true,
                'edit_psp_projects' => true,
                'edit_psp_other_projects' => true,
                'read_psp_project' => true,
                'read_private_psp_project' => true, */
            )
        );

        add_role('psp_project_manager',
            'Project Manager',
            array(
                'read' => true,
                'edit_posts' => false,
                'delete_posts' => false,
                'publish_posts' => false,
                'upload_files' => true,
                /*                'edit_psp_project' => true,
                                'edit_psp_projects' => true,
                                'edit_psp_other_projects' => true,
                                'read_psp_project' => true,
                                'read_private_psp_project' => true, */
            )
        );

    }

    /*
    * Assigns capabilities to the project roles
    */


    function psp_make_role_project_owner($role) {

        $role->add_cap('edit_psp_project');
        $role->add_cap('edit_psp_projects');
        $role->add_cap('edit_published_psp_projects');
        $role->add_cap('read_psp_project');
        $role->add_cap('read_private_psp_project');

    }

    function psp_make_role_project_manager($role) {

        $role->add_cap( 'read' );
        $role->add_cap( 'read_psp_project');
        $role->add_cap( 'read_private_psp_projects' );

        $role->add_cap( 'edit_psp_project' );
        $role->add_cap( 'edit_psp_projects' );
        $role->add_cap( 'edit_others_psp_projects' );
        $role->add_cap( 'edit_published_psp_projects' );

        $role->add_cap( 'publish_psp_projects' );

        $role->add_cap( 'delete_others_psp_projects' );
        $role->add_cap( 'delete_private_psp_projects' );
        $role->add_cap( 'delete_published_psp_projects' );

    }

    add_action('admin_init','psp_add_role_caps',999);
    function psp_add_role_caps() {

        $owners = get_role('psp_project_owner');
        psp_make_role_project_owner($owners);

        $manager = get_role('psp_project_manager');
        psp_make_role_project_manager($manager);

        $admin = get_role('administrator');
        psp_make_role_project_manager($admin);

        $editor = get_role('editor');
        psp_make_role_project_manager($editor);

    }

    /*
        Remove the add button for project owners
    */

    add_action('admin_menu','psp_remove_add_project');
    function psp_remove_add_project() {

            global $submenu;
            if(psp_get_current_user_role() == 'Project Owner') {
                $submenu['edit.php?post_type=psp_projects'][10] = '';

               //  unset($submenu["edit.php?post_type=psp_projects"][10]);
            }
    }

    /**
     * Returns the translated role of the current user. If that user has
     * no role for the current blog, it returns false.
     *
     * @return string The name of the current role
     **/
    function psp_get_current_user_role() {
        global $wp_roles;
        $current_user = wp_get_current_user();
        $roles = $current_user->roles;
        $role = array_shift($roles);
        return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
    }

?>