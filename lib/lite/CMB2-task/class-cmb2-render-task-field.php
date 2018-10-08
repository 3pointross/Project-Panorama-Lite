<?php

function cmb2_render_callback_for_tasks( $field, $value, $object_id, $object_type, $field_type ) {

    // make sure we specify each part of the value we need.
	$value = wp_parse_args( $value, array(
        'title'      => '',
        'complete'   => '',
    ) );

    ?>
	<div><p><label for="<?php echo $field_type->_id( '_title' ); ?>"><?php esc_html_e( 'Task', 'psp_projects' ); ?></label></p>
		<?php echo $field_type->input( array(
			'name'  => $field_type->_name( '[title]' ),
			'id'    => $field_type->_id( '_title' ),
			'value' => $value['title'],
			'desc'  => '',
		) ); ?>
	</div>
	<div><p><label for="<?php echo $field_type->_id( '_complete' ); ?>'"><?php esc_html_e( 'Completion', 'psp_projects' ); ?></label></p>
		<?php echo $field_type->select( array(
			'name'      => $field_type->_name( '[complete]' ),
			'id'        => $field_type->_id( '_complete' ),
            'options'   => psp_lite_completion_options( $value['complete'] ),
			'value'     => $value['complete'],
			'desc'      => '',
		) ); ?>
	</div>
    <br class="clear">
    <?php
    echo $field_type->_desc( true );

}
add_filter( 'cmb2_render_tasks', 'cmb2_render_callback_for_tasks', 10, 5 );

function psp_lite_completion_options( $value = false ) {

    $percentage = array (
        0 => '0%',
        5 => '5%',
        10 => '10%',
        15 => '15%',
        20 => '20%',
        25 => '25%',
        30 => '30%',
        35 => '35%',
        40 => '40%',
        45 => '45%',
        50 => '50%',
        55 => '55%',
        60 => '60%',
        65 => '65%',
        70 => '70%',
        75 => '75%',
        80 => '80%',
        85 => '85%',
        90 => '90%',
        95 => '95%',
        100 => '100%',
    );

	$complete_options = '';
	foreach ( $percentage as $val => $label ) {
		$complete_options .= '<option value="'. $val .'" '. selected( $value, $val, false ) .'>'. $label .'</option>';
	}

	return $complete_options;

}

function pano_lite_sanitize_tasks_callback( $override_value, $value ) {

	return $value;
}

add_filter( 'cmb2_sanitize_tasks', 'cmb2_sanitize_tasks_field', 10, 5 );
function cmb2_sanitize_tasks_field( $check, $meta_value, $object_id, $field_args, $sanitize_object ) {

    if ( is_array( $meta_value ) && $field_args['repeatable'] ) {

        foreach ( $meta_value as $key => $val ) {
            if ( isset( $val['complete'] ) && '0' == $val['complete'] ) {
                unset( $val['complete'] );
                $val = array_filter( $val );
                if ( empty( $val ) ) {
                    unset( $meta_value[ $key ] );
                    continue;
                } else {
                    $val['complete'] = '0';
                }
            }
            $meta_value[ $key ] = array_map( 'sanitize_text_field', $val );
        }

        return $meta_value;

    }

    return $check;

}

add_filter( 'cmb2_types_esc_tasks', 'cmb2_types_esc_tasks_field', 10, 4 );
function cmb2_types_esc_tasks_field( $check, $meta_value, $field_args, $field_object ) {
    if ( is_array( $meta_value ) && $field_args['repeatable'] ) {

        foreach ( $meta_value as $key => $val ) {
            $meta_value[ $key ] = array_map( 'esc_attr', $val );
        }

        return $meta_value;

    }

    return $check;

}

// add_action( 'cmb2_render_tasks', 'cmb2_render_callback_for_tasks', 10, 5 );

/**
 * Handles 'address' custom field type.
 */
class CMB2_Render_Task_Field extends CMB2_Type_Base {

	/**
	 * List of states. To translate, pass array of states in the 'state_list' field param.
	 *
	 * @var array
	 */
	protected static $percentage = array (
                            0 => '0%',
                            5 => '5%',
                            10 => '10%',
                            15 => '15%',
                            20 => '20%',
                            25 => '25%',
                            30 => '30%',
                            35 => '35%',
                            40 => '40%',
                            45 => '45%',
                            50 => '50%',
                            55 => '55%',
                            60 => '60%',
                            65 => '65%',
                            70 => '70%',
                            75 => '75%',
                            80 => '80%',
                            85 => '85%',
                            90 => '90%',
                            95 => '95%',
                            100 => '100%',
                        );

