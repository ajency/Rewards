<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: winners Template
*/
?>
<?php get_header(); ?>
<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>
<?php

$main_content_style = "";
if ( vp_metabox('background_settings.hb_content_background_color') )
  $main_content_style = ' style="background-color: ' . vp_metabox('background_settings.hb_content_background_color') . ';"';
?>
  <!-- BEGIN #main-content -->
<div id="main-content"<?php echo $main_content_style; ?>>
  <!-- <div class="fixed-header">
    <div class="container">
      <h1>Freedom First Draw Winners</h1>
      

      </div>
  </div> -->

  <div class="container steps-container">

    <div class="row main-row">
      <div id="page-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
        <div class="woocommerce">
          <?php
    $_pf = new WC_Product_Factory();
    $new_product = $_pf->get_product(269);
    $variations = $new_product->get_available_variations();

    ?>
    <div class="winners row">
        <h3>Winners List</h3>
    <?php
    foreach ($variations as $key => $value) {

    ?>
    <div class="coupon-table">
        <h4>Winners - <span style="color: #4269B7;"><?php echo strtoupper(implode('/', $value['attributes']));?></span></h4>
    <table cellspacing="6" cellpadding="4" style="width:100%">
        
           
            
            <?php  
            $pool_val = get_option('pool_'.strtoupper(implode('/', $value['attributes'])));
            $pool = strtoupper(implode('/', $value['attributes']));
            if($pool_val)
            {
                
                 $pool_list = maybe_unserialize(get_option('coupons_'.$pool.'_1'));
                 if(count($pool_list)>0){
                    ?>
                <tr><th>Coupon</th></tr>
                <?php
                 foreach ($pool_list as $key => $value) {
                    $order = new WC_Order($value['id']);
                    $billing_first_name = $order->billing_first_name;
                    $billing_last_name = $order->billing_last_name;
                    $billing_email = $order->billing_email;
                    $url = get_edit_post_link($value['id']);
                   
                    ?>
                        <tr><td><?php echo $value['coupon'];?></td></tr>

                    <?php
                     # code...
                 }
             }
             else
             {
                ?>
                 <tr><td><b>No data found</b></td></tr>
                 <?php
             }
            }
           else
             {
                ?>
                 <tr><td><b>No data found</b></td></tr>
                 <?php
             }

        
            ?>

    </table>
    </div>
    <?php



    }

     ?>
    </div>
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
