$(document).ready(function() {
    //slick slider on home page
    $('.single-item').slick({
        autoplay: true
    });
    //remove p tag for image once uploaded from the tinyMCE editor
    var imageResponsive = $(".responsive-img");

    if (imageResponsive.parent().is("p")) {
        var imageResponsive = imageResponsive.parent();
    }
    $(imageResponsive).wrap("<div class='responsive'></div>");

    //function to resize images in the pages which have class .responsive-img
    function resizeImg() {
        var width = $(window).width();
        var height = $(window).height();
        var img = $(".responsive-img");
        var imgWidth = img.width();
        var imgHeight = img.height();
        if (imgWidth > width) {
            $(".responsive-img").css({
                'width': '100%',
                'height': 'auto'
            });
        } else {
            imgWidth = img.width();
            imgHeight = img.height();
        }
    }
    //call to function
    resizeImg();
    //call to function on manually resize of the window
    jQuery(window).resize(function() {
        resizeImg();
    });
    var img = $("img").css({
        'max-width': '100%',
        'height': 'auto'
    });
    //check if image has float and if so apply to wrap div
    /*if ($('.responsive-img').css("float") == "left"){
        $( ".responsive" ).css("float", "left");
        $('.responsive-img').css("margin-right", "1em");
    }
    if ($('.responsive-img').css("float") == "right"){
        $( ".responsive" ).css("float", "right");
        $('.responsive-img').css("margin-left", "1em");
    }*/


});
/******************************************************************/