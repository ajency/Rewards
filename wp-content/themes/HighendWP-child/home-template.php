<?php
/*
    Template Name: home Template
*/

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?> xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?> xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<!--<![endif]-->
<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
      <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/images/favicon.png">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/css/theme.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/css/animate.min.css">
   <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/css/jquery-ui.min.css">
   <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/xoomaapp/css/jquery.ui.timepicker.css">

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>




</head>
<body class="gradient">

<?php echo do_shortcode('[product_page id="8"]'); ?>

<?php wp_footer(); ?>
</body>

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
</html>
