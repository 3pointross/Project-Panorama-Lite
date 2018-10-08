<?php

function edd_panorama_license_menu() {

	global $psp_settings_page;

	$psp_settings_page = add_submenu_page( 'edit.php?post_type=psp_projects','Project Panorama Settings', 'Settings', 'manage_options', 'panorama-license', 'edd_panorama_license_page' );

}
add_action('admin_menu', 'edd_panorama_license_menu');

function edd_panorama_license_page() {
	$license 	= get_option( 'edd_panorama_license_key' );
	$status 	= get_option( 'edd_panorama_license_status' );

    wp_enqueue_script(
        'admin-settings.js',
        PROJECT_PANARAMA_URI . '/assets/js/admin-settings.js',
        array('jquery'),
        null,
        true
    );

	?>
	<div class="wrap">
		<h2><?php _e('Project Panorama Options','psp_projects'); ?></h2>

        <br>

        <?php

            if( isset( $_GET[ 'tab' ] ) ) {
               $active_tab = $_GET[ 'tab' ];
            } else {
                $active_tab = 'psp_general_settings';
            }

            if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') {

            flush_rewrite_rules(); ?>

            <div class="updated">
                <p><?php _e('The Project Panorama settings have been updated','psp_projects'); ?>.</p>
            </div>

        <?php } ?>

        <h2 class="nav-tab-wrapper">
            <a href="edit.php?post_type=psp_projects&page=panorama-license&tab=psp_general_settings" class="nav-tab <?php if($active_tab == "psp_general_settings") { echo 'nav-tab-active'; } ?>"><?php _e('General','psp_projects'); ?></a>
            <a href="edit.php?post_type=psp_projects&page=panorama-license&tab=psp_appearance" class="nav-tab <?php if($active_tab == "psp_appearance") { echo 'nav-tab-active'; } ?>"><?php _e('Appearance','psp_projects'); ?></a>
        </h2>

		<form method="post" action="options.php">

			<?php settings_fields('edd_panorama_license'); ?>

            <?php if(isset($_GET['psp_activate_response'])): ?>
                <div class="psp-status-message">
                    <pre>
                        <?php psp_check_activation_response(); ?>
                    </pre>
                </div>
            <?php endif; ?>

            <div id="psp_general_settings" class="psp-settings-tab <?php if($active_tab == 'psp_general_settings') { echo "psp-settings-tab-active"; } ?>">
                <table class="form-table">
                        <tbody>
				        <?php if(PSP_PLUGIN_TYPE == 'professional'): ?>
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
						<?php endif; ?>
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
									<label for="psp_back"><?php _e('Back Button Link','psp_projects'); ?></label>
								</th>
								<td>
									<input id="psp_back" value="<?php echo get_option('psp_back','panorama'); ?>" type="text" name="psp_back">
									<label class="description" for="psp_back">Leave blank for last page visited</label>
								</td>
							</tr>
                        </tbody>
                </table>

            </div>

            <div id="psp_appearance" class="psp-settings-tab <?php if($active_tab == 'psp_appearance') { echo "psp-settings-tab-active"; } ?>">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_logo"><?php _e('Logo for Project Pages','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input id="psp_logo" type="text" size="36" name="psp_logo" value="<?php echo get_option('psp_logo','http://'); ?>" />
                                <input id="psp_upload_image_button" class="button" type="button" value="Upload Image" />
                            </td>
                        </tr>
                    </tbody>
                </table>

				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_calendar_language"><?php esc_html_e( 'Calendar Language', 'psp_projects' ); ?></label>
							</th>
							<td>
								<select id="psp_calendar_langauge" name="psp_calendar_language">
		                            <option value="<?php echo get_option( 'psp_calendar_language', 'en' ); ?>"><?php echo get_option( 'psp_calendar_language', 'en' ); ?></option>
		                            <option value="---" disabled>---</option>
		                            <option value="en">en</option>
		                            <option value="ar-ma">ar-ma</option>
		                            <option value="ar-sa">ar-sa</option>
		                            <option value="ar-tn">ar-tn</option>
		                            <option value="ar">ar</option>
		                            <option value="bg">bg</option>
		                            <option value="ca">ca</option>
		                            <option value="cs">cs</option>
		                            <option value="da">da</option>
		                            <option value="de-at">de-at</option>
		                            <option value="de">de</option>
		                            <option value="el">el</option>
		                            <option value="en-au">en-au</option>
		                            <option value="en-ca">en-ca</option>
		                            <option value="en-gb">en-gb</option>
		                            <option value="en-ie">en-ie</option>
		                            <option value="en-nz">en-nz</option>
		                            <option value="es">es</option>
		                            <option value="fa">fa</option>
		                            <option value="fi">fi</option>
		                            <option value="fr-ca">fr-ca</option>
		                            <option value="fr-ch">fr-ch</option>
		                            <option value="fr">fr</option>
		                            <option value="he">he</option>
		                            <option value="hi">hi</option>
		                            <option value="hr">hr</option>
		                            <option value="hu">hu</option>
		                            <option value="id">id</option>
		                            <option value="is">is</option>
		                            <option value="it">it</option>
		                            <option value="ja">ja</option>
		                            <option value="ko">ko</option>
		                            <option value="lt">lt</option>
		                            <option value="lv">lv</option>
		                            <option value="nb">nb</option>
		                            <option value="nl">nl</option>
		                            <option value="pl">pl</option>
		                            <option value="pt-br">pt-br</option>
		                            <option value="pt">pt</option>
		                            <option value="ro">ro</option>
		                            <option value="ru">ru</option>
		                            <option value="sk">sk</option>
		                            <option value="sl">sl</option>
		                            <option value="sr-cyrl">sr-cyrl</option>
		                            <option value="sr">sr</option>
		                            <option value="sv">sv</option>
		                            <option value="th">th</option>
		                            <option value="tr">tr</option>
		                            <option value="uk">uk</option>
		                            <option value="vi">vi</option>
		                            <option value="zh-cn">zh-cn</option>
		                            <option value="zh-tw">zh-tw</option>
		                        </select>
							</td>
						</tr>
					</tbody>
				</table>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_use_custom_template"><?php _e('Use Custom Template'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" id="psp_use_custom_template" value="1" name="psp_use_custom_template" class="js-psp-choose-custom-template" <?php echo get_option('psp_use_custom_template') === '1' ? 'checked="checked"' : null;?> />
                            </td>
                        </tr>

                        <?php // TODO: wrap in conditional for pro only feature ?>
                        <tr class="js-psp-choose-custom-template-active-show" style="display:none;">
                            <th scope="row" valign="top">
                                <label for="psp_use_custom_template"><?php _e('Choose Custom Template'); ?></label>
                            </th>
                            <td>



                                <?php
                                    $templates = wp_get_theme()->get_page_templates();

                                    if (!empty($templates)) :

                                        $templates['page.php'] = 'Standard Page';

									else:

										$templates['single.php'] = 'Single Post';


									endif;
									?>

                                    <select id="psp_custom_template" name="psp_custom_template">
                                        <option value=""><?php _e('Choose Template'); ?></option>
                                        <?php foreach($templates as $t_filename => $t_name) : ?>
                                            <option <?php echo get_option('psp_custom_template') === $t_filename ? 'selected' : null;?> value="<?php echo $t_filename;?>">
                                                <?php echo $t_name; ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>

									<div class="psp-warning">
										<span><?php _e('Warning: This is an unsupported feature and might not work or display well with all themes.','psp-projects'); ?></span>
									</div>

									<?php /* else: ?>
                                    <div style="color:red;">
                                        <?php _e('There are no custom templates in your current theme.'); ?>
                                    </div>

                                <?php endif; */ ?>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <fieldset class="psp-fieldset">
                    <legend><?php _e('Header','psp_projects'); ?></legend>


                <table class="form-table psp-color-table">
                    <tr>
                        <th scope="row" valign="top">
                            <label for="psp_header_background"><?php _e('Header Background','psp_projects'); ?></label>
                        </th>
                        <td>
                            <input id="psp_header_background" value="<?php echo get_option('psp_header_background'); ?>" name="psp_header_background" class="color-field" rel="2a3542">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="psp_header_text"><?php _e('Header Text','psp_projects'); ?></label>
                        </th>
                        <td>
                            <input id="psp_header_text" value="<?php echo get_option('psp_header_text'); ?>" name="psp_header_text" class="color-field" rel="fff">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="psp_header_accent"><?php _e('Accent Text','psp_projects'); ?></label>
                        </th>
                        <td>
                            <input id="psp_header_accent" value="<?php echo get_option('psp_header_accent'); ?>" name="psp_header_accent" class="color-field" rel="aeb2b7">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" valign="top">
                            <label for="psp_menu_background"><?php _e('Menu Background','psp_projects'); ?></label>
                        </th>
                        <td>
                            <input id="psp_menu_background" value="<?php echo get_option('psp_menu_background'); ?>" name="psp_menu_background" class="color-field" rel="2a3542">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="psp_menu_text"><?php _e('Menu Text','psp_projects'); ?></label>
                        </th>
                        <td>
                            <input id="psp_menu_text" value="<?php echo get_option('psp_menu_text'); ?>" name="psp_menu_text" class="color-field" rel="fff">
                        </td>
                    </tr>
                </table>

                </fieldset>

                <fieldset class="psp-fieldset">
                    <legend><?php _e('Body','psp_projects'); ?></legend>

                    <table class="form-table psp-color-table">
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_body_background"><?php _e('Body Background','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input id="psp_body_background" value="<?php echo get_option('psp_body_background'); ?>" name="psp_body_background" class="color-field" rel="f1f2f7">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_body_heading"><?php _e('Body Heading','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input id="psp_body_heading" value="<?php echo get_option('psp_body_heading'); ?>" name="psp_body_heading" class="color-field" rel="999">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_body_background"><?php _e('Body Text','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input id="psp_body_text" value="<?php echo get_option('psp_body_text'); ?>" name="psp_body_text" class="color-field" rel="333">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_body_link"><?php _e('Body Link','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input id="psp_body_link" value="<?php echo get_option('psp_body_link'); ?>" name="psp_body_link" class="color-field" rel="000">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_footer_background"><?php _e('Footer Background','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input id="psp_footer_background" value="<?php echo get_option('psp_footer_background'); ?>" name="psp_footer_background" class="color-field" rel="2a3542">
                            </td>
                        </tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_timeline_color"><?php _e('Timeline','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_timeline_color" value="<?php echo get_option('psp_timeline_color'); ?>" name="psp_timeline_color" class="color-field" rel="99C262">
							</td>
						</tr>
                    </table>

                </fieldset>

				<fieldset class="psp-fieldset">
					<legend><?php _e('Phases','psp_projects'); ?></legend>

					<table class="form-table psp-color-table">
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_1"><?php _e('Accent Color #1','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_1" value="<?php echo get_option('psp_accent_color_1'); ?>" class="color-field" rel="3299BB" name="psp_accent_color_1">
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_1_txt"><?php _e('Accent Color #1 Text','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_1_txt" value="<?php echo get_option('psp_accent_color_1_txt'); ?>" class="color-field" rel="ffffff" name="psp_accent_color_1_txt">
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_2"><?php _e('Accent Color #2','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_2" value="<?php echo get_option('psp_accent_color_2'); ?>" class="color-field" rel="4ECDC4" name="psp_accent_color_2">
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_2_txt"><?php _e('Accent Color #2 Text','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_2_txt" value="<?php echo get_option('psp_accent_color_2_txt'); ?>" class="color-field" rel="ffffff" name="psp_accent_color_2_txt">
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_3"><?php _e('Accent Color #3','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_3" value="<?php echo get_option('psp_accent_color_3'); ?>" class="color-field" rel="CBE86B" name="psp_accent_color_3">
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_3_txt"><?php _e('Accent Color #3 Text','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_3_txt" value="<?php echo get_option('psp_accent_color_3_txt'); ?>" class="color-field" rel="ffffff" name="psp_accent_color_3_txt">
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_4"><?php _e('Accent Color #4','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_4" value="<?php echo get_option('psp_accent_color_4'); ?>" class="color-field" rel="FF6B6B" name="psp_accent_color_4">
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_4_txt"><?php _e('Accent Color #4 Text','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_4_txt" value="<?php echo get_option('psp_accent_color_4_txt'); ?>" class="color-field" rel="ffffff" name="psp_accent_color_4_txt">
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_5"><?php _e('Accent Color #5','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_5" value="<?php echo get_option('psp_accent_color_5'); ?>" class="color-field" rel="C44D58" name="psp_accent_color_5">
							</td>
						</tr>
						<tr>
							<th scope="row" valign="top">
								<label for="psp_accent_color_5_txt"><?php _e('Accent Color #5 Text','psp_projects'); ?></label>
							</th>
							<td>
								<input id="psp_accent_color_5_txt" value="<?php echo get_option('psp_accent_color_5_txt'); ?>" class="color-field" rel="ffffff" name="psp_accent_color_5_txt">
							</td>
						</tr>
					</table>
				</fieldset>

                <p><input type="button" class="psp-reset-colors button-secondary" value="Reset Colors to Default" name="psp-reset-colors"></p>


                <fieldset class="psp-fieldset">
                    <legend><?php _e('Custom Styling','psp_projects'); ?></legend>
                    <table class="form-table">
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_open_css"><?php _e('Custom CSS','psp_projects'); ?></label>
                            </th>
                            <td>
                                <textarea rows="10" cols="75" name="psp_open_css" id="psp_open_css"><?php echo get_option('psp_open_css'); ?></textarea>
                            </td>
                        </tr>
                    </table>
                </fieldset>

            </div>

            <div id="psp_notifications" class="psp-settings-tab <?php if($active_tab == 'psp_notifications') { echo "psp-settings-tab-active"; } ?>">

                <fieldset class="psp-fieldset">
                    <table class="form-table">
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_from_name"><?php _e('From Name','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="psp_from_name" id="psp_from_name" value="<?php echo get_option('psp_from_name'); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_from_email"><?php _e('From E-mail','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="psp_from_email" id="psp_from_email" value="<?php echo get_option('psp_from_email'); ?>">
                            </td>
                        </tr>
                        <?php if(get_option('psp_logo') !== null) { ?>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_include_logo"><?php _e('Include Logo','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" name="psp_include_logo" id="psp_include_logo" <?php if(get_option('psp_include_logo')) { echo 'checked'; } ?>>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_default_subject"><?php _e('Default Subject Line','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="psp_default_subject" id="psp_default_subject" value="<?php echo get_option('psp_default_subject'); ?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_default_message"><?php _e('Default Message','psp_projects'); ?></label>
                            </th>
                            <td>
                                <pre><textarea name="psp_default_message" id="psp_default_message" rows="10" cols="75" ><?php echo get_option('psp_default_message'); ?></textarea></pre>
                            </td>
                        </tr>
                    </table>
                </fieldset>

            </div>

            <div id="psp_advanced" class="psp-settings-tab <?php if($active_tab == 'psp_advanced') { echo "psp-settings-tab-active"; } ?>">

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th scope="row" valign="top">
                                <label for="psp_disable_js"><?php _e('Disable WYSIWYG Buttons','psp_projects'); ?></label>
                            </th>
                            <td>
                                <input type="checkbox" id="psp_disable_js" value="1" name="psp_disable_js" <?php echo get_option('psp_disable_js') === '1' ? 'checked="checked"' : null;?> >
								<label for="psp_disable_js">If you're having issues with WordPress SEO while editing pages you can try enabling this.</label>
                            </td>
                        </tr>
                    </tbody>
                </table>

			</div>

            <?php do_action('psp_settings_page'); ?>

			<?php submit_button(); ?>

		</form>
	<?php
}

function edd_panorama_register_options() {
	// creates our settings in the options table
	register_setting('edd_panorama_license', 'edd_panorama_license_key', 'edd_panorama_sanitize_license');

	// Additional options
	add_option('psp_slug','panorama');
	add_option('psp_logo');
	add_option('psp_flush_rewrites');
    add_option('psp_rewrites_flushed');
	add_option('psp_back');
	add_option( 'psp_calendar_language', 'en' );

	register_setting( 'edd_panorama_license', 'psp_slug' );
	register_setting( 'edd_panorama_license', 'psp_logo' );
	register_setting( 'edd_panorama_license', 'psp_flush_rewrites' );
    register_setting( 'edd_panorama_license', 'psp_rewrites_flushed' );
	register_setting( 'edd_panorama_license', 'psp_back');
	register_setting( 'edd_panorama_license', 'psp_calendar_language' );

    // Notifications
    register_setting( 'edd_panorama_license', 'psp_from_name');
    add_option('psp_from_name');

    register_setting( 'edd_panorama_license', 'psp_from_email');
    add_option('psp_from_email');

    register_setting( 'edd_panorama_license', 'psp_default_subject');
    add_option('psp_default_subject');

    register_setting( 'edd_panorama_license', 'psp_default_message');
    add_option('psp_default_message');

    register_setting( 'edd_panorama_license', 'psp_include_logo');
    add_option('psp_include_logo');

    // Color Styling

    // Header
    add_option('psp_header_background','#2a3542');
    add_option('psp_header_text','#aaa');
    add_option('psp_menu_background','#2a3542');
    add_option('psp_menu_text','#fff');
    add_option('psp_header_accent','#aeb2b7');

    // Body
    add_option('psp_body_background','#f1f2f7');
    add_option('psp_body_text','#333');
    add_option('psp_body_link','#000');
    add_option('psp_body_heading','#999');
    add_option('psp_footer_background','#2a3542');

	// Phases

	$options = array(
		'psp_accent_color_1' 		=> '#3299BB',
		'psp_accent_color_1_txt'	=> '#ffffff',
		'psp_accent_color_2' 		=> '#4ECDC4',
		'psp_accent_color_2_txt'	=> '#ffffff',
		'psp_accent_color_3' 		=> '#CBE86B',
		'psp_accent_color_3_txt'	=> '#ffffff',
		'psp_accent_color_4' 		=> '#FF6B6B',
		'psp_accent_color_4_txt'	=> '#ffffff',
		'psp_accent_color_5' 		=> '#C44D58',
		'psp_accent_color_5_txt'	=> '#ffffff',
		'psp_timeline_color'		=> '#99C262'
	);

	foreach($options as $option => $val) {
		register_setting('edd_panorama_license',$option);
	}

    // Custom Template
    add_option('psp_use_custom_template', '0');
    add_option('psp_custom_template', '');

    add_option('psp_open_css');

    // Register Settings
    register_setting( 'edd_panorama_license', 'psp_header_background' );
    register_setting( 'edd_panorama_license', 'psp_header_text');
    register_setting( 'edd_panorama_license', 'psp_menu_background');
    register_setting( 'edd_panorama_license', 'psp_menu_text');
    register_setting( 'edd_panorama_license', 'psp_header_accent');

    register_setting('edd_panorama_license','psp_body_background');
    register_setting('edd_panorama_license','psp_body_text');
    register_setting('edd_panorama_license','psp_body_link');
    register_setting('edd_panorama_license','psp_body_heading');
    register_setting('edd_panorama_license','psp_footer_background');

    register_setting( 'edd_panorama_license', 'psp_open_css');

    // Custom Template
    register_setting('edd_panorama_license', 'psp_use_custom_template');
    register_setting('edd_panorama_license', 'psp_custom_template');

	// Advanced
	register_setting('edd_panorama_license', 'psp_disable_js');

}

add_action('admin_init', 'edd_panorama_register_options');

function edd_panorama_sanitize_license( $new ) {
	$old = get_option( 'edd_panorama_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'edd_panorama_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

add_action('admin_init', 'psp_check_if_rewrites_flushed');
function psp_check_if_rewrites_flushed() {

    $flushed = get_option('psp_rewrites_flushed');

    if($flushed != 'yes') {
        flush_rewrite_rules();
        update_option('psp_rewrites_flushed','yes');
    }

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
			'item_name' => urlencode( EDD_PROJECT_PANORAMA ), // the name of our product in EDD
		    'url'   => home_url()
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

function psp_check_activation_response() {

    // retrieve the license from the database
    $license = trim( get_option( 'edd_panorama_license_key' ) );


    // data to send in our API request
    $api_params = array(
        'edd_action'=> 'activate_license',
        'license' 	=> $license,
        'item_name' => urlencode( EDD_PROJECT_PANORAMA ), // the name of our product in EDD
        'url'   => home_url()
    );

    // Call the custom API.
    $response = wp_remote_get( add_query_arg( $api_params, PROJECT_PANORAMA_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

    var_dump($response);

}


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
add_action( 'admin_init', 'edd_panorama_deactivate_license' );


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

add_action( 'admin_menu', 'psp_lite_support_link' );
function psp_lite_support_link() {

    global $submenu;

    $submenu[ 'edit.php?post_type=psp_projects' ][] = array( __( 'Support', 'psp_projects' ), 'read', 'https://www.projectpanorama.com/support/' );

}
