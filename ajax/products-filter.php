<?php 
    add_action('wp_ajax_load_products', 'load_products_ajax');
    add_action('wp_ajax_nopriv_load_products', 'load_products_ajax');

    function load_products_ajax() {
        $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $cat_id = intval($_POST['cat_id']);
        $posts_per_page = 15; 
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $posts_per_page,
            'post_status'    => 'publish',
            'orderby'        => 'date', 
            'order'          => 'DESC', 
            'paged'          => $paged,
        );

        if (!empty($cat_id)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $cat_id,
                ),
            );
        }

        $orderby = 'date';
        $order = 'DESC';
        
        if (!empty($_POST['sortby'])) {
            switch ($_POST['sortby']) {
                case 'name-asc':
                    $orderby = 'title';
                    $order = 'ASC';
                    break;
                case 'name-desc':
                    $orderby = 'title';
                    $order = 'DESC';
                    break;
                case 'price-asc':
                    $orderby = 'meta_value_num';
                    $order = 'ASC';
                    $args['meta_key'] = '_price';
                    break;
                case 'price-desc':
                    $orderby = 'meta_value_num';
                    $order = 'DESC';
                    $args['meta_key'] = '_price';
                    break;
                case 'date-asc':
                    $orderby = 'date';
                    $order = 'ASC';
                    break;
                case 'date-desc':
                    $orderby = 'date';
                    $order = 'DESC';
                    break;
                default:
                    $orderby = 'date';
                    $order = 'DESC';
                    break;
            }
        }
        
        $args['orderby'] = $orderby;
        $args['order'] = $order;

        if ( isset($_POST['min_price'], $_POST['max_price']) ) {
            $min_price = floatval($_POST['min_price']);
            $max_price = floatval($_POST['max_price']);
        
            if ($min_price || $max_price) {
                $args['meta_query'][] = array(
                    'key'     => '_price',
                    'value'   => array($min_price, $max_price),
                    'compare' => 'BETWEEN',
                    'type'    => 'NUMERIC',
                );
            }
        }
        
        $products = new WP_Query($args);

        $total_products = $products->found_posts;
        $start = ($total_products > 0) ? (($paged - 1) * $posts_per_page + 1) : 0;
        $end = min($paged * $posts_per_page, $total_products);

        // Products HTML
        ob_start();
        if ($products->have_posts()) : 
            while ($products->have_posts()) : $products->the_post(); 
                echo '<div class="col-12 col-sm-6 col-md-4 col-product custom-style-61">';
                    get_template_part('template/product-list');
                echo '</div>';
            endwhile;
            wp_reset_postdata();
        else : 
            get_template_part('template/no-products'); 
        endif; 
        $products_html = ob_get_clean();

        ob_start();
        echo '<div id="ajax-pagination">'; 
            if ($products->max_num_pages > 1) {
                echo '<div class="paginatoin-area text-center">';
                    echo '<div class="d-flex justify-content-center gap-2 mt-5 ">';

                        $prev_page = $paged - 1;
                        $prev_disabled = ($paged <= 1) ? 'disabled' : '';
                        
                        echo '<a href="#" class="page-link-custom '.$prev_disabled.'" data-page="'.($prev_page > 0 ? $prev_page : 1).'">
                                <i class="bi bi-chevron-left"></i>
                            </a>';
                        
                        for ($i = 1; $i <= $products->max_num_pages; $i++) {
                            $active = ($i == $paged) ? 'active' : '';
                            echo '<a href="#" class="page-link-custom '.$active.'" data-page="'.$i.'">'.$i.'</a>';
                        }
                        
                        $next_page = $paged + 1;
                        $next_disabled = ($paged >= $products->max_num_pages) ? 'disabled' : '';
                        
                        echo '<a href="#" class="page-link-custom '.$next_disabled.'" data-page="'.($next_page <= $products->max_num_pages ? $next_page : $products->max_num_pages).'">
                                <i class="bi bi-chevron-right"></i>
                            </a>';

                    echo '</div>';
                echo '</div>';
            }
        echo '</div>';
        $pagination_html = ob_get_clean();

        $product_count_text = "Showing {$start}–{$end} of {$total_products} results";

        wp_send_json(array(
            'products'   => $products_html,
            'pagination' => $pagination_html,
            'product_count' => $product_count_text,
        ));
    }

    function ajax_products_script() {
        global $wp_query;
        if ( is_tax('product_cat') ) {
            $current_cat = get_queried_object();
            $cat_id = $current_cat->term_id;
        } else {
            $cat_id = 0;
        }
        wp_enqueue_script('ajax-products', get_template_directory_uri() . '/ajax/js/products-filter.js', array('jquery'), null, true);
        wp_localize_script('ajax-products', 'ajax_obj', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'cat_id'   => $cat_id,
        ));
    }
    add_action('wp_enqueue_scripts', 'ajax_products_script');
?>