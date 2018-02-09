jQuery(document).ready(function($){

    var body = $('body');
    var siteHeader = $('#site-header');
    var toggleNavigation = $('#toggle-navigation');
    var menuPrimaryContainer = $('#menu-primary-container');
    var menuSecondaryContainer = $('#menu-secondary-container');
    var toggleDropdown = $('.toggle-dropdown');
    var socialIcons =  $('#social-media-icons');

    $('.post-content').fitVids({
        customSelector: 'iframe[src*="dailymotion.com"], iframe[src*="slideshare.net"], iframe[src*="animoto.com"], iframe[src*="blip.tv"], iframe[src*="funnyordie.com"], iframe[src*="hulu.com"], iframe[src*="ted.com"], iframe[src*="wordpress.tv"]'
    });

    /* Object fit cross-browser support */
    
    objectFitAdjustment();
    $(window).resize(function(){
        objectFitAdjustment();
        adjustMenuTopPosition();
    });
    // Jetpack infinite scroll event that reloads posts.
    $( document.body ).on( 'post-load', function () {
        objectFitAdjustment();
    } );

    /* Mobile menu - primary menu */

    toggleNavigation.on('click', openPrimaryMenu);
    function openPrimaryMenu() {

        if( menuPrimaryContainer.hasClass('open') ) {
            menuPrimaryContainer.removeClass('open');
            $(this).removeClass('open');
            
            // remove status of open menus
            menuPrimaryContainer.find('.current').removeClass('current');
            menuPrimaryContainer.find('.current-ancestor').removeClass('current-ancestor');
            
            // reset to "tier-1" class
            var classes = menuPrimaryContainer.attr('class');
            var subString = classes.indexOf( 'tier-' ); // 23
            var tierClass = classes.slice( subString, subString + 6 ); // tier-1
            menuPrimaryContainer.removeClass( tierClass );
            menuPrimaryContainer.addClass('tier-1');

            // reset sub-menu label
            $('.label').text('');

            // change screen reader text
            $(this).children('span').text(mission_news_objectL10n.openMenu);

            // change aria text
            $(this).attr('aria-expanded', 'false');

            // allow scrolling again
            body.css('overflow', 'auto');

        } else {
            menuPrimaryContainer.addClass('open');
            $(this).addClass('open');

            // change screen reader text
            $(this).children('span').text(mission_news_objectL10n.closeMenu);

            // change aria text
            $(this).attr('aria-expanded', 'true');

            // prevent scrolling entire site when bottom of menu is reached
            body.css('overflow', 'hidden');
        }
    }

    // adjust mobile menu "top" value to line up correctly in case user has extra-tall header (rare)
    function adjustMenuTopPosition() {
        if (window.innerWidth < 800) {
            var newHeight = siteHeader.outerHeight(false);
            if (body.hasClass('admin-bar')) {
                if (window.innerWidth < 783) {
                    newHeight += 46;
                } else {
                    newHeight += 32;
                }
            }
            if (body.hasClass('news-ticker') && body.hasClass('news-ticker-top')) {
                newHeight += 36;
            }
            if (body.hasClass('header-image-active')) {
                newHeight += $('#header-image').outerHeight();
            }
            menuPrimaryContainer.css('top', newHeight + 'px');
        } else {
            menuPrimaryContainer.css('top', 'auto');
        }
    }
    $(window).load(function () {
        adjustMenuTopPosition();
    });

    toggleDropdown.on('click', navigateMobileDropdowns);
    $('#back-button').on('click', navigateMobileDropdowns);
    function navigateMobileDropdowns() {

        var classes = menuPrimaryContainer.attr('class');
        var subString = classes.indexOf( 'tier-' ); // 23
        var tierClass = classes.slice( subString, subString + 6 ); // tier-1

        // remove the class
        menuPrimaryContainer.removeClass( tierClass );

        // increment/decrement the class by 1
        var number = tierClass.slice( tierClass.length-1, tierClass.length );
        if ( $(this).attr('id') == 'back-button' ) {
            number = parseInt( number ) - 1;
        } else {
            number = parseInt( number ) + 1;
        }
        tierClass = 'tier-' + number;

        menuPrimaryContainer.addClass( tierClass );

        if ( $(this).attr('id') == 'back-button' ) {
            var oldCurrent = menuPrimaryContainer.find('.current');
            // remove class from former current list item
            oldCurrent.removeClass('current current-ancestor');
            // add class to current list item
            oldCurrent.parent().parent().addClass('current');
        } else {
            $(this).parents('.current').addClass('current-ancestor');
            // remove class from former current list item
            $(this).parents('.current').removeClass('current');
            // add class to current list item
            $(this).parent().addClass('current');
        }
        // update label
        if ( tierClass == 'tier-1' ) {
            $('.label').text('');
        } else {
            $('.label').text(menuPrimaryContainer.find('.current').children('a').text());
        }
        menuPrimaryContainer.scrollTop(0);
    }
    
    function moveSecondaryMenu() {
        
        if ( window.innerWidth < 800 ) {
            menuPrimaryContainer.append(menuSecondaryContainer);
            menuSecondaryContainer.addClass('moved');

            menuPrimaryContainer.append(socialIcons);
            socialIcons.addClass('moved');
        }
    }
    moveSecondaryMenu();
    $(window).resize(function(){

        if ( window.innerWidth > 800 ) {

            // move back to regular position
            if (menuSecondaryContainer.hasClass('moved') ) {
                menuSecondaryContainer.removeClass('moved');
                $('.top-nav').append(menuSecondaryContainer);
            }
            if (socialIcons.hasClass('moved') ) {
                socialIcons.removeClass('moved');
                $('.top-nav').append(socialIcons);
            }
        } else {
            // move into mobile menu
            if ( !menuSecondaryContainer.hasClass('moved') ) {
                menuPrimaryContainer.append(menuSecondaryContainer);
                menuSecondaryContainer.addClass('moved');
            }
            if ( !socialIcons.hasClass('moved') ) {
                menuPrimaryContainer.append(socialIcons);
                socialIcons.addClass('moved');
            }
        }
    });

    $('#search-toggle').on('click', openSearchBar);
    $('#close-search').on('click', openSearchBar);
    function openSearchBar(){

        if( body.hasClass('display-search') ) {
            body.removeClass('display-search');
            // make search input inaccessible to keyboards
            siteHeader.find('.search-field').attr('tabindex', -1);

            // allow scrolling again
            body.css('overflow', 'auto');
        } else {
            body.addClass('display-search');
            // make search input keyboard accessible
            siteHeader.find('.search-field').attr('tabindex', 0);
            // put cursor into the search input (delay 0.25 b/c of CSS transition)
            setTimeout( function() {
                $('#search-form-popup').find('#search-field').focus();
            }, 250);

            // prevent background scrolling
            body.css('overflow', 'hidden');
        }
    }

    // mimic cover positioning without using cover
    function objectFitAdjustment() {

        // if the object-fit property is not supported
        if( !('object-fit' in document.body.style) ) {

            $('.featured-image').each(function () {

                if ( !$(this).parent().parent('.post').hasClass('ratio-natural') ) {

                    var image = $(this).children('img').add($(this).children('a').children('img'));

                    // don't process images twice (relevant when using infinite scroll)
                    if ( image.hasClass('no-object-fit') ) {
                        return;
                    }

                    image.addClass('no-object-fit');

                    // if the image is not wide enough to fill the space
                    if (image.outerWidth() < $(this).outerWidth()) {

                        image.css({
                            'width': '100%',
                            'min-width': '100%',
                            'max-width': '100%',
                            'height': 'auto',
                            'min-height': '100%',
                            'max-height': 'none'
                        });
                    }
                    // if the image is not tall enough to fill the space
                    if (image.outerHeight() < $(this).outerHeight()) {

                        image.css({
                            'height': '100%',
                            'min-height': '100%',
                            'max-height': '100%',
                            'width': 'auto',
                            'min-width': '100%',
                            'max-width': 'none'
                        });
                    }
                }
            });
        }
    }
});