
/*
function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {

      // Only process image files.
      if (!f.type.match('image.*')) {
        continue;
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
          // Render thumbnail.
          var span = document.createElement('span');
          console.log(e);

          span.innerHTML = ['<img class="thumbnail small" src="', e.target.result,
                            '" title="', escape(theFile.name), '"/>'].join('');
          document.getElementById('image-preview').insertBefore(span, null);
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

document.getElementById('file[]').addEventListener('change', handleFileSelect, false);
*/
// initialize an anonymous, self-invoking function 
(function($) {

  // Get our form file input element and 
  // initialize formdata to false in order 
  // to display errors for crappy browsers.
  var input = document.getElementById("file[]"),
      formdata = false;
  if (window.FormData) {
    formdata = new FormData();
  }

  // Helper function to show the images once the browser has them
  function showUploadedItem(source) {
    var list = document.getElementById("image-list"),
        li   = document.createElement("li"),
        img  = document.createElement("img");
    img.src = source;
    img.className = 'thumbnail small';
    li.appendChild(img);
    list.appendChild(li);
  }

  function suckInUploadedItem(source, alt, id) {
    var parentDiv = document.getElementById("image-preview-exists"),
        div = document.createElement("div"),
        img = document.createElement("img"),
        link = document.createElement("a");
    img.src = source;
    img.alt = alt;
    link.className = 'media-remove';
    div.className = 'img-min-preview';
    link.innerHTML = 'X';
    link.href = '/media/' + id + '/remove';
    div.appendChild(img);
    div.appendChild(link);
    parentDiv.insertBefore(div, parentDiv.firstChild);
  }

  function resetForm(formid) {
    $(':input', '#' + formid)
      .find(':file')
      .val('');
  }

  if (input.addEventListener) {
    // Add event listener
    input.addEventListener("change", function() {
      console.log('hello!');
      var len = this.files.length,
          img,
          reader,
          file;

      for (var i = 0; i < len; i++)
      {
        file = this.files[i];

        // if (!!file.type.match(/image.*/)) {
          // @todo add this functionality to other events & 
          // artists that have SINGLE file images
          if ( window.FileReader ) {
            reader = new FileReader();
            reader.onloadend = function(event) {
              // console.log(event.target.result);
              // showUploadedItem(event.target.result);
            };
            reader.readAsDataURL(file);
          }

          if (formdata) {
            // Make sure to add the count into the "file[i]"
            // array so that it processes each image
            formdata.append("file[i]", file);
            // @todo add my form parent ID for the media
            formdata.append("id", $('[name="id"]').val());
          }

          if (formdata) {
            $.ajax({
              url: "/media-add",
              type: "POST",
              data: formdata,
              cache: false,
              processData: false,
              dataType: 'json',
              contentType: false,
              success: function (response) {
                // Log the success if it is a success
                console.log(response);
                console.log(response.img_min_dest);
                if (response.success == true) {
                  suckInUploadedItem('/' + response.img_min_dest, "New Image " + i, response.media_id);
                  $('form :file').val('');
                }

                // Call the media remove script again to allow another request if asked
                /*$('.media-remove').on('click', function(e) {
                  e.preventDefault();
                  var el = $(this),
                    url = el.attr('href');

                    $.ajax({
                        type: "GET",
                        cache: false,
                        dataType: 'json',
                        url : url,
                        success: function(data) {
                            el.parent('.img-min-preview').fadeOut();
                        }
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        alert('Something went wrong :X');
                    });
                });*/
              },
              error: function() {
                alert('something went wrong :X');
              },
              async: true
            });
          }
        //}
      }


    }, false);
  }
}(jQuery));
























