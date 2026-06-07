(function ($) {
    'use strict';

    var MOBILE_BP = 992;

    function isMobile() {
        return window.innerWidth < MOBILE_BP;
    }

    function isSidebarOpen() {
        return $('body').hasClass('sidebar-toggled');
    }

    function setBurgerIcon(open) {
        var $btn = $('#sidebarToggleTop');
        var $icon = $btn.find('i');
        if (!$icon.length) return;

        if (isMobile()) {
            $icon.removeClass('fa-bars fa-times');
            $icon.addClass(open ? 'fa-times' : 'fa-bars');
            $btn.attr('aria-expanded', open ? 'true' : 'false');
        } else {
            $icon.removeClass('fa-times').addClass('fa-bars');
            $btn.attr('aria-expanded', open ? 'false' : 'true');
        }
    }

    function openSidebar() {
        $('body').addClass('sidebar-toggled');
        $('.sidebar').addClass('toggled');
        if (isMobile()) {
            $('body').addClass('tc-sidebar-open');
            setBurgerIcon(true);
        } else {
            setBurgerIcon(true);
        }
    }

    function closeSidebar() {
        $('body').removeClass('sidebar-toggled tc-sidebar-open');
        $('.sidebar').removeClass('toggled');
        setBurgerIcon(false);
    }

    function toggleSidebar() {
        if (isSidebarOpen()) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    function initMobileSidebar() {
        if (isMobile()) {
            closeSidebar();
        } else {
            $('body').removeClass('tc-sidebar-open');
            setBurgerIcon(false);
        }
    }

    $(function () {
        initMobileSidebar();

        $('#sidebarToggleTop').off('click').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            toggleSidebar();
        });

        $(document).on('click', '.tc-sidebar-backdrop', function () {
            closeSidebar();
        });

        $(document).on('click', function (e) {
            if (!isMobile() || !isSidebarOpen()) return;
            if ($(e.target).closest('.sidebar, #sidebarToggleTop').length) return;
            closeSidebar();
        });

        $(window).on('resize', function () {
            clearTimeout(window._tcSidebarResize);
            window._tcSidebarResize = setTimeout(initMobileSidebar, 150);
        });

        setTimeout(initMobileSidebar, 200);

        $('.tc-admin-content table.table').addClass('tc-admin-table');
        $('.tc-admin-content .table-responsive').addClass('tc-table-wrap');
    });
})(jQuery);
