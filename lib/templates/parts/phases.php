<!-- Hidden admin URL so we can do Ajax -->
<input id="psp-ajax-url" type="hidden" value="<?php echo admin_url(); ?>admin-ajax.php">

<?php

        $phase_id = 0;
		$p = 0;

		if($style == 'psp-shortcode') { $wrapper_class = 'psp-shortcode-phases'; } else { $wrapper_class = 'psp-row'; } ?>

		<div class="<?php echo $wrapper_class; ?> cf psp-total-phases-<?php echo psp_get_phase_count(); ?>">

			<script>

				var chartOptions = {
					responsive: true
				}

                var allCharts = [];

			</script>

		<?php

			$i = 0; $c = 0; while(has_sub_field('phases',$id)): $i++; $c++; $p++;

				if($c == 1) {

					$color = 'blue';

					if(get_option('psp_accent_color_1')) {
						$chex = get_option('psp_accent_color_1');
					} else {
						$chex = '#3299BB';
					}

				} elseif ($c == 2) {

					$color = 'teal';

					if(get_option('psp_accent_color_2')) {
						$chex = get_option('psp_accent_color_2');
					} else {
						$chex = '#4ECDC4';
					}

				} elseif ($c == 3) {

					$color = 'green';

					if(get_option('psp_accent_color_3')) {
						$chex = get_option('psp_accent_color_3');
					} else {
						$chex = '#CBE86B';
					}

				} elseif ($c == 4) {

					$color = 'pink';

					if(get_option('psp_accent_color_4')) {
						$chex = get_option('psp_accent_color_4');
					} else {
						$chex = '#FF6B6B';
					}

				} elseif ($c == 5) {
					$color = 'maroon';

					if(get_option('psp_accent_color_5')) {
						$chex = get_option('psp_accent_color_5');
					} else {
						$chex = '#C44D58';
					}

					$c = 0;
				}

		?>
		<div class="psp-phase color-<?php echo $color; ?>" id="phase-<?php echo $i; ?>">

			<?php

            // Get an array with critical phase information

			$phase_data  = psp_get_phase_completed($id);

			$completed       = $phase_data[0];
			$tasks           = $phase_data[1];
			$completed_tasks = $phase_data[2];

			$remaining = 100 - $completed;

			?>

			<h3>
				<?php if($style != 'psp-shortcode') { echo '<i>'.$p.'.</i> '; } the_sub_field('title'); ?>
				<span class="psp-top-complete">
					<b><?php _e('Complete','psp_projects'); ?></b> <span><?php echo $completed; ?>%</span>
					<b class="psp-pl-10"><?php _e('Tasks','psp_projects'); ?></b> <span><?php echo $completed_tasks.' / '.$tasks; ?></span>
				</span>
			</h3>

					<div class="psp-phase-overview cf psp-phase-progress-<?php echo $completed; ?>">

						<div class="psp-chart">

							<span class="psp-chart-complete"><?php echo $completed; ?>%</span>

							<canvas class="phase-chart" id="chart-<?php echo $i; ?>" width="100%"></canvas>

							<script>

                                jQuery(document).ready(function() {

                                    var data = [
                                        {
                                            value: <?php echo $completed; ?>,
                                            color: "<?php echo $chex; ?>",
                                            label: "<?php _e('Completed','psp_projects'); ?>"
                                        },
                                        {
                                            value: <?php echo $remaining; ?>,
                                            color: "#efefef",
                                            label: "<?php _e('Remaining','psp_projects'); ?>"
                                        }
                                    ];


                                    var chart_<?php echo $i; ?> = document.getElementById("chart-<?php echo $i; ?>").getContext("2d");
    								// var phaseProgress_<?php echo $i; ?> = new Chart(chart_<?php echo $i; ?>).Doughnut(data,chartOptions);

                                    allCharts[<?php echo $i; ?>] = new Chart(chart_<?php echo $i; ?>).Doughnut(data,chartOptions);

                                });

							</script>

						</div>
						<div class="psp-phase-info">

							<h5><?php _e('Description','psp_projects'); ?></h5>

							<?php echo do_shortcode( get_sub_field( 'description' ) ); ?>

						</div>
					</div> <!-- tasks is '.$taskStyle.'-->

					<div class="psp-task-list-wrapper">

					<?php if((get_sub_field('tasks',$id)) && ($taskStyle != 'no')):

					$taskList = psp_populate_tasks($id,$taskStyle,$phase_id);

					if(get_sub_field('tasks',$id)) {

						if($taskStyle == 'complete') {

						  $taskbar = '<span>'.$taskList[1].' '.__('completed tasks').'</span>';

						} elseif ($taskStyle == 'incomplete') {

						  $taskbar = '<span>'.$taskList[1].' '.__('open tasks').'</span>';

						} else {

							$remaing_tasks = $tasks - $completed_tasks;
							$taskbar = '<span><b>'.$completed_tasks.'</b> '.__('of','psp_projects').' '.$tasks.' '.__('completed','psp_projects').'</span>';
						}

					} else {

						$taskbar = 'None assigned';

					}

					?>

					<h4><a href="#" class="task-list-toggle"><?php echo $taskbar; _e('Tasks','psp_projects'); ?></a></h4>

                    <ul class="psp-task-list">
                        <?php echo $taskList[0]; ?>
                    </ul>

				<?php endif; ?>
				</div>
			</div> <!--/.psp-task-list-->
			<?php $phase_id++; endwhile; ?>
		</div>
