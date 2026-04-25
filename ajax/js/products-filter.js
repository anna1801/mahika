jQuery(document).ready(function($){

    let selectedCategory = ajax_obj.cat_id || 0;

    function loadProducts(page = 1) {

        var cat_id = selectedCategory;
        var sortby = $('.ajax-sort').val();

        var min_price = $('.range-input .min').val();
        var max_price = $('.range-input .max').val();

        console.log('CAT:', cat_id, 'PRICE:', min_price, max_price);

        $.ajax({
            url: ajax_obj.ajax_url,
            type: 'POST',
            data: {
                action: 'load_products',
                page: page,
                cat_id: cat_id,
                sortby: sortby,
                min_price: min_price,
                max_price: max_price
            },
            success: function(response){
                $('#productsGrid').html(response.products);
                $('#ajax-pagination').replaceWith(response.pagination);
                $('.results').html(response.product_count);
            }
        });
    }

    // CATEGORY
    $(document).on('click', '.cat-link', function(){
        $('.cat-link').removeClass('active');
        $(this).addClass('active');

        selectedCategory = $(this).data('id') || 0;

        loadProducts(1);
    });

    // PAGINATION
    $(document).on('click', '.page-link-custom', function(e){
        e.preventDefault();
        var page = $(this).data('page');
        loadProducts(page);
    });

    // SORT
    $(document).on('change', '.ajax-sort', function(){
        loadProducts(1);
    });

    // PRICE FILTER
    $(document).on('click', '.filter-btn', function(e){
        e.preventDefault();

        let min = $('.range-input .min').val();
        let max = $('.range-input .max').val();

        $('#price_min').val(min);
        $('#price_max').val(max);

        loadProducts(1);
    });
    
    $(document).on('click', '.clear-price', function(e){

        $('.range-input .min').val(min_price);
        $('.range-input .max').val(max_price);
    
        $('#minPriceVal').text(min_price);
        $('#maxPriceVal').text(max_price);
    
        selectedCategory = 0;
        $('.cat-link').removeClass('active');
        $('.cat-link[data-id="0"]').addClass('active');
    
        $('.ajax-sort').val('');

        loadProducts(1);
    });

});