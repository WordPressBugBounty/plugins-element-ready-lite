(function ($) {

    "use strict";
 
    /*===============================  
            Mobile Menu 
    ================================*/

    jQuery(".navbar-toggler").on('click', function () {
        jQuery(this).toggleClass('active');
    });
    
    jQuery(".navbar-nav a").on('click', function () {
        jQuery(".navbar-toggler").removeClass('active');
    });

    var subMenu = jQuery(".sub-menu-bar .navbar-nav .sub-menu");

    if (subMenu.length) {
       
        subMenu.parent('li').children('a').append(function () {
            return '<button class="sub-nav-toggler"> <i class="fa fa-angle-down"></i> </button>';
        });

        var subMenuToggler = jQuery(".sub-menu-bar .navbar-nav .sub-nav-toggler");

        subMenuToggler.on('click', function () {
            jQuery(this).parent().parent().children(".sub-menu").slideToggle();
            //return false
        });

    }
   

    /*
      Element_Ready_Menu
    */
      function er_is_Valid_Http_Url(string) {
        try {
          const url = new URL(string);
          return url.protocol === 'http:' || url.protocol === 'https:';
        } catch (err) {
          return false;
        }
      }

      var Elements_Ready_Menu = function($scope, $) {
        
        var main_menu = $scope.find('.main-menu');
     
        main_menu.on('click', function() {
            $(this).toggleClass("active");
        });
        $scope.find('.element-ready-navbar > li > .nav-link.has-child').on('click', function(){
            if( er_is_Valid_Http_Url($(this).attr('href'))){
             var valid_url = new URL($(this).attr('href'));
             window.location.href = valid_url;
            }
           
        });   
        var $container_2 = $scope.find('.element-ready-style2');

        if ($container_2.length) {

            $('.stellarnav').stellarNav({
                theme: 'light',
                breakpoint: 991,
                position: 'right',
            });
        }

        var $container = $scope.find('.element-ready-fs-menu-wrapper');
        if ($container.length) {

            jQuery('.hamburger').click(function() {

                var $this = jQuery(this);
                if ($this.hasClass('is-active')) {
                    jQuery('.fsmenu, .logo').removeClass('is-active');
                    jQuery('.fsmenu, .logo').addClass('close-menu');
                } else {
                    jQuery('.fsmenu, .logo').removeClass('close-menu');
                    jQuery('.fsmenu, .logo').addClass('is-active');
                };
                $this.toggleClass('is-active');

            });

            jQuery(".fsmenu--list-element").hover(
                function() {
                    jQuery(this).addClass('open');
                    jQuery(this).removeClass('is-closing');
                },
                function() {
                    jQuery(this).removeClass('open');
                    jQuery(this).addClass('is-closing');
                }
            );
        }
    }

    var Element_Ready_Menu_Offcanvas = function($scope, $) {

        var $navigation_button = $scope.find(".navigation-button");
        //===== sidebar js
        var bodyOvrelay = $('.element-ready-body-overlay');
        var sidebarMenu = $('.element-ready-sidebar-menu');
        $(document).on('click', '.element-ready-body-overlay', function(e) {
            e.preventDefault();
            bodyOvrelay.removeClass('active');
            sidebarMenu.removeClass('active');
        });
        // sidebar menu 
        $(document).on('click', '.sidebar-menu-close', function(e) {
            e.preventDefault();
            bodyOvrelay.removeClass('active');
            sidebarMenu.removeClass('active');
        });

        $(document).on('click', '.navigation-button', function(e) {
            e.preventDefault();

            sidebarMenu.addClass('active');
            bodyOvrelay.addClass('active');
      
      
        });
    };

    var Element_Ready_Mobile_Menu_Offcanvas = function($scope, $) {

        var $container = $scope.find('.element-ready-mobile-menu-wr');
        let icon_class = $container.data('indicator') ? $container.data('indicator') : 'fa fa-angle-down';
        var $offcanvasNav = $scope.find('.element_ready_offcanvas_main_menu');

        var $offcanvasNavSubMenu = $offcanvasNav.find('.element-ready-sub-menu');
        $offcanvasNavSubMenu.parent().prepend(`<span class="element-ready-menu-expand"><i class="${icon_class}"></i></span>`);
        $offcanvasNavSubMenu.slideUp();

        $offcanvasNav.on('click', 'li a, li .element-ready-menu-expand', function(e) {
            var $this = $(this);
            
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
                        $submenu.slideUp('slow'); // Close current submenu
                        $this.parent().removeClass('menu-open');
                    } else {
                       setTimeout(function(){
                         // Close other submenus only in the same level
                         $this.closest('ul').find('ul:visible').slideUp('slow').parent().removeClass('menu-open');
                        
                         // Open the current submenu
                         $submenu.slideDown('slow');
                         $this.parent().addClass('menu-open');
                       }, 500);
                    }
                }
            }
        });
        
    }

    $(window).on('elementor/frontend/init', function() {

        elementorFrontend.hooks.addAction('frontend/element_ready/element-ready-mobile-offcanvas-menu.default', Element_Ready_Mobile_Menu_Offcanvas);
        elementorFrontend.hooks.addAction('frontend/element_ready/element-ready-header-offcanvas.default', Element_Ready_Menu_Offcanvas);
        elementorFrontend.hooks.addAction('frontend/element_ready/element-ready-menu.default', Elements_Ready_Menu);
        
    });

    $('.element_ready_offcanvas_main_menu > li a').on('click', function(e){
        const mq = window.matchMedia( "(max-width: 1024px)" );

        if( er_is_Valid_Http_Url($(this).attr('href'))){
            var valid_url = new URL($(this).attr('href'));
            window.location.href = valid_url;
        }
        if(mq.matches){
          $(".sidebar-menu-close").click();
        }
    });

})(jQuery);
