/**
 * Load dependent libraries.
 */
(function ($) {
  $('.details-wysi').wysihtml5({
    "stylesheets": []
  });
  if (typeof datetimepicker == 'function') {
    $('#datetimepicker6').datetimepicker();
  }
}(jQuery));
