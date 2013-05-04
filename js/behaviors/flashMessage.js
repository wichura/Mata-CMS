$(window).ready(function() {
    
    var lastFlash = null;
    var lastTargetTop = null;
    $("*[class^='flash-']").each(function(i) {

        // enable displaying multiple flash messages
        var marginTop = 10;
        var flash = $(this);
        var targetTop = lastFlash != null ? lastTargetTop + lastFlash.outerHeight() + marginTop : 10;
        flash.delay(300 * (i+1)).transition({
            top: targetTop,
            opacity: 1
        }, 700)

        lastFlash = flash;
        lastTargetTop = targetTop;

        $(this).delay(3000 * (i + 1)).transition({opacity: 0}, function() {
            $(this).remove();
            
            $("*[class^='flash-']").each(function() {
                flash = $(this)
                flash.css({top: flash.position().top - (flash.outerHeight(true) + marginTop)})
            })
        });
    })
})