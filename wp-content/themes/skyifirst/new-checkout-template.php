<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: New Checkout Template
*/
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
<?php
if ( ! defined( 'WOOCOMMERCE_CHECKOUT' ) ) {
    define( 'WOOCOMMERCE_CHECKOUT', true );
}
$main_content_style = "";
if ( vp_metabox('background_settings.hb_content_background_color') )
  $main_content_style = ' style="background-color: ' . vp_metabox('background_settings.hb_content_background_color') . ';"';
?>
  <!-- BEGIN #main-content -->
<div id="main-content"<?php echo $main_content_style; ?>>
  <div class="fixed-header">
    <div class="container">
      <h1>Freedom Draw Application</h1>
      <div class="row progress-section">
        <div class="col-4">
          <h3> Step 1  <small>| Client's Apartment Preference</small></h3>
        </div>
        <div class="col-4">
          <h3> Step 2  <small>| Client's Contact Details</small></h3>
        </div>
        <div class="col-4">
          <h3> Step 3  <small>| Partner and Payment Details</small></h3>
        </div>
      </div>

      <?php echo do_shortcode( '[skill number="15" char="%" caption="" color="#fff"]' ) ?>
    </div>
  </div>

  <div class="container steps-container">
<?php
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
// print_r($cart_item);
$unit_type = strtoupper($cart_item['variation']['unit_type']);
$attribute_pa_unit_type = strtoupper($cart_item['variation']['attribute_pa_unit_type']);
}
?>
    <div class="row main-row">
      <div id="page-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
        <div class="woocommerce">
          <form id="checkout" name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo site_url() ?>/checkout" enctype="multipart/form-data">
            <div class="accordion-group one open viewed">
          		<!-- <h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3> -->
          		<div class="acc-title">
          		    <h3>Step 1</h3>
                   <h4 class="unit_type"><?php echo $unit_type;echo $attribute_pa_unit_type;?></h4>
                    <div class="clearfix"></div>
          		</div>
          		<div class="acc-body">
          			<h4 class="step-intro">
          				Select apartment preference from 1BHK, 2BHK and 2BHK compact.
          			</h4>
          			<table class="shop_table woocommerce-checkout-review-order-table">
                           			</table>
          			<div class="hb-aligncenter">
          				<button type="button" name="customer_next" id="customer_next" class="hb-button hb-belize-hole hb-medium-button no-three-d" >Next <span class="icon-chevron-right"></span></button>
          			</div>
          		</div>
          	</div>
            <div class="accordion-group two">
              <div class="acc-title">
                  <h3>Step 2</h3>
              </div>
              <div class="acc-body">
                <div class="col2-set" id="customer_details">
                  <h4 class="step-intro">
                    Supply us with client's contact details. We shall need them to communicate participation code and results.
                  </h4>
                  <div>
                      <?php echo $woocommerce->checkout->checkout_form_billing()?>
                  </div>
                  <div class="clearfix"></div>
                  <br />
                  <div class="hb-aligncenter">
                    <button type="button" name="customer_back" id="customer_back" class="hb-button hb-belize-hole hb-medium-button no-three-d"><span class="icon-chevron-left"></span> Back</button>
                    <button type="button" name="payment_next" id="payment_next" class="hb-button hb-belize-hole hb-medium-button no-three-d">Next <span class="icon-chevron-right"></span></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="accordion-group three ">
        			<div class="acc-title">
                <h3>Step 3</h3>
              </div>
              <div class="acc-body">
        				<div id="partner-form">
        					<!--<h3 id="order_review_heading"><?php _e( 'Payment', 'woocommerce' ); ?></h3>-->
        					<h4 class="step-intro">
        					 Supply us with your contact details and Payment details.
        					</h4>

          				<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $price = get_post_meta($cart_item['product_id'] , '_price', true);

                };?>
                <h4 class="paymnt-amnt">
                  Amount to be paid : <span  class="amount"> <b><?php echo $price ; ?></b></span>
                </h4>
               
                  <div id="order_review" class="woocommerce-checkout-review-order" >
                    <?php woocommerce_checkout_payment(); ?>
                    
                  </div>
                  
        				</div>

              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- END .row -->
    </div>
  <!-- END .container -->

</div>
</div>
<!-- END #main-content -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
