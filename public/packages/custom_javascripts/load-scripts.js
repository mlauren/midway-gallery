// Javascript to preview images on pages other than exhibits
(function( mediable, $, undefined ) {

  // Class to add an image
  mediable.add = function() {
    $('.file').each(function(index, value) {

      $(this).bind("change", function(event) {
        var len = this.files.length,
          files = this.files,
          el = this,
          img,
          reader,
          file;

        // Remove any of the remaining images
        $(el).siblings('.image-preview-exists').children('.thumbnail').remove();
        for ( var i = 0; i < len; i++ ) {
          file = this.files[i];
          // Match the image and read the file in order to show an image preview.
          if (!!file.type.match(/image.*/)) {
            if ( window.FileReader ) {
              reader = new FileReader();
              reader.onloadend = function (e) {
                showUploadedItem(e.target.result, el);
              }
              reader.readAsDataURL(file);
            }
          }
        }
      });
    });
  }
  // Helper function to show the images once the browser has them
  function showUploadedItem(source, el) {
    var htmlString = '<div class="thumbnail"><img src="' +  source + '"/></div>';
    var parentDiv = $(el).siblings(".image-preview-exists");
    parentDiv.html(htmlString).addClass('col-md-3');
  } 

  // Remove a single record
  mediable.remove = function() {
    return $('body').on('click', '.media-remove ', function (e){
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
        /* alert(ajaxOptions); */
        el.closest('.image-preview-exists').removeClass('col-md-3');
      }).done(function(data) {
        el.closest('.image-preview-exists').removeClass('col-md-3');
        el.parent('.thumbnail').remove();
      });
    });
  }

}( window.mediable = window.mediable || {}, jQuery ));

mediable.remove();
mediable.add();


/**
 * Load dependent libraries.
 */
(function ($) {
  $('.details-wysi').wysihtml5({
    "stylesheets": []
  });
  if ( typeof datetimepicker == 'function' ) {
    $('.datetimepicker6').datetimepicker();
  }

}(jQuery));


