// 
// Adds ajax functions
(function( slidiable, $, undefined ) {

  slidiable.addImage = function() {

  }

  slidiable.addTitle = function() {
    
  }

  slidiable.addSlideText = function() {
    
  }


}( window.slidiable = window.slidiable || {}, jQuery ));


// Class that handles all of the html and form items



(function($) {

  var input = $("file"),
      formdata = false;
  if ( window.FormData ) {
    formdata = new FormData();
  }

  $('.slide_item').each(function() {
    var el = this,
        id = $(el).data('id');

// ------------- IMAGE
    // When the form image upload button changes get the form data
    if (input.addEventListener) {
      // Add event listener
      input.addEventListener("change", function(evt) {
        var len = this.files.length,
            img,
            reader,
            file;
        addLoadIcon("image-preview-exists");

        if ($('[name="id"]').val() != '') {
          formdata.append("id", $('[name="id"]').val());
        }

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
                // suckInUploadedItem('/' + response.img_min_dest, "New Image " + i, response.media_id);
                $('form :file').val('');
              }
            }).always(function() {
              updateMediaOrder('#image-preview-exists', '.img-min-preview');
            });
          }
        }
      }, false);
    }
// ------------- SLIDE TITLE
    $(el).child('#slide_title').change(function() {
      $.ajax()
    });
// ------------- SLIDE TEXT


  }); 

  // Create a function that will allow you to add a new autodraft item 

}(jQuery));
slidiable.addImage();
slidiable.addTitle();
slidiable.addSlideText();