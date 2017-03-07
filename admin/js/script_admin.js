$(document).ready(function() {
    //function to prompt the user to delete or not
    $(".confirm").click(function(e) {
        var link = this;
        //this prevent to follow link
        e.preventDefault();

        $("#dialog1").dialog({
            buttons: {
                "YES": function() {
                    window.location = link.href;
                },
                "NO": function() {
                    $(this).dialog('close');
                }
            }
        });
    });
    $("img").addClass("size-max");

    $('input.checkbox_icons').change(function() {
        if ($(this).is(':checked')) {
            $(this).next('input.social-url').addClass("visible");
        } else {
            $(this).next('input.social-url').removeClass("visible");
        }
    }).change();

    $('.reveal-modify').hide();
    $(".modify").click(function() {
        $(this).find(".rotate").toggleClass("down");
        $(this).nextAll('.reveal-modify').slideToggle("slow");
    });

    //function to scroll to error p tag
    /*if( $('.error').not(':empty') ) {
        $('html, body').animate({
            scrollTop: $('.error').offset().top
        }, 2000);
    }*/
}); //close document ready

//img.css({'max-width':'1170px', 'height':'auto'});

function confirmPageDelete($this) {
    $("#dialog2").dialog({
        buttons: {
            "YES": function() {
                $this.form.submit();
            },
            "NO": function() {
                $(this).dialog('close');
                window.location.reload();
            }
        }
    });
}

function confirmArticleDelete($this) {
    $("#dialog3").dialog({
        buttons: {
            "YES": function() {
                $this.form.submit();
            },
            "NO": function() {
                $(this).dialog('close');
                window.location.reload();
            }
        }
    });
}