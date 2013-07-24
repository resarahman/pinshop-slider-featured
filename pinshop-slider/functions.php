<?php
/**
 * Hooks Action
 */
add_action( 'themify_layout_before', 'child_theme_layout_before', 20 );

/**
 * Include product slider 2
 * @since 1.2.8
 */
function child_theme_layout_before() {
	if(is_front_page() && !is_paged()){ themify_get_ecommerce_template( 'includes/product-slider-2'); }
}

function child_theme_second_slider($themify_theme_config){
	$themify_theme_config['panel']['settings']['tab']['shop_settings']['custom-module'][0] = array(
		'title' => __('Product Slider Featured 2', 'themify'),
		'function' => 'themify_second_slider'
	);
	return $themify_theme_config;
}
add_filter('themify_theme_config_setup', 'child_theme_second_slider', 99999999999999);

if(!function_exists('themify_second_slider')){
	/**
	 * Creates module with settings for product slider
	 * @param array
	 * @return string
	 * @since 1.0.0
	 */
	function themify_second_slider($data=array()){
		$data = themify_get_data();
		$prefix = 'setting-product_slider_2_';
		
		/** Slider values @var array */
		$slider_ops = array( __('On', 'themify') => 'on', __('Off', 'themify') => 'off' );
		/** Slider status */
		if('' == $data[$prefix.'enabled'] || 'on' == $data[$prefix.'enabled']){
			$enabled_checked = "selected='selected'";
		} else {
			$enabled_display = "style='display:none;'";	
		}
		if($data[$prefix.'visible'] == "" ||!isset($data[$prefix.'visible'])){
			$data[$prefix.'visible'] = "4";	
		}
		
		$show_options = array('' => '',__('Yes', 'themify') => 'yes', __('No', 'themify') => 'no');
		$auto_options = array(0,1,2,3,4,5,6,7);
		$scroll_options = array(1,2,3,4,5,6,7);
		$speed_options = array( __('Fast', 'themify')=>300, __('Normal', 'themify')=>1000, __('Slow', 'themify')=>2000);
		$wrap_options = array('' => '',__('Yes', 'themify') => 'yes', __('No', 'themify') => 'no');
		$image_options = array("one","two","three","four","five","six","seven","eight","nine","ten");
		
		$output .= '<p><span class="label">' . __('Enable Slider', 'themify') . '</span> <select name="'.$prefix.'enabled" class="feature_box_enabled_check">';
		/** Iterate through slider options */
		foreach ($slider_ops as $key => $val) {
			$output .= '<option value="'.$val.'" ' . selected($data[$prefix.'enabled'], $val, false) . '>' . $key . '</option>';
		}
		$output .= '</select>' . '</p>

					<div class="feature_box_enabled_display" '.$enabled_display.'>
					<p class="pushlabel feature_box_posts">';
						$output .= wp_dropdown_categories(
							array("show_option_all"=> __('Featured Products', 'themify'),
							"show_option_all"=> __('Featured Products', 'themify'),
							"hide_empty"=>0,
							"echo"=>0,
							"name"=>$prefix."posts_category",
							'selected' => $data[$prefix.'posts_category'],
							'taxonomy' => 'product_cat'
						));
		$output .=	'<br/><input type="text" name="'.$prefix.'posts_slides" value="'.$data[$prefix.'posts_slides'].'" class="width2" /> ' . __('number of products to be queried', 'themify') . ' 
					</p>';
					
		$output .= '<p class="feature_box_posts">
						<span class="label">' . __('Hide Title', 'themify') . '</span>
						<select name="'.$prefix.'hide_title">';
						foreach($show_options as $name => $option){
								if($option == $data[$prefix.'hide_title']){
									$output .= '<option value="'.$option.'" selected="selected">'.$name.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$name.'</option>';
								}
							}
		$output .= '	</select>
					</p>';

		$output .= '<p class="feature_box_posts">
						<span class="label">' . __('Hide Price', 'themify') . '</span>
						<select name="'.$prefix.'hide_price">';
						foreach($show_options as $name => $option){
								if($option == $data[$prefix.'hide_price']){
									$output .= '<option value="'.$option.'" selected="selected">'.$name.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$name.'</option>';
								}
							}
		$output .= '	</select>
					</p>';	
					
		/*	
		$output .= '<p>
						<span class="label">' . __('Visible', 'themify') . '</span> 
						<select name="'.$prefix.'visible">';
						for($x = 1; $x <= apply_filters('themify_product_slider_visible', 7); $x++){
							if($data[$prefix.'visible'] == $x){
								$output .= '<option value="'.$x.'" selected="selected">'.$x.'</option>';	
							} else {
								$output .= '<option value="'.$x.'">'.$x.'</option>';	
							}
						}
			$output .=	'</select> <small>' . __('(# of slides visible at the same time)', 'themify') . '</small>
					</p>
					<p>
					<span class="label">' . __('Auto Play', 'themify') . '</span>
								<select name="'.$prefix.'auto">
								';
							foreach($auto_options as $option){
								if($option == $data[$prefix.'auto']){
									$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$option.'</option>';
								}
							}		
			$output .= '
						</select> <small>' . __('(auto advance slider, 0 = off)', 'themify') . '</small>
					</p>
					<p>
					<span class="label">' . __('Scroll', 'themify') . '</span>
								<select name="'.$prefix.'scroll">
								';
							foreach($scroll_options as $option){
								if($option == $data[$prefix.'scroll']){
									$output .= '<option value="'.$option.'" selected="selected">'.$option.'</option>';
								} else {
									$output .= '<option value="'.$option.'">'.$option.'</option>';
								}
							}		
			$output .= '
						</select>
					</p>
					<p>
						<span class="label">' . __('Speed', 'themify') . '</span> 
						<select name="'.$prefix.'speed">';
						foreach($speed_options as $name => $val){
							if($data[$prefix.'speed'] == $val){
								$output .= '<option value="'.$val.'" selected="selected">'.$name.'</option>';	
							} else {
								$output .= '<option value="'.$val.'">'.$name.'</option>';	
							}	
						}
			$output .= '</select>
					</p>
					<p>
						<span class="label">' . __('Wrap Slides', 'themify') . '</span> 
						<select name="'.$prefix.'wrap">';
						foreach($wrap_options as $name => $value){
								if($data[$prefix.'wrap'] == $value){
									$output .= '<option value="'.$value.'" selected="selected">'.$name.'</option>';	
								} else {
									$output .= '<option value="'.$value.'">'.$name.'</option>';	
								}
							}
			$output .=	'</select>
					</p>				
					</div>';*/		
		return $output;
	}
}
?>