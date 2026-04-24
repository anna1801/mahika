<?php 
/* Template Name: Contact page */ 
/* Template Post Type: page */ 
?>

<?php get_header(); ?>

  <?php get_template_part('template/inner-hero'); ?>

  <?php
    $title = get_field('title');
    $description = get_field('description');
    $contact_form_shorcode = get_field('contact_form_shorcode');
  ?>
  <section class="py-5">
    <div class="container py-5">
      <div class="row g-5">
        <div class="col-lg-5 reveal-left">
          <?php 
            if($title) :
              echo '<h2 class="display-6 fw-bold mb-4 custom-style-16" >'.$title.'</h2>';
            endif;
            if($description) :
              echo '<p class="mb-5">'.$description.'</p>';
            endif; 
          ?>
          <?php
            if( have_rows('contact_details') ):
              while( have_rows('contact_details') ): the_row();
              $icon = get_sub_field('icon');
              $title = get_sub_field('title');
              $details = get_sub_field('details');
              ?>
              <div class="d-flex mb-4">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm custom-style-24">
                  <i class="bi bi-<?php echo $icon; ?> text-rust fs-5"></i>
                </div>
                <div class="ms-3">
                  <?php
                    if($title) :
                      echo '<h4 class="fw-bold mb-1">'.$title.'</h4>';
                    endif;
                    if($details) :
                      if($icon == 'telephone-fill') {
                        echo '<a href="tel:'.$details.'" class="text-muted mb-0">'.$details.'</a>';
                      } elseif($icon == 'envelope-fill') {
                        echo '<a href="mailto:'.$details.'" class="text-muted mb-0">'.$details.'</a>';
                      } else {
                        echo '<p class="text-muted mb-0">'.$details.'</p>';
                      }
                    endif;
                  ?>
                </div>
              </div>
              <?php
              endwhile;
            endif;
          ?>
        </div>
        <?php
          if($contact_form_shorcode ) :
            echo  '<div class="col-lg-7 reveal-right">
                      <div class="bg-white p-5 rounded-4 shadow-sm">
                      '.do_shortcode($contact_form_shorcode ).'
                      </div>
                  </div>';
          endif;
        ?>
      </div>
    </div>
  </section>
  
<?php get_footer(); ?>