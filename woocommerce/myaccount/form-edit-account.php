<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );
?>

<div class="bg-white p-4 p-md-5 shadow-sm rounded-20">
  <h4 class="fw-bold mb-4">Account Details</h4>

  <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
    <?php do_action( 'woocommerce_edit_account_form_start' ); ?>
    <div class="row g-3">
      <div class="col-md-6 mb-3">
        <label class="form-label small fw-bold">First Name</label>
        <input type="text" class="form-control" placeholder="First Name" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" aria-required="true" />
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label small fw-bold">Last Name</label>
        <input type="text" class="form-control" placeholder="Last Name" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" aria-required="true" />
      </div>

      <div class="col-12 mb-3">
        <label class="form-label small fw-bold">Display Name</label>
        <input type="text" class="form-control" placeholder="Display Name" name="account_display_name" id="account_display_name" aria-describedby="account_display_name_description" value="<?php echo esc_attr( $user->display_name ); ?>" aria-required="true" /> <span id="account_display_name_description"><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
      </div>

      <div class="col-12 mb-4">
        <label class="form-label small fw-bold">Email</label>
        <input type="email" class="form-control" placeholder="Email Address" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" aria-required="true" />
      </div>
      <?php do_action( 'woocommerce_edit_account_form_fields' ); ?>
      <h6 class="fw-bold mt-3">Password Change</h6>
      <div class="col-12 mb-3">
        <input type="password" class="form-control" placeholder="Current Password (leave blank to leave unchanged)" name="password_current" id="password_current" autocomplete="current-password" />
      </div>
      <div class="col-12 mb-3">
        <input type="password" class="form-control" placeholder="New Password (leave blank to leave unchanged)" name="password_1" id="password_1" autocomplete="new-password" />
      </div>
      <div class="col-12 mb-3">
        <input type="password" class="form-control" placeholder="Confirm Password (leave blank to leave unchanged)" name="password_2" id="password_2" autocomplete="new-password" />
      </div>

      <?php do_action( 'woocommerce_edit_account_form' ); ?>
      <div class="col-12 mt-4">
        <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
				<button type="submit" class="btn btn-rust px-5 py-2 rounded-pill fw-bold" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
				<input type="hidden" name="action" value="save_account_details" />
      </div>
      <?php do_action( 'woocommerce_edit_account_form_end' ); ?>

    </div>
  </form>
</div>
<?php do_action( 'woocommerce_after_edit_account_form' ); ?>