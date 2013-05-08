mata.dialogBox = mata.dialogBox || {};

mata.dialogBox.renderView = function(dialogTitle, url, clickHandler) {
    var overlay = $("<div class='screen-overlay animated' />")
    $("body").append(overlay)
    overlay.transition({opacity: 0.5});


    $.ajax(url).success(function(data) {

        var wrapper = $("<div class='dialog-box' id='project-selector' />");
        wrapper.append($("<h2 />").html(dialogTitle));
        wrapper.append(data);
        $("body").append(wrapper);

        wrapper.transition({
            padding: "20px",
            opacity: 1,
            "margin-left": "-245px",
            "margin-top": "-15px"
        });

        wrapper.find(".multioption-element").on("click", clickHandler)

        $(document).bind("keyup.screen-overlay", function(e) {
            if (e.keyCode == 27) {
                mata.dialogBox.hide();
                e.stopPropagation();
            }

        });
    })

}

mata.dialogBox.hide = function() {
    $(".dialog-box").transition({
        padding: "15px",
        opacity: 0,
        "margin-left": "-240px",
        "margin-top": "-10px"

    }, function() {
        $(this).remove();
    });

    $(".screen-overlay").transition({
        opacity: 0
    }, function() {
        $(this).remove();
    })

    $(document).unbind("keyup.screen-overlay");
}
