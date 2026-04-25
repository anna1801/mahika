jQuery(document).ready(function($) {

    $('.custom-ajax-add-to-cart').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);
        var product_id = $form.find('button[name="add-to-cart"]').val();
        var quantity = $form.find('input[name="quantity"]').val();
        var data = {
            action: 'custom_ajax_add_to_cart',
            product_id: product_id,
            quantity: quantity
        };

        $.post(ajax_atc.ajax_url, data, function(response) {
            if (response.success) {               
                $form.find('input[name="quantity"]').val(1);
                $(document.body).trigger('wc_fragment_refresh');
            }
        });

    });

});