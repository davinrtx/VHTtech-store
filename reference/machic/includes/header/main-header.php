<?php

/*************************************************
## Main Header Function
*************************************************/

add_action('machic_main_header','machic_main_header_function',10);

if ( ! function_exists( 'machic_main_header_function' ) ) {
	function machic_main_header_function(){

		if(machic_page_settings('page_header_type') == 'type4') {
			
			get_template_part( 'includes/header/header-type4' );
		
		}elseif(machic_page_settings('page_header_type') == 'type3') {
			
			get_template_part( 'includes/header/header-type3' );
			
		}elseif(machic_page_settings('page_header_type') == 'type2') {
			
			get_template_part( 'includes/header/header-type2' );
			
		} elseif(machic_page_settings('page_header_type') == 'type1') {
			
			get_template_part( 'includes/header/header-type1' );
			
		} elseif(get_theme_mod('machic_header_type') == 'type4'){
			
			get_template_part( 'includes/header/header-type4' );
			
		} elseif(get_theme_mod('machic_header_type') == 'type3'){
			
			get_template_part( 'includes/header/header-type3' );
			
		} elseif(get_theme_mod('machic_header_type') == 'type1'){
			
			get_template_part( 'includes/header/header-type1' );
			
		} else {
			
			get_template_part( 'includes/header/header-type2' );
			
		}
		
	}
}



?>
