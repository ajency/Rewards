<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
	<div class="accordion-group one open viewed">
		<!-- <h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3> -->
		<div class="acc-title">
		    <h3>Step 1</h3>
		</div>
		<div class="acc-body">
			<table class="shop_table woocommerce-checkout-review-order-table">
			</table>
			<div class="hb-aligncenter">
				<button type="button" name="customer_next" id="customer_next" class="hb-button hb-medium-button no-three-d" >Next</button>
			</div>
		</div>
	</div>
	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
		<div class="accordion-group two">
			<div class="acc-title">
			    <h3>Step 2</h3>
			</div>
			<div class="acc-body">
				<div class="col2-set" id="customer_details">
					<div>
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>
					<div class="clearfix"></div>
					<div class="hb-aligncenter">
						<button type="button" name="customer_back" id="customer_back" class="hb-button hb-medium-button no-three-d">Back</button>
						<button type="button" name="payment_next" id="payment_next" class="hb-button hb-medium-button no-three-d">Next</button>
					</div>
				</div>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		<div class="accordion-group three">
			 <div class="acc-title">
                <h3>Step 3</h3>
            </div>
            <div class="acc-body">
				<div id="payment_options">
					<h3 id="order_review_heading"><?php _e( 'Payment', 'woocommerce' ); ?></h3>

					<?php endif; ?>

					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order" >
						<?php do_action( 'woocommerce_checkout_paymen_options' ); ?>
					</div>	
				</div>
			</div>
		</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
