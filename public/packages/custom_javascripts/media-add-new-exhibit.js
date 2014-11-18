(function( mediable, $, undefined ) { 

  // Get our form file input element and set formdata to false in order 
  // to display errors for crappy browsers.
  var input = document.getElementById("file[]"),
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
          input = $('input:hidden[name="id"]'),
          img,
          reader,
          file;

        if ( input.val() == 0 || input.val() == "" ) {
          var ajax = addExhibitDraft();
        }
        addLoadIcon("image-preview-exists");

        formdata.append("id", input.val());

        // console.log(formdata);

        for ( var i = 0; i < len; i++ ) {
          file = this.files[i];
          if (formdata) {
            // Make sure to add the count into the file[i] array
            formdata.append("file", file);

            doActionInsideLoop(i, formdata);
          }
        }
      }, false);
    }
  }

  function doActionInsideLoop(i) {
    var input = $('input:hidden[name="id"]');
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
      }
    }).always(function(response) {

      updateMediaOrder('#image-preview-exists', '.img-min-preview', input.val());
      $('form :file').val('');
    }).fail(function() {
      alert('Something Went Wrong!');
    });
  }

  function addExhibitDraft() {
    var input = $('input:hidden[name="id"]');
    var ajax = $.ajax({
      url: "/exhibit-add-empty",
      type: "POST",
      data: formdata,
      cache: false,
      processData: false,
      dataType: 'json',
      contentType: false,
      async: false
    }).done(function(response){
      formdata.append("id", response.id);
      input.val(response.id);
      var ex_id = response.id;
      $('image-preview-exists').data('exId', response.id);
    });
    return ajax;
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
          /*alert('Something went wrong :X');*/
      }).done(function(data) {
        el.parent('.img-min-preview').fadeOut(300, function() { 
          $(this).remove(); 
        });
        
      }).then(function() {
        updateMediaOrder('#image-preview-exists', '.img-min-preview', $('input:hidden[name="id"]').val());
      });
    });
  }
  function updateMediaOrder(container, imgPreview, ex_id) {
    var mediaIDs = [];
    console.log(ex_id);
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
