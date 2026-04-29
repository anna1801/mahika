<?php
    if (is_page()) {

        $page_title = get_field('page_title');
        if($page_title) {
            $title = $page_title;
        } else {
            $title = get_the_title();
        }
        $current = get_the_title();

        if( is_account_page() && !is_user_logged_in() ) {
            $title = 'Login';
            $current = 'Login';
        } 
        elseif ( is_wc_endpoint_url('order-received') ) {
            $title = 'Order Success';
            $current = 'Order Success';
        }
        elseif ( is_wc_endpoint_url('order-pay') ) {
            $title = 'Pay for Order';
            $current = 'Pay for Order';
        }
        elseif ( is_account_page() ) {

            if ( is_wc_endpoint_url('edit-account') ) {
                $title = 'Account Details';
                $next = '<span class="mx-2">/</span> Settings';
            } elseif ( is_wc_endpoint_url('orders') ) {
                $title = 'Recent Orders';
                $next = '<span class="mx-2">/</span> Recent Orders';
            } elseif ( is_wc_endpoint_url('view-order') ) {
                $order_id = isset($wp->query_vars['view-order']) ? $wp->query_vars['view-order'] : '';
                $title = 'Order #'.$order_id;
                $next = '<span class="mx-2">/</span>Order';
            } elseif ( is_wc_endpoint_url('downloads') ) {
                $title = 'Downloads';
                $next = '<span class="mx-2">/</span> Downloads';
            } elseif ( is_wc_endpoint_url('edit-address') ) {
                $title = 'Addresses';
                $next = '<span class="mx-2">/</span> Addresses';
            } elseif ( is_wc_endpoint_url('payment-methods') || is_wc_endpoint_url('add-payment-method') ) {
                $title = 'Payment Methods';
                $next = '<span class="mx-2">/</span> Payment Methods';
            } else {
                $title = get_the_title();
                $next = '';
            }
    
        }

    } elseif (is_search()) {
        $title = 'Search Results';
        $current = 'Showing results for "'. get_search_query().'"';
    }elseif (is_shop()) {
        $title = get_the_title(wc_get_page_id('shop'));
        $current = get_the_title(wc_get_page_id('shop'));
    } elseif ( is_singular('product') ) {
        $terms = get_the_terms( get_the_ID(), 'product_cat' );
        if ( $terms && ! is_wp_error( $terms ) ) {
            $names = [];
            foreach ( $terms as $term ) {
                $names[] = $term->name;
            }
            $title = implode(' / ', $names);
        }
        $current = get_the_title();
    } elseif ( is_product_category() ) {
        $category = get_queried_object();
        $title = $category->name; 
        $current = $category->name; 
    }
?>
<section id="page-hero">
    <div class="page-hero-bg"></div>
    <div class="page-hero-overlay"></div>
    <div class="text-center reveal">
        <h1 class="page-hero-title"><span><?php echo $title; ?></span></h1>
        <div class="breadcrumb-wrap reveal custom-style-3" >
            <a href="<?php echo site_url(); ?>">Home</a>
            <span class="mx-2">/</span>
            <?php
                if ( is_singular('product') ) {
                    echo '<a href="'.get_permalink( wc_get_page_id( 'shop' ) ).'">'.get_the_title(wc_get_page_id('shop')).'</a>';
                    echo '<span class="mx-2">/</span>';
                }

                if ( is_account_page() )  {
                    if ( is_wc_endpoint_url() ) {
                        echo '<a href="'.get_permalink().'">'.get_the_title().'</a>';
                        echo '<span>' . $next . '</span>';
                    } else {
                        echo '<span>' . $current . '</span>';
                    }
                } else {
                    echo '<span>' . $current . '</span>';
                }
            ?>
        </div>
    </div>
</section>