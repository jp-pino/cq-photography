(function() {

    var Menu = (function() {
        var burger = document.querySelector('.burger');
        var menu = document.querySelector('.menu');
        var menuList = document.querySelector('.menu__list');
        var brand = document.querySelector('.menu__brand');
        var menuItems = document.querySelectorAll('.menu__item');

        var active = false;

        var toggleMenu = function() {
            if ($("nav")[0].getBoundingClientRect().top == 0) {
                if (!active) {
                    menu.classList.add('menu--active');
                    menuList.classList.add('menu__list--active');
                    brand.classList.add('menu__brand--active');
                    burger.classList.add('burger--close');
                    for (var i = 0, ii = menuItems.length; i < ii; i++) {
                        menuItems[i].classList.add('menu__item--active');
                    }
                    active = true;
                    $('body').css({
                        'overflow': 'hidden'
                    });
                    $(document).bind('scroll', function() {
                        window.scrollTo(0, $(window).height());
                    });
                    $( window ).resize(function() {
                        window.scrollTo(0, $(window).height());
                    });
                    document.ontouchmove = function(e){ e.preventDefault(); }
                } else {
                    menu.classList.remove('menu--active');
                    menuList.classList.remove('menu__list--active');
                    brand.classList.remove('menu__brand--active');
                    burger.classList.remove('burger--close');
                    for (var i = 0, ii = menuItems.length; i < ii; i++) {
                        menuItems[i].classList.remove('menu__item--active');
                    }
                    active = false;
                    $(document).unbind('scroll');
                    $('body').css({
                        'overflow': 'visible'
                    });
                    document.ontouchmove = function(e){ return true; }
                }
            }
        };

        var bindActions = function() {
            burger.addEventListener('click', toggleMenu, false);
        };

        var init = function() {
            bindActions();
        };

        return {
            init: init
        };

    }());

    Menu.init();

}());
