<?php 
/* Template Name: Legal page */ 
/* Template Post Type: page */ 
?>

<?php get_header(); ?>

  <?php get_template_part('template/inner-hero'); ?>

  <section class="py-5">
    <div class="container py-4">
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <div class="legal-content reveal">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php get_footer(); ?>