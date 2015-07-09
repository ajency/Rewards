<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

function hb_scripts_setup () {

	if(!is_admin()){
		$theme_path = get_template_directory_uri();

		wp_enqueue_script('jquery');
		
		// Include Scroll To
		wp_register_script( 'hb_scrollto', $theme_path . '/scripts/jquery.scrollTo.js', NULL, NULL, TRUE);
		wp_enqueue_script( 'hb_scrollto' );
		
		//Include jQuery Scripts
   		wp_register_script( 'hb_scripts', $theme_path . '/scripts/scripts.js', array('jquery'), NULL, TRUE); 
		wp_enqueue_script( 'hb_scripts' );

		// Include Google Map API 3
		if (!hb_is_maintenance()){			
			wp_register_script('hb_gmap', '//www.google.com/jsapi', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_gmap' );
		}

		//Include Google Map jQuery
		if (!hb_is_maintenance()){
	   		wp_register_script( 'hb_map', $theme_path . '/scripts/map.js', array('jquery', 'hb_gmap'), NULL, TRUE); 
			wp_enqueue_script( 'hb_map' );
		}

		//Include MediaElement
		if (!hb_is_maintenance()){
	   		wp_register_script( 'hb_mediaelement', $theme_path . '/scripts/mediaelement/mediaelement.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_mediaelement' );
		}

		// Include FlexSlider
		if (!hb_is_maintenance()){
			wp_register_script( 'hb_flexslider', $theme_path . '/scripts/jquery.flexslider.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_flexslider' );
		}

		// Include Validate
		if (!hb_is_maintenance()){
			wp_register_script( 'hb_validate', $theme_path . '/scripts/jquery.validate.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_validate' );
		}

		// Include Countdown
		wp_register_script( 'hb_countdown', $theme_path . '/scripts/jquery.countdown.js', NULL, NULL, TRUE);
		wp_enqueue_script( 'hb_countdown' );

		// Include EasyChart
		if (!hb_is_maintenance()){
			wp_register_script( 'hb_easychart', $theme_path . '/scripts/jquery.easychart.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_easychart' );
		}

		// Include Responsive Carousel
		if (!hb_is_maintenance()){
			wp_register_script( 'hb_carousel', $theme_path . '/scripts/responsivecarousel.min.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_carousel' );
		}
		
		// Include AutoComplete UI
		if (!hb_is_maintenance()){
			wp_enqueue_script( 'jquery-ui-autocomplete');
		}

		if ( !hb_is_maintenance() && vp_metabox('misc_settings.hb_onepage') ){
			wp_register_script( 'hb_nav', $theme_path . '/scripts/jquery.nav.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_nav' );
		}

		// Include Preloader
		if (hb_options('hb_queryloader') == 'ytube-like'){
			wp_register_script( 'hb_pace', $theme_path . '/scripts/jquery.pace.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_pace' );
		}

		// Include Fullpage
		if ( basename(get_page_template()) == 'page-presentation-fullwidth.php' ) {
			wp_register_script( 'hb_fullpage', $theme_path . '/scripts/jquery.fullpage.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_fullpage' );
		}

		//Include jQuery Custom
   		wp_register_script( 'hb_jquery_custom', $theme_path . '/scripts/jquery.custom.js', NULL, NULL, TRUE);
		wp_enqueue_script( 'hb_jquery_custom' );

		// Include Featured Section effect
		if ( vp_metabox('featured_section.hb_featured_section_effect') == 'hb-bokeh-effect' && !hb_is_maintenance() ){
			wp_register_script( 'hb_fs_effects', $theme_path . '/scripts/canvas-effects.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_fs_effects' );
		} else if ( vp_metabox('featured_section.hb_featured_section_effect') == 'hb-clines-effect' && !hb_is_maintenance() ) {
			wp_register_script( 'hb_cl_effects', $theme_path . '/scripts/canvas-lines.js', NULL, NULL, TRUE);
			wp_enqueue_script( 'hb_cl_effects' );
		}

		// Include Comment Reply Script
		if (!hb_is_maintenance() && comments_open()){
			wp_enqueue_script( "comment-reply" );
		}
	}
	
}
add_action('wp_enqueue_scripts', 'hb_scripts_setup');
?>