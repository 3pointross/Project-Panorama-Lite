<?php

global $post;

$id = ( !empty( $id ) ? $id : $post->ID ); ?>

		<div id="psp-essentials" class="<?php echo $style; ?> cf">

			<div id="psp-description-documents" class="psp-overview-box cf">

				<div id="psp-description">

					<div class="summary">
						<h4><?php _e('Project Description','psp_projects'); ?></h4>
						<?php the_field('project_description',$id); ?>
					</div>

				</div>

				<?php if($docs != 'none'): ?>

					<div id="psp-documents" class="<?php echo $style; ?>">

						<h4><?php _e('Documents','psp_projects'); ?></h4>

						<?php if(PSP_PLUGIN_TYPE == 'professional') {

								if(get_field('documents',$id)) {
									echo psp_documents($id);
								} else {
									echo '<p>'.__("No documents at this time.").'</p>';
								}

							} else {

								$documents_text = get_field('documents2');

								$documents_fields = get_post_meta($id,'_pano_documents');

								if((empty($documents_text)) && (empty($documents_fields))) {
									echo '<p>'.__("No documents at this time.").'</p>';
								} else {

									echo $documents_text;

									echo psp_lite_documents( $id );

								}

							}

							do_action('psp_after_documents'); ?>

						</div> <!--/#project-documents-->

				<?php endif; ?>

			</div> <!--/.psp-overview-box-->

			<div id="psp-quick-overview">

				<?php echo psp_short_progress($id); ?>

				<?php echo psp_the_timing($id); ?>

			</div>

		</div> <!--/#psp-essentials-->
