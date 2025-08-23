(function ($) {
    "use strict";
    
    // Dropdown on mouse hover with gap fix
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                // Main dropdown hover
                $('.navbar .dropdown').on('mouseenter', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseleave', function () {
                    var $this = $(this);
                    // Add delay to prevent immediate closing
                    setTimeout(function() {
                        if (!$this.is(':hover') && !$this.find('.dropdown-menu:hover').length) {
                            $('.dropdown-toggle', $this).trigger('click').blur();
                        }
                    }, 150);
                });
                
                // Keep dropdown open when hovering over menu items
                $('.navbar .dropdown-menu').on('mouseenter', function() {
                    $(this).parent().addClass('show');
                }).on('mouseleave', function() {
                    var $this = $(this);
                    setTimeout(function() {
                        if (!$this.is(':hover') && !$this.parent().is(':hover')) {
                            $this.parent().removeClass('show');
                        }
                    }, 150);
                });
                
                // Handle submenu hover
                $('.dropdown-submenu').on('mouseenter', function() {
                    $(this).find('.dropdown-menu').addClass('show');
                }).on('mouseleave', function() {
                    var $this = $(this);
                    setTimeout(function() {
                        if (!$this.is(':hover')) {
                            $this.find('.dropdown-menu').removeClass('show');
                        }
                    }, 150);
                });
                
                // Handle clicks on dropdown items
                $('.navbar .dropdown-item').not('.dropdown-toggle').on('click', function(e) {
                    // Close dropdown after click
                    setTimeout(function() {
                        $('.navbar .dropdown-menu').removeClass('show');
                        $('.navbar .dropdown').removeClass('show');
                    }, 200);
                });
                
            } else {
                $('.navbar .dropdown').off('mouseenter').off('mouseleave');
                $('.navbar .dropdown-menu').off('mouseenter').off('mouseleave');
                $('.dropdown-submenu').off('mouseenter').off('mouseleave');
                $('.navbar .dropdown-item').off('click');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Date and time picker
    $('#date').datetimepicker({
        format: 'L'
    });
    $('#time').datetimepicker({
        format: 'LT'
    });


    // Service carousel
    $(".service-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        margin: 30,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });


    // Team carousel
    $(".team-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        margin: 30,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:4
            }
        }
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        center: true,
        autoplay: true,
        smartSpeed: 1000,
        margin: 30,
        dots: true,
        loop: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    
})(jQuery);

