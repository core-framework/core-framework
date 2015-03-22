!function ($) {
    $(function () {
        $('.dropdown-toggle').dropdown();
        // make code pretty
        window.prettyPrint && prettyPrint();
    })
}(window.jQuery);

$(document).ready(function () {
    hashScrollInit();

    $('.minimize').on('click', function (e) {
        e.preventDefault();
        var minimizeWrap = $(this).parents('.minimize-wrap');
        if (!minimizeWrap.hasClass('collapsed')) {
            minimizeWrap.addClass('collapsed');
            $(this).removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');
        } else {
            minimizeWrap.removeClass('collapsed');
            $(this).removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-right');
        }

    });

    //login & register
    $('#loginLink').on('click', function () {
        $('#registerModal').modal('hide');
        $('#loginModal').modal('show');
    });

    $('#registerLink').on('click', function () {
        $('#loginModal').modal('hide');
        $('#registerModal').modal('show');
    });

});


function hashScrollInit() {
    var hash = window.location.hash;
    if (hash != "" && hash != undefined) {
        var x = "a[href=" + hash + "]";
        if ($(x).length) {
            $('html, body').animate({
                scrollTop: $('a[href=' + hash + ']').position().top
            }, 500);
        }
    }

    $('.permalink').click(function () {
        var self = $(this);
        $('html, body').animate({
            scrollTop: self.position().top
        }, 500);
    });
}