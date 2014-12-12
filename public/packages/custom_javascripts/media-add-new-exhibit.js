// Adds ajax functions in a Class
(function( ajaxable, $, undefined ) {

  ajaxable.addImage = function(formdata) {
    return $.ajax({
            url: "/exhibit-media-add",
            type: "POST",
            data: formdata,
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            async: true
          });
  }

  ajaxable.removeImage = function(formdata) {
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

  ajaxable.addDraft = function() {
    return $.ajax({
              url: "/exhibit-add-empty",
              type: "POST",
              cache: false,
              processData: false,
              dataType: 'json',
              contentType: false,
              async: true
            });
  }

  ajaxable.reorderImages = function(formdata) {
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

}( window.ajaxable = window.ajaxable || {}, jQuery ));

(function( mediable, $, undefined ) {

  var callbackForFormData = function() {

    

  }

  mediable.add = function() {
    // --- add jQuery listener to input --- //
    return $(document.body).on('change', 'input#file', function(e) {

      var len = this.files.length,
          formdata = false,
          el = this,
          ex_id,
          input = $('input:hidden[name="id"]'),
          img,
          reader,
          file;
      // --- check for formdata support -- // 
      if ( window.FormData ) {
        formdata = new FormData();
      }
      // make sure a condition is met then run another function after
      if ( input.val() == 0 || input.val() == "" ) {

        // --- Ajaxable AutoDraft Form function --- //
        ajaxable.addDraft().done( function(response) {
          formdata.append("id", response.id);
          input.val(response.id);
          ex_id = response.id;
          $('image-preview-exists').attr('data-ex-id', ex_id);
          
        }).fail( function() {
          // Put in Error Message if something goes
          // wrong with adding the image
          var errorTxt = 'Oh snap! Something went wrong with adding an exhibit.',
              htmlString = '<div class="alert alert-danger" role="alert">' + errorTxt + '</div>';
          $('.feedback-container').html(htmlString);
          removeLoadIcon("image-preview-exists");


          /// ---- Remove the html feedback container ---- ///
        }).then(function() {
          // --- add a loading icon --- //
          addLoadIcon("image-preview-exists");

          formdata.append("data-id", ex_id);
          formdata.append("data-type", 'Exhibit');

        });
      }
      ex_id = $('image-preview-exists').attr('data-ex-id');
      console.log(formdata);

      // Then loop through all the files

      for ( var i = 0; i < len; i++ ) {

        console.log(formdata);
        file = el.files[i];
        if (formdata) {
          // Make sure to aådd the count into the file[i] array
          formdata.append("file", file);

          // --- Ajax Form function --- //
          ajaxable.addImage(formdata)
            .done(function(response) {
              removeLoadIcon("image-preview-exists");
              if ( response.success == true ) {
                suckInUploadedItem('/' + response.img_min_dest, "New Image " + i, response.media_id);
              }
            }).always(function(response) {
              updateMediaOrder('#image-preview-exists', '.img-min-preview', input.val());
              // Remove the value of the form
              $('form :file').val('');
            }).fail(function(response) {
              // Put in Error Message if something goes
              // wrong with adding the image
              var errorTxt = 'Oh snap! Something went wrong with adding one of your images.',
                  htmlString = '<div class="alert alert-danger" role="alert">' + errorTxt + '</div>';
              $('.feedback-container').html(htmlString);
              removeLoadIcon("image-preview-exists");


              /// ---- Remove the html feedback container ---- ///
            });
        }
      }
    });
  }

  // Remove a single record
  mediable.remove = function() {
    return $('body').on('click', '.media-remove', function (e){
      e.preventDefault();
      var el = $(this),
      url = el.attr('href'),
      input_silent = $('input:hidden[name="id"]').val();

      $.ajax({
        type: "POST",
        cache: false,
        dataType: 'json',
        url : url,
        async: false
      }).fail(function(jqXHR, ajaxOptions, thrownError) {
        // Put in Error Message if something goes
        // wrong with removing image
        var errorTxt = 'Oh snap! Something went wrong with removing your images.',
          htmlString = '<div class="alert alert-danger" role="alert">' + errorTxt + '</div>';
        $('.feedback-container').html(htmlString);
      }).done(function(data) {
        el.parent('.img-min-preview').fadeOut(300, function() { 
          $(this).remove();
          updateMediaOrder('#image-preview-exists', '.img-min-preview', input_silent);
        });
      });
    });
  }
  function updateMediaOrder(container, imgPreview, ex_id) {
    var mediaIDs = [];
    // Handle the media-ids order and post it when new ones come in.
    $(container).find(imgPreview).each(function(){
      mediaIDs.push( $(this).data('id') );
    });
    $.post(
      '/media-add-id-order',
      {
        ex_id : ex_id,
        media_ids: mediaIDs
      }
    ).fail(function() {
      // Put in Error Message if something goes
      // wrong with removing image
      var errorTxt = 'Oh snap! Something went wrong with adding one of your images. Please Try Again.',
          htmlString = '<div class="alert alert-danger" role="alert">' + errorTxt + '</div>';
      $('.feedback-container').html(htmlString);
    });
  }

  // Helper function to show the images once the browser has them
  function suckInUploadedItem(source, alt, id) {
    var parentDiv = document.getElementById("image-preview-exists"),
        div = document.createElement("div"),
        img = document.createElement("img"),
        link = document.createElement("a");
    img.src = source;
    img.alt = alt;
    link.className = 'media-remove';
    div.className = 'img-min-preview';
    div.setAttribute('data-id', id);
    link.innerHTML = 'X';
    link.href = '/media/' + id + '/remove';
    div.appendChild(img);
    div.appendChild(link);
    parentDiv.insertBefore(div, parentDiv.firstChild);
  }

  function addLoadIcon(element) {
    var element = document.getElementById(element),
        icon = document.createElement("i"),
        div = document.createElement("div");
    icon.className = "fa fa-spinner fa-spin fa-3x";
    div.className = 'img-min-preview icon';
    div.appendChild(icon);
    element.insertBefore(div, element.firstChild);
  }

  function removeLoadIcon(element) {
    var element = $("#" + element),
        icon = element.children(".icon");
    icon.remove();
  }

  mediable.sortable = function() {
    $('body').on('mouseenter', '#image-preview-exists', function (e){
      $( this ).sortable(
        { 
          cursor: "move",
          opacity: 0.7,
          update: function(event, ui) {
            updateMediaOrder(this, '.img-min-preview', $('input:hidden[name="id"]').val());
          }
        }
      );
      $( "#image-preview-exists" ).disableSelection();
      $( this ).sortable('enable');
    }).on('mouseleave', '#image-preview-exists', function (e){
       $( this ).sortable('disable');
    });
  }

  mediable.updateOrder = function() {
    updateMediaOrder('#image-preview-exists', '.img-min-preview');
  }

}( window.mediable = window.mediable || {}, jQuery ));

mediable.remove();
mediable.add();
mediable.sortable();


/**
 * Load dependent libraries.
 */
(function ($) {

  $(document.body).on('change', 'input#file', function(e) {
    mediable.add();
  });

  $('.details-wysi').wysihtml5({
    "stylesheets": []
  });
  if ( typeof datetimepicker == 'function' ) {
    $('.datetimepicker6').datetimepicker();
  }
}(jQuery));
