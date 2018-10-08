jQuery(document).ready(function($) {

    psp_lite_update_phase_status_visibility();
    $('#acf-field-phases_automatic_progress').click(function() {
        psp_lite_update_phase_status_visibility();
    });

    function psp_lite_update_phase_status_visibility() {

        var automatic_phase_progress = $('#acf-field-phases_automatic_progress').prop( 'checked' );

        if( automatic_phase_progress ) {
            $('div.phase-percentage-complete').hide();
        } else {
            $('div.phase-percentage-complete').show();
        }

    }

});
