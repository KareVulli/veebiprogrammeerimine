$(function () {
    setInterval(function() {
        var dNow = new Date();
        var s = dNow.getDate() + '.' + dNow.getMonth() + '.' + dNow.getFullYear() + ' ' + dNow.getHours() + ':' + dNow.getMinutes() + ':' + dNow.getSeconds();
        $('#datetime').text(s);
    }, 1000);

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('collapsed');
        $('.content').toggleClass('expanded');
    });
});