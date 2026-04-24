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
              <span class="cart-badge">3</span>
            </a>
          </div>
          <!-- to do -->
        </div>
      </div>
    </nav>

    <!-- to do -->
    <div class="overlay" id="cartOverlay"></div>
    <div class="cart-sidebar" id="cartSidebar">
      <div class="cart-header">
        <h4>My Shopping Cart</h4>
        <button class="close-cart" id="closeCart"><i class="bi bi-x-lg"></i></button>
      </div>
      <div class="cart-items">
        <!-- Item 1 -->
        <div class="d-flex align-items-center gap-3 mb-4">
          <div class="cart-item-img-box">
            <img src="img/fish-masala.png" alt="Fish Masala" />
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-0 custom-style-12">Fish Masala (125g)</h6>
            <small class="text-muted">1 x ₹65.00</small>
          </div>
          <button class="btn btn-sm text-danger border-0 p-0"><i class="bi bi-trash"></i></button>
        </div>
        <!-- Item 2 -->
        <div class="d-flex align-items-center gap-3 mb-4">
          <div class="custom-style-10">
            <img class="custom-style-11" src="img/red-chilli-powder.png" alt="Red Chilly Powder" />
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-0 custom-style-12">Red Chilly Powder (125g)</h6>
            <small class="text-muted">1 x ₹65.00</small>
          </div>
          <button class="btn btn-sm text-danger border-0 p-0"><i class="bi bi-trash"></i></button>
        </div>
        <!-- Item 3 -->
        <div class="d-flex align-items-center gap-3 mb-4">
          <div class="custom-style-10">
            <img class="custom-style-11" src="img/chicken-masala.png" alt="Chicken Masala" />
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-0 custom-style-12">Chicken Masala (125g)</h6>
            <small class="text-muted">1 x ₹65.00</small>
          </div>
          <button class="btn btn-sm text-danger border-0 p-0"><i class="bi bi-trash"></i></button>
        </div>
        <div class="text-center py-5 d-none">
          <i class="bi bi-cart-x fs-1 text-muted"></i>
          <p class="mt-2">Your cart is empty</p>
        </div>
      </div>
      <div class="cart-footer">
        <div class="cart-summary-line"><span>Subtotal</span><span>₹195.00</span></div>
        <div class="cart-summary-line"><span>Tax (5%)</span><span>₹9.75</span></div>
        <div class="cart-total"><span>Total</span><span>₹204.75</span></div>
        <div class="cart-btns">
          <a href="cart.html" class="btn btn-outline-dark rounded-pill py-2">View Cart</a>
          <a href="checkout.html" class="btn btn-rust py-2">Checkout</a>
        </div>
      </div>
    </div>
    <!-- to do -->
  </header>
<main>