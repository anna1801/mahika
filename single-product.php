<?php get_header(); ?>

  <?php 
    get_template_part('template/inner-hero');

    if ( ! defined( 'ABSPATH' ) ) exit;

    global $post;

    if ( ! is_a( $post, 'WC_Product' ) ) {
        $product = wc_get_product( get_the_ID() );
    }

    $id = get_the_ID();
    $title = get_the_title();
    $regular_price = $product->get_regular_price();
    $sale_price    = $product->get_sale_price();
  ?>

  <section id="product-detail">
    <div class="container">

      <div class="row g-5 reveal">
        <?php 
          $featured_id = $product->get_image_id();
          $attachment_ids = $product->get_gallery_image_ids(); 
        ?>
        <div class="col-lg-6 reveal-left">
          <div class="gallery-wrap">
            <div class="thumbnails">
              <?php
                if ( $featured_id ) :
                  $featured_url = wp_get_attachment_image_url( $featured_id, 'full' );
                  ?>
                  <div class="thumb active" onclick="switchImg(this,'<?php echo esc_url( $featured_url ); ?>')">
                    <img src="<?php echo esc_url( $featured_url ); ?>" alt="<?php echo $title; ?>" />
                  </div>
                  <?php
                endif; 

                if ( ! empty( $attachment_ids ) ) : 
                  foreach ( $attachment_ids as $attachment_id ) :
                    $image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
                    ?>
                    <div class="thumb" onclick="switchImg(this,'<?php echo esc_url( $image_url ); ?>')">
                      <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo $title; ?>" />
                    </div>
                    <?php 
                  endforeach; 
                endif; 
              ?>
            </div>
            <div class="main-img-wrap" id="mainImgWrap">
              <?php
                if ( $featured_id ) :
                    $featured_url = wp_get_attachment_image_url( $featured_id, 'full' );
                    echo  '<a href="'. esc_url( $featured_url ) .'" class="glightbox" data-gallery="product-gallery" id="mainImgLink">
                            <img src="'. esc_url( $featured_url ) .'" alt="'. $title . '" id="mainImg" />
                          </a>';
                endif; 
              ?>
              <div class="custom-style-25">
                <?php
                  if ( ! empty( $attachment_ids ) ) : 
                    foreach ( $attachment_ids as $attachment_id ) :
                      $image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
                      echo '<a href="'. esc_url( $image_url ) .'" class="glightbox" data-gallery="product-gallery"></a>';
                    endforeach; 
                  endif; 
                ?>
              </div>
              <div class="fresh-badge"><i class="bi bi-check-circle-fill me-1"></i>Always Fresh</div>
              <div class="zoom-hint"><i class="bi bi-zoom-in me-1"></i>Click to zoom • Hover to magnify</div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 reveal-right">
          <div class="product-info-wrap">

            <?php
              $terms = get_the_terms( get_the_ID(), 'product_cat' );
              if ( $terms && ! is_wp_error( $terms ) ) {
                echo '<span class="product-cat-tag">';
                  $names = [];
                  foreach ( $terms as $term ) {
                      $names[] = $term->name;
                  }
                  $cat = implode(', ', $names);
                  echo '<i class="bi bi-grid-fill me-1"></i>'.$cat;
                echo '</span>';
              }
            ?>
        
            <h1 class="product-title"><?php echo $title; ?></h1>

            <?php
              $average = $product->get_average_rating();
              $review_count = $product->get_review_count();
            ?>
            <div class="review-row">
              <span class="stars-lg">
                <?php
                  for ($i = 1; $i <= 5; $i++) {
                    if ($i <= floor($average)) {
                      echo '<i class="bi bi-star-fill"></i>'; 
                    } else {
                      echo '<i class="bi bi-star"></i>'; 
                    }
                  }
                ?>
              </span>
              <span class="review-count">(<?php echo $review_count; ?> Review)</span>
              <a href="#desc-tabs" class="text-decoration-none ms-1 custom-style-47">Write a review</a>
            </div>

            <div class="price-row">
              <?php
                if($product->is_on_sale()) {
                  echo '<span class="price-now">'.wc_price($sale_price).'</span>';
                  echo '<span class="price-was">'.wc_price($regular_price).'</span>';
                  $discount =  $regular_price - $sale_price;
                  echo '<span class="price-save">Save ₹'.$discount.'</span>';
                } else {
                  echo '<span class="price-now">'.wc_price($regular_price).'</span>';
                }
              ?>
            </div>

            <hr class="divider" />

            <form class="custom-ajax-add-to-cart" method="post">
              <div class="qty-row">
                <div class="qty-wrap">
                  <button type="button" class="qty-btn" onclick="changeQty(-1)">−</button>
                  <input type="text" name="quantity" class="qty-input" value="1" min="1" id="qtyInput" readonly />
                  <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                </div>
                <button type="submit" name="add-to-cart" value="<?php echo $product->get_id(); ?>" class="btn-add-cart single_add_to_cart_button btn btn-cart2 add_to_cart_button ajax_add_to_cart" id="cartBtn" onclick="handleCart()">
                  <i class="bi bi-cart-plus me-2"></i>Add to Cart
                </button>
                <button class="btn-wishlist" id="wishBtn" onclick="toggleWish()" title="Add to Wishlist">
                  <?php echo do_shortcode('[yith_wcwl_add_to_wishlist label="wishlist" ]'); ?>
                </button>
              </div>
            </form>
            
            <?php
              $sku = $product->get_sku();
              if ( !empty($sku) ) :
                echo '<div class="sku-row mt-2">SKU: <span>'.$sku.'</span></div>';
              endif;
            ?>

            <?php
              $short_description = $product->get_short_description();
              if ( ! empty( $short_description ) ) {
                  echo '<div class="product-description mt-3 text-muted custom-style-48">';
                  echo wp_kses_post( $short_description );
                  echo '</div>';
              }
            ?>

          </div>
        </div>
      </div>

      <?php
        $description = $product->get_description();
        $weight = $product->get_weight();
        $length = $product->get_length();
        $width  = $product->get_width();
        $height = $product->get_height();
        $origin = get_post_meta($post->ID, '_product_origin', true);
        $terms = get_the_terms( get_the_ID(), 'product_cat' );
        $brands = get_the_terms( $product->get_id(), 'product_brand' );
        $review_count = $product->get_review_count();
        if($review_count > 0) {
          $count = '('.$review_count.')';
        } else {
          $count = '';
        }
      ?>
      <div id="desc-tabs" class="mt-5 reveal">
        <div class="tab-nav">
          <button class="tab-btn active" onclick="switchTab(this,'tab-desc')">Description</button>
          <button class="tab-btn" onclick="switchTab(this,'tab-info')">Additional Info</button>
          <button class="tab-btn" onclick="switchTab(this,'tab-reviews')">Reviews <?php echo $count; ?></button>
        </div>

        <div class="tab-panel active" id="tab-desc">
          <?php echo apply_filters( 'the_content', $description ); ?>
        </div>

        <div class="tab-panel table-responsive" id="tab-info">
          <table class="table table-bordered table-striped custom-style-50">
            <tbody>
              <?php
                if ( ! empty( $weight ) ) {
                  echo  '<tr>
                          <th class="custom-style-51">Weight</th>
                          <td>'.$weight.'g</td>
                        </tr>';
                }

                if ( ! empty($length) || ! empty($width) || ! empty($height) ) {
                  echo  '<tr>
                          <th class="custom-style-52">Dimensions</th>
                          <td>'.$length.' × '.$width.' × '.$height.' cm</td>
                        </tr>';
                }

                if($origin) {
                  echo  '<tr>
                          <th class="custom-style-52">Origin</th>
                          <td>'.$origin.'</td>
                        </tr>';
                }
              
                if ( $terms && ! is_wp_error( $terms ) ) {
                  echo '<tr>';
                    echo '<th class="custom-style-52">Type</th>';
                    $names = [];
                    foreach ( $terms as $term ) {
                      $names[] = $term->name;
                    }
                    $cat = implode(', ', $names);
                    echo '<td>'.$cat.'</td>';
                  echo '</tr>';
                }

                if ( ! empty($brands) && ! is_wp_error($brands) ) {
                  echo '<tr>';
                    echo '<th class="custom-style-52">Brand</th>';
                    $names = [];
                    foreach ( $brands as $brand ) {
                      $names[] = $brand->name;
                    }
                    $brand = implode(', ', $names);
                    echo '<td>'.$brand.'</td>';
                  echo '</tr>';
                }
              ?>
            </tbody>
          </table>
        </div>

        <div class="tab-panel" id="tab-reviews">
          <?php
            $comments = get_comments([
              'post_id' => $product->get_id(),
              'status'  => 'approve'
            ]);
          ?>
          <div class="custom-style-53 rounded-3 reviews">
            <?php foreach ($comments as $comment): 
              $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));
              $letter = strtoupper(substr($comment->comment_author, 0, 1));
              ?>
              <div class="d-flex gap-3 align-items-start p-3 rounded-3 review">
                <div class="custom-style-54"><?php echo $letter; ?></div>
                <div>
                  <div class="fw-bold custom-style-55">
                    <?php echo esc_html($comment->comment_author); ?>
                  </div>
                  <div class="custom-style-56">
                    <?php for ($i=1; $i<=5; $i++): ?>
                      <span><?php echo $i <= $rating ? '★' : '☆'; ?></span>
                    <?php endfor; ?>
                  </div>
                  <p class="custom-style-57">
                    <?php echo esc_html($comment->comment_content); ?>
                  </p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <form action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post" class="reviewform">
            <div class="mt-4 p-3 rounded-3 custom-style-53">
              <h6 class="custom-style-58">Leave a Review</h6>
              <div class="row g-3">
                <div class="col-md-4">
                  <input name="author" class="form-control custom-style-59" placeholder="Your Name" required>
                </div>
                <div class="col-md-4">
                  <input name="email" type="email" class="form-control custom-style-59" placeholder="Email" required>
                </div>
                <div class="col-md-4">
                  <input name="phone" type="tel" class="form-control custom-style-59" placeholder="Phone">
                </div>
                <div class="col-12">
                  <textarea name="comment" class="form-control custom-style-60" rows="3" placeholder="Your review..." required></textarea>
                </div>
                <div class="col-12 mt-2 rating-stars d-flex align-items-center gap-2">
                  <label class="fw-bold small text-uppercase">Rating</label>
                  <div class="stars" id="ratingStars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                      <span data-value="<?php echo $i; ?>">★</span>
                    <?php endfor; ?>
                    <input type="hidden" name="rating" id="ratingValue" value="5">
                  </div>
                </div>
                <div class="col-12 mt-3">
                  <label class="form-label fw-bold small text-uppercase">Security Verification</label>
                  <div class="captcha-container">
                    <div class="captcha-code" id="captchaCode">Z9Y1P</div>
                    <button type="button" class="btn-refresh-captcha" onclick="generateCaptcha()">
                      <i class="bi bi-arrow-clockwise"></i>
                    </button>
                    <input name="captcha_input" type="text" class="form-control captcha-input" id="captchaInput" placeholder="Enter code" required>
                    <input type="hidden" name="captcha_expected" id="captchaExpected" value="Z9Y1P">
                  </div>
                  <div id="captchaError" class="text-danger small mt-1 custom-style-25"></div>
                </div>
                <div class="col-12 mt-4">
                  <button type="submit" class="btn btn-rust py-2 px-5 rounded-pill">
                    Submit Review
                  </button>
                </div>
              </div>
            </div>
            <input type="hidden" name="comment_post_ID" value="<?php echo $product->get_id(); ?>">
            <input type="hidden" name="comment_parent" value="0">
            <input type="hidden" name="comment_type" value="review">
            <?php comment_id_fields(); ?>
          </form>
        </div>

      </div>
    </div>
  </section>

  <?php
    $terms = wp_get_post_terms($id, 'product_cat', ['fields' => 'ids']);
    if (!empty($terms)) {
      $args = [
        'post_type'      => 'product',
        'posts_per_page' => 4,
        'post__not_in'   => [$id],
        'tax_query'      => [
            [
              'taxonomy' => 'product_cat',
              'field'    => 'term_id',
              'terms'    => $terms,
            ],
        ],
      ];
      $related_products = new WP_Query($args);
      if ($related_products->have_posts()) :
        ?>
        <section id="related">
          <div class="container">
            <h2 class="section-title reveal mb-5">Related Products</h2>
            <div class="row g-3" id="relatedGrid">
              <?php
                while ($related_products->have_posts()) : $related_products->the_post();
                  echo '<div class="col-12 col-sm-6 col-md-6 col-lg-3 col-product reveal custom-style-61">';
                    get_template_part('template/product-list');
                  echo '</div>';
                endwhile;
              ?>
            </div>
          </div>
        </section>
        <?php
      endif;
      wp_reset_postdata();
    }
  ?>

<?php get_footer(); ?>