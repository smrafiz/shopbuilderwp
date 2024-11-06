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

        headerSearchOpen: function () {
			$('a[href="#header-search"]').on("click", function (event) {
				event.preventDefault();
				$("#header-search").addClass("open");
				$('#header-search > form > input[type="search"]').focus();
			});

			$("#header-search, #header-search button.close").on("click keyup", function (event) {
				if (
					event.target === this ||
					event.target.className === "close" ||
					event.keyCode === 27
				) {
					$(this).removeClass("open");
				}
			});
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

		/* Counter */
		counterUp: function () {
			const counterContainer = $('.counter');
			if (counterContainer.length) {
				counterContainer.counterUp({
					delay: counterContainer.data('rtsteps'),
					time: counterContainer.data('rtspeed')
				});
			}
		},

  		/* Pricing Switch */
		pricingTab: function () {
			$(".pricing-switch-container").on("click", function () {
				let $this = $(this);
				let $wrapper = $this.closest('.rt-pricing-tab');
				$wrapper.find(".pricing-switch")
					.parents(".price-switch-box")
					.toggleClass("price-switch-box--active");
				$wrapper.find(".pricing-switch").toggleClass("pricing-switch-active");
				$wrapper.find(".price-box").toggleClass("price-box-show price-box-hide");
			});
		},

		/* preloader */
		preLoader: function () {
			$('#preloader').fadeOut('slow', function () {
				$(this).remove();
			});
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
				ShopBuilderWP.counterUp();
				ShopBuilderWP.pricingTab();
            });

        }
    });

    window.ShopBuilderWP = ShopBuilderWP;

})(jQuery);
