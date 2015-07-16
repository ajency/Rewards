<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Partner Template
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
            <h3> Step 1  <small>| Apartment Preference</small></h3>
          </div>
          <div class="col-4">
            <h3> Step 2  <small>| Your Contact Details</small></h3>
          </div>
          <div class="col-4">
            <h3> Step 3  <small>| Online or Cheque Payment</small></h3>
          </div>
        </div>

        <?php echo do_shortcode( '[skill number="15" char="%" caption="" color="#fff"]' ) ?>
      </div>
    </div>
    <form id="checkout" name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo site_url() ?>/application" enctype="multipart/form-data">

  <div class="container steps-container">

    <div class="row main-row">
      <div id="page-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
        <div class="accordion-group one open viewed">
      		<!-- <h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3> -->
      		<div class="acc-title">
      		    <h3>Step 1</h3>
      		</div>
      		<div class="acc-body">
      			<h4 class="step-intro">
      				Select your apartment preference from 1BHK, 2BHK and 2BHK compact to initiate the enrollment for the draw.
      			</h4>
      			<table class="shop_table woocommerce-checkout-review-order-table">
        <?php echo wc_get_template( "checkout/review-order.php", array( "checkout" => WC()->checkout() ) ) ?>
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
                Supply us with your contact details. We shall need them to communicate participation code and results.
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
        <div class="accordion-group three">
    			 <div class="acc-title">
                    <h3>Step 3</h3>
                </div>
                <div class="acc-body">
    				<div id="partner-form">
    					<!--<h3 id="order_review_heading"><?php _e( 'Payment', 'woocommerce' ); ?></h3>-->
    					<h4 class="step-intro">
    					Supply us with your contact detials and Payment details
    					</h4>

    				<?php some_custom_checkout_field($checkout); ?>
            <div id="order_review" class="woocommerce-checkout-review-order" >
              <?php do_action( 'woocommerce_checkout_paymen_options' ); ?>
            </div>


    				</div>
    			</div>
    		</div>
        <div class="form-row place-order">

            <input type="hidden" id="_wpnonce" name="_wpnonce" value="de36be6088"><input type="hidden" name="_wp_http_referer" value="/woocommerce2/wp-admin/admin-ajax.php">

            <input type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order">


</div>

    </div>
    <!-- END .row -->
  </div>
  <!-- END .container -->
</div>
</form>
<!-- END #main-content -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
