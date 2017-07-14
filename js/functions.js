jQuery(document).ready(function($){

    var body = $('body');
    var siteHeader = $('#site-header');
    var titleContainer = $('#title-container');
    var toggleNavigation = $('#toggle-navigation');
    var menuPrimaryContainer = $('#menu-primary-container');
    var menuPrimary = $('#menu-primary');
    var menuPrimaryItems = $('#menu-primary-items');
    var toggleDropdown = $('.toggle-dropdown');
    //var toggleSidebar = $('#toggle-sidebar');
    //var sidebarPrimary = $('#sidebar-primary');
    //var sidebarPrimaryContent = $('#sidebar-primary-content');
    //var sidebarWidgets = $('#sidebar-primary-widgets');
    //var socialMediaIcons = siteHeader.find('.social-media-icons');
    var menuLink = $('.menu-item').children('a');

    objectFitAdjustment();

    toggleNavigation.on('click', openPrimaryMenu);

    $('.post-content').fitVids({
        customSelector: 'iframe[src*="dailymotion.com"], iframe[src*="slideshare.net"], iframe[src*="animoto.com"], iframe[src*="blip.tv"], iframe[src*="funnyordie.com"], iframe[src*="hulu.com"], iframe[src*="ted.com"], iframe[src*="wordpress.tv"]'
    });

    $(window).resize(function(){
        objectFitAdjustment();
    });

    // Jetpack infinite scroll event that reloads posts.
    $( document.body ).on( 'post-load', function () {
        objectFitAdjustment();
    } );

    function openPrimaryMenu() {

        if( menuPrimaryContainer.hasClass('open') ) {
            menuPrimaryContainer.removeClass('open');
            $(this).removeClass('open');
            body.removeClass('noscroll');
            
            // remove status of open menus
            menuPrimaryContainer.find('.current').removeClass('current');
            menuPrimaryContainer.find('.current-ancestor').removeClass('current-ancestor');
            
            // reset to "tier-1" class
            var classes = menuPrimaryContainer.attr('class');
            var subString = classes.indexOf( 'tier-' ); // 23
            var tierClass = classes.slice( subString, subString + 6 ); // tier-1
            menuPrimaryContainer.removeClass( tierClass );
            menuPrimaryContainer.addClass('tier-1');

            $('.label').text('');

            // change screen reader text
            //$(this).children('span').text(objectL10n.openMenu);

            // change aria text
            $(this).attr('aria-expanded', 'false');

        } else {
            menuPrimaryContainer.addClass('open');
            $(this).addClass('open');
            body.addClass('noscroll');

            // change screen reader text
            //$(this).children('span').text(objectL10n.closeMenu);

            // change aria text
            $(this).attr('aria-expanded', 'true');
        }
    }
    
    function moveSecondaryMenu() {
        
        if ( window.innerWidth < 700 ) {
            menuPrimaryContainer.append( $('#menu-secondary-container') );
            $('#menu-secondary-container').addClass('moved');

            menuPrimaryContainer.append( $('#social-media-icons') );
            $('#social-media-icons').addClass('moved');
        }
    }
    moveSecondaryMenu();

    $(window).load(function() {
        // adjust mobile menu to fit right
        if ( window.innerWidth < 700 ) {
            var newHeight = siteHeader.outerHeight(false);
            if ( window.innerWidth < 783 && body.hasClass('admin-bar') ) {
                newHeight += 46;
            }
            menuPrimaryContainer.css('top', newHeight + 'px' );
        }
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

        // add new class
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

    $('#search-toggle').on('click', openSearchBar);
    $('#close-search').on('click', openSearchBar);
    function openSearchBar(){

        if( body.hasClass('display-search') ) {
            body.removeClass('display-search');
            // make search input inaccessible to keyboards
            siteHeader.find('.search-field').attr('tabindex', -1);
        } else {
            body.addClass('display-search');
            // make search input keyboard accessible
            siteHeader.find('.search-field').attr('tabindex', 0);
            // put cursor into the search input (delay 0.25 b/c of CSS transition)
            setTimeout( function() {
                $('#search-form-popup').find('#search-field').focus();
            }, 250);
        }
    }

    /* allow keyboard access/visibility for dropdown menu items */
    menuLink.focus(function(){
        $(this).parents('ul').addClass('focused');
    });
    menuLink.focusout(function(){
        $(this).parents('ul').removeClass('focused');
    });

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

/* fix for skip-to-content link bug in Chrome & IE9 */
window.addEventListener("hashchange", function(event) {

    var element = document.getElementById(location.hash.substring(1));

    if (element) {

        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
            element.tabIndex = -1;
        }

        element.focus();
    }

}, false);