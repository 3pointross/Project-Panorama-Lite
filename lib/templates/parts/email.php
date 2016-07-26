        <div style="background:#f1f2f7; padding: 30px;">
            <div style="background:#fff; padding: 4%; border-radius: 12px; font-family: 'Arial','Helvetica','San-Serif'; width: 92%; max-width: 640px; margin: 0 auto;">

                <?php if($logo) { ?>
                    <img src="<?php echo $logo; ?>" style="display: block; max-width: 200px; text-align: center; height: auto; margin: 0 auto 30px auto;" alt="">
                <?php } ?>

                <?php if($user->first_name) { echo '<p>'.__('Hello','psp_projects').' '.$user->first_name.'</p>'; } ?>

                <p><?php echo wpautop($message); ?></p>

                <?php if(!empty($progress)) { ?>
                    <p style="text-align: center; text-transform: uppercase; font-size: 12px; color: #444; font-weight: bold; margin-top: 40px;"><?php _e('Current Status','psp_projects'); ?></p>
                    <div style="background: #f1f1f1; margin: 20px 0; height: 30px;">
                        <?php if($progress >= 10) { ?>
                            <div style="height: 30px;width: <?php echo $progress; ?>%; background: #3299bb"><div style="color: #fff; line-height: 30px; text-align: right; padding-right: 10px;"><?php echo $progress; ?>%</div></div>
                        <?php } else { ?>
                            <div style="height: 30px;width: <?php echo $progress; ?>%; background: #3299bb; display: inline-block"></div><div style="color: #666; display: inline-block; margin-left: 10px; font-weight: bold;"><?php echo $progress; ?>%</div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <p style="padding-top: 30px; margin-top: 30px; border-top: 1px solid #efefef; text-align: center;"><a href="<?php echo get_permalink($post_id); ?>" style="font-weight: bold; color: #0074a2; text-align: center; padding: 10px 25px; border: 1px solid #0074a2; border-radius: 3px; display: inline-block; text-decoration: none;"><?php _e('Click here to view.','psp_projects'); ?></a></p>

            </div>
        </div>