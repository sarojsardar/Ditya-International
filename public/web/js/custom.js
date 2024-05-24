$(document).ready(function () {

    // Mobile Nav
    $("#menu1").metisMenu();
    // MObile Nav End

    // Side menubar
    $('#close-btn, .toggle-btn').click(function (e) {

        e.preventDefault();
        e.stopPropagation();
        $('#mySidenav, .body-bg').toggleClass("active");

    });
    $('#mySidenav').click(function (e) {

        e.stopPropagation();

    });
    $('body').click(function () {

        $('#mySidenav').removeClass('active');

    });



    // Portfolio
    $(document).ready(function () {
        $('.portfolio').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            centerMode: true,
            centerPadding: '0',
            infinite: true,
            focusOnSelect: true,
            touchMove: true,
            responsive: [
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        centerMode: false,
                    }
                }
            ]
        });

    });
    // Portfolio End


    // Extra Document
    $(document).ready(function () {
        $('.extra-document').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            dots: false,
            centerMode: true,
            centerPadding: '0',
            infinite: true,
            focusOnSelect: true,
            touchMove: true,
            responsive: [
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                        centerMode: false,
                    }
                }
            ]
        });

    });
    // Extra Document End


    // Partners
    $(document).ready(function () {
        $('#partners').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            infinite: true,
            focusOnSelect: true,
            touchMove: true,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 5,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 2,
                    }
                }
            ]
        });

    });
    // Partners End



    // Testimonials
    $(document).ready(function () {
        $('#testimonials').slick({
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: false,
            dots: false,
            infinite: true,
            focusOnSelect: true,
            touchMove: true,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });

    });
    // Testimonials End

    // Gallery
    $('#lightgallery').lightGallery();
    // Gallery End

    // Skip Ads
    $(".skip-ads-head .btn").on("click", function () {
        $(".skip-ads").addClass("active");
    });

    $(function () {
        setTimeout(function () {
            $(".skip-ads").fadeOut(1000);
        }, 10000);
    });
    // Skip Ads End
});
