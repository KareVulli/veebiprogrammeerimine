$(function() {
    $('.image-priview').click(function(e) {
        var image = $(this).data('url');
        var title = $(this).attr('alt');
        $('#full-image').attr('src', image);
        $('#full-image').attr('alt', title);
        $('#image-modal-label').text(title);
        $('#image-modal').modal('show');
    });
});