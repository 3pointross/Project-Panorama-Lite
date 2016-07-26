<?php

	// ====================
	// = Custom Templates =
	// ====================

	/*
	|--------------------------------------------------------------------------
	| CONSTANTS
	|--------------------------------------------------------------------------
	*/

	if ( ! defined( 'PSP_BASE_FILE' ) )
	    define( 'PSP_BASE_FILE', __FILE__ );
	if ( ! defined( 'PSP_BASE_DIR' ) )
	    define( 'PSP_BASE_DIR', dirname( PSP_BASE_FILE ) );
	if ( ! defined( 'PSP_PLUGIN_URL' ) )
	    define( 'PSP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	
	
	add_filter('template_include','psp_template_chooser');
	
	function psp_template_chooser($template) { 
		// Post ID
	    $post_id = get_the_ID();

	    // For all other CPT
	    if ( get_post_type( $post_id ) != 'psp_projects' ) {
	        return $template;
	    }

	    // Else use custom template
	    if ( is_single() ) {
            if(PSP_PLUGIN_TYPE == 'professional') {
    	        return psp_template_hierarchy( 'single' );
            } else {
                return psp_template_hierarchy( 'single-lite' );
            }
	    }

	}
	
	/**
	 * Get the custom template if is set
	 *
	 * @since 1.0
	 */

	function psp_template_hierarchy( $template ) {

	    // Get the template slug
	    $template_slug = rtrim( $template, '.php' );
	    $template = $template_slug . '.php';

	    // Check if a custom template exists in the theme folder, if not, load the plugin template file
	    if ( $theme_file = locate_template( array( 'psp-templates/' . $template ) ) ) {
	        $file = $theme_file;
	    }
	    else {
	        $file = PSP_BASE_DIR . '/templates/' . $template;
	    }

	    return apply_filters( 'rc_repl_template_' . $template, $file );
	}



?>