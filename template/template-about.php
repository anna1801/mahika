<?php 
/* Template Name: About page */ 
/* Template Post Type: page */ 
?>

<?php get_header(); ?>

  <?php get_template_part('template/inner-hero'); ?>

  <?php
    $about_showhide = get_field('about_showhide');
    $about_title = get_field('about_title');
    $about_image = get_field('about_image');
    $about_description = get_field('about_description');
    if($about_showhide) :
    ?>
    <section id="intro">
      <div class="container">
        <div class="row align-items-center g-5 reveal">
          <div class="col-lg-7">
            <?php 
              if($about_title) :
                echo '<h2 class="intro-headline">'.$about_title.'</h2>';
              endif;
              if($about_description) :
                echo '<div class="intro-body">' . $about_description . '</div>';
              endif;
            ?>
          </div>
          <?php 
            if($about_image) :
              echo  '<div class="col-lg-5">
                        <div class="intro-img-card">
                            <img src="'.$about_image['url'].'" alt="'.$about_image['alt'].'" />
                        </div>
                    </div>';
            endif;
          ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php
    $features_showhide = get_field('features_showhide');
    $features_title = get_field('features_title');
    if($features_showhide && have_rows('features')) :
    ?>
    <section id="why-choose">
      <div class="container text-center">
        <?php
          if($features_title) :
            echo '<h2 class="why-title reveal">'.$features_title.'</h2>';
          endif;
        ?>
        <div class="row g-4 justify-content-center mt-4">
          <?php
            while( have_rows('features') ): the_row();
              $image = get_sub_field('image');
              $description = get_sub_field('description');
              ?>
              <div class="col-6 col-md-3 reveal custom-style-4" >
                <div class="why-item">
                  <?php 
                    if($image) :
                      echo '<img src="'.$image['url'].'" alt="'.$image['alt'].'" />';
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

<?php get_footer(); ?>