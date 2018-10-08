jQuery(document).ready(function($) {
	
	if((jQuery('body.psp-standalone-page').length) && (history.length >= 1)) {
		
		jQuery('#nav-back').show();
		
	}
	
	if($('#psp-task-style').val() == 'Yes') { 
        $('.task-list-toggle').unbind().addClass('notoggle').click(function() { return false; });
	} else { 
        $('.psp-task-list').hide();	
	}

   $('#nav-menu a').smoothScroll(); 
   
   jQuery('#nav-menu a').hover(function() { 
    	jQuery(this).addClass('active');  
	}, function() { 
    	jQuery(this).removeClass('active'); 
    });
	
	if(jQuery('#wpadminbar').length) { 
		jQuery('#psp-title').animate({ top : "32px"},250);
	}

	if($('.psp-theme-template').length) { 
	
		var container_width = $('.psp-theme-template').width();
		
		if(container_width > 1200) {
			$('.psp-theme-template').addClass('psp-width-full');
		} else if (container_width > 960) { 
			$('.psp-theme-template').addClass('psp-width-960');
		} else {
			$('.psp-theme-template').addClass('psp-width-single');
		} 
	
	}

    jQuery('.task-list-toggle').click(function() {

        target = jQuery(this).parent().siblings('ul.psp-task-list');

        if(jQuery(target).hasClass('active')) {
            jQuery(target).slideUp('medium');
            jQuery(target).removeClass('active');
            jQuery(this).removeClass('active');
        } else {
            jQuery(target).slideDown('medium');
            jQuery(target).addClass('active');
            jQuery(this).addClass('active');
        }

        return false;

    });

	if($('.psp-notify-list li.all-line').length) {
		
		$('li.all-line input').click(function() { 
		
			if($(this).is(':checked')) {
				$(this).parents('ul.psp-notify-list').children('li').children('input').prop('checked',true);
			} else { 
				$(this).parents('ul.psp-notify-list').children('li').children('input').prop('checked',false);
			}
		
		});
	}

    $(".doc-status").leanModal({ closeButton: ".modal-close" });
	
	$('.doc-status').click(function() { 
		
		target = $(this).val();
		$(target + '.psp-document-form').show();
		$(target + '.psp-message-form').hide();
		$(target + '.psp-confirm-note').hide();
		$(target + '.modal-close').html('Cancel');
	
	});

    $('.document-update-form').submit(function(event) {

        event.preventDefault();

        // Gather data to submit
        var project_id = $(this).children('input[name=psp-project-id]').val();
        var doc_id = $(this).children('input[name=psp-document-id]').val();
        var filename = $(this).children('input[name=psp-document-name]').val();
        var editor = $(this).children('input[name=psp-current-user]').val();

        var status = $('#psp-pro-'+project_id+'-doc-'+doc_id).val();
		var status_label = $('#psp-pro-'+project_id+'-doc-'+doc_id+' option:selected').text();
        var message = $('#psp-du-doc-'+doc_id+' textarea[name=psp-doc-message]').val();


        // Build the notification list
        var users = [];

        $('#psp-du-doc-'+doc_id+' input.psp-notify-user-box:checked').each(function() {
            users.push($(this).val());
        });

		var ajaxurl = $('#psp-ajax-url').val();

        // var ajaxurl = 'http://'+window.location.host+'/wp-admin/admin-ajax.php';

        $.ajax({
            url: ajaxurl + "?action=psp_update_doc_fe",
            type: 'post',
            data: {
                project_id : project_id,
                doc_id: doc_id,
                status : status,
                users : users,
                message : message,
                filename : filename,
                editor : editor
            },
            success: function(data) {

                $('#psp-project-'+project_id+'-doc-'+doc_id+' a.doc-status').removeClass().addClass('doc-status').addClass('status-'+status).html(status_label+' <span class="fa fa-pencil" href="#"></span>');
                
				$('#psp-du-doc-'+doc_id+' .psp-document-form').fadeOut();
				$('#psp-du-doc-'+doc_id+' .psp-message-form').fadeIn();
				
				if(users.length) { 
					$('#psp-du-doc-'+doc_id+' .psp-confirm-note').fadeIn();
				}
				
				$('#psp-du-doc-'+doc_id+' .modal-close').html('Done');
				
				// $('#psp-du-doc-'+doc_id).fadeOut();
                // $('#lean_overlay').fadeOut();

            },
            error: function(data) {
                console.log(data);
            }
        });

    });

    $('.complete-task-link').click(function() {

        var formID = $(this).attr('data-target');

        var projectID = $(this).parent().parent().children('#edit-task-'+formID).children('form').children('input[name=psp-project-id]').val();
        var phaseID = $(this).parent().parent().children('#edit-task-'+formID).children('form').children('input[name=psp-phase-id]').val();
        var taskID = $(this).parent().parent().children('#edit-task-'+formID).children('form').children('input[name=psp-task-id]').val();
        var phase_progress = $(this).parent().parent().children('#edit-task-'+formID).children('form').children('input[name=psp-phase-auto]').val();
        var total_progress = $(this).parent().parent().children('#edit-task-'+formID).children('form').children('input[name=psp-overall-auto]').val();
        var progress = 100;

		var ajaxurl = $('#psp-ajax-url').val();

        $.ajax({
            url: ajaxurl + "?action=psp_update_task_fe",
            type: 'post',
            data: {
                project_id : projectID,
                phase_id: phaseID,
                task_id: taskID,
                progress: progress
            },
            success: function(data) {

		        if(total_progress == 'Yes') {
		            psp_update_total_progress(projectID);
		        }

            },
            error: function(data) {
                console.log(data);
            }
        });

        var the_parent = $(this).parents('li.task-item-'+taskID);
        target = $(the_parent).children('span').children('em');

        if(progress == '100') { $(the_parent).addClass('complete'); } else { $(the_parent).removeClass('complete'); }

        $(target).removeClass();
        $(target).addClass('status');
        $(target).addClass('psp-' + progress);

        $(the_parent).attr('data-progress',progress);

        if(phase_progress == 'Yes') {
            psp_update_phase_completion(projectID,phaseID);
        }

        return false;


    });

    $('.task-update-form').submit(function(event) {
		
        event.preventDefault();

        var projectID = $(this).children('input[name=psp-project-id]').val();
        var phaseID = $(this).children('input[name=psp-phase-id]').val();
        var taskID = $(this).children('input[name=psp-task-id]').val();
        var progress = $(this).children('select').val();
        var parentDiv = $(this).parents('.task-select');
		
		var phase_progress = $(this).children('input[name=psp-phase-auto]').val();
		var total_progress = $(this).children('input[name=psp-overall-auto]').val();

		var ajaxurl = $('#psp-ajax-url').val();
		
        $.ajax({
            url: ajaxurl + "?action=psp_update_task_fe",
            type: 'post',
            data: {
                project_id : projectID,
                phase_id: phaseID,
                task_id: taskID,
                progress: progress
            },
            success: function(data) {
                
				$(parentDiv).slideUp('slow');
		        
				if(total_progress == 'Yes') {
					psp_update_total_progress(projectID);
				}
				
            },
            error: function(data) {
                console.log(data);
            }
        });

        the_parent = $(this).parents('li.task-item-'+taskID);
        target = $(the_parent).children('span').children('em');

        $(target).removeClass();
        $(target).addClass('status');
        $(target).addClass('psp-' + progress);

        $(the_parent).attr('data-progress',progress);

        if(progress == '100') { $(the_parent).addClass('complete'); } else { $(the_parent).removeClass('complete'); }

        if(phase_progress == 'Yes') {
            psp_update_phase_completion(projectID,phaseID);
        }

    });


    function psp_toggle_marker(progress,milestone) {

            if(progress >= milestone) {
                $('.psp-'+milestone+'-milestone').addClass('completed');
            } else {
                $('.psp-'+milestone+'-milestone').removeClass('completed');
            }
    }

    function psp_update_total_progress(projectID) {

		var ajaxurl = $('#psp-ajax-url').val();

        $.ajax({
            url: ajaxurl + "?action=psp_update_total_fe",
            type: 'post',
            data: {
                project_id : projectID,
            },
            success: function(new_progress) {

                $('.psp-progress span').removeClass();
                $('.psp-progress span').addClass('psp-' + new_progress);
                $('.psp-progress span').html('<b>' + new_progress + '%</b>');

                var milestones = [20,25,40,50,60,75,80];

                for(m = 0; m < milestones.length; m++) {
                    psp_toggle_marker(new_progress,milestones[m]);
                }

            },
            error: function(data) {
                console.log(data);
            }
        });

    }

    function psp_update_phase_completion(projectID,phaseID) {

        var tasks = 0;
        var task_completion = 0;
        var tasks_completed = 0;

		phaseID++;

        $('#phase-'+phaseID+' ul.psp-task-list li').each(function() {

            var task_status = $(this).attr('data-progress');
            task_status = parseInt(task_status);
            task_completion = task_completion + task_status;
            tasks++;
            if(task_status == 100) { tasks_completed++; }

        });

        completion = Math.ceil(task_completion / tasks);
        remaining = 100 - completion;

        allCharts[phaseID].segments[0].value = completion;
        allCharts[phaseID].segments[1].value = remaining;
        allCharts[phaseID].update();

        $('#phase-'+phaseID+' .psp-chart-complete').html(completion + '%');
        $('#phase-'+phaseID+' .task-list-toggle span b').html(tasks_completed);
        $('#phase-'+phaseID+' .psp-top-complete span').html(completion + '%');
		$('#phase-'+phaseID+' .psp-phase-overview').removeClass().addClass('psp-phase-overview cf psp-phase-progress-' + completion);

	    if($(window).width() > 768) {
			$('.psp-phase-info').css('height','auto');
	        pspEqualHeight($(".psp-phase-info"));
	    }

    }

    $('.task-edit-link').click(function() {

        var the_parent = $(this).parents('li.task-item');
        $(the_parent).children('.task-select').slideDown('slow');

        return false;

    });

    if($(window).width() > 768) {
        pspEqualHeight($(".psp-phase-info"));
    }
	
	if((jQuery('body.psp-standalone-page').length) && (history.length >= 1)) {
		
		jQuery('#nav-back').show();
		
	}
	
	$('.psp-tpt-toggle').click(function(e) { 
	
		e.preventDefault();
	
		if($(this).hasClass('psp-task-toggle-closed')) { 
		
			$(this).removeClass('psp-task-toggle-closed');
			$(this).parent().addClass('psp-open');
			
			$(this).parent().siblings('.psp-task-content').slideDown('slow');
		
		} else { 
		
			$(this).addClass('psp-task-toggle-closed');
			$(this).parent().removeClass('psp-open');
			
			$(this).parent().siblings('.psp-task-content').slideUp('slow');
		
		}
	
	});
	
	/* Table Pagination */
	
	$('table.psp-table-pagination').each(function() {
	    var currentPage = 0;
	    var numPerPage = 5;
	    var $table = $(this);
	    $table.bind('repaginate', function() {
	        $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
	    });
	    $table.trigger('repaginate');
	    var numRows = $table.find('tbody tr').length;
	    var numPages = Math.ceil(numRows / numPerPage);
	    var $pager = $('<div class="psp-pager">More</div>');
	    for (var page = 0; page < numPages; page++) {
	        $('<span class="psp-page-number"></span>').text(page + 1).bind('click', {
	            newPage: page
	        }, function(event) {
	            currentPage = event.data['newPage'];
	            $table.trigger('repaginate');
	            $(this).addClass('active').siblings().removeClass('active');
	        }).appendTo($pager).addClass('clickable');
	    }
	    $pager.insertAfter($table).find('span.page-number:first').addClass('active');
		
		$('.psp-page-number:first-child').addClass('active');
		
	});
	
	/* Document Pagination & Search */
	
	if($('.psp-documents-row > li').length > 5) { 
				
	    var currentPage = 0;
	    var numPerPage = 5;
	    var $table = $('.psp-documents-row');
	    $table.bind('repaginate', function() {
	        $table.find('li.list-item').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
	    });
	    $table.trigger('repaginate');
	    var numRows = $table.find('li.list-item').length;
	    var numPages = Math.ceil(numRows / numPerPage);
	    var $pager = $('<div class="psp-pager"></div>');
	    for (var page = 0; page < numPages; page++) {
	        $('<span class="psp-page-number col-md-6"></span>').text(page + 1).bind('click', {
	            newPage: page
	        }, function(event) {
	            currentPage = event.data['newPage'];
	            $table.trigger('repaginate');
	            $(this).addClass('active').siblings().removeClass('active');
	        }).appendTo($pager).addClass('clickable');
	    }
	    $('#psp-document-nav').append($pager).find('span.page-number:first').addClass('active');
		
		$('.psp-page-number:first-child').addClass('active');	
		
	    $('#psp-documents-live-search').fastLiveFilter('.psp-documents-row');
		
		$('#psp-documents-live-search').change(function() { 
			if($(this).val().length < 3) {
				$table.trigger('repaginate');
				$('.psp-pager').show();
			} else { 
				$('.psp-pager').hide();
			}
		});
		
	}
	

	
	
});

function pspEqualHeight(group) {

    tallest = 0;
	smallest = 100000;
    group.each(function() {
        thisHeight = jQuery(this).height();
        if(thisHeight > tallest) {
            tallest = thisHeight;
        }
		if(thisHeight < smallest) {
			smallest = thisHeight;
		}
    });

	difference = tallest - smallest;

	if(difference <= 450) { 
		group.height(tallest);
	}
}

// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = jQuery('#psp-title').outerHeight();

jQuery(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = jQuery(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        jQuery('#psp-title').animate({ top : "-75px"},250);
        
    } else {
        // Scroll Up
        if(st + jQuery(window).height() < jQuery(document).height()) {
			if(jQuery('#wpadminbar').length) { 
				jQuery('#psp-title').animate({ top : "32px"},250);
			} else { 
				jQuery('#psp-title').animate({ top : "0px"},250);
        	}
		}
    }
    
    lastScrollTop = st;
}
/*
jQuery(window).load(function() { Pizza.init(document.body, {donut: true}); });
    */