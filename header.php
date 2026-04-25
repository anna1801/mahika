<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

  <div id="preloader">
    <div class="loader-content">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/theme/img/logo.png" alt="Logo" class="loader-logo">
      <div class="loader-bar"></div>
    </div>
  </div>

  <header id="site-header">
    <nav class="navbar navbar-expand-lg" id="mainNav">
      <div class="container">
        <?php
          $header_logo = get_field('header_logo', 'option');
          if($header_logo) :
            echo '<a class="navbar-brand" href="'.site_url().'"><img src="'.$header_logo['url'].'" alt="'.$header_logo['alt'].'" /></a>';
          endif;
        ?>
        <div class="d-flex align-items-center gap-2 order-lg-3">
          <div class="d-flex d-lg-none align-items-center gap-2 me-2">
            <div class="user-dropdown-wrapper position-relative">
              <a href="javascript:void(0)" class="nav-icon-btn">
                <i class="bi bi-person"></i>
              </a>
              <!-- to do -->
              <div class="user-dropdown">
                <a href="login.html"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                <a href="register.html"><i class="bi bi-person-plus me-2"></i>Register</a>
                <hr class="m-0 opacity-10">
                <a href="my-account.html"><i class="bi bi-person-circle me-2"></i>My Account</a>
                <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>"><i class="bi bi-heart me-2"></i>My Wishlist</a>
              </div>
            </div>
            <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" class="nav-icon-btn"><i class="bi bi-heart"></i></a>
            <a href="javascript:void(0)" class="nav-icon-btn" id="mobileCartTrigger"><i class="bi bi-bag"></i></a>
          </div>
          <!-- to do end -->
          <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <i class="bi bi-list fs-4 custom-style-1"></i>
          </button>
        </div>

        <div class="collapse navbar-collapse order-lg-2" id="navMenu">
          <?php
            wp_nav_menu([
              'theme_location' => 'header-menu',
              'container'      => false,
              'menu_class'     => 'navbar-nav mx-auto',
              'walker'         => new Header_Menu_Walker(),
            ]);
          ?>
          <!-- to do -->
          <div class="d-none d-lg-flex align-items-center gap-3">
            <div class="position-relative">
              <?php
                $search_placeholder = get_field('search_placeholder', 'option');
                if($search_placeholder) {
                  $placeholder = $search_placeholder;
                } else {
                  $placeholder = 'Search';
                }
              ?>
              <input type="text" class="search-input" placeholder="<?php echo $placeholder; ?>" />
              <button class="search-btn"><i class="bi bi-search"></i></button>
            </div>
            <div class="user-dropdown-wrapper position-relative">
              <a href="javascript:void(0)" class="nav-icon-btn">
                <i class="bi bi-person"></i>
              </a>
              <div class="user-dropdown">
                <a href="login.html"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
                <a href="register.html"><i class="bi bi-person-plus me-2"></i>Register</a>
                <hr class="m-0 opacity-10">
                <a href="my-account.html"><i class="bi bi-person-circle me-2"></i>My Account</a>
                <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>"><i class="bi bi-heart me-2"></i>My Wishlist</a>
              </div>
            </div>
            <a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" class="nav-icon-btn"><i class="bi bi-heart"></i></a>
            <a href="javascript:void(0)" class="nav-icon-btn" id="cartTrigger">
              <i class="bi bi-bag"></i>
              <span class="cart-badge notification auto-cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </a>
          </div>
          <!-- to do -->
        </div>
      </div>
    </nav>

    <div class="overlay" id="cartOverlay"></div>



    <?php get_template_part('ajax/minicart'); ?>














    <!-- to do -->
  </header>
<main>