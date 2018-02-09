/*global jQuery */
/*jshint browser:true */
/*!
 * FitVids 1.1
 *
 * Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 */

;(function( $ ){

    'use strict';

    $.fn.fitVids = function( options ) {
        var settings = {
            customSelector: null,
            ignore: null
        };

        if(!document.getElementById('fit-vids-style')) {
            // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
            var head = document.head || document.getElementsByTagName('head')[0];
            var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
            var div = document.createElement("div");
            div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
            head.appendChild(div.childNodes[1]);
        }

        if ( options ) {
            $.extend( settings, options );
        }

        return this.each(function(){
            var selectors = [
                'iframe[src*="player.vimeo.com"]',
                'iframe[src*="youtube.com"]',
                'iframe[src*="youtube-nocookie.com"]',
                'iframe[src*="kickstarter.com"][src*="video.html"]',
                'object',
                'embed'
            ];

            if (settings.customSelector) {
                selectors.push(settings.customSelector);
            }

            var ignoreList = '.fitvidsignore';

            if(settings.ignore) {
                ignoreList = ignoreList + ', ' + settings.ignore;
            }

            var $allVideos = $(this).find(selectors.join(','));
            $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
            $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

            $allVideos.each(function(){
                var $this = $(this);
                if($this.parents(ignoreList).length > 0) {
                    return; // Disable FitVids on this video.
                }
                if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
                if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
                {
                    $this.attr('height', 9);
                    $this.attr('width', 16);
                }
                var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
                    width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                    aspectRatio = height / width;
                if(!$this.attr('id')){
                    var videoID = 'fitvid' + Math.floor(Math.random()*999999);
                    $this.attr('id', videoID);
                }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
                $this.removeAttr('height').removeAttr('width');
            });
        });
    };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );
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