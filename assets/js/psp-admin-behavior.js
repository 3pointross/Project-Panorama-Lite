jQuery(function() {


	// Initialize special fields if they exist
	
	if(jQuery('.datepicker').length) { jQuery(".datepicker").datepicker(); }

	if(jQuery('.color-field').length) { jQuery('.color-field').wpColorPicker(); }
	
	
	// Deal with the task rows
			
        jQuery(".task-row :checked").each(function() {
            jQuery(this).parent().parent().addClass('completed');
            jQuery(this).addClass('completed');
        });
		
        jQuery(".task-row :checkbox").change(function() {
            if(jQuery(this).hasClass('completed')) {
                jQuery(this).removeClass('completed');
                jQuery(this).parent().parent().removeClass('completed');
            } else {
                jQuery(this).parent().parent().addClass('completed');
                jQuery(this).addClass('completed');
            }
        });		


		var psp_uploader;

        jQuery('#psp_upload_image_button').click(function(e) {
 
		        e.preventDefault();
 
		        //If the uploader object has already been created, reopen the dialog
		        if (psp_uploader) {
		            psp_uploader.open();
		            return;
		        }
  
		        //Extend the wp.media object
		        psp_uploader = wp.media.frames.file_frame = wp.media({
		            title: 'Choose Image',
		            button: {
		                text: 'Choose Image'
		            },
		            multiple: false
		        });
				

		        //When a file is selected, grab the URL and set it as the text field's value
		        psp_uploader.on('select', function() {
		            attachment = psp_uploader.state().get('selection').first().toJSON();
		            jQuery('#psp_logo').val(attachment.url);
		        });
 
		        //Open the uploader dialog
		        psp_uploader.open();
 
		    });
			
			// Reset the colors to default
        	jQuery('.psp-reset-colors').click(function() {

           		jQuery('.psp-color-table input.color-field').each(function() {

                	default_color = jQuery(this).attr('rel');
                	jQuery(this).wpColorPicker('color',default_color);

           	 	});

            return false;

        });

        if(jQuery('#psp-notify-users').length) {

            if(jQuery('#psp-notify-users').prop('checked')) {
                jQuery('.psp-notification-edit').show();
            }

            jQuery('#psp-notify-users').change(function() {

                if(jQuery(this).prop('checked')) {
                    tb_show('Notify Users','#TB_inline?width=480&inlineId=psp-notification-modal&width=640&height=640');
                }

            });

        }

        jQuery('.psp-notification-help').click(function() {

            tb_show('Notificiation Help','#TB_inline?width=480&inlineId=psp-notification-modal&width=640&height=640');

        });

        jQuery('.psp-notification-edit').click(function() {

            tb_show('Notify Users','#TB_inline?width=480&inlineId=psp-notification-modal&width=640&height=640');

        });

        jQuery('.psp-notify-ok').click(function() {

            pspSetNotifications();
            tb_remove();
            return false;

        });

        jQuery('.all-checkbox').change(function() {

            if(jQuery(this).prop('checked')) {
                jQuery('.psp-notify-list input').prop('checked',true);
            } else {
                jQuery('.psp-notify-list input').prop('checked',false);
            }

        });

        jQuery('#acf-allowed_users .acf-button').click(function() {

            pspShowNotifyWarning();

        });

        jQuery('#acf-allowed_users select.user').change(function() {

            pspShowNotifyWarning();

        });

});  

function pspShowNotifyWarning() {
    jQuery('.psp-notify-warning').show();
}

function pspSetNotifications() {

    var psp_notification_list = jQuery('.psp-notify-user-box:checkbox:checked');

    if(psp_notification_list.length) {

        jQuery('.psp-notification-edit').show();


    } else {

        jQuery('.psp-notification-edit').hide();
        jQuery('#psp-notify-users').prop('checked',false);

    }

}
