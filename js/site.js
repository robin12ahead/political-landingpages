$ = jQuery;
$(document).ready(function () {

    $('.acf-field-select').each(function() {
        var selectLabel = $(this).find('.acf-label > label').text();

        $(this).find('.acf-input > select').attr('data-placeholder', selectLabel)
        $(this).find('.acf-input > select option:first').text(selectLabel)
    });

    /*--------------------------------------------
    Navbar
    --------------------------------------------*/
    // Navbar toggle
    $('.navbar-toggle').click(function () {
        $(this).toggleClass('is-active');
        $('body').toggleClass('overflow-hidden');
        $('#main-nav').toggleClass('menu-open');
        $('#site-header').toggleClass('header-open');
        $('#site-header #main-navbar').toggleClass('navbar-dark');
    });

    $('#main-menu .nav-link').click(function () {
        $('body').removeClass('overflow-hidden');
        $('.navbar-toggle').removeClass('is-active');
        $('#main-nav').removeClass('menu-open');
        $('#site-header').removeClass('header-open');
        $('#site-header #main-navbar').removeClass('navbar-dark');
    });

    $(window).on('resize load', function () {
        // add padding to main according to header height
        var navbarheight = $('header#site-header').outerHeight();
        $('main.site-main').css('padding-top', navbarheight);
    })

    $('#primary-menu').find('.menu-item-has-children').each(function() {
        $(this).children('a.nav-link').wrap('<div class="dropdown-wrapper"></div>');
        $(this).find('.dropdown-wrapper').append('<span class="dropdown-icon"></span>');

        // on touch devices
        if(window.matchMedia("(pointer: coarse)").matches) {
            $(this).click(function() {
                $(this).toggleClass('collapsed');
                $(this).find('.dropdown-icon').toggleClass('open');
            })
        } else {
            $(this).on('mouseenter', function() {
                $(this).find('.dropdown-icon').addClass('open');
            })
    
            $(this).on('mouseleave', function() {
                $(this).find('.dropdown-icon').removeClass('open');
            })
        }

    });

    /*--------------------------------------------
    Accordions 
    --------------------------------------------*/

    $('.accordion-item').each(function () {
        var currentAccordion = $(this);
        $(this).find('.accordion-trigger').click(function () {
            $(currentAccordion).toggleClass('collapsed');
            $(this).find('.accordion_trigger-icon').toggleClass('collapsed');
        })
    });

    /*--------------------------------------------
    Floating placeholders 
    --------------------------------------------*/

    // Add floating placeholder label to all form fields
    $('input, textarea, select, .wpcf7-form-control').each(function () {

        if ( $(this).attr('type') !== 'checkbox' &&  $(this).attr('type') !== 'file') {

            // remove all test placeholders beforehand
            $(this).parent().find('.form_placeholder').remove();

            // get the correct placeholder text
            let placeholder_text = "";
            if ($(this).is('input, textarea')) {
                placeholder_text = $(this).attr('placeholder');
            } else if ($(this).is('select')) {
                placeholder_text = $(this).find("option:first-child").text();
            }

            // define placeholder html
            let placeholder_html = '<label class="form_placeholder">' + placeholder_text + '</label>';

            // put placeholder before each input
            $(this).before(placeholder_html);

            // hide all placeholders
            $('.form_placeholder').hide();

            // show each placeholder if input is filled
            if ($(this).attr('type') == 'date') {
                $(this).on('focus', function (e) {
                    $(this).parent().find('.form_placeholder').show();
                });
            } else {
                $(this).on('input', function (e) {
                    if ($(this).val()) {
                        $(this).parent().find('.form_placeholder').show();
                    } else {
                        $(this).parent().find('.form_placeholder').hide();
                    }
                });
            }

        }
    });

    /*--------------------------------------------
    copy url to clickboard
    --------------------------------------------*/

    $('[data-copy-clipboard="click"]').click(function () {
        var url = window.location.href;
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(url).select();
        document.execCommand('copy');
        tempInput.remove();

        var copiedText = $(this).attr('data-copy-clickboard-text');
        $(this).find('[data-copy-clipboard="notice"]').text(copiedText);
    });
    
    /*--------------------------------------------
    Sticky Navbar hide on scroll
    --------------------------------------------*/
        
    // hide navbar on scroll
    var prevScrollpos = window.pageYOffset;
    var headerSelector = $('header#site-header');
    
    window.onscroll = function() {
      var currentScrollPos = window.pageYOffset;

      if (currentScrollPos < 16) {
      	$(headerSelector).removeClass('navbar-hide');
      } else if (prevScrollpos > currentScrollPos) {
        $(headerSelector).removeClass('navbar-hide');
      } else {
        $(headerSelector).addClass('navbar-hide');
      }
      prevScrollpos = currentScrollPos;
      
      if (currentScrollPos > 48) {
      	$(headerSelector).addClass('navbar-sticky');
      } else {
      	$(headerSelector).removeClass('navbar-sticky');
      }
    }
        
    /*--------------------------------------------
    Hero scroll-down button
    --------------------------------------------*/

    $('.scroll-to-main').each(function () {
        $(this).on('click', function () {
            let heroHeight = $(this).parent().outerHeight();
            let headerHeight = $('header#site-header').outerHeight();
            $('html, body').animate({
                scrollTop: heroHeight + headerHeight
            }, 0);
        })
    })


    $('.scroll-to-top').each(function () {
        $(this).on('click', function () {
            $('html, body').animate({
                scrollTop: 0
            }, 0);
        })
    })


    /*--------------------------------------------
    Other Stuff
    --------------------------------------------*/
    // add row to acf frontend forms
    $('.acf-fields.-top.-border').addClass('row');

    // add required attr to all .required class
    $('.required').attr("required", "true");;

    // cookie banner open link
    $('.nav-link[title="revisit-consent"]').attr('data-cky-tag', 'revisit-consent');
    $('.nav-link[title="revisit-consent"]').addClass('cky-banner-element');

    // wrap pagination links
    $('.pagination-wrapper').each(function() {
        $(this).find('.page-numbers:not(.next):not(.prev)').wrapAll('<div class="pagination-numbers"></div>');
    });


});

// document.addEventListener('DOMContentLoaded', function() {
//     if(typeof(Storage) !== 'undefined') {
//         // See if there is a scroll pos and go there.
//         var lastYPos = +localStorage.getItem('scrollYPos');
//         if (lastYPos) {
//             // console.log('Setting scroll pos to:', lastYPos);
//             // window.scrollTo(0, lastYPos);
//             window.scrollTo({
//                 top: lastYPos,
//                 behavior: 'instant'
//               })
//         }

//         // On navigating away first save the position.
//         var anchors = document.querySelectorAll('.page-numbers');

//         var onNavClick = function() {
//             // console.log('Saving scroll pos to:', window.scrollY);
//             localStorage.setItem('scrollYPos', window.scrollY);
//         };

//         for (var i = 0; i < anchors.length; i++) {
//             anchors[i].addEventListener('click', onNavClick);
//         }
//     }
// });