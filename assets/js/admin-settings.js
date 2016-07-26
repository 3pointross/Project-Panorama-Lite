/**
 * Custom admin settings javascript for Project Panorama
 * @author  TJ Miller <holla@sixlabs.io>
 */
;(function($) {

  var $psp_active_template_checkbox = $('.js-psp-choose-custom-template');

  $psp_active_template_checkbox.click(function(event) {
    $.event.trigger('psp_cutom_template_active', $(this));
  });

  $(document).on('psp_cutom_template_active', function(event, checkbox) {
    var $checkbox = $(checkbox);

    $active_elements_show = $('.js-psp-choose-custom-template-active-show');

    if ($checkbox.is(':checked')) {
      $active_elements_show.show();
    } else {
      $active_elements_show.hide();
    }
  }).trigger('psp_cutom_template_active', $psp_active_template_checkbox);

})(jQuery);