$(document).ready(function() {
    $(document).on('mouseenter', '#masthead .navbar li.menu-item-has-children', function() {
        var $this = $(this),
            $button;
    });
    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();

        var target = $(this).attr('href');
        var $target = $(target);

        if ($target.length) {
            var offsetTop = $target.offset().top - 50;

            $('html, body').animate({
                scrollTop: offsetTop
            }, 600);

            history.pushState(null, null, target);
        }
    });

    var $sidemenu_banner = null;
    var $home_introduction_banner = null;
    if( $('.sidemenu-banner.swiper')[0] ) {
        $sidemenu_banner = new Swiper('.sidemenu-banner.swiper', {
            slidesPerView: 1,
        });
    }

    if( $('.swiper-introduction-banner.swiper')[0] ) {
        $home_introduction_banner = new Swiper('.swiper-introduction-banner', {
            slidesPerView: 1,
            effect: "coverflow",
            preloadImages: false,
            loop: true,
            autoplay: {
                delay: 8000,
                disableOnInteraction: false,
            },
            coverflowEffect: {
                rotate: 85,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            pagination: {
                el: '.swiper-introduction-banner .intro-banner-pagination'
            }
        });
    }

    $(document).on('click', '#masthead .navbar .menu-toggler', function(e) {
        e.preventDefault();
        var $button = $(this),
            $navbar = $button.closest('nav.navbar'),
            $side_menu = $navbar.siblings('.side-menu-wrapper');
        $navbar.addClass('navbar-opened');
        $side_menu.addClass('open');
    });
    $(document).on('click', '#masthead .side-menu-wrapper .close-side-menu', function(e) {
        e.preventDefault();
        var $button = $(this),
            $side_menu = $button.closest('.side-menu-wrapper'),
            $navbar = $side_menu.siblings('.navbar');
        $navbar.removeClass('navbar-opened');
        $side_menu.removeClass('open');
    });

    $('.gpSlider.swiper').each(function() {
        var $slider = $(this);
        new Swiper($slider[0], {
            slidesPerView: "auto",
            spaceBetween: 16,
            loop: true,
            slidesOffsetBefore: 0,
            slidesOffsetAfter: 0,
        });
    });

    $('.result-board.swiper').each(function() {
        var $slider = $(this),
            $speed = 300,
            $autoplay = false,
            $autoplayTimeout = 8500,
            $ppp = 3,
            $spaceBetween = 24;
        if( $slider.hasClass('infinite-swiper') ) {
            $speed = 6000;
            $autoplay = true;
            $autoplayTimeout = 0;
            $ppp = "auto";
            $spaceBetween = 15;
        }
        new Swiper($slider[0], {
            slidesPerView: $ppp,
            speed: $speed,
            autoplay: true ? {
                delay: $autoplayTimeout,
                disableOnInteraction: false,
            } : false,
            breakpoints: {
                0: {
                    slidesPerView: "auto",
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: $ppp,
                    spaceBetween: $spaceBetween,
                }
            }
        });
    });
});