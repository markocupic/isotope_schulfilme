jQuery(function ($) {
    $().ready(function () {
        if (!$(".main-navigation-iso-filter-search .inner").length) {
            return;
        }
        var form = $(".main-navigation-iso-filter-search .inner").first();
        form.addClass('main-navigation-iso-filter-search-form');

        // Move form to the top of the body
        $(form).detach().prependTo('body');

        // Show overlay
        $('.main-navigation-iso-filter-search a.toggler').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            form.addClass('is-pre-active');
            window.setTimeout(function () {
                form.addClass('is-active');
                form.removeClass('is-pre-active');
            }, 100);
        });

        // Hide form when clicking the close icon
        $('.main-navigation-iso-filter-search-form-close').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            hideIsoProductSearchForm();
        });

        // Hide form when typing ESC
        $(document).keyup(function (e) {
            if (e.keyCode == 27) {
                hideIsoProductSearchForm();
            }
        });

        /**
         * Close form
         */
        function hideIsoProductSearchForm() {
            form.removeClass('is-active');
            form.removeClass('is-pre-active');
        }

    });

});