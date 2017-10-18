<?php
/**
 * This is the front page for RacquetGrid.
 * @author: marybaum
 * Date: 10/7/17
 * @package Customizations
 * @subpackage Home
 *
 */

//* racquetgrid custom body class
function rg_add_body_class( $classes ) {
	$classes[] = 'rg';
	return $classes;
}

//* Add widget support for homepage
add_action( 'genesis_meta' , 'rg_front_page_genesis_meta');
function rg_front_page_genesis_meta() {

	if( is_home() )  {

		//* Force full-width content layout
		add_filter( 'genesis_pre_get_option_site_layout' , '__genesis_return_full_width_content' );

		//* Remove Genesis loop
		remove_action( 'genesis_loop' , 'genesis_do_loop' );

		//* Are there active widgets?
		if( is_active_sidebar( 'homegrid1' ) || is_active_sidebar( 'homegrid2' ) || is_active_sidebar( 'homegrid3' ) || is_active_sidebar( 'homegrid4' ) ) {

			//* Add Home featured widget areas.
			add_action( 'genesis_before_content_sidebar_wrap' , 'rg_home_featured', 15 );

		}

	}

//* Add home-widgets markup
function rg_home_featured() {

	genesis_widget_area( 'homegrid1' , array(
		'before' => '<div class="homegrid1 widget-area">',
		'after' => '</div>',
	) );

	genesis_widget_area( 'homegrid2' , array(
		'before' => '<div class="homegrid2 widget-area">',
		'after' => '</div>',
	) );

	genesis_widget_area( 'homegrid3' , array(
		'before' => '<div class="homegrid3 widget-area">',
		'after' => '</div>',
	) );

	genesis_widget_area( 'homegrid4' , array(
		'before' => '<div class="homegrid4 widget-area">',
		'after' => '</div>',
	) );


}

}

genesis();
