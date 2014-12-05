// 
// Adds ajax functions
(function( slidiable, $, undefined ) {

  slidiable.addImage = function() {
    // update function to preview and save the images


  }

  slidiable.addSlideText = function() {
    // Ajax function to update any of the input fields
  }

  slidiable.reorderSlides = function(formdata) {
    // Ajax function to update data order for slides
    return $.ajax({
              url: "/slide-reorder",
              type: "POST",
              data: formdata,
              cache: false,
              processData: false,
              dataType: 'json',
              contentType: false,
              async: false
            });
  }

  slidiable.addSlideFormat = function() {
    // Ajax function to add slide template to form
    return $.get( "/slide-add" );
  }

  slidiable.addSlideObject = function(formdata) {
    // Ajax function to add data for slide
    return $.ajax({
              url: "/slide-add",
              type: "POST",
              data: formdata,
              cache: false,
              processData: false,
              dataType: 'json',
              contentType: false,
              async: false
            });
  }

}( window.slidiable = window.slidiable || {}, jQuery ));


(function($) {
  ///  ~~~~~ @todo wrap all this functionality in a class and call it in one big init function
  // ---- Hide The things we don't want to see when document is loaded ---- //

  // ---- Call the class that does everything ---- //

  $(document.body).on('load', function() {})

  // ---- Add the slide form into the page ----- //
  // ------------------------------------------ //
  $(document.body).on('click', '.add-slide-object', function(e) {
    var slideGroup, slides, el;
    e.preventDefault();
    el = $(this);

    slideGroup = $('.slide-group');
    slides = slideGroup.children('.slide-container');

    if ( slides.length < 6 ) {
      // use the slidiable function responsible
      // for returning ajax response
      slidiable.addSlideFormat().done(function(data, textStatus, jqXHR) {
        var data, result, index, formdata = false ,responseID;
        // Define the formdata to pass into the ajax
        if ( window.FormData ) {
          formdata = new FormData();
        }
        data = $(data);
        // Append new ajax object to its parent and get its index value
        result = data.appendTo(slideGroup);
        index = result.index();
        // Assign index value to data attrribute and send it to formdata
        $(result).attr("data-order", index);
        formdata.append("data-order", index);
        // ----- Ajax function to add new record ---//
        // pass data order in and return object ID //
        slidiable.addSlideObject(formdata).done(function(response) {
          if ( response.success == true ) {
            var responseID = response.id;
            //console.log(responseID);
            // Add ID of object to data-id attr
            $(result).attr("data-id", responseID);
            $(result).find("input:hidden").val(responseID);
          }
        });
      });
    }
    else {
      var type, feedbackMsg;
      type = 'danger';
      feedbackMsg = 'You may not add more than 6 images';
      feedBackResponse = addFeedbackMsg(type, feedbackMsg);
      // Append response to the feedback container.
      $('.feedback-container').append(feedBackResponse);
      // Hide the link to add a new record
      el.hide();
      // Close the alert.
      autoCloseAlert('.alert', 2000);
    }
  });
  // ---- Make each form draggable and update object ---- //
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
          // ---- Ajax function update each child in slide group based on order ----- //
          $( this ).children().each(function (key, value) {
            var formdata;
            if ( window.FormData ) {
              formdata = new FormData();
            }
            // Update data attr
            $(this).attr("data-order", key);
            // Pass the relevant values into ajaxable object
            formdata.append("data-id", $(this).attr("data-id"));
            formdata.append("data-order", key);
            // get each media id and send it thru a nifty ajax call
            slidiable.reorderSlides(formdata).fail(function(response) {
              if (response.success == false) {
                var type = 'danger', feedbackMsg = response.error_msg;
                feedBackResponse = addFeedbackMsg(type, feedbackMsg);
                $('.feedback-container').append(feedBackResponse);
                autoCloseAlert('.alert', 2000);
              }
            });
          });
        }
      }
    );
  });

  // ---- Adding and Dealing with the images in each form ----- //
  // ------------------------------------------ //
  $('.slide-container').each(function(e) {
    var fileUpload, formdata, el;
    var form_submitting = false;
    el = $(this);
    formdata = false;

    if ( window.FormData ) {
      formdata = new FormData();
    }
    fileUpload = $(this).find('input#file');

    // ---- Deal with the file upload ---- //

    fileUpload.on('change', function(e) {
      var fileInput = this
          file = fileInput.files[0],
          dataID = $(el).attr('data-id');

      el.find('#img-preview').remove();

      if (formdata) {
        formdata.append("data-id", dataID);
        formdata.append("file", file);
        if(form_submitting == false){
          form_submitting = true;
          $.ajax({
            url: "/slide-edit-media",
            type: "POST",
            data: formdata,
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            async: true
          }).done(function(response) { // success callback
            form_submitting = false;
            if (response.success == true) {
              el.find('.col-md-4').append('<img id="img-preview" src="/' + response.img_min_obj + '" />')
            }
          }).fail(function(response) {
            if (response.success == false) {
              var type = 'danger', feedbackMsg = response.error_msg;
              feedBackResponse = addFeedbackMsg(type, feedbackMsg);
              $('.feedback-container').append(feedBackResponse);
              autoCloseAlert('.alert', 2000);
            }
          });
        }
      }
    });
  });

  // ---- Remove individual slide records ----- //
  // ------------------------------------------ //
  $(document.body).on('click', '.remove-slide', function(e) {
    e.preventDefault;
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
