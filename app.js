$(function () {
    var expanded = true;

    if($('#loginModal').data('show')) {
        $('#loginModal').modal('show');
    }

    setInterval(function() {
        var dNow = new Date();
        var s = dNow.getDate() + '.' + dNow.getMonth() + '.' + dNow.getFullYear() + ' ' + dNow.getHours() + ':' + dNow.getMinutes() + ':' + dNow.getSeconds();
        $('#datetime').text(s);
    }, 1000);

    $('#sidebarCollapse').on('click', function () {
        expanded = !expanded;
        $('#sidebar').toggleClass('collapsed');
        $('.content').toggleClass('expanded');
    });

    $( window ).resize(function() {
        if ($( window ).width() < 768 && expanded) {
            $('#sidebar').addClass('collapsed');
            $('.content').addClass('expanded');
        } else if ($( window ).width() >= 768 && !expanded) {
            $('#sidebar').removeClass('collapsed');
            $('.content').removeClass('expanded');
        };
    });

    particlesJS.load('particles', 'assets/particles.json');
});