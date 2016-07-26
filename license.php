<?php


/************************************
* the code below is just a standard
* options page. Substitute with 
* your own.
*************************************/

function edd_panorama_license_menu() {
	add_submenu_page( 'edit.php?post_type=psp_projects','Project Panorama Settings', 'Settings', 'manage_options', 'panorama-license', 'edd_panorama_license_page' );
}
add_action('admin_menu', 'edd_panorama_license_menu');

function edd_panorama_license_page() {
	$license 	= get_option( 'edd_panorama_license_key' );
	$status 	= get_option( 'edd_panorama_license_status' );
	?>
	<div class="wrap">
		<h2><?php _e('Project Panorama License Options','psp_projects'); ?></h2>

        <?php if($_GET['settings-updated'] == 'true') {

            flush_rewrite_rules(); ?>

            <div class="updated">
                <p>The Project Panorama settings have been updated.</p>
            </div>

        <?php } ?>

		<form method="post" action="options.php">
		
			<?php settings_fields('edd_panorama_license'); ?>

        <?php if(PSP_PLUGIN_TYPE == 'professional'): ?>
        <table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key','psp_projects'); ?>
						</th>
						<td>
							<input id="edd_panorama_license_key" name="edd_panorama_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="edd_panorama_license_key"><?php _e('Enter your license key','psp_projects'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Activate License','psp_projects'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;" class="psp-activation-notice"><?php _e('Active','psp_projects'); ?></span>
									<?php wp_nonce_field( 'edd_panorama_nonce', 'edd_panorama_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_deactivate" value="<?php _e('Deactivate License','psp_projects'); ?>"/>
								<?php } else { ?>
                                    <span style="color:red;" class="psp-activation-notice"><?php _e('Inactive','psp_projects'); ?></span>
									<?php wp_nonce_field( 'edd_panorama_nonce', 'edd_panorama_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e('Activate License','psp_projects'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
			</table>
			<?php endif; ?>

				<table class="form-table">
					<tr>
						<td colspan="2"><hr></td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="psp_slug"><?php _e('Project Slug','psp_projects'); ?></label>
						</th>
						<td>
							<input id="psp_slug" value="<?php echo get_option('psp_slug','panorama'); ?>" type="text" name="psp_slug">
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="psp_logo"><?php _e('Logo for Project Pages','psp_projects'); ?></label>
						</th>
						<td>
						    <input id="psp_logo" type="text" size="36" name="psp_logo" value="<?php echo get_option('psp_logo','http://'); ?>" />
						    <input id="psp_upload_image_button" class="button" type="button" value="Upload Image" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<hr><br>
							<p><em>If you're having trouble with WordPress SEO sitemaps.xml or getting 404 errors on other pages, try checking this option and <a href="options-permalink.php">resaving your permalinks</a>.</em></p>
						</td>
					</tr>
					<tr>
						<th scope="row" valign="top">
							<label for="psp_flush_rewrites"><?php _e('Disable Flush Rewrites','psp_projects'); ?></label>
						</th>
						<td>
							<input id="psp_flush_rewrites" type="checkbox" name="psp_flush_rewrites" <?php if(get_option('psp_flush_rewrites') == 'on') { echo 'checked'; }?>>
						</td>
					</tr>
				</tbody>
			</table>	
			<?php submit_button(); ?>
		
		</form>
	<?php
}

function edd_panorama_register_option() {
	// creates our settings in the options table
	register_setting('edd_panorama_license', 'edd_panorama_license_key', 'edd_sanitize_license' );
	
	// Additional options
	add_option('psp_slug','panorama');
	add_option('psp_logo');
	add_option('psp_flush_rewrites');
	
	register_setting( 'edd_panorama_license', 'psp_slug' ); 
	register_setting( 'edd_panorama_license', 'psp_logo' ); 
	register_setting( 'edd_panorama_license', 'psp_flush_rewrites');
	
} 	

add_action('admin_init', 'edd_panorama_register_option');

function edd_sanitize_license( $new ) {
	$old = get_option( 'edd_panorama_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'edd_panorama_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}



/************************************
* this illustrates how to activate 
* a license key
*************************************/

function edd_panorama_activate_license() {
		
	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_activate'] ) ) {
				
		// run a quick security check 
	 	if( ! check_admin_referer( 'edd_panorama_nonce', 'edd_panorama_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edd_panorama_license_key' ) );
			

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'activate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( EDD_PROJECT_PANORAMA ) // the name of our product in EDD
		);
		
		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, PROJECT_PANORAMA_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "active" or "inactive"

		update_option( 'edd_panorama_license_status', $license_data->license );

	}
	

		
}
add_action('admin_init', 'edd_panorama_activate_license',0);


/***********************************************
* Illustrates how to deactivate a license key.
* This will descrease the site count
***********************************************/

function edd_panorama_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_deactivate'] ) ) {

		// run a quick security check 
	 	if( ! check_admin_referer( 'edd_panorama_nonce', 'edd_panorama_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edd_panorama_license_key' ) );
			

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'deactivate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( EDD_PROJECT_PANORAMA ) // the name of our product in EDD
		);
		
		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, PROJECT_PANORAMA_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'edd_panorama_license_status' );

	}
}
add_action('admin_init', 'edd_panorama_deactivate_license');


/************************************
* this illustrates how to check if 
* a license key is still valid
* the updater does this for you,
* so this is only needed if you
* want to do something custom
*************************************/

function edd_panorama_check_license() {

	global $wp_version;

	$license = trim( get_option( 'edd_panorama_license_key' ) );
		
	$api_params = array( 
		'edd_action' => 'check_license', 
		'license' => $license, 
		'item_name' => urlencode( EDD_PROJECT_PANORAMA ) 
	);

	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, PROJECT_PANORAMA_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );
	
	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}
