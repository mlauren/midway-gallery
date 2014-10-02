/**
 * Load dependent libraries.
 */
(function ($) {
  $('#details').wysihtml5({
    "stylesheets": []
  });
  if (typeof datetimepicker == 'function') {
    $('#datetimepicker6').datetimepicker();
  }
}(jQuery));
