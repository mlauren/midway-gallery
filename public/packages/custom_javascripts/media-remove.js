$(document).ready(function() {
    // console.log(Laravel.imageGroup);
    $('.media-remove').on('click', function(e) {
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
            },
            async: true
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('Something went wrong :X');
        });
    });
});