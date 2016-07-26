<?php 
/* Custom functions for PSP Lite */

function psp_lite_documents($post_id) { 
	
	ob_start();

	include(psp_template_hierarchy('/parts/documents-lite.php'));
		
	return ob_get_clean();


}

?>