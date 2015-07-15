<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
/*
Template Name: Checkout Template
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

        <?php echo do_shortcode( '[skill number="15" char="%" caption="" color="#16A085"]' ) ?>
      </div>
    </div>

  <div class="container steps-container">

    <div class="row main-row">
      <div id="page-<?php the_ID(); ?>" <?php post_class('col-12'); ?>>
        <?php the_content(); ?>
      </div>
    </div>
    <!-- END .row -->
  </div>
  <!-- END .container -->
</div>
<!-- END #main-content -->

<?php endwhile; endif; ?>

<?php get_footer(); ?>
