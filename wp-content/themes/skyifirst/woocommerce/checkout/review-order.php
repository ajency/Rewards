<?php
/**
 * Review order table
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>


<?php
	do_action( 'woocommerce_review_order_before_cart_contents' );

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			?>

			<div class="hb-woo-product-details2 checkout">
				<div class="hb-woo-main-link ">
					<h2 class="hb-woo-title"><?php echo WC()->cart->get_item_data( $cart_item ); ?></h2>
					<div><span class="price"><span class="amount"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></span></span> all inclusive*</div>
				</div>
			</div>

			<?php
		}
	}

	do_action( 'woocommerce_review_order_after_cart_contents' );
?>

