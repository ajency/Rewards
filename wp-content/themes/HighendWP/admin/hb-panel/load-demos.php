<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php wp_enqueue_script( 'hb-demo-scripts', HBTHEMES_ADMIN_URI . '/assets/js/demo-scripts.js', array( 'jquery' ), false, true ); ?>

<?php

function hb_num($size){
    $let = substr($size, -1);
    $ret = substr($size, 0, -1);
    switch (strtoupper($let)) {
        case 'P':
            $ret *= 1024;
        case 'T':
            $ret *= 1024;
        case 'G':
            $ret *= 1024;
        case 'M':
            $ret *= 1024;
        case 'K':
            $ret *= 1024;
    }
    return $ret;
}

$max_execution_time  = ini_get("max_execution_time");
$max_input_time      = ini_get("max_input_time");
$memory_limit        = ini_get("memory_limit");
$upload_max_filesize = ini_get("upload_max_filesize");
?>

<div class="wrap about-wrap hb-alt-wrap">
	<h2><?php _e('Import Demo Templates', 'hbthemes'); ?></h2>
	<div class="hb-badge"></div>
	<p class="about-p"><?php _e('Choose demo template to import:', 'hbthemes'); ?></p>
	<input type="hidden" id="hb_nonce" value="<?php echo wp_create_nonce('vafpress'); ?>" />
</div>


<?php if ( $max_execution_time < 400 || $max_input_time < 300 || hb_num(WP_MEMORY_LIMIT) < 67108864 || hb_num($upload_max_filesize) < 10485760 ) { ?>
	<div class="hb-msg hb-error visible">
    <p><strong><?php _e('In case you are having issues with demo imports, please increase these limits:', 'hbthemes'); ?></strong></p>
    
	<ol>
    <?php if ($max_execution_time < 400) {
        echo '<li><strong>Maximum Execution Time (max_execution_time) : </strong>' . $max_execution_time . ' seconds. <span style="color:red"> Recommended max_execution_time should be at least 400 Seconds.</span></li>';
    }
    if ($max_input_time < 300)
        echo '<li><strong>Maximum Input Time (max_input_time) : </strong>' . $max_input_time . ' seconds. <span style="color:red"> max_input_time should be at least 300 Seconds.</span></li>';
    if (hb_num(WP_MEMORY_LIMIT) < 67108864) {
        echo '<li><strong>WordPress Memory Limit (WP_MEMORY_LIMIT) : </strong>' . WP_MEMORY_LIMIT . ' <span style="color:red"> memory limit should be at least 64MB. Please refer to : <a target="_blank" href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP">Increasing memory allocated to PHP</a> for more information</span></li>';
    }
    if (hb_num($upload_max_filesize) < 10485760) {
        echo '<li><strong>Maximum Upload File Size (upload_max_filesize) : </strong>' . $upload_max_filesize . ' <span style="color:red"> Maximum Upload Filesize should be at least 10MB.</li>';
    } ?>
    </ol>
    <p>If you are not familiar with this, please contact your hosting company support.</p>
    </div>
<?php } ?>
<div class="import-message"></div>

