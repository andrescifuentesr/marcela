<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package marcela
 */

//-------------------------------------------------  
//Register Socail Menu
//-------------------------------------------------
add_action( 'init', 'social_register_nav_menus' );

function social_register_nav_menus() {
	register_nav_menu( 'social', __( 'Social', 'example-textdomain' ) );
}


//-------------------------------------------------  
//function control Excerpt
//-------------------------------------------------

//Remove [...] string using Filters
function new_excerpt_more( $more ) {
	return '[...]<div class="read-more"><a href="'. get_permalink( get_the_ID() ) . '">Lire la suite</a></div>';
}
add_filter('excerpt_more', 'new_excerpt_more');

//Control Excerpt Length using Filters
function custom_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

//-------------------------------------------------  
//function custome Image
//-------------------------------------------------
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'imgGallery', 300, 300, true );
	add_image_size( 'imgPub', $width, 200, false );
	add_image_size( 'imgGalleryGrid', 500 , 500, true );
}


//======================
//fx menuicons styles
//======================
function add_menu_icons_styles(){
?>
 
<style>

#menu-posts-galerie .wp-menu-image:before {
	content: "\f306";
}
#menu-posts-reportage .wp-menu-image:before {
	content: "\f488";
}
#menu-posts-publication .wp-menu-image:before {
	content: "\f497";
}
#menu-posts-infos .wp-menu-image:before {
	content: "\f496";
}

</style>
 
<?php
}
add_action( 'admin_head', 'add_menu_icons_styles' );
