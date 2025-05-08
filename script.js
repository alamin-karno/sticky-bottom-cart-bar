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

    function showVariationWarning() {
        $('html, body').animate({ scrollTop: $('.variations_form').offset().top - 100 }, 400);
        alert('Please select a variation before clicking the button.');
    }

    function submitForm(redirectTo) {
        const $form = $('form.cart');
        const $btn = $(document.activeElement);

        if ($form.hasClass('variations_form') && $form.find('.variations select').length > 0) {
            let valid = true;
            $form.find('.variations select').each(function () {
                if (!$(this).val()) valid = false;
            });

            if (!valid) {
                showVariationWarning();
                return;
            }
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
            $('#cbcb-price-container').html(variation.price_html);
        }
    });
});
