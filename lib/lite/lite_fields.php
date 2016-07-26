<?php 
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
				'key' => 'field_527d5d61fb854',
				'label' => __('Percent Complete','psp_projects'),
				'name' => 'percent_complete',
				'type' => 'num_slider',
				'minimum_number' => 1,
				'max_number' => 100,
				'inc_number' => 1,
				'start_number' => '',
			),
			array (
				'key' => 'field_52a9e43c4b145',
				'label' => __('Project Details','psp_projects'),
				'name' => '',
				'type' => 'tab',
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
			array (
				'key' => 'field_52a9e4594b146',
				'label' => __('Documents','psp_projects'),
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_5324b4261d324',
				'label' => __('Documents','psp_projects'),
				'name' => 'documents2',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'full',
				'media_upload' => 'yes',
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
			'position' => 'normal',
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
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 1,
	));

}

