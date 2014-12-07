// 
// Adds ajax functions
(function( slidiable, $, undefined ) {

  slidiable.addImage = function(formdata) {
    return $.ajax({
              url: "/slide-edit-media",
              type: "POST",
              data: formdata,
              cache: false,
              processData: false,
              dataType: 'json',
              contentType: false,
              async: true
            });
  }

  slidiable.removeImage = function(formdata) {
    return $.ajax({
              url: "/slide-remove-media",
              type: "POST",
              data: formdata,
              cache: false,
              processData: false,
              dataType: 'json',
              contentType: false,
              async: true
            });
  }

  slidiable.addSlideText = function(formdata) {
    // Ajax function to update any of the input fields
    return $.ajax({
              url: "/slide-add-text",
              type: "POST",
              data: formdata,
              cache: false,
              processData: false,
              dataType: 'json',
              contentType: false,
              async: true
        });
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
              async: true
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
              async: true
            });
  }

  slidiable.removeSlide = function(formdata) {
    // Ajax function to update data order for slides
    return $.ajax({
              url: "/slide-remove",
              type: "POST",
              data: formdata,
              cache: false,
              processData: false,
              dataType: 'json',
              contentType: false,
              async: true
            });
  }

}( window.slidiable = window.slidiable || {}, jQuery ));


(function($) {
  ///  ~~~~~ @todo wrap all this functionality in a class and call it in one big init function

  // ---- Add the slide forms into the page ----- //
  // ------------------------------------------ //
  $(document.body).on('click', '.add-slide-object', function(e) {
    var slideGroup, slides, el;
    e.preventDefault();
    el = $(this);

    slideGroup = $('.slide-group');
    slides = slideGroup.children('.slide-container');

    if ( slides.length < 6 ) {
      // ---- Uses slidiable Ajax Method  ---- //
      slidiable.addSlideFormat().done(function(data, textStatus, jqXHR) {
        var data, result, index, formdata = false ,responseID;
        // Define the formdata to pass into the ajax
        if ( window.FormData ) {
          formdata = new FormData();
        }
        data = $(data);
        // Append new ajax object to its parent and get its index value
        result = data.prependTo(slideGroup);
        index = result.index();
        // Assign index value to data attrribute and send it to formdata
        $(result).attr("data-order", index);
        formdata.append("data-order", index);
        // ----- Ajax function to add new record ---//
        // pass data order in and return object ID //
        // ---- Uses slidiable Ajax Method  ---- //
        slidiable.addSlideObject(formdata).done(function(response) {
          if ( response.success == true ) {
            var responseID = response.id;
            //console.log(responseID);
            // Add ID of object to data-id attr
            $(result).attr("data-id", responseID);
            $(result).find("input:hidden").val(responseID);

            /// Make sure the sort order is being refreshed and completed now
            refreshReorderSlides( '.slide-group' );
          }
        }).fail(function() {
          var type = 'danger', feedbackMsg = 'Something went wrong!';
          feedBackResponse = addFeedbackMsg(type, feedbackMsg);
          $('.feedback-container').append(feedBackResponse);
          autoCloseAlert('.alert', 2000);
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
          refreshReorderSlides( this );
        }
      }
    );
  });
  
  $('.slide-group').on('change', 'input#file', function(e) {
    var el, dataID, formdata, parent, fileInput = this, file, form_submitting = false, loadingIcon, imgFormat, txtValue, txtType;

    el = $(this);
    dataID = el.attr('data-id');
    formdata = false;
    parent = el.closest('.slide-container');
    dataID = el.closest('.slide-container').attr('data-id');

    if ( window.FormData ) {
      formdata = new FormData();
    }
    file = fileInput.files[0];

    parent.find('#img-preview').remove();

    addLoadIcon("#img-preview-container", parent);
    loadingIcon = $(parent).find('.fa-spinner');

    if (formdata) {
      formdata.append("data-id", dataID);
      formdata.append("file", file);
      if(form_submitting == false){
        form_submitting = true;
        // ---- Uses Slidiable Ajax Method  ---- //
        slidiable.addImage(formdata)
          .done(function(response) { // success callback
            form_submitting = false;
            if (response.success == true) {
              imgFormat = document.createElement('img');
              imgFormat.className = 'img-responsive';
              imgFormat.id = 'img-preview';
              imgFormat.src = '/' + response.img_min_obj;

              // --- Remove Loading Icon --- //
              loadingIcon.remove();
              // -- Append all of the gross HTML -- //
              parent.find('#img-preview-container').append(imgFormat)
                .append('<h4 class="img-preview-remove"><a href="" >X</a></h4>')
                .append('<h4 class="img-preview-overlay">Preview</h4>');
            }
          }).fail(function(response) {
            // Renders Feedback for Errors
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
  
  $('.slide-group').on('click', '.img-preview-remove a', function(e) {
    var el, dataID, formdata, parent;
    e.preventDefault();
    el = $(this);
    formdata = false;
    parent = el.closest('.slide-container');
    dataID = el.closest('.slide-container').attr('data-id');
    if ( window.FormData ) {
      formdata = new FormData();
      formdata.append('data-id', dataID);
    }
    // --- Updating Slide Record Remove --- //
    slidiable.removeImage(formdata).done(function() {
      // --- Remove the old image --- //
      parent.find("#img-preview-container").children().remove();
    });
  });

  $('.slide-group').on('click', '.remove-slide', function(e) {
    var el, dataID, formdata, parent;

    e.preventDefault();
    el = $(this);
    formdata = false;
    parent = el.closest('.slide-container');
    dataID = el.closest('.slide-container').attr('data-id');
    if ( window.FormData ) {
      formdata = new FormData();
      formdata.append('data-id', dataID);
    }

    $.ajax({
      url: "/slide-remove",
      type: "POST",
      data: formdata,
      cache: false,
      processData: false,
      dataType: 'json',
      contentType: false,
      async: true
    }).done(function() {
      parent.remove();
      $('.add-slide-object').show();
    });

  });

  // ----- Update Text Fields ----- //
  // ------------------------------ //
  $('.slide-group').on('focusout', '.slide-container .form-group.info-add input', function(e) {
    console.log('hello');
    var el, dataID, formdata, parent, txtType, txtValue;

    e.preventDefault();
    el = $(this);
    formdata = false;
    parent = el.closest('.slide-container');
    dataID = el.closest('.slide-container').attr('data-id');
    if ( window.FormData ) {
      formdata = new FormData();
      formdata.append('data-id', dataID);
    }
    txtType = $(this).attr('name');
    txtValue = $(this).val();
    formdata.append('txtType', txtType);
    formdata.append('txtValue', txtValue);
    // ----- Add Slide Text AJAX ----- //
    slidiable.addSlideText(formdata);

  });

  // ----- Function to save the order of slides ----- //
  // ------------------------------ //
  function refreshReorderSlides( parent ) {
    // ---- Ajax function update each child in slide group based on order ----- //
    $( parent ).children().each(function (key, value) {
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
      // ---- Uses slidiable Ajax Method  ---- //
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


  function addLoadIcon(element, el) {
    var element = $(el).find(element);
    element.append($('<i></i>')
        .addClass("fa fa-spinner fa-spin fa-3x"));
        icon = document.createElement("i");
  }

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
