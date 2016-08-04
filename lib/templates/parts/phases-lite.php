<!-- Hidden admin URL so we can do Ajax -->
<input id="psp-ajax-url" type="hidden" value="<?php echo admin_url(); ?>admin-ajax.php">

<?php
$phase_id   = 0;
$p          = 0;
$wrapper_class = ( $style == 'psp-shortcode' ? 'psp-shortcode-phases' : 'psp-row' ); ?>

<div class="<?php echo $wrapper_class; ?> cf psp-total-phases-<?php echo psp_get_phase_count(); ?>">

	<script>

		var chartOptions = {
			responsive: true,
            percentageInnerCutout : 80
		}

        var allCharts = [];

	</script>

	<?php
	$phases = get_post_meta( $id, '_pano_phases', true );

	if( !empty( $phases ) ):

		$i = 0; $c = 0; foreach($phases as $phase): $i++; $c++; $p++;

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

        $completed = ( isset( $phase[ 'percentage_complete' ] ) ? $phase[ 'percentage_complete' ] : 0 );
        $remaining = 100 - $completed; ?>

		<div class="psp-phase color-<?php echo esc_attr( $color ); ?> psp-phase-progress-<?php echo esc_attr( $completed ); ?>" id="phase-<?php echo $i; ?>">

			<h3>
				<?php if($style != 'psp-shortcode') { echo '<i>'.$p.'.</i> '; } echo $phase['title']; ?>
				<span class="psp-top-complete">
					<b><?php _e('Complete','psp_projects'); ?></b> <span><?php echo $completed; ?>%</span>
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

					<?php echo $phase['description']; ?>

				</div>
			</div> <!-- tasks is '.$taskStyle.'-->

		</div> <!--/.psp-task-list-->

        <?php $phase_id++; endforeach; ?>

    <?php endif; ?>

</div>
