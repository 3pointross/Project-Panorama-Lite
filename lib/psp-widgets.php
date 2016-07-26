<?php

    /* Widgets */

	// TODO: Update widget creation method

    class psp_project_list_widget extends WP_Widget {

        function __construct() {

            //Constructor
            $widget_ops = array(
                'classname' => 'psp_project_list_widget',
                'description' => 'List of Panorama Projects'
                );
            parent::__construct(
                'psp_project_list_widget',
                'Panorama Project List',
                $widget_ops
                );
        }

        function widget($args, $instance) {

            //outputs the widget
            extract($args, EXTR_SKIP);

            $project_type = apply_filters('project_type', $instance['project_type']);
            $project_status = apply_filters('project_status', $instance['project_status']);
            $project_access = apply_filters('project_access', $instance['project_access']);

            $widget_shortcode = '[project_list type="'.$project_type.'" status="'.$project_status.'" access="'.$project_access.'"]';

            echo do_shortcode($widget_shortcode);

        }

        function update ($new_instance, $old_instance) {

            $instance = $old_instance;

            // Save the new fields

            $instance['project_type'] = strip_tags($new_instance['project_type']);
            $instance['project_status'] = strip_tags($new_instance['project_status']);
            $instance['project_access'] = strip_tags($new_instance['project_access']);

            return $instance;

        }

        function form($instance) {

            $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'entry_title' => '', 'comments_title' => '' ) );

            $project_type = strip_tags($instance['project_type']);
            $project_status = strip_tags($instance['project_status']);
            $project_access = strip_tags($instance['project_access']);

            // Set defaults
            if(empty($project_type)) { $project_type = 'all'; }
            if(empty($project_status)) { $project_status = 'all'; }
            if(empty($project_access)) { $project_access = 'user'; }

            $project_types = get_terms('psp_tax');

            ?>

            <p>
                <label for="<?php echo $this->get_field_id('project_type'); ?>">Type</label>
                <select id="<?php echo $this->get_field_id('project_type'); ?>" name="<?php echo $this->get_field_name('project_type'); ?>">
                        <option value="all">All</option>
                    <?php foreach($project_types as $type) { ?>
                        <option value="<?php echo $type->slug; ?>" <?php if($project_type == $type->slug) { echo 'selected'; } ?>><?php echo $type->name; ?></option>
                    <?php } ?>
                </select>
            </p>

            <p><label for="<?php echo $this->get_field_id('project_status'); ?>">Status</label>
                <select id="<?php echo $this->get_field_id('project_status'); ?>" name="<?php echo $this->get_field_name('project_status'); ?>">
                    <option value="all" <?php if($project_status == 'all') { echo 'selected'; } ?>>All</option>
                    <option value="active" <?php if($project_status == 'active') { echo 'selected'; } ?>>Active</option>
                    <option value="complete" <?php if($project_status == 'complete') { echo 'selected'; } ?>>Complete</option>
                </select>
            </p>

            <p><input type="checkbox" name="<?php echo $this->get_field_name('project_access'); ?>" id="<?php echo $this->get_field_id('project_access'); ?>" value="user" <?php if($project_access == 'user') { echo 'checked'; } else { echo 'unchecked'; } ?>> <label for="<?php echo $this->get_field_id('project_access'); ?>">Only display projects current user has permission to access</label></p>


        <?php
        }

}

add_action('widgets_init','register_psp_widgets');
function register_psp_widgets() {
    register_widget('psp_project_list_widget');
}
