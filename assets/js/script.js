jQuery(function ($) {
    function showLoading($btn) {
        $btn.prop('disabled', true);
        $btn.find('.sbcb-label').hide();
        $btn.find('.sbcb-loader').show();
    }

    function hideLoading($btn) {
        $btn.prop('disabled', false);
        $btn.find('.sbcb-label').show();
        $btn.find('.sbcb-loader').hide();
    }

    function showWarning(message, scrollToSelector = 'form.cart') {
        $('html, body').animate({ scrollTop: $(scrollToSelector).offset().top - 100 }, 400);
        alert(message);
    }

    function validateFormFields($form) {
        let valid = true;

        $form.find('input, select, textarea').each(function () {
            const $el = $(this);

            // Skip hidden fields and unchecked checkboxes/radio
            if (!$el.is(':visible') || $el.prop('disabled')) return;

            const isRequired = $el.prop('required') || $el.closest('.required').length > 0;

            if (isRequired && !$el.val()) {
                valid = false;
                return false; // break loop
            }
        });

        return valid;
    }

    function submitForm(redirectTo) {
        const $form = $('form.cart');
        const $btn = $(document.activeElement);

        // Validate variation selections
        if ($form.hasClass('variations_form') && $form.find('.variations select').length > 0) {
            let valid = true;
            $form.find('.variations select').each(function () {
                if (!$(this).val()) valid = false;
            });

            if (!valid) {
                showWarning(sbcb_params.text_select_variation, '.variations_form');
                return;
            }
        }

        // Validate all required form inputs
        if (!validateFormFields($form)) {
            showWarning(sbcb_params.text_fill_required_fields);
            return;
        }

        showLoading($btn);

        let formData = $form.serialize();

        if ($form.hasClass('variations_form')) {
            formData = formData.replace(/product_id=[0-9]+&?/g, '');
        }

        // Add the nonce to the form data
        formData += '&_wpnonce=' + sbcb_params.ajax_nonce;

        $.post(sbcb_params.ajax_url, formData, function (response) {
            // Check if WooCommerce returned an error (e.g., out of stock)
            if (response && response.fragments && response.fragments.notices_html) {
                // WooCommerce often includes notices in 'fragments.notices_html'
                // This indicates a soft error (like validation, out of stock) rather than a network/server error.
                // Redirect to cart to display these notices.
                window.location.href = sbcb_params.cart_url;
                return; 
            }
            hideLoading($btn);
            window.location.href = redirectTo;
        }).fail(function (jqXHR, textStatus, errorThrown) {
            hideLoading($btn);
            showWarning(sbcb_params.text_ajax_error); 
            console.error('SBCB AJAX error:', textStatus, errorThrown);
        });
    }

    $('#sbcb-add-to-cart').click(() => submitForm(sbcb_params.cart_url));
    $('#sbcb-buy-now').click(() => submitForm(sbcb_params.checkout_url));

    // Update price on variation change
    $('form.variations_form').on('found_variation', function (event, variation) {
        if (variation && variation.price_html) {
            // Create a temporary element to parse HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = variation.price_html;

            // Try to get sale price first (inside <ins>), then fallback to regular
            let priceEl = tempDiv.querySelector('ins .amount') || tempDiv.querySelector('.amount');

            if (priceEl) {
                $('#sbcb-price-container').html(priceEl.outerHTML);
            } else {
                $('#sbcb-price-container').html(variation.price_html); // fallback just in case
            }
        }
    });

    // ✅ Sticky Bar visibility based on reaching the bottom only
    const stickyBar = $('#sbcb-sticky-bar');

    function checkIfBottom() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const windowHeight = window.innerHeight;
    const docHeight = document.documentElement.scrollHeight;

    const hasScroll = docHeight > windowHeight;

        if (hasScroll && scrollTop + windowHeight >= docHeight - 5) {
            stickyBar.addClass('sbcb-hidden');
        } else {
            stickyBar.removeClass('sbcb-hidden');
        }
    }

    window.addEventListener('scroll', checkIfBottom);
    window.addEventListener('resize', checkIfBottom);
    checkIfBottom();
});
