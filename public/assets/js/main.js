$(function ($) {
    "use strict";

        /* Offset start */
        var $window = $(window),
        $body = $('body');
        // Click To Scroll 

        $('.navigation .navbar-nav a').on('click', function (event) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top -80
            }, 1000);
            event.preventDefault();
        });


        // Navbar collapse on click
        $('.nav-link').on('click', function () {
            $('.navbar-collapse').collapse('hide');
        });

        // Product deal countdown
        $('[data-countdown]').each(function () {
            var $this = $(this),
                finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function (event) {
                $this.html(event.strftime('<span>%D <small>Days</small></span> <span>%H <small>Hrs</small></span>  <span>%M <small>Min</small></span> <span>%S <small>Sec</small></span>'));
            });
        });

        // bottom to top js start
        var html_body = $('html, body');
        var amountScrolled = 300;
        var bootomclass = $('.bottomtotop');
        bootomclass.hide();
        $window.on('scroll', function () {
            if ($window.scrollTop() > amountScrolled) {
                bootomclass.fadeIn('slow');
            } else {
                bootomclass.fadeOut('slow');
            }
            if ($(".navigation").offset().top > 0) {
                $(".navigation").addClass("stiky-nav");
            } else {
                $(".navigation").removeClass("stiky-nav");
            }
        });

        bootomclass.on('click', function () {
            html_body.animate({
                scrollTop: 0
            }, 600);
            return false;
        });

    //scrollspy menu
    $body.scrollspy({
        target: '#mainmenu',
        offset: 100
    });
    //   magnific popup activation
    $('.video-play-btn').magnificPopup({
        type: 'video'
    });
    $('.img-popup').magnificPopup({
        type: 'image'
    });

    //Aos Active js
    AOS.init({
        easing: 'ease-out-back',
        duration: 1000
    });    

    // deal_slider 
    var $deal_slider = $('.deal-slider');
    $deal_slider.owlCarousel({
    loop: true,
    nav: false,
    autoplay:false,
    dots:false,
    margin:30,
    autoplayTimeout: 3000,
    smartSpeed: 1200,
    responsive: {
        0: {
            items: 1
        },
        576: {
            items: 1
        },
        950: {
            items: 1
        },
        960: {
            items: 1
        },
        1200: {
            items: 1
        }
    }
    });
    // testimonial-slider 
    var $testimonialSlider = $('.testimonial-slider');
        $testimonialSlider.owlCarousel({
        loop: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        nav: true,
        dots:false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        autoplayTimeout: 6000,
        smartSpeed: 1200,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            950: {
                items: 1
            },
            960: {
                items: 1
            },
            1200: {
                items: 1
            }
        }
    });

    // product_slider
    var $product_slider = $('.product-slider');
        $product_slider.owlCarousel({
        loop: true,
        nav: true, navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        dots: false,
        margin:30,
        autoplay: false,
        autoplayTimeout: 8000,
        smartSpeed: 1500,
        responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            },
            1200: {
                items: 4
            },
            1920: {
                items: 4
            }
        }
    });
    
    // twitte-slider
    var $twitte_slider = $('.twitte-slider');
    $twitte_slider.owlCarousel({
    loop: true,
    nav: true,
    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
    dots: false,
    margin:30,
    autoplay: true,
    center: true,
    autoplayTimeout: 2500,
    smartSpeed: 1500,
    responsive: {
            0: {
                items: 1
            },
            576: {
                items: 1
            }
            }
        });

    //  preloader js start 
    $window.on('load', function () {
    setTimeout(function () {
        $('#preloader').fadeOut('slow', function () {});
    }, 600);
    });

    

});
