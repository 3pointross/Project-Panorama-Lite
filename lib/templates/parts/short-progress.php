<?php
/**
 * Created by PhpStorm.
 * User: rossjohnson
 * Date: 1/3/15
 * Time: 1:18 PM
 */
?>

<div id="psp-short-progress">
	<h4><?php _e('Project Progress','psp_projects'); ?></h4>
	<p class="psp-progress"><span class="psp-<?php echo psp_compute_progress($id); ?>"><b><?php echo psp_compute_progress($id); ?>%</b></span></p>
</div>