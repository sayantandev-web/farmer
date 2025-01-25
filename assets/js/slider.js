$(document).ready(() => {
    $(".owl-carousel").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        smartSpeed: 2000,
        autoplayHoverPause: false
    });

    $(".owl-carousel").mousedown(() => {
        gsap.fromTo(
            cursorVerticalGrab, {
                css: {
                    transform: "scale(0, 0)"
                }
            }, {
                duration: 0.6,
                ease: "back.out(1.7)",
                css: {
                    transform: "scale(1, 1)"
                }
            }
        );
    });
});