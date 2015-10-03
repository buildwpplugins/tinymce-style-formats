<?php 
/**
 * Plugin Name: TinyMCE Style Formats
 * Plugin URI:  http://wordpress.org/extend/plugins/health-check/
 * Description: Allows editors to create buttons using the TinyMCE formats menu.
 * Version:     0.1
 * Author:      Build WP Plugins
 * Author URI:  http://buildwpplugins.com 
 * Text Domain: bwpp-tsf
 */

if ( ! defined( 'BWPP_TSF_VERSION' ) ) {
	define('BWPP_TSF_VERSION', '0.1');
}

// Callback function to insert 'styleselect' into the $buttons array
function bwpp_tsf_mce_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	//var_dump($buttons);
	return $buttons;
}
// Register our callback to the appropriate filter
// _2 places the new button on the second line
add_filter('mce_buttons_2', 'bwpp_tsf_mce_buttons');


// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'bwpp_tsf_mce_before_init_insert_formats' ); 

// Callback function to filter the MCE settings
function bwpp_tsf_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => __( 'Button', 'bwpp-tsf' ),  
			'selector' => 'a',  
			'classes' => 'button',
			// font awesome must be available in the admin area to see the icon
			'icon'	   => ' fa fa-hand-pointer-o'
		),  
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
}

add_filter('mce_css', 'bwpp_tsf_register_editor_stylesheet');

function bwpp_tsf_register_editor_stylesheet( $mce_css ){
	if ( ! empty( $mce_css ) ) {
		$mce_css .= ',';
	}

	// bust cache with new version
	$mce_css .= plugins_url( 'assets/css/editor.css?ver=' . BWPP_TSF_VERSION , __FILE__ );

	return $mce_css;
}

add_action( 'admin_print_styles', 'bwpp_tsf_tinymce_icons_font_awesome' );

function bwpp_tsf_tinymce_icons_font_awesome(){ ?>
	<style type="text/css">
		.mce-ico.fa { font-family: tinymce, FontAwesome, Arial; }
	</style>
<?php 
}

// End File