!function ($) {
    $(function () {
        $('.dropdown-toggle').dropdown();
        // make code pretty
        window.prettyPrint && prettyPrint();
    })
}(window.jQuery);

$(document).ready(function () {
    hashScrollInit();
});


function hashScrollInit() {
    var hash = window.location.hash;
    if (hash != "" && hash != undefined) {
        var x = "a[href=" + hash + "]";
        if ($(x).length) {
            $('html, body').animate({
                scrollTop: $('a[href='+hash+']').position().top
            }, 500);
        }
    }

    $('.permalink').click(function(){
        var self = $(this);
        $('html, body').animate({
            scrollTop: self.position().top
        }, 500);
    });
}