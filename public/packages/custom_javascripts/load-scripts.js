(function( mediable, $, undefined ) {

  // Remove a single record
  mediable.remove = function() {
    return $('body').on('click', '.media-remove', function (e){
      e.preventDefault();
      var el = $(this),
        url = el.attr('href');

      $.ajax({
        type: "POST",
        cache: false,
        dataType: 'json',
        url : url,
        async: false
      }).fail(function(jqXHR, ajaxOptions, thrownError) {
        /*alert(ajaxOptions);*/
      }).done(function(data) {
      });
    });
  }

}( window.mediable = window.mediable || {}, jQuery ));

mediable.remove();


/**
 * Load dependent libraries.
 */
(function ($) {
  $('.details-wysi').wysihtml5({
    "stylesheets": []
  });
  $('.datetimepicker6').datetimepicker();
}(jQuery));


