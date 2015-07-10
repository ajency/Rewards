<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<?php
global $product, $post, $woocommerce;
		$variations = $product->get_available_variations();
		?>
		<form id="myForm" action="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>"  ?>
			<input type="hidden" id="variation_id" name="variation_id" value="" />
			<input type="hidden" id="product_id" name="product_id" value="" />
				<input type="hidden" id="add-to-cart" name="add-to-cart" value="" />
					<input type="hidden" id="attribute_pa_unit_type" name="attribute_pa_unit_type" value="" />

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



			<div class="hb-woo-product-details">
				<button type="submit" id="buy_button<?php echo $value['variation_id']?>" data-product="<?php echo $product->id; ?>" value="<?php echo $value['variation_id']?>" class="hb-woo-main-link">
					<h2 class="hb-woo-title"><?php echo implode('/', $value['attributes']);?></h2>
					<div><?php echo $value['price_html'];?> all inclusive*</div>
				</button>
			</div>

				<script>

				jQuery('.single_add_to_cart_button').on('click' , function(e){
				 e.preventDefault()
				 jQuery('#variation_id').val(jQuery(e.currentTarget).val());
				 jQuery('#product_id').val(jQuery(e.currentTarget).attr('data-product'));
				   jQuery('#add-to-cart').val(jQuery(e.currentTarget).attr('data-product'));

				   jQuery('#attribute_pa_unit_type').val(jQuery('#attributepa_unit_type'+jQuery(e.currentTarget).val()).val());
				 jQuery('form#myForm').submit();
				})


				</script>


		<?php
		}
		?>	</form>

<?php
