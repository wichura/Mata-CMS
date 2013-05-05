$(window).ready(function() {

    var isRetina = window.devicePixelRatio > 1;

    if (isRetina)
        $("img").each(function(i, el) {
            var newImg = $(new Image());
            var newSrc =
                    $(el).attr("src").substring(0, $(el).attr("src").lastIndexOf(".")) + "@x2" +
                    $(el).attr("src").substring($(el).attr("src").lastIndexOf("."), $(el).attr("src").length);

            newImg.src = newSrc;
            $(newImg).load(function() {

                if ($(el).hasClass("no-rescale") == false)
                    $(el).css({
                        width: newImg.width() / 2,
                        height: newImg.height() / 2
                    })

                $(el).attr("src", newSrc)
            })
        })
})