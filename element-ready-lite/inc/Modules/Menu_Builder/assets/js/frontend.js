!(function (e) {
    "use strict";
    jQuery(".navbar-toggler").on("click", function () {
        jQuery(this).toggleClass("active");
    }),
        jQuery(".navbar-nav a").on("click", function () {
            jQuery(".navbar-toggler").removeClass("active");
        });
    var n = jQuery(".sub-menu-bar .navbar-nav .sub-menu");
    function a(e) {
        try {
            let n = new URL(e);
            return "http:" === n.protocol || "https:" === n.protocol;
        } catch (a) {
            return !1;
        }
    }
    n.length &&
        (n
            .parent("li")
            .children("a")
            .append(function () {
                return '<button class="sub-nav-toggler"> <i class="fa fa-angle-down"></i> </button>';
            }),
        jQuery(".sub-menu-bar .navbar-nav .sub-nav-toggler").on("click", function () {
            jQuery(this).parent().parent().children(".sub-menu").slideToggle();
        }));
    var t = function (e, n) {
            e.find(".main-menu").on("click", function () {
                n(this).toggleClass("active");
            }),
                e.find(".element-ready-navbar > li > .nav-link.has-child").on("click", function () {
                    if (a(n(this).attr("href"))) {
                        var e = new URL(n(this).attr("href"));
                        window.location.href = e;
                    }
                }),
                e.find(".element-ready-style2").length && n(".stellarnav").stellarNav({ theme: "light", breakpoint: 991, position: "right" }),
                e.find(".element-ready-fs-menu-wrapper").length &&
                    (jQuery(".hamburger").click(function () {
                        var e = jQuery(this);
                        e.hasClass("is-active")
                            ? (jQuery(".fsmenu, .logo").removeClass("is-active"), jQuery(".fsmenu, .logo").addClass("close-menu"))
                            : (jQuery(".fsmenu, .logo").removeClass("close-menu"), jQuery(".fsmenu, .logo").addClass("is-active")),
                            e.toggleClass("is-active");
                    }),
                    jQuery(".fsmenu--list-element").hover(
                        function () {
                            jQuery(this).addClass("open"), jQuery(this).removeClass("is-closing");
                        },
                        function () {
                            jQuery(this).removeClass("open"), jQuery(this).addClass("is-closing");
                        }
                    ));
        },
        l = function (e, n) {
            e.find(".navigation-button");
            var a = n(".element-ready-body-overlay"),
                t = n(".element-ready-sidebar-menu");
            n(document).on("click", ".element-ready-body-overlay", function (e) {
                e.preventDefault(), a.removeClass("active"), t.removeClass("active");
            }),
                n(document).on("click", ".sidebar-menu-close", function (e) {
                    e.preventDefault(), a.removeClass("active"), t.removeClass("active");
                }),
                n(document).on("click", ".navigation-button", function (e) {
                    e.preventDefault(), t.addClass("active"), a.addClass("active");
                }),
                i(e, n);
        },
        i = function (e, n) {
            var a = e.find(".element-ready-mobile-menu-wr");
            let t = a.data("indicator") ? a.data("indicator") : "fa fa-angle-down";
            var l = e.find(".element_ready_offcanvas_main_menu"),
                i = l.find(".element-ready-sub-menu");
            i.parent().prepend(`<span class="element-ready-menu-expand"><i class="${t}"></i></span>`),
                i.slideUp(),
                l.on("click", "li.menu-item-has-children > a, li .element-ready-menu-expand", function (e) {
                    var $this = jQuery(this);
            
                    // Check if the clicked item has a submenu
                    if ($this.parent().hasClass('element-ready-menu-item-has-children') || 
                        $this.parent().hasClass('has-children') || 
                        $this.parent().hasClass('has-sub-menu') || 
                        $this.parent().hasClass('element-ready-element-ready-sub-menu')) {
                        
                        // Prevent default action for links with "#" or expand buttons
                        if ($this.attr('href') === '#' || $this.hasClass('element-ready-menu-expand')) {
                            e.preventDefault();
                
                            // Check if the submenu is visible
                            var $submenu = $this.siblings('ul');
                            if ($submenu.is(':visible')) {
                                $this.closest('li').siblings('li').find('ul').slideUp(); // Close current submenu
                                $this.parent().removeClass('menu-open');
                            } else {
                                $this.closest('ul').find('ul:visible').slideUp().parent().removeClass('menu-open');
                        
                                // Open the current submenu
                                $submenu.slideDown('slow');
                                $this.parent().addClass('menu-open');
                            }
                            
                        }
                    }
                });
        };
    e(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/element-ready-mobile-offcanvas-menu.default", i),
            elementorFrontend.hooks.addAction("frontend/element_ready/element-ready-header-offcanvas.default", l),
            elementorFrontend.hooks.addAction("frontend/element_ready/element-ready-menu.default", t);
    }),
        e(".element_ready_offcanvas_main_menu > li a").on("click", function (n) {
            let t = window.matchMedia("(max-width: 1024px)");
            if (a(e(this).attr("href"))) {
                var l = new URL(e(this).attr("href"));
                window.location.href = l;
            }
            t.matches && e(".sidebar-menu-close").click();
        });
})(jQuery);