	public static function init() {
		add_filter( 'cmb2_render_task', array( __CLASS__, 'class_name' ) );
		add_filter( 'cmb2_sanitize_task', array( __CLASS__, 'maybe_save_split_values' ), 12, 4 );

		/**
		 * The following snippets are required for allowing the address field
		 * to work as a repeatable field, or in a repeatable group
		 */
		add_filter( 'cmb2_sanitize_task', array( __CLASS__, 'sanitize' ), 10, 5 );
		add_filter( 'cmb2_types_esc_task', array( __CLASS__, 'escape' ), 10, 4 );
	}

	public static function class_name() { return __CLASS__; }

	/**
	 * Handles outputting the address field.
	 */
	public function render() {

		// make sure we assign each part of the value we need.
		$value = wp_parse_args( $this->field->escaped_value(), array(
			'title'      => '',
			'complete'   => '',
		) );

	    $complete_list = $this->field->args( 'complete', array() );

        if ( empty( $complete_list ) ) {
			$complete_list = self::$percentage;
		}

		// Add the "label" option. Can override via the field text param
		$complete_list = array( '' => esc_html( $this->_text( 'completion_text', 'Completion' ) ) ) + $complete_list;

		$complete_options = '';
		foreach ( $complete_list as $val => $label ) {
			$complete_options .= '<option value="'. $val .'" '. selected( $value['task'], $val, false ) .'>'. $label .'</option>';
		}

		$complete_label = 'Task';

		ob_start();
		// Do html
		?>
		<div>
            <p><label for="<?php echo $this->_id( '_title', false ); ?>"><?php echo esc_html( $this->_text( 'task_title_text', 'Task' ) ); ?></label></p>
			<?php echo $this->types->input( array(
				'name'  => $this->_name( '[title]' ),
				'id'    => $this->_id( '_title' ),
				'value' => $value['title'],
				'desc'  => '',
			) ); ?>
		</div>
		<div>
            <p><label for="<?php echo $this->_id( '_completion', false ); ?>'"><?php echo esc_html( $this->_text( 'task_completion_text', 'Completion' ) ); ?></label></p>
			<?php echo $this->types->input( array(
				'name'  => $this->_name( '[complete]' ),
				'id'    => $this->_id( '_complete' ),
				'value' => $value['complete'],
				'desc'  => '',
			) ); ?>
		</div>
		<p class="clear">
			<?php echo $this->_desc();?>
		</p>
		<?php

		// grab the data from the output buffer.
		return $this->rendered( ob_get_clean() );
	}

	/**
	 * Optionally save the Address values into separate fields
	 */
	public static function maybe_save_split_values( $override_value, $value, $object_id, $field_args ) {
		if ( ! isset( $field_args['split_values'] ) || ! $field_args['split_values'] ) {
			// Don't do the override
			return $override_value;
		}

		$address_keys = array( 'address-1', 'address-2', 'city', 'state', 'zip' );

		foreach ( $address_keys as $key ) {
			if ( ! empty( $value[ $key ] ) ) {
				update_post_meta( $object_id, $field_args['id'] . 'addr_'. $key, sanitize_text_field( $value[ $key ] ) );
			}
		}

		remove_filter( 'cmb2_sanitize_address', array( __CLASS__, 'sanitize' ), 10, 5 );

		// Tell CMB2 we already did the update
		return true;
	}

	public static function sanitize( $check, $meta_value, $object_id, $field_args, $sanitize_object ) {

		// if not repeatable, bail out.
		if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
			return $check;
		}

		foreach ( $meta_value as $key => $val ) {
			$meta_value[ $key ] = array_filter( array_map( 'sanitize_text_field', $val ) );
		}

		return array_filter($meta_value);
	}

	public static function escape( $check, $meta_value, $field_args, $field_object ) {
		// if not repeatable, bail out.
		if ( ! is_array( $meta_value ) || ! $field_args['repeatable'] ) {
			return $check;
		}

		foreach ( $meta_value as $key => $val ) {
			$meta_value[ $key ] = array_filter( array_map( 'esc_attr', $val ) );
		}

		return array_filter($meta_value);
	}

}
