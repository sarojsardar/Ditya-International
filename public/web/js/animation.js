$(function(){
    var windows = $(window),
        header = $("#header"),
        icon = $("#nav-icon"),
        isOpenNav = false,
        navLink = $(".nav-link-true"),
        currentPage = window.location.href.split('/').splice(-1)[0];

    var data = {
          scrolling: false,
          main: $(".main-true").length > 0,
    }
    var methods = {
        scrollAnimate() {
            var offsets = windows.scrollTop() + windows.height(),
                animateItem = $(".animate-true:not(.done)"),
                animateItemLength = animateItem.length,
                animate;
            if(animateItemLength ) {
                for (animate = 0; animate < animateItemLength; animate++) {
                    var animatable = animateItem.eq(animate),
                        type = animatable.attr("data-animatetype"),
                        delay = animatable.attr("data-delay")
                    if (!animatable.hasClass('done')) {
                        if ((animatable.offset().top + animatable.height()) < offsets + animatable.height() - 30) {
                            animatable.addClass(type).addClass(delay).addClass("done")
                        }
                    }
                }
            }else {}
        },
         fixedHeader() {
            var header = $("header");
            if(!header.hasClass("isNavopen")) {
                if (data.main) {
                    if (windows.scrollTop() > $(".main-true").height() / 2) {
                       header.addClass("isActive");
                    } else {
                       header.removeClass("isActive");
                    }
                } else {
                   header.addClass("isActive");
                }
            }
        },
        
        imageonWindowTop () {
            var imgOffset = windows.scrollTop() > experienceEl.offset().top - header.height(),
                endOffset = windows.scrollTop() > $("#endExperience").offset().top - experienceImage.height()
            return imgOffset && !endOffset;
        },
        exploreNav (el) {
            el.toggleClass("isOpenTRUE");
            header.removeClass("isActive")
            isOpenNav = el.hasClass("isOpenTRUE")
            icon.toggleClass('open')
            if(isOpenNav) {
                $(".fullScreen-nav").toggle()
                setTimeout(function() {
                    $(".nav-content").toggleClass("active")
                    header.toggleClass("isNavopen");
                }, 200)
            }else {
                header.toggleClass("isNavopen");
                navLink.addClass("opacityNow")
                $("#nav-logo").addClass("opacityNow")
                $(".nav-content").toggleClass("active")
                setTimeout(function() {
                    $(".fullScreen-nav").toggle()
                    navLink.removeClass("opacityNow")
                    $("#nav-logo").removeClass("opacityNow")
                    methods.fixedHeader()
                }, 400)

            }
        },
        
     }


    windows.on('scroll', function() {
        data.scrolling = true;
        methods.scrollAnimate()
    });
    
    methods.scrollAnimate()
    $("#explore-nav").on("click", function (e) {
        methods.exploreNav($(this))
        e.preventDefault()
    })
    $(".close-full-nav").on("click", function (e) {
        methods.exploreNav($(this))
        e.preventDefault()
    })

});