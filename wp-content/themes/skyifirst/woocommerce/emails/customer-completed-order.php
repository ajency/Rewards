<?php
/**
 * Customer completed order email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>

<p><?php printf( __( "Hi %s ", 'woocommerce' ),  $order->billing_first_name . ' ' . $order->billing_last_name ); ?></p>

<?php do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text ); ?>

<!-- <h2><?php printf( __( 'Order #%s', 'woocommerce' ), $order->get_order_number() ); ?></h2> -->
<?php	if($order->payment_method == 'cheque')
{
	?>
<p>Thank you for participating in the Freedom Draw.</p> 
<p>Your application has been registered in our database.</p>
<h4 style="color:#6F6C6C;">Here is your coupon code:</h4>
<div style="max-width:300px; margin:auto; background: #9A9A9A; color: #fff; border: 6px solid #CAC9C9; box-shadow: 0 0 2px rgba(0,0,0,0.2); font-size:20px; text-align: center; padding: 10px 0; word-wrap: break-word;">
<?php
	$coupon = get_post_meta($order->id, 'coupon' ,true);
 
 	echo $coupon 
 ;?>
</div>
<br/>
<p>The result of the draw will be declared on <b>19th August 2015</b>.</p>
	<?php
}
?>
<!-- <table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<thead>
		<tr>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( true, false, true ); ?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				foreach ( $totals as $total ) {
					$i++;
					?><tr>
						<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
						<td style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['value']; ?></td>
					</tr><?php
				}
			}
		?>
	</tfoot>
</table> -->

<!-- <?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text ); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text ); ?>

<?php do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text ); ?> -->

<?php do_action( 'woocommerce_email_footer' ); ?>
