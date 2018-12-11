$(function() {
    var currentImage;

    $('.image-preview').click(function(e) {
        currentImage = $(this);
        var image = $(this).data('url');
        var photo = $(this).data('photo');
        var title = $(this).attr('alt');
        $('#full-image').attr('src', image);
        $('#full-image').attr('alt', title);
        $('#image-modal-label').text(title);
        $('#image-modal').modal('show');
        $('#add-comment').data('photo', photo);
        loadComments(photo);
        clearCommentFrom();
    });

    $('#add-comment').click(function(e) {
        e.preventDefault();
        var image = $(this).data('photo');
        var rating = $('#rating').val();
        var comment = $('#comment').val();

        $.post( "requests/add_comment.php", {
            id: image,
            comment: comment,
            rating: rating
        }, function( data ) {
            $('#status').html(getAlert('success', data.message));
            updateRating(image, data.rating);
            loadComments(image);
            clearCommentFrom();
        })
        .fail(function(xhr, status, error) {
            var data = JSON.parse(xhr.responseText);
            $('#status').html(getAlert('danger', data.message));
        });;

    });

    function loadComments(photo) {
        $.getJSON("requests/get_comments.php?id=" + photo, function(data) {
            //console.log(data);
            var comments = '';
            if (data.length == 0) {
                comments = '<p class="text-black-50"><em>Kommentaarid puuduvad. Ole esimene!</em></p>'
            } else {
                $.each(data, function(index, comment) {
                    rating = '';
                    for (var i = 0; i < 5; i++) {
                        if (i < comment.rating) {
                            rating += '<i class="fas fa-star"></i>';
                        } else {
                            rating += '<i class="far fa-star"></i>';
                        }
                    }
    
                    comments += '<li class="list-group-item list-group-item-action flex-column">' +
                            '<div class="d-flex w-100 justify-content-between">' +
                                '<h5 class="mb-1">' + comment.username + '</h5>' +
                                '<small>' + comment.created + '</small>' +
                            '</div>' +
                            '<p class="mb-1">' + comment.comment + '</p>' +
                            '<small>' + rating + '</small>' +
                        '</li>';
                });
            }
            
            $('#comments').html(comments);
        });
    }

    function getAlert(type, message) {
        return '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
            '</button>' +
        '</div>';
    }

    function clearCommentFrom() {
        $('#rating').val(5)
        $('#comment').val('');
    }

    function updateRating(image, rating) {
        console.log("UpdateRating: " + rating);
        currentImage.parent().find('.rating').text('Hinne: ' + rating);
    }
});