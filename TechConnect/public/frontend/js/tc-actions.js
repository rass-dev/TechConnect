/**
 * TechConnect — AJAX cart & wishlist (no full page reload / scroll jump)
 */
(function ($) {
    'use strict';

    const scrollPos = { y: 0 };

    function saveScroll() {
        scrollPos.y = window.scrollY || window.pageYOffset;
    }

    function restoreScroll() {
        window.scrollTo(0, scrollPos.y);
    }

    function showToast(type, message) {
        $('.tc-toast').remove();
        const $toast = $('<div class="tc-toast tc-toast-' + type + '">' +
            '<i class="fa ' + (type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle') + '"></i>' +
            '<span>' + message + '</span></div>');
        $('body').append($toast);
        requestAnimationFrame(function () { $toast.addClass('show'); });
        setTimeout(function () {
            $toast.removeClass('show');
            setTimeout(function () { $toast.remove(); }, 300);
        }, 3500);
    }

    function updateCounts(data) {
        if (data.cart_count !== undefined) {
            $('a.cart .total-count').text(data.cart_count);
        }
        if (data.wishlist_count !== undefined) {
            $('a.wishlist .total-count').text(data.wishlist_count);
        }
    }

    function handleResponse(res, $trigger) {
        restoreScroll();
        if (res.success) {
            showToast('success', res.message || 'Success!');
            if ($trigger && $trigger.data('remove-row')) {
                $trigger.closest('[data-wishlist-row]').fadeOut(280, function () {
                    $(this).remove();
                    if ($('[data-wishlist-row]').length === 0) {
                        $('#wishlist_item_list').html(
                            '<div class="tc-empty-state"><p>No products in your wishlist.</p>' +
                            '<a href="' + ($('a[href*="product-grids"]').first().attr('href') || '/') + '" class="btn-modern">Continue Shopping</a></div>'
                        );
                    }
                });
            }
            if ($trigger && $trigger.data('close-modal')) {
                $('.product-quickview').modal('hide');
            }
        } else {
            showToast('error', res.message || 'Action failed.');
        }
        updateCounts(res);
    }

    function handleError(xhr) {
        restoreScroll();
        let msg = 'Something went wrong. Please try again.';
        if (xhr.status === 401 || xhr.status === 403) {
            msg = 'Please log in to continue.';
            setTimeout(function () {
                window.location.href = '/user/login';
            }, 1200);
        } else if (xhr.responseJSON && xhr.responseJSON.message) {
            msg = xhr.responseJSON.message;
        }
        showToast('error', msg);
    }

    function ajaxGet(url, $trigger) {
        saveScroll();
        $.ajax({
            url: url,
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        }).done(function (res) {
            handleResponse(res, $trigger);
        }).fail(handleError);
    }

    function ajaxPost(url, data, $trigger) {
        saveScroll();
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        }).done(function (res) {
            handleResponse(res, $trigger);
        }).fail(handleError);
    }

    function isCartLink(href) {
        return href && /\/add-to-cart\//.test(href);
    }

    function isWishlistAddLink(href) {
        return href && /\/wishlist\/[^/?#]+/.test(href) && href.indexOf('wishlist-delete') === -1;
    }

    function isWishlistDeleteLink(href) {
        return href && /wishlist-delete\//.test(href);
    }

    $(document).on('click', 'a[href*="add-to-cart"]', function (e) {
        if ($(this).hasClass('no-ajax')) return;
        const href = $(this).attr('href');
        if (!isCartLink(href)) return;
        e.preventDefault();
        ajaxGet(href, $(this));
    });

    $(document).on('click', 'a[href*="/wishlist/"]', function (e) {
        if ($(this).hasClass('no-ajax')) return;
        const href = $(this).attr('href');
        if (!isWishlistAddLink(href)) return;
        e.preventDefault();
        ajaxGet(href, $(this));
    });

    $(document).on('click', 'a[href*="wishlist-delete"]', function (e) {
        if ($(this).hasClass('no-ajax')) return;
        e.preventDefault();
        const $el = $(this);
        $el.data('remove-row', true);
        ajaxGet($el.attr('href'), $el);
    });

    $(document).on('submit', 'form[action*="single-add-to-cart"]', function (e) {
        e.preventDefault();
        const $form = $(this);
        const $trigger = $('<span>').data('close-modal', true);
        ajaxPost($form.attr('action'), $form.serialize(), $trigger);
    });

})(jQuery);
