$(function () {
    // Back to Top //
    var btn = $("#Back2Top");

    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll > 1200) {
            btn.addClass("b2tshow");
        } else {
            btn.removeClass("b2tshow");
        }
    });

    btn.on('click', function (e) {
        e.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, '300');
    });

    // categorylist-section //
    $("#card1").click(function () {
        $(".card1").show();
        $(".card2, .card3, .card4, .card5, .card6, .card7, .card8, .card9, .card10").toggle();
    });
    $("#card2").click(function () {
        $(".card2").show();
        $(".card1, .card3, .card4, .card5, .card6, .card7, .card8, .card9, .card10").toggle();
    });
    $("#card3").click(function () {
        $(".card3").show();
        $(".card2, .card1, .card4, .card5, .card6, .card7, .card8, .card9, .card10").toggle();
    });
    $("#card4").click(function () {
        $(".card4").show();
        $(".card2, .card3, .card1, .card5, .card6, .card7, .card8, .card9, .card10").toggle();
    });
    $("#card5").click(function () {
        $(".card5").show();
        $(".card2, .card3, .card4, .card1, .card6, .card7, .card8, .card9, .card10").toggle();
    });
    $("#card6").click(function () {
        $(".card6").show();
        $(".card2, .card3, .card4, .card5, .card1, .card7, .card8, .card9, .card10").toggle();
    });
    $("#card7").click(function () {
        $(".card7").show();
        $(".card2, .card3, .card4, .card5, .card6, .card1, .card8, .card9, .card10").toggle();
    });
    $("#card8").click(function () {
        $(".card8").show();
        $(".card2, .card3, .card4, .card5, .card6, .card7, .card1, .card9, .card10").toggle();
    });
    $("#card9").click(function () {
        $(".card9").show();
        $(".card2, .card3, .card4, .card5, .card6, .card7, .card8, .card1, .card10").toggle();
    });
    $("#card10").click(function () {
        $(".card10").show();
        $(".card2, .card3, .card4, .card5, .card6, .card7, .card8, .card9, .card1").toggle();
    });
    
    // Scrollbar auto height
    $(document).ready(function(){
        var height = $(".scrollbar").height();
        if(height >= 500) {
            $('.scrollbar').removeClass('hide-scroll');
        } else {
            $('.scrollbar').addClass('hide-scroll');
        }
    })

});