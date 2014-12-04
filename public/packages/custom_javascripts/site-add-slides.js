// 
// Adds ajax functions
(function( slidiable, $, undefined ) {

  slidiable.init = function(el) {

  }

  slidiable.addImage = function() {

  }

  slidiable.addTitle = function() {
    
  }

  slidiable.addSlideText = function() {
    
  }

  slidiable.addSlideFormat = function() {
    // Ajax function to get and append form
    return $.get( "/slide-add" );
  }

  slidiable.addSlideObject = function(formdata) {
    // Ajax function to get and append form
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

  // ---- Hide The things we don't want to see ---- //





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
      slidiable.addSlideFormat().done(function(data, textStatus, jqXHR) {
        var data, result, index, formdata = false ,responseID;

        if ( window.FormData ) {
          formdata = new FormData();
        }

        data = $(data);
        // Append new ajax object to its parent and get its index value
        result = data.appendTo(slideGroup);
        index = result.index();
        // Assign index value to data attrribute
        $(result).attr("data-order", index);

        formdata.append("data-order", index);

        // ----- Ajax function to add new record ---//
        // pass data order in and return object ID //
        slidiable.addSlideObject(formdata).done(function(response) {
          if ( response.success == true ) {
            var responseID = response.id;
            console.log(responseID);
            // Add ID of object to data-id attr
            $(result).attr("data-id", index);

            //////
            // @todo add response id to input as well so we can:
            // update the draggable sort order in the form
            // update the images using ajax
            // process the rest of the form in PHP if we want to 
            // ~~~~buuuut maybe just keep the whole thing in javascript
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
          // ---- Ajax function update each child in slide group based on order ----- //
          $( this ).children().each(function (key, value) {
            // Update data attr
            $(this).attr("data-order", key);

            // get each media id and send it thru a nifty ajax call

          });

        }
      }
    );
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
