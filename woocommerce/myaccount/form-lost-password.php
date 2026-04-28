<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );

if ( function_exists( 'woocommerce_output_all_notices' ) ) {
    woocommerce_output_all_notices();
}
?>

<div class="auth-wrapper d-flex align-items-center justify-content-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5 col-lg-4">
        <div class="auth-card p-4 p-md-5 bg-white shadow-sm reveal custom-style-27">
          <div class="text-center mb-4">
            <h2 class="mt-4 fw-bold custom-style-16" >Reset Password</h2>
            <p class="text-muted small">Enter your username or email to get reset instructions</p>
          </div>

          <form method="post" class="woocommerce-ResetPassword lost_reset_password">
            <section class="mb-4 reveal">
              <label class="form-label small fw-bold">Username or Email Address</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                <input class="form-control bg-light border-start-0 ps-0" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="Email or Username" required aria-required="true" required />
              </div>
            </section>
            
            <?php do_action( 'woocommerce_lostpassword_form' ); ?>

            <input type="hidden" name="wc_reset_password" value="true" />
            <button type="submit" class="btn btn-rust w-100 py-2 fw-bold mb-3 shadow-sm custom-style-28" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Submit', 'woocommerce' ); ?></button>

            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

            <div class="text-center">
              <p class="small text-muted"><a href="<?php echo wc_get_page_permalink( 'myaccount' ); ?>" class="text-rust text-decoration-none fw-bold"><i class="bi bi-arrow-left me-1"></i>Back to Login</a></p>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php do_action( 'woocommerce_after_lost_password_form' ); ?>