<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Thankyou Template
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

  <div>
    Thank you for your order  
  </div>

  </div>

<!-- END #main-content -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
