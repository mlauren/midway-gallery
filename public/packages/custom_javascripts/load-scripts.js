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

        $(el).siblings('.image-preview-exists').children('.thumbnail').remove();
        for ( var i = 0; i < len; i++ ) {
          file = this.files[i];
          if (formdata) {

            // Make sure to add the count into the file[i] array
            formdata.append("file", this.files[i]);
          }

          // @todo take this out of the loop.
          if ( formdata ) {
            $.ajax({
              url: "/media-add",
              type: "POST",
              data: formdata,
              cache: false,
              processData: false,
              dataType: 'json',
              contentType: false,
              async: true
            }).done(function(response) {
              removeLoadIcon("image-preview-exists");
              if ( response.success == true ) {
                suckInUploadedItem('/' + response.img_min_dest, "New Image " + i, response.media_id);
                $('form :file').val('');
              }
            }).always(function() {
              updateMediaOrder('#image-preview-exists', '.img-min-preview');
            });
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
  $('.datetimepicker6').datetimepicker();

}(jQuery));


