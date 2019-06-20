i = 0;

$(document).ready(function() {
    $(".blockquote").hide(function() {
        $(this).css("opacity", 1);
    });

    var maxHeight = Math.max.apply(null, $(".blockquote").map(function (){
        return $(this).outerHeight();
    }).get());

    $("#about").outerHeight(maxHeight + 60);

    quoteFade();
    setInterval(quoteFade, 5000);
});


$(window).on('resize', function(){
    var maxHeight = Math.max.apply(null, $(".blockquote").map(function (){
        return $(this).outerHeight();
    }).get());

    $("#about").outerHeight(maxHeight + 60);
});


function quoteFade() {
    $(".blockquote").fadeOut("slow", "swing", function() {
        // console.log("HEY");
    });

    $(".blockquote").eq(i).fadeIn("slow", "swing", function() {
        if (i < $(".blockquote").length - 1) {
            i += 1;
        } else {
            i = 0;
        }
    });
}
