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

        const formData = $form.serialize();

        // Check if variation is selected and add it to the form data
        let variationData = '';
        $form.find('.variations select').each(function () {
            if ($(this).val()) {
                variationData += '&' + $(this).attr('name') + '=' + $(this).val();
            }
        });
        
        // Combine form data and variation data
        const finalFormData = formData + variationData;

        $.post(cbcb_params.ajax_url, finalFormData, function () {
            hideLoading($btn);

            window.location.href = redirectTo;
        });
    }

    $('#cbcb-add-to-cart').click(function () {
        submitForm(cbcb_params.cart_url);
    });

    $('#cbcb-buy-now').click(function () {
        submitForm(cbcb_params.checkout_url);
    });
});
