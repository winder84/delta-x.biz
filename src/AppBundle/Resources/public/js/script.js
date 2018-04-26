$(document).ready(function() {

    $(window).scroll(function(){
        var $wrapper = $('.wrapper'),
            scroll = $(window).scrollTop();

        if (scroll >= 132) $wrapper.addClass('fixedMenu');
        else $wrapper.removeClass('fixedMenu');
    });

    $('#showMobileMenu').on('click', function() {
        var $menu = $(this).closest('.mobileFixed').find('.mobileMenuBlock');
        if ($menu.hasClass('expanded')) {
            $menu.slideDown(100);
        } else {
            $menu.slideUp(100);
        }
        $menu.toggleClass('expanded');
        return false;
    });

    $('.catalogMenu').find('.currentCatalog').on('click', function() {
        var $submenu = $(this).parent().find('ul');

        if ($submenu.is(':visible')) {
            $submenu.slideUp(100);
            $(this).toggleClass('collapsed expanded');
        } else {
            $submenu.slideDown(100);
            $(this).toggleClass('collapsed expanded');
        }
    });

    $('.actSubItem').on('mouseenter', function() {
        if (window.innerWidth > 1025) {
            var $submenu = $(this).parent().find('.submenu');
            $submenu.slideDown(100);
            $(this).removeClass('collapsed');
            $(this).addClass('expanded');
        }
        return false;
    });

    $('.actSubItem').on('click', function() {
        if (window.innerWidth < 1025) {
            var $submenu = $(this).parent().find('.submenu');
            if ($submenu.is(':visible')) {
                $submenu.slideUp(100);
                $(this).toggleClass('collapsed expanded');
            } else {
                $submenu.slideDown(100);
                $(this).toggleClass('collapsed expanded');
            }
            return false;
        }
        return true;
    });


    $('.actSubItem').parent('.subItemMenu').on('mouseleave', function() {
        if (window.innerWidth > 1025) {
            var $submenu = $(this).parent().find('.submenu');
            $submenu.slideUp(100);
            $(this).find('.actSubItem').removeClass('expanded');
            $(this).find('.actSubItem').addClass('collapsed');
        }

        return false;
    });

    $(function(){
        $(document).click(function(event) {
            if ($(event.target).closest($('.submenu')).length) return;
            if ($(event.target).closest($('.catalogMenu')).length) return;
            $('.submenu').slideUp(100);
            $('.actSubItem.expanded').toggleClass('collapsed expanded');
            $('.catalogMenu').find('ul').slideUp(100);
            $('.catalogMenu').find('.currentCatalog.expanded').toggleClass('collapsed expanded');
            event.stopPropagation();
        });
    });


    $('.flexslider').flexslider({
        animation: "slide"
    }).show();

    $('.lightzoom').lightzoom({
        speed: 400,
        isOverlayClickClosing: true,
        isEscClosing: true,
        viewTitle: true
    });
});