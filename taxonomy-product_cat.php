<?php get_header(); ?>

  <?php 
    $current_cat = get_queried_object(); 

    $cat_id = $current_cat->term_id;

    get_template_part('template/inner-hero'); 
  ?>
  
  <section id="shop-layout">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-3" id="sidebar">
          <?php
            global $wpdb;
            $min_price = $wpdb->get_var("
              SELECT MIN(CAST(meta_value AS DECIMAL)) 
              FROM {$wpdb->postmeta} pm
              INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
              WHERE pm.meta_key = '_price'
              AND p.post_type = 'product'
              AND p.post_status = 'publish'
            ");
            $max_price = $wpdb->get_var("
              SELECT MAX(CAST(meta_value AS DECIMAL)) 
              FROM {$wpdb->postmeta} pm
              INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
              WHERE pm.meta_key = '_price'
              AND p.post_type = 'product'
              AND p.post_status = 'publish'
            ");
            $min_price = $min_price ? floor($min_price) : 0;
            $max_price = $max_price ? ceil($max_price) : 1000;
          ?>
          <div class="sidebar-card reveal custom-style-33 price-filter">
            <h6>Filter By Price</h6>
            <div class="price-range-wrap mt-2">
              <div class="range-slider">
                <span class="range-selected"></span>
              </div>
              <div class="range-input">
                <input 
                  type="range" 
                  class="min"
                  min="<?php echo esc_attr($min_price); ?>"
                  max="<?php echo esc_attr($max_price); ?>"
                  value="<?php echo esc_attr($min_price); ?>"
                  step="1"
                >
                <input 
                  type="range" 
                  class="max"
                  min="<?php echo esc_attr($min_price); ?>"
                  max="<?php echo esc_attr($max_price); ?>"
                  value="<?php echo esc_attr($max_price); ?>"
                  step="1"
                >
              </div>
              <div class="d-flex justify-content-between align-items-center mt-4">
                <span class="price-label">
                  Price: ₹
                  <span id="minPriceVal"><?php echo esc_html($min_price); ?></span>
                  —
                  ₹<span id="maxPriceVal"><?php echo esc_html($max_price); ?></span>
                </span>
                <button class="btn-filter filter-btn">Filter</button>
              </div>
              <div class="text-start mt-3">
                <script>
                  var min_price = <?php echo esc_html($min_price); ?>;
                  var max_price = <?php echo esc_html($max_price); ?>;
                </script>
                <a href="javascript:void(0)" class="text-rust small fw-bold text-decoration-none clear-price" onclick="resetPriceFilter()"> Clear All </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-9">
     
          <div class="d-md-none mb-3">
            <button class="mobile-filter-btn" onclick="document.getElementById('sidebar').classList.toggle('show')">
              <i class="bi bi-funnel-fill"></i> Filter &amp; Categories
            </button>
          </div>

          <?php 
            if (have_posts()) : 
              $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
              $args = array(
                'post_type'      => 'product',
                'posts_per_page' => 15,
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

              $products = new WP_Query($args);
              $total = $products->found_posts;
              $per_page = $products->query_vars['posts_per_page'];
              $current_page = max(1, $paged);
              $first = ( ($current_page - 1) * $per_page ) + 1;
              $last = min( $total, $current_page * $per_page );
            ?>
            <div class="toolbar reveal">
              <span class="results">Showing <strong><?php echo $first . '–' . $last; ?></strong> of <strong><?php echo $total; ?></strong> results</span>
              <div class="d-flex align-items-center gap-2">
                <div class="view-toggle">
                  <button id="gridBtn" class="active" onclick="setView('grid')" title="Grid view"><i
                      class="bi bi-grid-3x3-gap-fill"></i></button>
                  <button id="listBtn" onclick="setView('list')" title="List view"><i class="bi bi-list-ul"></i></button>
                </div>
                <select class="sort-select nice-select ajax-sort" name="sortby">
                  <option value="">Relevance</option>
                  <option value="name-asc">Name (A - Z)</option>
                  <option value="name-desc">Name (Z - A)</option>
                  <option value="price-asc">Price (Low → High)</option>
                  <option value="price-desc">Price (High → Low)</option>
                  <option value="date-desc">Newest</option>
                  <option value="date-asc">Oldest</option>
                </select>
              </div>
            </div>
            <div class="row g-3 products-grid" id="productsGrid">
              <?php
                while ($products->have_posts()) : $products->the_post(); 
                  echo '<div class="col-12 col-sm-6 col-md-4 col-product custom-style-61">';
                    get_template_part('template/product-list');
                  echo '</div>';
                endwhile;
                wp_reset_postdata();
              ?>  
            </div>
            <?php 
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
            ?> 
          <?php 
            else : 
              get_template_part('template/no-products'); 
            endif; 
          ?> 
        </div>
      </div>
    </div>
  </section>

<?php get_footer(); ?>