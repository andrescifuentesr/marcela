<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package marcela
 */


/**
 * Register Socail Menu
 */
// add_action( 'init', 'social_register_nav_menus' );

// function social_register_nav_menus() {
// 	register_nav_menu( 'social', __( 'Social', 'loulou' ) );
// }

// //-------------------------------------------------  
// //function shortcode
// //-------------------------------------------------
// function google_maps_shortcode( $atts ) {
// 	return '
// 		<div class="map-wrapper">
// 			<div id="map_canvas"></div>
// 		</div>';
// }
// add_shortcode( 'google_maps', 'google_maps_shortcode' );


//-------------------------------------------------  
//function custome Image
//-------------------------------------------------
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'imgGallery', $width, 300, false );
	add_image_size( 'imgGalleryGrid', 500 , 500, true );
	add_image_size( 'imgBlog', 1400, 300, true );
}
