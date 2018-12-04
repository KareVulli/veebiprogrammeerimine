// VanillaJS

$(function() {    
    loadNewPhoto();

    function loadNewPhoto() {
        $.getJSON("requests/get_image.php", function(data) {
            //console.log(data.url);
            if (data.url == '') {
                $('#photo').hide();
                $('#error').show();
            } else {
                $('#photo').show();
                $('#error').hide();
            }
            $('#photo').attr("src", data.url);
        });
    }

    $('#photo').click(function(e) {
        loadNewPhoto();
    });
});
