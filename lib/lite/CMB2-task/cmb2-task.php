<?php
function psp_cmb2_task_field( $metakey, $post_id = 0 ) {
	echo psp_cmb2_get_task_field( $metakey, $post_id );
}

/**
 * Template tag for returning an address from the CMB2 address field type (on the front-end)
 *
 * @since  0.1.0
 *
 * @param  string  $metakey The 'id' of the 'address' field (the metakey for get_post_meta)
 * @param  integer $post_id (optional) post ID. If using in the loop, it is not necessary
 */
function psp_cmb2_get_task_field( $metakey, $post_id = 0 ) {

	$post_id = $post_id ? $post_id : get_the_ID();

	$task = get_post_meta( $post_id, $metakey, 1 );

	// Set default values for each address key
	$task = wp_parse_args( $phase, array(
		'title'        => '',
        'complete'     => '',
	) );

	$output = '<div class="cmb2-task">';
	$output .= '<p><strong>Task:</strong> ' . esc_html( $task['title'] ) . '</p>';
	$output .= '<p><strong>Completion:</strong> ' . esc_html( $task['complete'] ) . '</p>';
	$output .= '</div><!-- .cmb2-task -->';

	return apply_filters( 'psp_cmb2_get_task_field', $output );
}

function cmb2_init_task_field() {
	require_once dirname( __FILE__ ) . '/class-cmb2-render-task-field.php';
	CMB2_Render_Task_Field::init();
}
add_action( 'cmb2_init', 'cmb2_init_task_field' );