<div class="hb-templates">
	<div class="hb-row clearfix">
		
		<div class="hb-col-3">
			<img src="<?php echo HBTHEMES_URI; ?>/admin/assets/images/theme-files/preview-main.jpg" alt="thumb" />
			<div class="bottom-part">
				<div class="hb-title">Highend Main Demo</div>
				<div class="hb-desc"><?php _e('Full featured demo with 110+ pages.','hbthemes'); ?></div>
                <div class="hb-desc hb-import-options">
                    <div class="checkbox-element"><input type="checkbox" checked name="content" value="content" /> <label for="content" class="checkbox-title">Content</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="sliders" value="sliders" /> <label for="sliders"  class="checkbox-title">Sliders</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="widgets" value="widgets" /> <label for="widgets"  class="checkbox-title">Widgets</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="media" value="media" /> <label for="media"  class="checkbox-title">Attachments</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="highend_options" value="highend_options" /> <label for="highend_options"  class="checkbox-title">Theme Options</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="essential_grid" value="essential_grid" /> <label for="media"  class="checkbox-title">Essential Grid</label></div>
                </div>
				<div class="hb-button-holder"><a href="#" data-demo-id="main-demo" data-demo-name="Highend Main Demo" class="hb-import-template button-primary"><?php _e('Import', 'hbthemes'); ?></a><a href="http://hb-themes.com/themes/highend_wp/" target="_blank" class="button"><?php _e('Live Preview','hbthemes'); ?></a></div>
			</div>
		</div>

        <div class="hb-col-3">
            <img src="<?php echo HBTHEMES_URI; ?>/admin/assets/images/theme-files/preview-photography.jpg" alt="thumb" />
            <div class="bottom-part">
                <div class="hb-title">Photography</div>
                <div class="hb-desc"><?php _e('Beautiful demo for all creative folks.','hbthemes'); ?></div>
                <div class="hb-desc hb-import-options">
                    <div class="checkbox-element"><input type="checkbox" checked name="content" value="content" /> <label for="content" class="checkbox-title">Content</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="sliders" value="sliders" /> <label for="sliders"  class="checkbox-title">Sliders</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="widgets" value="widgets" /> <label for="widgets"  class="checkbox-title">Widgets</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="media" value="media" /> <label for="media"  class="checkbox-title">Attachments</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="highend_options" value="highend_options" /> <label for="highend_options"  class="checkbox-title">Theme Options</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="essential_grid" value="essential_grid" /> <label for="media"  class="checkbox-title">Essential Grid</label></div>
                </div>
                <div class="hb-button-holder"><a href="#" data-demo-id="photography" data-demo-name="Photography" class="hb-import-template button-primary"><?php _e('Import', 'hbthemes'); ?></a><a href="http://hb-themes.com/themes/highend/photography" target="_blank" class="button"><?php _e('Live Preview','hbthemes'); ?></a></div>
            </div>
        </div>

        <div class="hb-col-3">
            <img src="<?php echo HBTHEMES_URI; ?>/admin/assets/images/theme-files/preview-presentation.jpg" alt="thumb" />
            <div class="bottom-part">
                <div class="hb-title">Presentation</div>
                <div class="hb-desc"><?php _e('A creative way to present your business.','hbthemes'); ?></div>
                <div class="hb-desc hb-import-options">
                    <div class="checkbox-element"><input type="checkbox" checked name="content" value="content" /> <label for="content" class="checkbox-title">Content</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="sliders" value="sliders" /> <label for="sliders"  class="checkbox-title">Sliders</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="widgets" value="widgets" /> <label for="widgets"  class="checkbox-title">Widgets</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="media" value="media" /> <label for="media"  class="checkbox-title">Attachments</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="highend_options" value="highend_options" /> <label for="highend_options"  class="checkbox-title">Theme Options</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="essential_grid" value="essential_grid" /> <label for="media"  class="checkbox-title">Essential Grid</label></div>
                </div>
                <div class="hb-button-holder"><a href="#" data-demo-id="presentation" data-demo-name="Presentation" class="hb-import-template button-primary"><?php _e('Import', 'hbthemes'); ?></a><a href="http://hb-themes.com/themes/highend/presentation" class="button" target="_blank"><?php _e('Live Preview','hbthemes'); ?></a></div>
            </div>
        </div>

        <div class="hb-col-3">
            <img src="<?php echo HBTHEMES_URI; ?>/admin/assets/images/theme-files/preview-sblog.jpg" alt="thumb" />
            <div class="bottom-part">
                <div class="hb-title">Simple Blog</div>
                <div class="hb-desc"><?php _e('An old classic blog with a modern touch.','hbthemes'); ?></div>
                <div class="hb-desc hb-import-options">
                    <div class="checkbox-element"><input type="checkbox" checked name="content" value="content" /> <label for="content" class="checkbox-title">Content</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="sliders" value="sliders" /> <label for="sliders"  class="checkbox-title">Sliders</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="widgets" value="widgets" /> <label for="widgets"  class="checkbox-title">Widgets</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="media" value="media" /> <label for="media"  class="checkbox-title">Attachments</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="highend_options" value="highend_options" /> <label for="highend_options"  class="checkbox-title">Theme Options</label></div>
                    <div class="checkbox-element"><input type="checkbox" checked name="essential_grid" value="essential_grid" /> <label for="media"  class="checkbox-title">Essential Grid</label></div>
                </div>
                <div class="hb-button-holder"><a href="#" data-demo-id="simple-blog" data-demo-name="Simple Blog" class="hb-import-template button-primary"><?php _e('Import', 'hbthemes'); ?></a><a href="http://hb-themes.com/themes/highend/simple-blog" class="button" target="_blank"><?php _e('Live Preview','hbthemes'); ?></a></div>
            </div>
        </div>

		<div class="hb-col-3">
			<img src="<?php echo HBTHEMES_URI; ?>/admin/assets/images/theme-files/preview-soon.jpg" alt="thumb" />
			<div class="bottom-part">
				<div class="hb-title">Coming Soon</div>
				<div class="hb-desc"><?php _e('New templates are released with each theme update.','hbthemes'); ?></div>
                <div class="hb-space"></div>
			</div>
		</div>

	</div>
</div>
