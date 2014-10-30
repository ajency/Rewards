<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the body element.
 *
 * @package    Ajency
 * @subpackage skyi
 * @since      Skyi 0.1
 */
?>

<?php wp_footer(); ?>
<script>
    var AJAXURL = '<?php echo admin_url('admin-ajax.php') ?>';
    var SITEURL = '<?php echo site_url() ?>';
    var ROLES = <?php echo json_encode(get_all_roles()); ?>;
    var DATE  = <?php echo json_encode(get_date()); ?>;
    var UPLOADURL = '<?php echo admin_url('async-upload.php'); ?>';
    var _WPNONCE = '<?php echo wp_create_nonce('media-form'); ?>';
    
</script>
<?php if ( !is_development() ): ?>
    <script
        src="<?php echo get_template_directory_uri(); ?>/js/production/<?php echo get_current_page_slug() ?>-main-build.js?ver=<?php echo get_js_version() ?>"></script>
<?php else: ?>
    <script
        data-main="<?php echo get_template_directory_uri(); ?>/js/dev/js/pages/<?php echo get_current_page_slug() ?>-main"
        src="<?php echo get_template_directory_uri(); ?>/js/dev/js/plugins/require.js"></script>
<?php endif; ?>

</body>
</html>