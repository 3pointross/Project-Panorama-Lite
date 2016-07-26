<?php

function psp_the_start_date($id) {

    $months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

    $startDate = get_field('start_date',$id);

    $s_year = substr($startDate,0,4);
    $s_month = substr($startDate,4,2);
    $s_day = substr($startDate,6,2);

	if(!empty($startDate)):

    ?>

    <div class="psp-date">
        <span class="cal">
            <span class="month"><?php echo $months[$s_month - 1]; ?></span>
            <span class="day"><?php echo $s_day; ?></span>
        </span>
        <b><?php echo $s_year; ?></b>
    </div>

    <?php
	endif;

}

function psp_the_end_date($id) {

    $months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

    $endDate = get_field('end_date',$id);

	if(!empty($endDate)):

    $e_year = substr($endDate,0,4);
    $e_month = substr($endDate,4,2);
    $e_day = substr($endDate,6,2); ?>
	
    <div class="psp-date">
        <span class="cal">
	        <span class="month"><?php echo $months[$e_month - 1]; ?></span>
		    <span class="day"><?php echo $e_day; ?></span>
    	</span>
        <b><?php echo $e_year; ?></b>
    </div>

    <?php
	endif;

}

function psp_text_date($date) { 
	
    $year = substr($date,0,4);
    $month = substr($date,4,2);
    $day = substr($date,6,2);
	
    return $month.'/'.$day.'/'.$year;
	
}

function psp_the_timebar($id) { 

    $startDate = get_field('start_date',$id);
    $endDate = get_field('end_date',$id);
	
    $s_year = substr($startDate,0,4);
    $s_month = substr($startDate,4,2);
    $s_day = substr($startDate,6,2);

    $e_year = substr($endDate,0,4);
    $e_month = substr($endDate,4,2);
    $e_day = substr($endDate,6,2);

    $textStartDate = psp_text_date($startDate);
    $textEndDate = psp_text_date($endDate);


    if((empty($startDate)) || (empty($endDate))) { return; }

    global $post;
    $all_time = psp_calculate_timing($id);

    if($all_time[0] < 0 ) {
        $all_time[0] = 100;
    }

    $psp_tt_10 = $all_time[0] >= 10 ? 'active' : null;
    $psp_tt_20 = $all_time[0] >= 20 ? 'active' : null;
    $psp_tt_30 = $all_time[0] >= 30 ? 'active' : null;
    $psp_tt_40 = $all_time[0] >= 40 ? 'active' : null;
    $psp_tt_50 = $all_time[0] >= 50 ? 'active' : null;
    $psp_tt_60 = $all_time[0] >= 60 ? 'active' : null;
    $psp_tt_70 = $all_time[0] >= 70 ? 'active' : null;
    $psp_tt_80 = $all_time[0] >= 80 ? 'active' : null;
    $psp_tt_90 = $all_time[0] >= 90 ? 'active' : null;
?>
	 	<div class="psp-timebar">
			
		 <?php
		 if($all_time[2] > $all_time[1]) {
		 	$days_left = '<span class="psp-time-details">'.$all_time[2].__('days past project end date.','psp_projects').'</span>';
	   	 } else {
		 	$days_left = '<span class="psp-time-details">'.$all_time[2].__(' days remaining','psp_projects').'</span>';
	 	 } ?>

    		 <p class="psp-time-start-end"><?php echo $textStartDate; ?> <span><?php echo $textEndDate; ?></span></p>

    		 <div class="psp-time-progress">

       		  	<p class="psp-time-bar"><span class="psp-<?php echo $all_time[0]; ?>"></span></p>

      			<ol class="psp-time-ticks">
          			<li class="psp-tt-10 <?php echo $psp_tt_10; ?>"></li>
            		<li class="psp-tt-20 <?php echo $psp_tt_20; ?>"></li>
            		<li class="psp-tt-30 <?php echo $psp_tt_30; ?>"></li>
            		<li class="psp-tt-40 <?php echo $psp_tt_40; ?>"></li>
            		<li class="psp-tt-50 <?php echo $psp_tt_50; ?>"></li>
            		<li class="psp-tt-60 <?php echo $psp_tt_60; ?>"></li>
            		<li class="psp-tt-70 <?php echo $psp_tt_70; ?>"></li>
            		<li class="psp-tt-80 <?php echo $psp_tt_80; ?>"></li>
            		<li class="psp-tt-90 <?php echo $psp_tt_90; ?>"></li>
        		</ol>

        		<span class="psp-time-indicator" style="left: <?php echo $all_time[0]; ?>%"><span></span><?php echo $all_time[0]; ?>%</span>

   	 	  </div> <!--/.psp-time-progress-->

	</div> <!--/.psp-timebar-->
	
	<?php 

}

