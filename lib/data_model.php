<?php

	// ==============
	// = Data Model =
	// ==============

	/* The custom post types and taxonomies */
	
	// Register Custom Post Type
	function psp_projects() {
		
		$psp_slug = get_option('psp_slug','panorama');

		$labels = array(
			'name'                => _x( 'Projects', 'Post Type General Name', 'psp_projects' ),
			'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'psp_projects' ),
			'menu_name'           => __( 'Projects', 'psp_projects' ),
			'parent_item_colon'   => __( 'Parent Project:', 'psp_projects' ),
			'all_items'           => __( 'All Projects', 'psp_projects' ),
			'view_item'           => __( 'View Project', 'psp_projects' ),
			'add_new_item'        => __( 'Add New Project', 'psp_projects' ),
			'add_new'             => __( 'New Project', 'psp_projects' ),
			'edit_item'           => __( 'Edit Project', 'psp_projects' ),
			'update_item'         => __( 'Update Project', 'psp_projects' ),
			'search_items'        => __( 'Search Projects', 'psp_projects' ),
			'not_found'           => __( 'No projects found', 'psp_projects' ),
			'not_found_in_trash'  => __( 'No projects found in Trash', 'psp_projects' ),
		);
		$rewrite = array(
			'slug'                => $psp_slug,
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);
		$args = array(
			'label'               => __( 'psp_projects', 'psp_projects' ),
			'description'         => __( 'Projects', 'psp_projects' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'comments', 'revisions', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 20,
			'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
            'capability_type'     => array('psp_project','psp_projects'),
//            'capability_type'     => array('psp_project','psp_projects'),
            'map_meta_cap'        => true,
		);
		register_post_type( 'psp_projects', $args );
	}

	// Hook into the 'init' action
	add_action( 'init', 'psp_projects');
	
	// Modify custom post type display

	function psp_project_header($defaults) {

		$new = array();

		foreach($defaults as $key => $title) { 
			
			if($key=='title') { 
				$new[$key] = $title;
				$new['client'] = 'Client';
				$new['shortcode'] = 'Project ID';
				$new['progress'] = '% Complete';
			} else { $new[$key] = $title; }
		}
		
		return $new; 
	}
	
	function psp_project_header_content($column_name, $post_ID) { 
		if($column_name == 'client') { 
			echo get_field('client');
		} elseif ($column_name == 'progress') { 
			$completed = psp_compute_progress($post_DID); 
			if($completed > 10) { 
				echo '<p class="progress"><span class="psp-'.$completed.'"><strong>%'.$completed.'</strong></span></p>';
			} else { 
				echo '<p class="progress"><span class="psp-'.$completed.'"></span></p>';
			}
		} elseif ($column_name == 'shortcode') { 
			echo $post_ID;
		}
	}
	
	add_filter('manage_psp_projects_posts_columns', 'psp_project_header');  
  	add_action('manage_psp_projects_posts_custom_column', 'psp_project_header_content', 10, 2); 
	
	// Custom Project Taxonomies
	
	function psp_project_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Project Types', 'Taxonomy General Name', 'psp_projects' ),
			'singular_name'              => _x( 'Project Type', 'Taxonomy Singular Name', 'psp_projects' ),
			'menu_name'                  => __( 'Project Types', 'psp_projects' ),
			'all_items'                  => __( 'All Project Types', 'psp_projects' ),
			'parent_item'                => __( 'Parent Project Type', 'psp_projects' ),
			'parent_item_colon'          => __( 'Parent Project Type:', 'psp_projects' ),
			'new_item_name'              => __( 'New Project Type', 'psp_projects' ),
			'add_new_item'               => __( 'Add Project Type', 'psp_projects' ),
			'edit_item'                  => __( 'Edit Project Type', 'psp_projects' ),
			'update_item'                => __( 'Update Project Type', 'psp_projects' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'psp_projects' ),
			'search_items'               => __( 'Search Project Types', 'psp_projects' ),
			'add_or_remove_items'        => __( 'Add or remove project types', 'psp_projects' ),
			'choose_from_most_used'      => __( 'Choose from the most used items', 'psp_projects' ),
			'not_found'                  => __( 'Not Found', 'psp_projects' ),
		);
		$rewrite = array(
			'slug'                       => 'panorama-projects',
			'with_front'                 => true,
			'hierarchical'               => true,
		);

        /*
        $caps = array(
          'edit_post'                   => 'edit_psp_project',
          'edit_posts'                  => 'edit_psp_projects',
          'edit_others_posts'           => 'edit_other_psp_projects',
          'publish_posts'               => 'publish_psp_projects',
          'read_post'                   => 'read_psp_project',
          'read_private_posts'          => 'read_psp_private_projects',
          'delete_post'                 => 'delete_psp_project'
        );
        */

		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'                    => $rewrite
        );
		register_taxonomy( 'psp_tax', array( 'psp_projects' ), $args );

	}

	// Hook into the 'init' action
	add_action( 'init', 'psp_project_taxonomy', 0 );
	
	add_action('save_post','psp_mark_as_complete',10,2);
	
	function psp_mark_as_complete($post_id,$post) {
								
		$project_completion = psp_compute_progress($post->ID);
		$current_status = get_post_meta($post->ID,'_psp_completed',true);
		
		if($current_status == '') { update_post_meta($post->ID,'_psp_completed','0'); }
		
		if($project_completion == '100') {
			update_post_meta($post->ID,'_psp_completed','1');
		} else { 
			update_post_meta($post->ID,'_psp_completed','0');
		}
		
	}
		

?>