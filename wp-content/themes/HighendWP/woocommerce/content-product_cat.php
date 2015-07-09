<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

if ( is_product_tag() || is_product_category() )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', hb_options('hb_woo_product_columns') );

// Increase loop count
$woocommerce_loop['loop']++;
?>
<li class="product-category hb-woo-product col-<?php echo 12 / $woocommerce_loop['columns'] ?>">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

		<?php
			$small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
			$dimensions    			= wc_get_image_size( $small_thumbnail_size );
			$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
			$shop_catalog			= wc_get_image_size( 'shop_catalog' );


			if ( $thumbnail_id ) {
				$image = hb_resize ( $thumbnail_id, '', $shop_catalog['width'], $shop_catalog['height'], true);
			} else {
				$image = wc_placeholder_img_src();
			}


			if ( $image ) {
				if ( isset($image["url"]) ){
					$image=$image["url"];
				}
				$image = str_replace( ' ', '%20', $image );

				echo '<a href="'. get_term_link( $category->slug, 'product_cat' ) . '" class="woo-category-wrap"><img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $shop_catalog['width'] ) . '" height="' . esc_attr( $shop_catalog['height'] ) . '" />';
			}
		?>

		<div class="woo-cat-details">
		<h6 class="special">
			<?php
				echo $category->name;
			?>
		</h6>
		<?php if ( $category->count > 0 ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">' . $category->count . ' '. __("products", "woocommerce") . '</span>', $category );
		}
		?>
		</div>
		<?php if ( $image ) { ?> </a> <?php } ?>


		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>

	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</li>