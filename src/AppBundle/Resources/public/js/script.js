$(document).ready(function() {

    $(window).scroll(function(){
        var $wrapper = $('.wrapper'),
            scroll = $(window).scrollTop();

        if (scroll >= 132) $wrapper.addClass('fixedMenu');
        else $wrapper.removeClass('fixedMenu');
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

    $('.actSubItem').on('mouseover', function() {
        var $submenu = $(this).parent().find('.submenu');
        $submenu.slideDown(100);
        $(this).removeClass('expanded');
        $(this).addClass('collapsed');

        return false;
    });

    $('.actSubItem').parent('.subItemMenu').on('mouseleave', function() {
        var $submenu = $(this).parent().find('.submenu');
        $submenu.slideUp(100);
        $(this).find('.actSubItem').removeClass('collapsed');
        $(this).find('.actSubItem').addClass('expanded');

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
});