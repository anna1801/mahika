<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

  <div class="auth-wrapper d-flex align-items-center justify-content-center custom-style-26" id="login">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
          <div class="auth-card p-4 p-md-5 bg-white shadow-sm reveal custom-style-27" >
            <div class="text-center mb-4">
              <h2 class="mt-4 fw-bold custom-style-16" >Welcome Back</h2>
              <p class="text-muted small">Enter your credentials to access your account</p>
            </div>
            <form class="woocommerce-form woocommerce-form-login" method="post" novalidate>
              <?php do_action( 'woocommerce_login_form_start' ); ?>
              <div class="mb-3">
                <label class="form-label small fw-bold">Email Address</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                  <input type="text" class="form-control bg-light border-start-0 ps-0" placeholder="name@mail.com" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) && is_string( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required aria-required="true" />
                </div>
              </div>
              <div class="mb-3">
                <div class="d-flex justify-content-between">
                  <label class="form-label small fw-bold">Password</label>
                  <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="small text-rust text-decoration-none fw-bold">Forgot Password?</a>
                </div>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                  <input class="form-control bg-light border-start-0 ps-0" placeholder="••••••••" type="password" name="password" id="password" autocomplete="current-password" required aria-required="true" />
                </div>
              </div>
              <?php do_action( 'woocommerce_login_form' ); ?>
              <div class="mb-4 form-check">
                <input class="form-check-input" name="rememberme" type="checkbox" id="rememberMe" value="forever">
								<label class="form-check-label small" for="rememberMe">Remember Me</label>
              </div>
              <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
              <button type="submit" class="btn btn-rust w-100 py-2 fw-bold mb-3 shadow-sm custom-style-28 woocommerce-form-login__submit<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Login', 'woocommerce' ); ?></button>
              <?php do_action( 'woocommerce_login_form_end' ); ?>
              <div class="text-center">
                <p class="small text-muted">Don't have an account? <span id="go_register"> Register Now </span> </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="auth-wrapper d-flex align-items-center justify-content-center custom-style-26 hidden" id="registration">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
          <div class="auth-card p-4 p-md-5 bg-white shadow-sm reveal custom-style-27">
            <div class="text-center mb-4">
              <h2 class="mt-4 fw-bold custom-style-16" >Create Account</h2>
              <p class="text-muted small">Join us to experience authentic Telangana flavors</p>
            </div>
            <form method="post" class="woocommerce-form woocommerce-form-register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
              <?php do_action( 'woocommerce_register_form_start' ); ?>
              <div class="row g-3">
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold">Full Name</label>
                  <input type="text" class="form-control bg-light" name="full_name" id="reg_full_name" value="<?php echo ( ! empty( $_POST['full_name'] ) ) ? esc_attr( wp_unslash( $_POST['full_name'] ) ) : ''; ?>" required aria-required="true" placeholder="e.g. John Doe" />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold">Email Address</label>
                  <input type="email" class="form-control bg-light" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required aria-required="true" placeholder="name@mail.com" />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold">Mobile Number</label>
                  <input type="tel" class="form-control bg-light" name="phone_number" id="reg_phone_number" value="<?php echo ( ! empty( $_POST['phone_number'] ) ) ? esc_attr( wp_unslash( $_POST['phone_number'] ) ) : ''; ?>" required aria-required="true" placeholder="+91 91234 56789" />
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label small fw-bold">Password</label>
                  <input type="password" class="form-control bg-light" name="password" id="reg_password" autocomplete="new-password" required aria-required="true" placeholder="••••••••" />
                </div>
              </div>
              <?php do_action( 'woocommerce_register_form' ); ?>
              <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
              <button type="submit" class="btn btn-rust w-100 py-2 fw-bold mb-3 mt-4 shadow-sm custom-style-28 <?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register Now', 'woocommerce' ); ?></button>
              <?php do_action( 'woocommerce_register_form_end' ); ?>
              <div class="text-center">
                <p class="small text-muted">Already have an account? <span id="go_login"> Login Here</span></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>