// Javascript to preview images on pages other than exhibits
(function( mediable, $, undefined ) {
  // Get our form file input element and set formdata to false in order
  // to display errors for crappy browsers.
  var input = document.getElementById("image"),
    formdata = false,
    ex_id;
  if ( window.FormData ) {
    formdata = new FormData();
  }
  mediable.add = function() {
    $('.file').each(function(index, value) {

      $(this).bind("change", function(event) {
        console.log(this.files);
        var len = this.files.length,
          el = this,
          img,
          reader,
          file;

        $(el).siblings('#image-preview-exists').children('.thumbnail').remove();
        for ( var i = 0; i < len; i++ ) {
          file = this.files[i];
          if (!!file.type.match(/image.*/)) {
            if ( window.FileReader ) {
              reader = new FileReader();
              reader.onloadend = function (e) {
                console.log(e);
                showUploadedItem(e.target.result, el);
              };
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
    if ( typeof parentDiv == 'undefined' ) {
      el.parents('.form-group').append('<div class="col-xs-6 col-md-3 image-preview-exists"></div>')
      var parentDiv = $(".image-preview-exists");
      console.log(el.parents('.form-group'));
    }
    parentDiv.html(htmlString);
  } 

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
  if (typeof datetimepicker == 'function') {
    $('.datetimepicker6').datetimepicker();
  }
}(jQuery));


