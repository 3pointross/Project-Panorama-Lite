	
	function PopulatePspSingleShortcode() {
	
		jQuery('.psp-loading').show();
	
		data = { action: 'psp_get_projects' }
	
		jQuery.post(ajaxurl, data, function (response) { 
	
			response = response.slice(0,-1);
			
			jQuery('#psp-single-project-list').html(response);
			jQuery('.psp-loading').hide();
	
		});
	}

	function InsertPspProject() { 

		pspId = jQuery('#psp-single-project-id').val();
		pspStyle = jQuery('input[name="psp-display-style"]:checked').val();

		if(pspStyle == 'full') {
	
			pspOverview = jQuery('#psp-single-overview').val();
        		if(pspOverview.length) { pspOverviewAtt = 'overview="'+pspOverview+'"'; }

			pspMilestones = jQuery('#psp-single-milestones').val();
		    	if(pspMilestones.length) { pspMilestonesAtt = 'milestones="'+pspMilestones+'"'; }
				
        	pspPhases = jQuery('#psp-single-phases').val();
            	if(pspPhases.length) { pspPhasesAtt = 'phases="'+pspPhases+'"'; }
				
				
        	pspProgress = jQuery('#psp-single-progress').val();
            	if(pspProgress.length) { pspProgressAtt = 'progress="'+pspProgress+'"'; }
	
    		shortcode = '[project_status id="'+pspId+'" '+pspProgressAtt+' '+pspOverviewAtt+' '+pspMilestonesAtt+' '+pspPhasesAtt+' ]';
		
		} else { 
	
			pspPart = jQuery('#psp-part-display').val();
		
			if(pspPart == 'overview') { 
		
	    		shortcode = '[project_status_part id="'+pspId+'" display="overview"]';
			
			} else if (pspPart == 'documents') {
			
				shortcode = '[project_status_part id="'+pspId+'" display="documents"]';
			
			} else if (pspPart == 'progress') {
			
				pspPartStyle = jQuery('#psp-part-overview-progress-select').val();
				shortcode = '[project_status_part id="'+pspId+'" display="progress" style="'+pspPartStyle+'"]';
			
			} else if (pspPart == 'phases') {
			
				pspPartStyle = jQuery('#psp-part-phases-select').val();
				shortcode = '[project_status_part id="'+pspId+'" display="phases"]';
			
			} else if (pspPart == 'tasks') {
				
				pspPartStyle = jQuery('#psp-part-tasks-select').val();
				shortcode = '[project_status_part id="'+pspId+'" display="tasks" style="'+pspPartStyle+'"]';
			}
	
		}
	
		tinymce.activeEditor.execCommand('mceInsertContent', false, shortcode);

		tb_remove(); return false;

	}

	function InsertPspProjectList() { 

		pspListTax = jQuery('#psp-project-taxonomy').val();
		pspListStatus = jQuery('#psp-project-status').val();
    	pspUserAccess = jQuery('#psp-user-access').val();
    	pspCount = jQuery('#psp-project-count').val();
		pspSort = jQuery('#psp-project-sort').val();

    	if(pspUserAccess == 'on') {
    		pspAccess = 'user';
    	} else {
    		pspAccess = 'all';
    	}
	
		shortcode = '[project_list type="'+pspListTax+'" status="'+pspListStatus+'" count="'+pspCount+'" sort="'+pspSort+'" ]';
	
		tinymce.activeEditor.execCommand('mceInsertContent', false, shortcode);
	
		tb_remove(); return false;

	}
	
