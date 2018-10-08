<?php

add_action( 'cmb2_admin_init', 'psp_projects_register_phases_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function psp_projects_register_phases_metabox() {


	// Start with an underscore to hide fields from custom fields list
	$prefix = '_pano_';

	/**
	 * Repeatable Users Group
	 */
	 $psp_cmb2_users = new_cmb2_box( array(
		 'id'			=>	$prefix . 'users_meta',
		 'title'		=>	__( 'User Access', 'psp_projects' ),
		 'object_types'	=>	array( 'psp_projects' ),
		 'context'		=>	'side',
	 ) );

	 $psp_cmb2_users->add_field( array(
		'name' => __( 'Private Project', 'psp_projects' ),
		'desc' => __( 'Restrict access to specific users', 'psp_projects' ),
		'id'   => 'restrict_access_to_specific_users',
		'type' => 'checkbox',
	) );

	 $psp_cmb2_users->add_field( array(
		 'name'	=>	__( 'Assigned Users', 'psp_projects' ),
		 'description'	=>	__( 'Search for users to add to this project', 'psp_projects' ),
		 'id'	=>	$prefix . 'users',
		 'type' => 'user_search_text',
		 'attributes' => array(
 			'required'            => false, // Will be required only if visible.
 			'data-conditional-id' => 'restrict_access_to_specific_users',
 		),
	 ) );

	/**
	 * Repeatable Phase Group
	 */

	$psp_cmb2_docs = new_cmb2_box( array(
		'id'           => $prefix . '_doc_metabox',
		'title'        => __( 'Documents', 'psp_projects' ),
		'object_types' => array( 'psp_projects', ),
	) );

	$group_field_id = $psp_cmb2_docs->add_field( array(
		'id'          => $prefix . 'documents',
		'type'        => 'group',
		'description' => __( 'Add documents to the project for download', 'psp_projects' ),
		'options'     => array(
			'group_title'   => __( 'Documents {#}', 'psp_projects' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Document', 'psp_projects' ),
			'remove_button' => __( 'Remove Document', 'psp_projects' ),
			'sortable'      => true, // beta,
			'priority'		=> 'low'
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$psp_cmb2_docs->add_group_field( $group_field_id, array(
		'name'       => __( 'Title', 'psp_projects' ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$psp_cmb2_docs->add_group_field( $group_field_id, array(
		'name'        => __( 'Description', 'psp_projects' ),
		'id'          => 'description',
		'type'        => 'textarea',
	) );

	$psp_cmb2_docs->add_group_field( $group_field_id, array(
		'name'        => __( 'File', 'psp_projects' ),
		'id'          => 'file',
		'type'        => 'file',
	) );

	$psp_cmb2_docs->add_group_field( $group_field_id, array(
		'name'        => __( 'Link', 'psp_projects' ),
		'description'	=> __('If a link is provided it will take priority over any file attached','psp_projects'),
		'id'          => 'link',
		'type'        => 'text',
	) );

	$psp_cmb2_docs->add_group_field( $group_field_id, array(
		'name'        => __( 'Status', 'psp_projects' ),
		'id'          => 'status',
		'type'        => 'select',
		'show_option_none' => false,
	    'default'          => 'In Review',
	    'options'          => array(
	        'In Review' => __( 'In Review', 'psp_projects' ),
	        'Revisions'   => __( 'Revisions', 'psp_projects' ),
	        'Approved'     => __( 'Approved', 'psp_projects' ),
	        'Rejected'     => __( 'Rejected', 'psp_projects' ),
	    ),
	) );


	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Phases', 'psp_projects' ),
		'object_types' => array( 'psp_projects', ),
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'phases',
		'type'        => 'group',
		'description' => __( 'Projects can be broken up into individual phases', 'psp_projects' ),
		'options'     => array(
			'group_title'   => __( 'Phases {#}', 'psp_projects' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Phase', 'psp_projects' ),
			'remove_button' => __( 'Remove Phase', 'psp_projects' ),
			'sortable'      => true, // beta,
			'priority'		=> 'low'
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => __( 'Title', 'psp_projects' ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
	    'name'             => __('Percentage Complete','psp_projects'),
	    'id'               => __('percentage_complete','psp_projects'),
	    'type'             => 'select',
	    'show_option_none' => false,
		'default'		 	=> '0',
		'classes'			=> 'phase-percentage-complete',
	    'default'          => 'custom',
	    'options'          => array(
	        '0' 	=> __( '0%', 'psp_projects' ),
	        '5' 	=> __( '5%', 'psp_projects' ),
	        '10'    => __( '10%', 'psp_projects' ),
	        '15' 	=> __( '15%', 'psp_projects' ),
	        '20' 	=> __( '20%', 'psp_projects' ),
	        '25'    => __( '25%', 'psp_projects' ),
	        '30' 	=> __( '30%', 'psp_projects' ),
	        '35' 	=> __( '35%', 'psp_projects' ),
	        '40'    => __( '40%', 'psp_projects' ),
	        '45' 	=> __( '45%', 'psp_projects' ),
	        '50' 	=> __( '50%', 'psp_projects' ),
	        '55'    => __( '55%', 'psp_projects' ),
	        '60' 	=> __( '60%', 'psp_projects' ),
	        '65' 	=> __( '65%', 'psp_projects' ),
	        '70'    => __( '70%', 'psp_projects' ),
	        '75' 	=> __( '75%', 'psp_projects' ),
	        '80' 	=> __( '80%', 'psp_projects' ),
	        '85'    => __( '85%', 'psp_projects' ),
	        '90' 	=> __( '90%', 'psp_projects' ),
	        '95' 	=> __( '95%', 'psp_projects' ),
	        '100'    => __( '100%', 'psp_projects' ),
	    ),
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => __( 'Description', 'psp_projects' ),
		'description' => __( 'Write a description for this phase', 'psp_projects' ),
		'id'          => 'description',
		'type'        => 'wysiwyg',
	) );

	if( PSP_LITE_USE_TASKS ) {

		$cmb_group->add_group_field( $group_field_id, array(
			'name'        => __( 'Tasks', 'psp_projects' ),
			'description' => __( 'Add individual tasks for this phase', 'psp_projects' ),
			'id'          => 'tasks',
			'type'        => 'tasks',
			'repeatable'	=> true,
			'options'     => array(
				'add_row_text'	=>  __( 'Add Task', 'psp_projects' )
			),
		) );

	}

}


if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_overview',
		'title' => 'Overview',
		'fields' => array (
			array (
				'key' => 'field_527d5d1cfb84f',
				'label' => 'Client',
				'name' => 'client',
				'type' => 'text',
				'instructions' => __('Name of the client or project','psp_projects'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_52c46fa974b08',
				'label' => __('Automatic Progress','psp_projects'),
				'name' => 'automatic_progress',
				'type' => 'checkbox',
				'instructions' => __('Automatically calculate progress based on completion of phases (below)','psp_projects'),
				'choices' => array (
					'Yes' => __('Yes','psp_projects'),
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
            'key' => 'field_5436e7f4e06b4',
            'label' => __('Automatic Phase Progress','psp_projects'),
            'name' => 'phases_automatic_progress',
            'type' => 'checkbox',
            'instructions' => __('Automatically calculate phase completion based on tasks','psp_projects'),
            'choices' => array (
                'Yes' => 'Yes',
            ),
			'conditional_logic'	=>	array (
				'status' =>	1,
				'rules' => array (
					array(
						'field'	=> 'field_52c46fa974b08',
						'operator' => '==',
						'value' => 'Yes'
					),
				),
				'allorany' => 'all',
			),
            'default_value' => '',
            'layout' => 'vertical',
        	),
			array (
				'key' => 'field_527d5d61fb854',
				'label' => __('Percent Complete','psp_projects'),
				'name' => 'percent_complete',
				'type' => 'num_slider',
				'minimum_number' => 1,
				'max_number' => 100,
				'inc_number' => 1,
				'start_number' => '',
				'conditional_logic'	=>	array (
					'status' =>	1,
					'rules' => array (
						array(
							'field'	=> 'field_52c46fa974b08',
							'operator' => '!=',
							'value' => 'Yes'
						),
					),
					'allorany' => 'all',
				),
	            'default_value' => '',
	            'layout' => 'vertical',
			),
			array (
				'key' => 'field_527d5d3cfb851',
				'label' => __('Project Description','psp_projects'),
				'name' => 'project_description',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_527d5d4afb852',
				'label' => __('Start Date','psp_projects'),
				'name' => 'start_date',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 0,
			),
			array (
				'key' => 'field_527d5d57fb853',
				'label' => __('End Date','psp_projects'),
				'name' => 'end_date',
				'type' => 'date_picker',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'psp_projects',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_milestones',
		'title' => __('Milestones','psp_projects'),
		'fields' => array (
			array (
				'key' => 'field_53138cd18335f',
				'label' => __('Milestones','psp_projects'),
				'name' => '',
				'type' => 'message',
				'message' => __('If desired, describe what will be completed at key points in the project.','psp_projects'),
			),
			array (
				'key' => 'field_528170f6552e1',
				'label' => __('Display Milestones','psp_projects'),
				'name' => 'display_milestones',
				'type' => 'checkbox',
				'choices' => array (
					'Yes' => __('Yes','psp_projects'),
				),
				'default_value' => '',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_52817036552d8',
				'label' => __('Milestone Frequency','psp_projects'),
				'name' => 'milestone_frequency',
				'type' => 'select',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'null' => '---',
					'quarters' => '25% / 50% / 75%',
					'fifths' => '20% / 40% / 60% / 80%',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_52a9e020fba90',
				'label' => __('1st Milestone','psp_projects'),
				'name' => '',
				'type' => 'tab',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
			),
			array (
				'key' => 'field_53138d853bbf8',
				'label' => __('Note:','psp_projects'),
				'name' => '',
				'type' => 'message',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '!=',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'message' => __('If you\'d like to label key milestones please turn "Display Milestones" on (above).','psp_projects'),
			),
			array (
				'key' => 'field_5281706e552d9',
				'label' => __('Title','psp_projects'),
				'name' => '25%_title',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_528170a1552da',
				'label' => __('Description','psp_projects'),
				'name' => '25%_description',
				'type' => 'textarea',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_52a9e067fba92',
				'label' => __('2nd Milestone','psp_projects'),
				'name' => '',
				'type' => 'tab',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
			),
			array (
				'key' => 'field_53138db13bbf9',
				'label' => __('Note:','psp_projects'),
				'name' => '',
				'type' => 'message',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '!=',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
			),
			array (
				'key' => 'field_528170ac552db',
				'label' => __('Title','psp_projects'),
				'name' => '50%_title',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_528170b6552dc',
				'label' => __('Description','psp_projects'),
				'name' => '50%_description',
				'type' => 'textarea',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_52a9e084fba93',
				'label' => __('3rd Milestone','psp_projects'),
				'name' => '',
				'type' => 'tab',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
			),
			array (
				'key' => 'field_53138dbe3bbfa',
				'label' => __('Note: ','psp_projects'),
				'name' => '',
				'type' => 'message',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '!=',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
			),
			array (
				'key' => 'field_528170c2552dd',
				'label' => __('Title','psp_projects'),
				'name' => '75%_title',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_528170cc552de',
				'label' => __('Description','psp_projects'),
				'name' => '75%_description',
				'type' => 'textarea',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_52a9e03afba91',
				'label' => __('4th Milestone','psp_projects'),
				'name' => '',
				'type' => 'tab',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
						array (
							'field' => 'field_52817036552d8',
							'operator' => '==',
							'value' => 'fifths',
						),
					),
					'allorany' => 'all',
				),
			),
			array (
				'key' => 'field_53138dcc3bbfb',
				'label' => __('Note:','psp_projects'),
				'name' => '',
				'type' => 'message',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '!=',
							'value' => 'Yes',
						),
					),
					'allorany' => 'all',
				),
				'message' => '',
			),
			array (
				'key' => 'field_53138d1583360',
				'label' => __('Note:','psp_projects'),
				'name' => '',
				'type' => 'message',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_52817036552d8',
							'operator' => '==',
							'value' => 'quarters',
						),
					),
					'allorany' => 'all',
				),
				'message' => __('These fields are only available if you select "Fifths" on the milestone frequency field.','psp_projects'),
			),
			array (
				'key' => 'field_528170db552df',
				'label' => __('Title','psp_projects'),
				'name' => '100%_title',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
						array (
							'field' => 'field_52817036552d8',
							'operator' => '==',
							'value' => 'fifths',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_528170e6552e0',
				'label' => __('Description','psp_projects'),
				'name' => '100%_description',
				'type' => 'textarea',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_528170f6552e1',
							'operator' => '==',
							'value' => 'Yes',
						),
						array (
							'field' => 'field_52817036552d8',
							'operator' => '==',
							'value' => 'fifths',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'psp_projects',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 1,
	));

}

// CMB2 phases
