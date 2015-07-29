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
	global $product, $post, $woocommerce;
// $array = WC_Product_Variable::get_available_variations();

	do_action( 'woocommerce_review_order_before_cart_contents' );

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$prod = $cart_item['data']->post;
	  $variation = $cart_item['variation_id'];
		$product = new WC_Product($prod->ID);
		$_pf = new WC_Product_Factory();
		$new_product = $_pf->get_product($prod->ID);

		// if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
		// 	?>
		 <!--	<div class="hb-woo-product-details2 checkout">
		// 		<div class="hb-woo-main-link ">
		// 			<h2 class="hb-woo-title"><?php echo WC()->cart->get_item_data( $cart_item ); ?></h2>
		// 			<div><span class="price"><span class="amount"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></span></span> all inclusive*</div>
		// 		</div>
		// 	</div>-->
			<?php
		// }
	} 

	 if ( WC()->cart->get_cart_contents_count() == 0 ){

		$_pf = new WC_Product_Factory();
		$new_product = $_pf->get_product(29);


	}?>
	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
	<?php

			$variations = $new_product->get_available_variations();
			?>
			<form id="myForm"  class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>"  ?>
				<input type="hidden" id="variation_id" name="variation_id" value="<?php echo $variation;?>" />
				<input type="hidden" id="product_id" name="product_id" value="" />
					<input type="hidden" id="add-to-cart" name="add-to-cart" value="" />
						<input type="hidden" id="attribute_pa_unit_type" name="attribute_pa_unit_type" value="" />
							<div class="row">

			<?php
			foreach ($variations as $key => $value) {

			?>

				<?php
				if(!empty($value['attributes'])){
					foreach ($value['attributes'] as $attr_key => $attr_value) {
					?>
					<input type="hidden" id="attributepa_unit_type<?php echo $value['variation_id']?>" name="attributepa_unit_type<?php echo $value['variation_id']?>" value="<?php echo $attr_value?>">
					<?php
					}
				}
				?>



				<div class="hb-woo-product-details col-4">
					<button type="button" id="buy_button<?php echo $value['variation_id']?>" data-product="<?php echo $product->id; ?>" value="<?php echo $value['variation_id']?>" class="hb-woo-main-link-checkout hb-woo-main-link">
						<h2 class="hb-woo-title"><?php echo implode('/', $value['attributes']);?></h2>
						<div><?php echo $value['sku'];?> all inclusive*</div>
					</button>
				</div>




			<?php
			}
			?>
			</div>
<?php
	do_action( 'woocommerce_review_order_after_cart_contents' );
?>
