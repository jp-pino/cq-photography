$(window).scroll(function(){
    var height = $(window).height();
    var pos = $("nav")[0].getBoundingClientRect().top;
    var offset = 500;

    var opacity = 2*(height - pos)/height - 1;
    var opacity2 = 100*(height - pos)/height - 99;
    if (opacity < 0) {
        $(".title-text").css("opacity", 0);
        $("#main-nav").css("opacity", 1);
    } else {
        $(".title-text").css("opacity", opacity);
        $("#main-nav").css("opacity", 1 - opacity/8);
    }

    if (opacity2 < 0) {
        $(".burger").css("opacity", 0);
    } else {
        $(".burger").css("opacity", opacity2);
    }

});
