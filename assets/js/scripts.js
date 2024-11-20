;(function ($) {

    'use strict';

	$('a[href=\\#]').on('click', function (e) {
		e.preventDefault();
	})

    var ShopBuilderWP = {

        _init: function () {

            var offCanvas = {
                menuBar: $('.trigger-off-canvas'),
                drawer: $('.shopbuilderwp-offcanvas-drawer'),
                drawerClass: '.shopbuilderwp-offcanvas-drawer',
                menuDropdown: $('.dropdown-menu.depth_0'),
            };

            ShopBuilderWP.menuDrawerOpen(offCanvas);
            ShopBuilderWP.offcanvasMenuToggle(offCanvas);
            ShopBuilderWP.backToTop();
            ShopBuilderWP.preLoader();
            ShopBuilderWP.menuOffset();
            ShopBuilderWP.headRoom();
            ShopBuilderWP.magnificPopup();
            ShopBuilderWP.parallaxMouse();
            ShopBuilderWP.typingEffect();
            ShopBuilderWP.widgetsFilter();
            ShopBuilderWP.tabTitleTrack();
            ShopBuilderWP.primaryButton();
        },

		// headRoom js
		headRoom: function () {
			var myElement = document.querySelector(".headroom");
			var headroom = new Headroom(myElement);
			headroom.init();

			$(window).on('scroll', function () {
				var height = $(window).scrollTop();
				if (height < 86) {
					$('.site-header').removeClass('scrolling');
				} else {
					$('.site-header').addClass('scrolling');
				}
			});

			var intHeight = $('.headroom')[0].getBoundingClientRect().height;
			$('.fixed-header-space').height(intHeight);
		},

		magnificPopup: function (){
			var yPopup = $(".popup-youtube");
			if (yPopup.length) {
				yPopup.magnificPopup({
					disableOn: 700,
					type: 'iframe',
					mainClass: 'mfp-fade',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			}
		},

		//mouse-parallax
		parallaxMouse: function () {
			const parallaxWrapper = $(".rt-image-parallax");
			if ( parallaxWrapper.length ) {
				const parallaxInstances = [];
				$('.rt-mouse-parallax').each(function(index) {
					var $this = $(this);
					$this.attr('id', "rt-parallax-instance-" + index);
					if ($(window).width() > 1199) {
						parallaxInstances[index] = new Parallax($("#rt-parallax-instance-" + index).get(0), {});
					}
				});
			}
		},

		menuOffset: function () {
            $(".dropdown-menu > li").each(function () {
                var $this = $(this),
                    $win = $(window);

                if ($this.offset().left + ($this.width() + 30) > $win.width() + $win.scrollLeft() - $this.width()) {
                    $this.addClass("dropdown-inverse");
                } else if ($this.offset().left < ($this.width() + 30)) {
                    $this.addClass("dropdown-inverse-left");
                } else {
                    $this.removeClass("dropdown-inverse");
                }
            });
        },

        menuDrawerOpen: function (offCanvas) {
            offCanvas.menuBar.on('click', e => {
                e.preventDefault();
                offCanvas.menuBar.toggleClass('is-open')
                offCanvas.drawer.toggleClass('is-open');
                e.stopPropagation()
            });

            $(document).on('click', e => {
                if (!$(e.target).closest(offCanvas.drawerClass).length) {
                    offCanvas.drawer.removeClass('is-open');
                    offCanvas.menuBar.removeClass('is-open')
                }
            });
        },

        offcanvasMenuToggle: function (offCanvas) {
            offCanvas.drawer.each(function () {
                const caret = $(this).find('.caret');
                caret.on('click', function (e) {
                    e.preventDefault();
                    $(this).closest('li').toggleClass('is-open');
                    $(this).parent().next().slideToggle(300);
                })
            })
        },

        backToTop: function () {
            /* Scroll to top */
            $('.scrollToTop').on('click', function () {
                $('html, body').animate({scrollTop: 0}, 800);
                return false;
            });
        },

		/* windrow back to top scroll */
        backTopTopScroll: function () {
            if ($(window).scrollTop() > 100) {
                $('.scrollToTop').addClass('show');
            } else {
                $('.scrollToTop').removeClass('show');
            }
        },

		/* preloader */
		preLoader: function () {
			$('#preloader').fadeOut('slow', function () {
				$(this).remove();
			});
		},

	    /* Typing effect */
	    typingEffect: function() {
		    var animationDelay = 2500,
			    barAnimationDelay = 3800,
			    barWaiting = barAnimationDelay - 3000,
			    lettersDelay = 50,
			    typeLettersDelay = 150,
			    selectionDuration = 500,
			    typeAnimationDelay = selectionDuration + 800,
			    revealDuration = 600,
			    revealAnimationDelay = 1500;

		    initHeadline();

		    function initHeadline() {
			    singleLetters($('.sb-headline.letters').find('b'));
			    animateHeadline($('.sb-headline'));
		    }

		    function singleLetters($words) {
			    $words.each(function() {
				    var word = $(this),
					    letters = word.text().split(''),
					    selected = word.hasClass('is-visible');
				    for (var i in letters) {
					    if (word.parents('.rotate-2').length > 0) letters[i] = '<em>' + letters[i] + '</em>';
					    letters[i] = (selected) ? '<i class="in">' + letters[i] + '</i>' : '<i>' + letters[i] + '</i>';
				    }
				    var newLetters = letters.join('');
				    word.html(newLetters).css('opacity', 1);
			    });
		    }

		    function animateHeadline($headlines) {
			    var duration = animationDelay;
			    $headlines.each(function() {
				    var headline = $(this);

				    if (headline.hasClass('loading-bar')) {
					    duration = barAnimationDelay;
					    setTimeout(function() {
						    headline.find('.sb-words-wrapper').addClass('is-loading')
					    }, barWaiting);
				    } else if (headline.hasClass('clip')) {
					    var spanWrapper = headline.find('.sb-words-wrapper'),
						    newWidth = spanWrapper.width() + 10
					    spanWrapper.css('width', newWidth);
				    } else if (!headline.hasClass('type')) {
					    var words = headline.find('.sb-words-wrapper b'),
						    width = 0;
					    words.each(function() {
						    var wordWidth = $(this).width();
						    if (wordWidth > width) width = wordWidth;
					    });
					    headline.find('.sb-words-wrapper').css('width', width);
				    }

				    //trigger animation
				    setTimeout(function() {
					    hideWord(headline.find('.is-visible').eq(0))
				    }, duration);
			    });
		    }

		    function hideWord($word) {
			    var nextWord = takeNext($word);

			    if ($word.parents('.sb-headline').hasClass('type')) {
				    var parentSpan = $word.parent('.sb-words-wrapper');
				    parentSpan.addClass('selected').removeClass('waiting');
				    setTimeout(function() {
					    parentSpan.removeClass('selected');
					    $word.removeClass('is-visible').addClass('is-hidden').children('i').removeClass('in').addClass('out');
				    }, selectionDuration);
				    setTimeout(function() {
					    showWord(nextWord, typeLettersDelay)
				    }, typeAnimationDelay);

			    } else if ($word.parents('.sb-headline').hasClass('letters')) {
				    var bool = ($word.children('i').length >= nextWord.children('i').length);
				    hideLetter($word.find('i').eq(0), $word, bool, lettersDelay);
				    showLetter(nextWord.find('i').eq(0), nextWord, bool, lettersDelay);

			    } else if ($word.parents('.sb-headline').hasClass('clip')) {
				    $word.parents('.sb-words-wrapper').animate({
					    width: '2px'
				    }, revealDuration, function() {
					    switchWord($word, nextWord);
					    showWord(nextWord);
				    });

			    } else if ($word.parents('.sb-headline').hasClass('loading-bar')) {
				    $word.parents('.sb-words-wrapper').removeClass('is-loading');
				    switchWord($word, nextWord);
				    setTimeout(function() {
					    hideWord(nextWord)
				    }, barAnimationDelay);
				    setTimeout(function() {
					    $word.parents('.sb-words-wrapper').addClass('is-loading')
				    }, barWaiting);

			    } else {
				    switchWord($word, nextWord);
				    setTimeout(function() {
					    hideWord(nextWord)
				    }, animationDelay);
			    }
		    }

		    function showWord($word, $duration) {
			    if ($word.parents('.sb-headline').hasClass('type')) {
				    showLetter($word.find('i').eq(0), $word, false, $duration);
				    $word.addClass('is-visible').removeClass('is-hidden');

			    } else if ($word.parents('.sb-headline').hasClass('clip')) {
				    $word.parents('.sb-words-wrapper').animate({
					    'width': $word.width() + 10
				    }, revealDuration, function() {
					    setTimeout(function() {
						    hideWord($word)
					    }, revealAnimationDelay);
				    });
			    }
		    }

		    function hideLetter($letter, $word, $bool, $duration) {
			    $letter.removeClass('in').addClass('out');

			    if (!$letter.is(':last-child')) {
				    setTimeout(function() {
					    hideLetter($letter.next(), $word, $bool, $duration);
				    }, $duration);
			    } else if ($bool) {
				    setTimeout(function() {
					    hideWord(takeNext($word))
				    }, animationDelay);
			    }

			    if ($letter.is(':last-child') && $('html').hasClass('no-csstransitions')) {
				    var nextWord = takeNext($word);
				    switchWord($word, nextWord);
			    }
		    }

		    function showLetter($letter, $word, $bool, $duration) {
			    $letter.addClass('in').removeClass('out');

			    if (!$letter.is(':last-child')) {
				    setTimeout(function() {
					    showLetter($letter.next(), $word, $bool, $duration);
				    }, $duration);
			    } else {
				    if ($word.parents('.sb-headline').hasClass('type')) {
					    setTimeout(function() {
						    $word.parents('.sb-words-wrapper').addClass('waiting');
					    }, 200);
				    }
				    if (!$bool) {
					    setTimeout(function() {
						    hideWord($word)
					    }, animationDelay)
				    }
			    }
		    }

		    function takeNext($word) {
			    return (!$word.is(':last-child')) ? $word.next() : $word.parent().children().eq(0);
		    }

		    function switchWord($oldWord, $newWord) {
			    $oldWord.removeClass('is-visible').addClass('is-hidden');
			    $newWord.removeClass('is-hidden').addClass('is-visible');
		    }
	    },

	    widgetsFilter: function() {
		    $('#sb-preloader').fadeIn('slow');

		    if (typeof $.fn.isotope == 'function') {
			    // Run 1st time
			    var $isotopeContainer = $('.sb-isotope-wrapper');

			    // setTimeout(function () {
				    $isotopeContainer.each(function () {
					    var $container = $(this).find('.featured-container'),
						    filter = $(this).find('.isotope-tab a.current').data('filter');
					    runIsotope($container, filter);
				    });

				    $('#sb-preloader').fadeOut('slow');

				    // Run on click event
				    $('.isotope-tab a').on('click', function () {
					    $(this).closest('.isotope-tab').find('.current').removeClass('current');
					    $(this).addClass('current');
					    var $container = $(this).closest('.filter-wrapper').siblings('.widgets-wrapper').find('.featured-container'),
						    filter = $(this).attr('data-filter');
					    var trackItemClass = $(this).parent().find('.sb-filter-item-track');
					    var position = $(this).position();
					    console.log(position)

					    trackItemClass.css({
						    left: `${position.left}px`,
						    width: `${$(this).outerWidth()}px`,
					    });
					    runIsotope($container, filter);
					    return false;
				    });

				    function runIsotope($container, filter) {
					    $container.isotope({
						    filter: filter,
						    transitionDuration: ".6s",
						    hiddenStyle: {
							    opacity: 0,
							    transform: "scale(0.001)"
						    },
						    visibleStyle: {
							    transform: "scale(1)",
							    opacity: 1
						    }
					    });
				    }

			    // },1000);

		    }
	    },

	    tabTitleTrack: function() {
		    // Helper function to adjust the track position
		    function adjustTrack($container, trackSelector, activeSelector) {
				var trackItemClass = 'sb-filter-item-track';
			    var newChildDiv = $('<div>', { class: trackItemClass });
			    $container.append(newChildDiv);

			    var track = $container.find(trackSelector);
			    var selectedTrack = track.filter(activeSelector);
			    var trackItem = $container.find(`.${trackItemClass}`);

			    if (selectedTrack.length > 0) {
				    var trackPosition = selectedTrack.position();

				    trackItem.css({
					    left: `${trackPosition.left}px`,
					    width: `${selectedTrack.outerWidth()}px`,
				    });
			    } else {
				    trackItem.css({ width: 0 });
			    }

			    $container.on('click touchstart', trackSelector, function(event) {
				    var $this = $(event.currentTarget);
				    var position = $this.position();

				    trackItem.css({
					    left: `${position.left}px`,
					    width: `${$this.outerWidth()}px`,
				    });
			    });
		    }

		    // Case 1: Using aria-selected for .sb-filter-track
		    var $filterTrackContainer = $('.sb-filter-track .e-n-tabs-heading');
		    if ($filterTrackContainer.length > 0) {
			    adjustTrack($filterTrackContainer, '.e-n-tab-title', '[aria-selected="true"]');
		    }

		    // Case 2: Using active class for .sb-isotope-wrapper
		    var $isotopeContainer = $('.sb-isotope-wrapper .isotope-tab');
		    if ($isotopeContainer.length > 0) {
			    adjustTrack($isotopeContainer, '.nav-item', '.current');
		    }
	    },

	    primaryButton: function() {
			var button = $('.sb-button a, a.sb-button');

			if (button.length > 0) {
				$('.sb-button a, a.sb-button').each(function() {
					const buttonText = $(this).find('.elementor-button-text').text().trim();

					if (buttonText) {
						$(this).attr('data-text', buttonText);
					}
				});
			}
	    },
    };

    $(document).ready(function (e) {
        ShopBuilderWP._init();
    });

    $(document).on('load', () => {
        ShopBuilderWP.menuOffset();
    })

    $(window).on('scroll', (event) => {
        ShopBuilderWP.backTopTopScroll(event);
    });

    $(window).on('resize', () => {
        ShopBuilderWP.menuOffset($);
    });

    $(window).on('elementor/frontend/init', () => {
        if (elementorFrontend.isEditMode()) {
            //For all widgets
            elementorFrontend.hooks.addAction('frontend/element_ready/widget', () => {
				ShopBuilderWP.magnificPopup();
				ShopBuilderWP.parallaxMouse();
				ShopBuilderWP.widgetsFilter();
            });

        }
    });

    window.ShopBuilderWP = ShopBuilderWP;

})(jQuery);
