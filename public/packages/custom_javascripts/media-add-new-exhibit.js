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

			    for ( var i = 0; i < len; i++ ) {
					file = this.files[i];
		      		if ( window.FileReader ) {
						reader = new FileReader();
						reader.onloadend = function (e) { 
							showUploadedItem(e.target.result);
						};
						reader.readAsDataURL(file);
					}
					if (formdata) {
						formdata.append("images[]", file);
					}

			      if (formdata) {

			        // Make sure to add the count into the file[i] array
			        formdata.append("file", this.files[i]);
			      }
			      formdata.append("id", $('[name="id"]').val());

			    }

			}, false);

		}
	}
	function showUploadedItem (source) {
		var list = document.getElementById("image-list"),
			div   = document.createElement("div"),
			img  = document.createElement("img");
		img.src = source;
		
		div.className = 'col-md-3';
		img.className = 'img-responsive img-rounded';
		div.appendChild(img);
		list.appendChild(div);
	}

}( window.mediable = window.mediable || {}, jQuery ));

mediable.add();
