<?php
$output = $el_class = $bg_image = $fw_columns = $top_margin = $bottom_margin = $bg_color = $fw_same_height = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $bg_type = $video_mp4 = $video_webm = $video_poster = $video_texture = $section_id = $section_title = $image_url = $parallax = $waved_border_top = $waved_border_bottom = $bg_repeat = $background_color = $text_color = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'fullwidth'		  => '',
    'css' 			  => '',
    'bg_type' 		  => '',
    'video_mp4'		  => '',
    'video_webm'	  => '',
    'video_poster'	  => '',
    'video_texture'   => '',
    'section_id'	  => '',
    'section_title'	  => '',
    'image_url'	 	  => '',
    'parallax'	  	  => '',
    'waved_border_top'	  	  => '',
    'waved_border_bottom' 	  => '',
    'bg_repeat' 	  => '',
    'background_color'=> '',
    'border'		  => '',
    'fw_columns'	  => '',
    'fw_same_height'  => '',
    'top_margin'	  => '',
    'bottom_margin'   => '',
    'animation' => '',
	'animation_delay' => '',
), $atts));

wp_enqueue_script( 'wpb_composer_front_js' );

if ($animation_delay != ''){$animation_delay = ' data-delay="' . $animation_delay . '"';}
$el_class = $this->getExtraClass($el_class);
if ($animation != ''){$el_class .= ' hb-animate-element ' . $animation;}
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
$unique_class = uniqid('hb-fw-');
$img_to_print = $waved_border = $one_pager = $background_texture = "";

if ($border == 'yes'){
	$border = ' with-border';
} else {
	$border = ' without-border';		
}

if ($bg_repeat == 'repeat') {
	$background_texture = " background-texture";
}

if ($section_id != '' || $section_title != ''){
	$one_pager = " hb-one-page-section";
}

if ($fw_columns == 'yes'){
	$fw_columns = ' fw-columns';
}

if ($fw_same_height == 'yes'){
	$fw_columns .= ' hb-same-height';
}

$wave_color = $background_color;

if ($background_color != ''){
	$background_color = 'background-color:'.$background_color.';';
}

if ($image_url != ''){
	if( strpos($image_url, "http" ) !== false){
		// Image URL
	} else {
		// Image ID
		$image_url = wp_get_attachment_image_src($image_url, 'full');
		$image_url = $image_url[0];
	}
	
	$image_url = 'background-image:url('.$image_url.');';
	$img_to_print = $image_url;
}

if ($parallax == 'yes'){
	$parallax = " parallax";
	$img_to_print = "";
} else {
	$parallax = "";
}

if ($video_poster != ''){
	if( strpos($video_poster, "http" ) !== false){
		// Image URL
	} else {
		// Image ID
		$video_poster = wp_get_attachment_image_src($image_url, 'full');
		$video_poster = $video_poster[0];
	}
	$video_poster = ' poster="'.$video_poster.'"';
}

if ($video_webm != ''){
	if( strpos($video_webm, "http" ) !== false){
		// Video URL
		} else {
		// Video ID
		$video_webm = wp_get_attachment_url( $video_webm );
	}
	$video_webm = '<source src="' . $video_webm . '" type="video/webm">';
}

if ($video_texture != 'yes'){
	$video_texture = ' no-overlay';
} else {
	$video_texture = '';
}

if ($video_mp4 != ''){
	if( strpos($video_mp4, "http" ) !== false){
		// Video URL
	} else {
		// Video ID
		$video_mp4 = wp_get_attachment_url( $video_mp4 );
	}

	$video_mp4 = '
	<div class="video-wrap">
		<video class="hb-video-element"'.$video_poster.' autoplay loop="loop" muted="muted">
			<source src="'.$video_mp4.'" type="video/mp4">
			'.$video_webm.'
		</video>
		<div class="video-overlay'.$video_texture.'"></div>
	</div>';
}

if ($section_id != ''){
	$section_id = ' id="'.$section_id.'"';
}

if ($section_title != ''){
	$section_title = ' data-title="'.$section_title.'"';
}

if ($waved_border_top == "yes" || $waved_border_bottom == "yes"){
	$waved_border = " waved-border"; ?>

<style type="text/css">
	<?php
	if ( $waved_border_top == "yes" && $waved_border_bottom != "yes" ) {
		echo "." . $unique_class .":before";
	} else if ( $waved_border_top != "yes" && $waved_border_bottom == "yes" ){
		echo "." . $unique_class .":after";
	} else if ( $waved_border_top == "yes" && $waved_border_bottom == "yes" ) {
		echo "." . $unique_class .":before,";
		echo "." . $unique_class .":after";
	} ?>{background-image:url("data:image/svg+xml;utf8,<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 19 14' width='19' height='14' enable-background='new 0 0 19 14' xml:space='preserve' preserveAspectRatio='none slice'><g><path fill='<?php echo $wave_color; ?>' d='M0,0c4,0,6.5,5.9,9.5,5.9S15,0,19,0v7H0V0z'/><path fill='<?php echo $wave_color; ?>' d='M19,14c-4,0-6.5-5.9-9.5-5.9S4,14,0,14l0-7h19V14z'/></g></svg>")}
</style>

<?php }

if ($top_margin != ''){
	$top_margin = "margin-top:" . $top_margin . "px !important;";
}

if ($bottom_margin != ''){
	$bottom_margin = "margin-bottom:" . $bottom_margin . "px !important;";
}

if ( $fullwidth == 'yes' ){
	
	// Let's create our fullwidth section

	if ($bg_type == 'bg_video'){

		// Build video section
		$output .= '<div class="fw-section video-fw-section '.$unique_class.$fw_columns.$one_pager.$border.$background_texture.$video_texture.$waved_border.'" style="'.$background_color.$img_to_print.$bottom_margin.$top_margin.'"'.$section_title.$section_id.'>';
		$output .= '<div class="'.$css_class.' video-content"'.$style.$animation_delay.'>';

		$output .= wpb_js_remove_wpautop($content);

		$output .= '</div>';
		$output .= $video_mp4;
		$output .= '</div>';
	} else {

		if ($bg_type == 'solid_color'){
			$image="";
		}

		// Build image or color section
		$output .= '<div class="fw-section '.$unique_class.$fw_columns.$one_pager.$border.$background_texture.$video_texture.$waved_border.'" style="'.$background_color.$img_to_print.$bottom_margin.$top_margin.'"'.$section_title.$section_id.'>';
		$output .= '<div class="'.$css_class.' fw-content-wrap"'.$style.$animation_delay.'>';

		$output .= wpb_js_remove_wpautop($content);

		$output .= '</div>';
		$output .='<div class="video-overlay'.$video_texture.'"></div>';

		if ( $parallax != '' && $image_url != '' ){
			$output .= '<div class="hb-parallax-wrapper" style="'.$image_url.'"></div>';
		}

		$output .= '</div>'.$this->endBlockComment('row');
	}


}

else {

	// A regular row
	$output .= '<div class="'.$css_class.'"'.$style.$animation_delay.'>';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</div>'.$this->endBlockComment('row');
}

echo $output;