function psp_the_timing($id) {

    $startDate = get_field('start_date',$id);
    $endDate = get_field('end_date',$id);
	
    $s_year = substr($startDate,0,4);
    $s_month = substr($startDate,4,2);
    $s_day = substr($startDate,6,2);

    $e_year = substr($endDate,0,4);
    $e_month = substr($endDate,4,2);
    $e_day = substr($endDate,6,2);

    $textStartDate = $s_month.'/'.$s_day.'/'.$s_year;
    $textEndDate = $e_month.'/'.$e_day.'/'.$e_year;


    if((empty($startDate)) || (empty($endDate))) { return; }

    global $post;
    $all_time = psp_calculate_timing($id);

    if($all_time[0] < 0 ) {
        $all_time[0] = 100;
    }

    $psp_tt_10 = $all_time[0] >= 10 ? 'active' : null;
    $psp_tt_20 = $all_time[0] >= 20 ? 'active' : null;
    $psp_tt_30 = $all_time[0] >= 30 ? 'active' : null;
    $psp_tt_40 = $all_time[0] >= 40 ? 'active' : null;
    $psp_tt_50 = $all_time[0] >= 50 ? 'active' : null;
    $psp_tt_60 = $all_time[0] >= 60 ? 'active' : null;
    $psp_tt_70 = $all_time[0] >= 70 ? 'active' : null;
    $psp_tt_80 = $all_time[0] >= 80 ? 'active' : null;
    $psp_tt_90 = $all_time[0] >= 90 ? 'active' : null;
?>


    <div id="psp-time-overview">

        <div class="project-timing cf">

            <?php

            if (($startDate) || ($endDate)): ?>

                <h4><?php _e('Project Timing','psp_projects'); ?></h4>

                <ul class="psp-timing cf">
                    <?php if($startDate): ?>
                        <li><strong><?php _e('Start','psp_projects'); ?></strong>
                            <?php psp_the_start_date($id); ?>
                        </li>
                    <?php endif;
                    if($endDate): ?>
                        <li><strong><?php _e('End','psp_projects'); ?></strong>
							<?php psp_the_end_date($id); ?>
                        </li>
                    <?php endif; ?>
                </ul>


				<?php if(($startDate) && ($endDate)): ?>

       		 	<div class="psp-timebar">
					
   				 <?php
    			 if($all_time[2] > $all_time[1]) {
      			 	$days_left = '<span class="psp-time-details">'.$all_time[2].__('days past project end date.','psp_projects').'</span>';
    		   	 } else {
      			 	$days_left = '<span class="psp-time-details">'.$all_time[2].__(' days remaining','psp_projects').'</span>';
    		 	 } ?>

            		 <p class="psp-time-start-end"><?php echo $textStartDate; ?> <span><?php echo $textEndDate; ?></span></p>

            		 <div class="psp-time-progress">

               		  	<p class="psp-time-bar"><span class="psp-<?php echo $all_time[0]; ?>"></span></p>

              			<ol class="psp-time-ticks">
                  			<li class="psp-tt-10 <?php echo $psp_tt_10; ?>"></li>
                    		<li class="psp-tt-20 <?php echo $psp_tt_20; ?>"></li>
                    		<li class="psp-tt-30 <?php echo $psp_tt_30; ?>"></li>
                    		<li class="psp-tt-40 <?php echo $psp_tt_40; ?>"></li>
                    		<li class="psp-tt-50 <?php echo $psp_tt_50; ?>"></li>
                    		<li class="psp-tt-60 <?php echo $psp_tt_60; ?>"></li>
                    		<li class="psp-tt-70 <?php echo $psp_tt_70; ?>"></li>
                    		<li class="psp-tt-80 <?php echo $psp_tt_80; ?>"></li>
                    		<li class="psp-tt-90 <?php echo $psp_tt_90; ?>"></li>
                		</ol>

                		<span class="psp-time-indicator" style="left: <?php echo $all_time[0]; ?>%"><span></span><?php echo $all_time[0]; ?>%</span>

           	 	  </div> <!--/.psp-time-progress-->

    		</div> <!--/.psp-timebar-->
			<?php endif; // if start and end date ?>
			
	  <?php endif; // if start or end date ?>
	  </div> <!--/.project-timing-->
    <?php
}

function psp_calculate_timing($post_id) {

    if(empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }

    $startDate = get_field('start_date',$post_id);
    $endDate = get_field('end_date',$post_id);

    $today = time();
    $s_year = substr($startDate,0,4);
    $s_month = substr($startDate,4,2);
    $s_day = substr($startDate,6,2);

    $e_year = substr($endDate,0,4);
    $e_month = substr($endDate,4,2);
    $e_day = substr($endDate,6,2);

    $startDate = strtotime($s_year.'-'.$s_month.'-'.$s_day);
    $endDate = strtotime($e_year.'-'.$e_month.'-'.$e_day);

    $total_days = abs($startDate - $endDate);
    $total_days = floor($total_days/(60*60*24));

    $datediff = abs($today - $endDate);

    $time_completed = floor($datediff/(60*60*24));

	if($startDate > $today) {

        $time_percentage = 0;

    } elseif($endDate < $today) {

        $time_percentage = 100;

    } elseif($total_days == 0) {

		$time_percentage = 100;

	} else {

	    $time_percentage = floor(100 - ($time_completed / $total_days * 100));

	}

    $all_time = array($time_percentage,$total_days,$time_completed);

    return $all_time;

}

function psp_verbal_status($all_time,$calc_completed) {

    if($all_time[0] > $calc_completed) { return 'behind'; } else { return 'time'; }

}

function psp_the_timing_bar($post_id) {

    $time_elapsed = psp_calculate_timing($post_id);
    $completed = psp_compute_progress($post_id);

    if($completed < $time_elapsed[0]) {
        $progress_class = 'psp-behind';
    } else {
        $progress_class = 'psp-ontime';
    }

    if($time_elapsed[0] < 0 ) {
        $time_elapsed[0] = 100;
    }

    echo '<p class="psp-timing-progress psp-progress '.$progress_class.'"><span class="psp-'.$time_elapsed[0].'"><strong>%'.$time_elapsed[0].'</strong></span></p>';

}
