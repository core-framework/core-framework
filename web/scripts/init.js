window.app = {
    $btn: null
};

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

    //register and login btn
    $('#loginBtn, #registerBtn').on('click', function () {
        app.$btn = $(this);
        app.$btn.button('loading');
        $(this).parents('.modal').find('form').submit();
    });

    //on form submit
    $('#registerForm, #loginForm').on('submit', function (e) {
        e.preventDefault();
        var data = $(this).serialize(),
            url = $(this).attr('action'),
            id = $(this).parents('.modal').attr('id');

        var $ajax = $.ajax({
            url: url,
            data: data,
            method: 'POST',
            dataType: 'JSON'
        });


        $ajax.done(function (data) {
            if (data.status === 'success') {
                showAlert('#' + id + ' .notice.alert', data.msg || data.message, 'success');
                if(data.redirectUrl) {
                    window.location.href = data.redirectUrl;
                }
            } else {
                showAlert('#' + id + ' .notice.alert', data.msg || data.message, 'error');
            }
        }).error(function (data){
            showAlert('#' + id + ' .notice.alert', data.msg || data.message, 'error');
        }).always(function () {
            app.$btn.button('reset');
        });

    });

});

function showAlert(selector, msg, type) {

    if ($(selector).length === 0) {
        throw new Error(selector + 'Element not found');
    }

    $(selector).removeClass('alert-success alert-danger');
    if (type === 'success') {
        $(selector).addClass('alert-success');
    } else {
        $(selector).addClass('alert-danger');
    }

    var promise = $(selector).text(msg).fadeIn().delay(8000).fadeOut();
    $(window).scrollTop($(selector).offset().top - 100);

    promise.promise().then(function() {
        $(selector).removeClass('alert-success alert-danger');
    });
}

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

