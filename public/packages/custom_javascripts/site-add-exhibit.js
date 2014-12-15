(function($) {
  /*
   * Add a class to return responses
   * from ajax
   */
  var ExhibitMedia = function() {}

  ExhibitMedia.prototype = {
    addImage: function(formdata) {
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
    },
    removeImage: function(formdata) {
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
    },
    addDraft: function(data) {
      var ajaxResponse;
      $.ajax({
        url: "/exhibit-add-empty",
        type: "POST",
        cache: false,
        processData: false,
        dataType: 'json',
        contentType: false,
        async: false,
        success: function(data) {
          ajaxResponse = data.id;
        },
      }).fail(function(response){});
      return ajaxResponse;
    },
    reorderImages: function(formdata) {
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
  }

  /*
   * Add a class to handle the procedural dom manipulations
   */
  var EffectDomElements = function() {}

  EffectDomElements.prototype = {
    exID: false,
    mediaSrc: new ExhibitMedia(), // Add this class as a property for the class
    initialize: function() {
      request.getExIDFromUrl();
      this.mediaAdd();
      this.sortable();
      this.removeMedia()
    },
    getExIDFromUrl: function() {
      var el = this,
          loc = window.location.pathname.split('/');
      if ( loc[1] == "exhibit-add" )
        el.exID = false;
      el.exID = loc[2];
    },
    mediaAdd: function() {
      var el = this,
        input = document.getElementById("file"),
        urlVal = el.getExIDFromUrl();

      if (input.addEventListener) {
        // Add event listener
        input.addEventListener("change", function(evt) {
          var len = this.files.length,
            input = $('input:hidden[name="id"]'),
            requestdraft,
            img,
            reader,
            formdata = false,
            ex_id,
            file;

          if ( window.FormData ) {
            formdata = new FormData();
          }

          // Define the id of the new exhibit draft that's being created
          if ( el.exID == false) {
            el.exID = el.mediaSrc.addDraft();
          }
          // get this id and add it to dom elements
          if ( el.exID != false ) {
            input.val(el.exID);
            // -- Adds a loading icon before preview -- //
            el.addLoadIcon("image-preview-exists");

            for ( var i = 0; i < len; i++ ) {
              // Define the file for this iteration
              file = this.files[i];
              if (formdata) {
                // Make sure to add the count into the file[i] array
                formdata.append("file", file);
                formdata.append("data-id", el.exID);
                formdata.append("data-type", "Exhibit");
                // Call async AJAX function
                el.mediaSrc.addImage(formdata).done(function(response) {
                  el.removeLoadIcon("image-preview-exists");
                  // check the response and load the preview
                  if ( response.success == true ) {
                    el.suckInUploadedItem('/' + response.img_min_dest, "New Image " + i, response.media_id);
                  }
                  el.updateMediaOrder('#image-preview-exists', '.img-min-preview', el.exID);
                  $('form :file').val('');
                }).fail(function() {
                  // Put in Error Message if something goes
                  // wrong with removing image
                  var errorTxt = 'Oh snap! Something went wrong with adding one of your images.',
                      htmlString = '<div class="alert alert-danger" role="alert">' + errorTxt + '</div>';
                  $('.feedback-container').html(htmlString);
                });
                
              }
            }
          }
        }, false);
      }
    },
    addLoadIcon: function(element) {
      var element = document.getElementById(element),
      icon = document.createElement("i"),
      div = document.createElement("div");
      icon.className = "fa fa-spinner fa-spin fa-3x";
      div.className = 'img-min-preview icon';
      div.appendChild(icon);
      element.insertBefore(div, element.firstChild);
    },
    removeLoadIcon: function(element) {
      var element = $("#" + element),
          icon = element.children(".icon");
      icon.remove();
    },
    suckInUploadedItem: function(source, alt, id) {
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
    },
    updateMediaOrder: function(container, imgPreview, ex_id) {
      var mediaIDs = [];
      // Handle the media-ids order and post it when new ones come in.
      $(container).find(imgPreview).each(function(){
        mediaIDs.push( $(this).data('id') );
      });
      // -- Post all of the media IDs to the url -- //
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
    },
    sortable: function() {
      var el = this;
      return $('body').on('mouseenter', '#image-preview-exists', function (e){
        $( this ).sortable(
          { 
            cursor: "move",
            opacity: 0.7,
            update: function(event, ui) {
              console.log(el.exID);
              el.updateMediaOrder(this, '.img-min-preview', el.exID);
            }
          }
        );
        $( "#image-preview-exists" ).disableSelection();
        $( this ).sortable('enable');
      }).on('mouseleave', '#image-preview-exists', function (e){
         $( this ).sortable('disable');
      });
    },
    removeMedia: function() {
      var mediaClass = this;
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
            mediaClass.updateMediaOrder('#image-preview-exists', '.img-min-preview', mediaClass.exID);
          });
        });
      });
    }
  }

  var request = new EffectDomElements();
  request.initialize();

} (jQuery));


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