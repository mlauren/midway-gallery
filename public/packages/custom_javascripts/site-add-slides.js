// 
// Adds ajax functions
(function( slidiable, $, undefined ) {

  slidiable.init = function(el) {

    // Hide the form elements that we dont want to see per form item

    // Add the image to the record
    el.on('click', el.closest('add-image'), function() {

    });

  }

  slidiable.addImage = function() {

  }

  slidiable.addTitle = function() {
    
  }

  slidiable.addSlideText = function() {
    
  }

  slidiable.addSlideObject = function(slideGroup) {
    // Ajax function to get and append form
    return $.get( "/slide-add" );
  }


}( window.slidiable = window.slidiable || {}, jQuery ));


(function($) {

  // ---- Hide The things we don't want ---- //





  // ---- Add the slide form into the page ----- //
  // ------------------------------------------ //
  $(document.body).on('click', '.add-slide-object', function(e) {
    var slideGroup, slides;

    e.preventDefault();

    slideGroup = $('.slide-group');
    slides = slideGroup.children('.slide-container');

    if ( slides.length < 6 ) {
      // use the slidiable function responsible
      // for returning ajax response
      slidiable.addSlideObject(slideGroup).done(function(data) {
        slideGroup.append(data);
        // update the value of slides
        slides = slideGroup.children('.slide-container');

        // add data number order to slides to update value
        slides.each(function(key, value) {
          $(this).attr("data-order", key);
        });



        // ---- Ajax function to add a new record 
        // ---- add a data-id for ID in record----- //
        /// here



      });
    }
    else {
      var type, feedbackMsg;
      type = 'danger';
      feedbackMsg = 'You may not add more than 6 images';
      feedBackResponse = addFeedbackMsg(type, feedbackMsg);
      // Append response to the feedback container.
      $('.feedback-container').append(feedBackResponse);
      // Close the alert.
      autoCloseAlert('.alert', 2000);
    }
  });


  // ---- Make each form draggable ----- //
  // ------------------------------------------ //
  $(document.body).on('mouseenter', '.slide-group', function (e) {
    // Makes the items sortable
    $( this ).sortable(
      {
        key: "sort",
        delay: 150,
        handle: ".drag-order",
        cursor: "move",
        opacity: 0.7,
        update: function(event, ui) {
          console.log(event);
          console.log(ui);

          var sorted = $( ".slide-group" ).sortable( "serialize", { key: "sort" } );
          // console.log(sorted);
          // ---- Ajax function update each child in slide group based on order ----- //
          $( this ).children().each(function () {

            // get each media id and send it thru a nifty ajax call
            console.log('hello');

          });

        }
      }
    );
  });



  // ---- click events per each slide container ----
  $('.slide-container').each( function(key, value) {
    var el = $(this);
    //slidiable.init(el);
  });

  // ---- Handle the function that controls the drag order ----
  $('body').on('click', 'drag-order', function () {

  });

  // --- helper function to append add feedback function to top of page
  function addFeedbackMsg(type, feedbackMsg) {
    var feedback = '<div class="alert alert-' + type + '" role="alert">'
      + '<button type="button" class="close" data-dismiss="alert">'
      + '<span aria-hidden="true">&times;</span>'
      + '<span class="sr-only">Close</span></button>'
      + feedbackMsg
      + '</div>';
    return feedback;
  }

  // --- helper function to dismiss feedback
  function autoCloseAlert(selector, delay) {
     var alert = $(selector).alert();
     window.setTimeout(function() { alert.alert('close') }, delay);
  }




}(jQuery));





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