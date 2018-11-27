// VanillaJS

window.onload = function() {
    document.getElementById('submit').disabled = true;
    document.getElementById('photo').addEventListener('change', function() {
        var file = this.files[0];
        if (file && file.size > 2500000) {
            document.getElementById('submit').disabled = true;
        } else {
            document.getElementById('submit').disabled = false;
        };

    });
};