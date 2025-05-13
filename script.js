jQuery(function ($) {
    function showLoading($btn) {
        $btn.prop('disabled', true);
        $btn.find('.cbcb-label').hide();
        $btn.find('.cbcb-loader').show();
    }

    function hideLoading($btn) {
        $btn.prop('disabled', false);
        $btn.find('.cbcb-label').show();
        $btn.find('.cbcb-loader').hide();
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
                showWarning('Please select a product variation before proceeding.', '.variations_form');
                return;
            }
        }

        // Validate all required form inputs
        if (!validateFormFields($form)) {
            showWarning('Please fill all required product fields before adding to cart.');
            return;
        }

        showLoading($btn);

        let formData = $form.serialize();

        if ($form.hasClass('variations_form')) {
            formData = formData.replace(/product_id=[0-9]+&?/g, '');
        }

        $.post(cbcb_params.ajax_url, formData, function () {
            hideLoading($btn);
            window.location.href = redirectTo;
        });
    }

    $('#cbcb-add-to-cart').click(() => submitForm(cbcb_params.cart_url));
    $('#cbcb-buy-now').click(() => submitForm(cbcb_params.checkout_url));

    // Update price on variation change
    $('form.variations_form').on('found_variation', function (event, variation) {
        if (variation && variation.price_html) {
            // Create a temporary element to parse HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = variation.price_html;

            // Try to get sale price first (inside <ins>), then fallback to regular
            let priceEl = tempDiv.querySelector('ins .amount') || tempDiv.querySelector('.amount');

            if (priceEl) {
                $('#cbcb-price-container').html(priceEl.outerHTML);
            } else {
                $('#cbcb-price-container').html(variation.price_html); // fallback just in case
            }
        }
    });

    // ✅ Sticky Bar visibility based on reaching the bottom only
    const stickyBar = $('#cbcb-sticky-bar');

    function checkIfBottom() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const windowHeight = window.innerHeight;
    const docHeight = document.documentElement.scrollHeight;

    const hasScroll = docHeight > windowHeight;

        if (hasScroll && scrollTop + windowHeight >= docHeight - 5) {
            stickyBar.addClass('cbcb-hidden');
        } else {
            stickyBar.removeClass('cbcb-hidden');
        }
    }

    window.addEventListener('scroll', checkIfBottom);
    window.addEventListener('resize', checkIfBottom);
    checkIfBottom();
});
