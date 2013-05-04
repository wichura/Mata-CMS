$(window).ready(function() {
    $("*[class^='flash-']").each(function(i) {

        // enable displaying multiple flash messages
        var marginTop = 10;
        var flash = $(this);
        flash.delay(300 * (i+1)).transition({
            top: (marginTop * i) + ((flash.outerHeight(true) * i) + marginTop),
            opacity: 1
        })



        $(this).delay(3000 * (i + 1)).transition({opacity: 0}, function() {
            $(this).remove();
            $("*[class^='flash-']").each(function() {
                flash = $(this)
                flash.css({top: flash.position().top - (flash.outerHeight(true) + marginTop)})
            })
        });
    })
})