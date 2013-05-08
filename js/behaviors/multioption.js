$(window).ready(function() {
    $("body").on("click", ".multioption-element", function() {
        $(this).toggleClass("active");
        $(this).find("input[type=hidden]").val($(this).hasClass("active") ? 1 : 0)
    })
})
