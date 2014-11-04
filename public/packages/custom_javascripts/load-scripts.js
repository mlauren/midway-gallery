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

    if (input.addEventListener) {
      // Add event listener
      input.addEventListener("change", function(evt) {
        var len = this.files.length,
          img,
          reader,
          file;

        // console.log(formdata);

        for ( var i = 0; i < len; i++ ) {
          file = this.files[i];
          if (!!file.type.match(/image.*/)) {
            if ( window.FileReader ) {
              reader = new FileReader();
              reader.onloadend = function (e) {
                console.log(e);
                showUploadedItem(e.target.result);



              };
              reader.readAsDataURL(file);
            }

          }
        }
      }, false);
    }
  }

  function removeSiblings() {

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

  // Helper function to show the images once the browser has them
  function showUploadedItem(source, id) {
    var parentDiv = document.getElementById("image-preview-exists"),
      div = document.createElement("div"),
      img = document.createElement("img"),
      link = document.createElement("a");
    img.src = source;

    div.className = 'thumbnail';

    link.className = 'media-remove';
    link.innerHTML = 'X';
    // link.href = '/media/' + id + '/remove';
    link.className = "media-remove";

    div.appendChild(img);
    div.insertBefore(link, img);
    parentDiv.insertBefore(div, parentDiv.firstChild);
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


