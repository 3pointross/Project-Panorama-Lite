<?php
$i = 0;
global $post;
$id = ( isset( $id ) ? $id : $post->ID ); ?>

<div id="psp-documents-list">

	<div id="psp-document-nav">
		<input id="psp-documents-live-search" type="text" placeholder="Search..." class="psp-col-md-6">
	</div>

	<ul class="psp-documents-row list">

        <?php

		$documents = get_post_meta($id,'_pano_documents',true);

		if(!empty($documents)) {

			foreach($documents as $doc):

				if(isset($doc['file'])) { $file = $doc['file']; }
				if(isset($doc['link'])) { $url = $doc['link']; }

				// Check to see if there is a file, if not, use the manually entered URL

				if(!empty($file)) {
					$doc_link = $doc['file'];
				} else {
					$doc_link = $url;
				}

				$icon = psp_get_icon_class($doc_link);

				$doc_status = psp_translate_doc_status($doc['status']);

				?>

				<li id="psp-project-<?php echo $post_id; ?>-doc-<?php echo $i; ?>" class="list-item">

						<a href="<?php echo $doc_link; ?>" class="psp-icon <?php echo $icon; ?>"></a>
				    	<p class="psp-doc-title">
							<a href="<?php echo $doc_link; ?>" target="_new"><strong class="doc-title"><?php echo $doc['title']; ?></strong></a>
					    	<a class="doc-status status-<?php echo $doc['status']; ?>" href="#psp-du-doc-<?php echo $i; ?>"><?php echo $doc_status; ?></a>
					    		<span class="description"><?php echo $doc['description']; ?></span>
				    	</p>

				</li>

			<?php $i++; endforeach; ?>
		<?php } ?>
	</ul>
</div>
