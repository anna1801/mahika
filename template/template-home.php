<?php 
/* Template Name: Home page */ 
/* Template Post Type: page */ 
?>

<?php get_header(); ?>

  <?php if( have_rows('hero_slider') ): ?>
    <section id="hero" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php 
          $i = 1; 
          while( have_rows('hero_slider') ): the_row();
          if($i == 1) {
            $class = 'active';
          } else {
            $class = '';
          }
          $featured_image = get_sub_field('featured_image');
          $heading = get_sub_field('heading');
          ?>
          <div class="carousel-item <?php echo $class; ?>">
            <div class="hero-bg custom-style-29"></div>
            <div class="hero-overlay"></div>
            <div class="container hero-content d-flex align-items-center">
              <div class="row align-items-center">
                <?php 
                  if($featured_image) :
                    echo  '<div class="col-lg-6 col-md-6 order-2 order-lg-1 text-center">
                            <img src="'.$featured_image['url'].'" alt="'.$featured_image['alt'].'" class="hero-pkg custom-style-30" />
                          </div>';
                  endif;
                  if($heading) :
                    echo  '<div class="col-lg-6 col-md-6 order-1 order-lg-2 ps-lg-5">
                            <h1 class="hero-title animate__animated animate__fadeInRight">
                              '.$heading.'
                            </h1>
                          </div>';
                  endif; 
                ?>
              </div>
            </div>
          </div>
          <?php 
          $i++; 
          endwhile; 
        ?>
      </div>
      <?php
        $x = 1; 
        while( have_rows('hero_slider') ): the_row();
          if($x > 1) :
            ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#hero" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#hero" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
            <?php
          endif;
          $x++;
        endwhile;
      ?>
    </section>
  <?php endif; ?>

  <?php
    $mission = get_field('mission');
    $vission = get_field('vission');
    $about_showhide = get_field('about_showhide');
    if($about_showhide) :
    ?>
    <section id="about-strip" class="reveal">
      <div class="container text-center">
        <div class="about-content-wrap mx-auto">
          <?php 
            if($mission) :
              echo '<p class="about-p1"> '.$mission.' </p>';
            endif;
            if($vission) :
              echo '<p class="about-p2">'.$vission.'</p>';
            endif;
          ?>
          <div class="ornamental-divider">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/theme/img/border.png" alt="Ornamental Divider" />
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php
    $products_showhide = get_field('products_showhide');
    $products_title = get_field('products_title');
    $products_description = get_field('products_description');
    $products_cta = get_field('products_cta');
    if($products_showhide) :
    ?>
    <section id="products">
      <div class="container">
        <div class="text-center mb-5 reveal fade-in-up">
          <?php 
            if($products_title) :
              echo '<h2 class="section-title">'.$products_title.'</h2>';
            endif;
            if($products_description) :
              echo '<p class="mt-4 custom-style-31">'.$products_description.'</p>';
            endif;
          ?>
        </div>
        <div class="row g-4">
          <?php
            $args = array(
              'post_type'      => 'product',
              'posts_per_page' => 4,
              'post_status'    => 'publish',
              'orderby'        => 'date', 
              'order'          => 'DESC',
            );
            $products = new WP_Query($args);
            if ($products->have_posts()) : 
                while ($products->have_posts()) : $products->the_post(); 
                  echo '<div class="col-6 col-md-6 col-lg-3 reveal custom-style-5">';
                    get_template_part('template/product-list');
                  echo '</div>';
                endwhile;
                wp_reset_postdata();
            endif; 
          ?> 
        </div>
        <?php
          if($products_cta) :
            echo  '<div class="text-center mt-5 reveal">
                    <a href="'.$products_cta['url'].'" target="'.$products_cta['target'].'" class="btn-rust text-decoration-none px-5 py-3">'.$products_cta['title'].'</a>
                  </div>';
          endif;
        ?>
      </div>
    </section>
  <?php endif; ?>

  <?php
    $categories_showhide = get_field('categories_showhide');
    $categories_title = get_field('categories_title');
    if($categories_showhide) :
    ?>
    <section id="categories">
      <div class="container">
        <?php
          if($categories_title) :
            echo  '<div class="text-center mb-3">
                    <h2 class="section-title reveal">'.$categories_title.'</h2>
                  </div>';
          endif;
        ?>
        <div class="row row-cols-3 row-cols-sm-4 row-cols-md-5 row-cols-lg-9 g-3 justify-content-center mb-3">
          <?php
            $categories = get_terms([
              'taxonomy'   => 'product_cat',
              'hide_empty' => false,
            ]);
            if (!empty($categories) && !is_wp_error($categories)) {
              foreach ($categories as $category) {
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image_url = wp_get_attachment_url($thumbnail_id);
                if (!$image_url) {
                  $image_url = wc_placeholder_img_src();
                }
                ?>
                <a href="<?php echo esc_url(get_term_link($category)); ?>">
                  <div class="col reveal custom-style-32">
                    <div class="cat-pill">
                      <div class="cat-icon">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
                      </div>
                      <span class="cat-label">
                        <?php echo esc_html($category->name); ?>
                      </span>
                    </div>
                  </div>
                </a>
                <?php
              }
            }
          ?>
        </div>
      </div>
    </section> 
  <?php endif; ?>

  <?php
    $story_showhide = get_field('story_showhide');
    $story_image = get_field('story_image');
    $story_content = get_field('story_content');
    $features_title = get_field('features_title');
    if($story_showhide) :
    ?>
    <section id="farm-story">
      <div class="container">
        <div class="row align-items-center g-5">
          <?php
            if($story_image) :
              echo  '<div class="col-lg-6 reveal fade-in-left">
                      <div class="farm-art">
                        <img src="'.$story_image['url'].'" alt="'.$story_image['alt'].'" />
                      </div>
                    </div>';
            endif;
          ?>
          <div class="col-lg-6 farm-text-block reveal fade-in-right mb-5">
            <?php 
              if($story_content) :
                echo '<p class="farm-desc">'.$story_content.'</p>';
              endif;

              if( have_rows('core_features') ):
                if($features_title) :
                  echo '<h2 class="pillars-title">'.$features_title.'</h2>';
                endif;
                echo '<div class="pillar-cards-grid">';
                  $i = 1;
                  while( have_rows('core_features') ): the_row();
                    $icon = get_sub_field('icon');
                    $title = get_sub_field('title');
                    $description = get_sub_field('description');
                    if ($i % 2 == 0) {
                      $class = 'bg-yellow-light';
                    } else {
                      $class = 'bg-green-light';
                    }
                    ?>
                    <div class="pillar-card-v2">
                      <div class="pillar-icon-box <?php echo $class; ?>">
                        <i class="bi bi-<?php echo $icon; ?>"></i>
                      </div>
                      <div class="pillar-info">
                        <?php 
                          if($title) :
                            echo '<h6>'.$title.'</h6>';
                          endif;
                          if($description) :
                            echo '<p>'.$description.'</p>';
                          endif;
                        ?>
                      </div>
                    </div>
                    <?php 
                    $i++;
                  endwhile;
                echo '</div>';
              endif;
            ?>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php
    $benefits_showhide = get_field('benefits_showhide');
    $benefits_title = get_field('benefits_title');
    if($benefits_showhide && have_rows('benefits')) :
    ?>
    <section id="pillars-circles" class="bg-cream">
      <div class="container">
        <?php
          if($benefits_title) :
            echo '<div class="text-center mb-5"><h2 class="section-title reveal">'.$benefits_title.'</h2></div>';
          endif;
        ?>
        <div class="row g-4 justify-content-center">
          <?php
            while( have_rows('benefits') ): the_row();
              $icon = get_sub_field('icon');
              $title = get_sub_field('title');
              $description = get_sub_field('description');
              ?>
              <div class="col-md-4 reveal custom-style-4">
                <div class="circle-pillar">
                  <?php 
                    if($icon) :
                      echo '<img src="'.$icon['url'].'" alt="'.$icon['alt'].'" class="mb-3 custom-style-37">';
                    endif;
                    if($title) :
                      echo '<h6>'.$title.'</h6>';
                    endif;
                    if($description) :
                      echo '<p>'.$description.'</p>';
                    endif;
                  ?>
                </div>
              </div>
              <?php 
            endwhile; 
          ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php
    $testimonials_showhide = get_field('testimonials_showhide');
    $testimonials_title = get_field('testimonials_title');
    if($testimonials_showhide && have_rows('testimonials')) :
    ?>
    <section id="testimonials" class="bg-cream">
      <div class="container">
        <?php 
          if($testimonials_title) :
            echo '<div class="text-center mb-4"><h2 class="section-title reveal">'.$testimonials_title.'</h2> </div>';
          endif;
        ?>
        <div id="testiCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
          <div class="carousel-inner">
          <?php
            $i = 1; 
            while( have_rows('testimonials') ): the_row();
              if($i == 1) {
                $class = 'active';
              } else {
                $class = '';
              }
              $author = get_sub_field('author');
              $quote = get_sub_field('quote');
              ?>
              <div class="carousel-item <?php echo $class; ?>">
                <div class="testi-slide text-center">
                  <?php
                    if($quote) :
                      echo '<p class="testi-quote">'.$quote.'</p>';
                    endif;
                    if($author) :
                      echo '<p class="testi-author">'.$author.'</p>';
                    endif;
                  ?>
                </div>
              </div>
              <?php 
              $i++;
            endwhile; 
          ?>
          <?php
            $x = 1; 
            while( have_rows('testimonials') ): the_row();
              if($x > 1) :
                ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#testiCarousel" data-bs-slide="prev">
                  <i class="bi bi-arrow-left-short testi-arrow"></i>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testiCarousel" data-bs-slide="next">
                  <i class="bi bi-arrow-right-short testi-arrow"></i>
                </button>
                <?php
              endif;
              $x++;
            endwhile;
          ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php
    $bottomcta_showhide = get_field('bottomcta_showhide');
    $bottomcta_description = get_field('bottomcta_description');
    $bottomcta_cta = get_field('bottomcta_cta');
    if($bottomcta_showhide) :
    ?>
    <section id="cta-banner">
      <div class="container">
        <?php
          if($bottomcta_description) :
            echo '<h2 class="reveal">'.$bottomcta_description.'</h2>';
          endif;
          if($bottomcta_cta) :
            echo  '<a href="'.$bottomcta_cta['url'].'" target="'.$bottomcta_cta['target'].'" class="btn-cta text-decoration-none reveal d-inline-block mt-4 custom-style-35 mb-4">
                    <i class="bi bi-telephone-fill me-2"></i>'.$bottomcta_cta['title'].'
                  </a>';
          endif;
        ?>
      </div>
    </section>
  <?php endif; ?>

<?php get_footer(); ?>