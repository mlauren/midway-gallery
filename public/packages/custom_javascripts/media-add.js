(function( mediable, $, undefined ) { 

  // Get our form file input element and set formdata to false in order 
  // to display errors for crappy browsers.
  var input = document.getElementById("file[]"),
      formdata = false;
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
        addLoadIcon("image-preview-exists");
        

        for ( var i = 0; i < len; i++ ) {
          file = this.files[i];
          if (formdata) {

            // Make sure to add the count into the file[i] array
            formdata.append("file", this.files[i]);
          }
          formdata.append("id", $('[name="id"]').val());

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
      }, false);
      //});
    }
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
        async: true
      }).fail(function(jqXHR, ajaxOptions, thrownError) {
          alert('Something went wrong :X');
      }).done(function(data) {
        el.parent('.img-min-preview').fadeOut(300, function() { 
          $(this).remove(); 
        });
        
      }).then(function() {
        updateMediaOrder('#image-preview-exists', '.img-min-preview');
      });
    });
  }
  function updateMediaOrder(container, imgPreview) {
    var mediaIDs = [];
    // Handle the media-ids order and post it when new ones come in.
    var ex_id = $(container).data('ex-id');
    $(container).find(imgPreview).each(function(){
      mediaIDs.push( $(this).data('id') );
    });
    $.post(
      '/media-add-id-order',
      {
        ex_id : ex_id,
        media_ids: mediaIDs
      }
    );
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
            updateMediaOrder(this, '.img-min-preview');
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


// update the mediable elements on page load
mediable.updateOrder()
mediable.remove();
mediable.add();
mediable.sortable();





