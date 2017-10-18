<?php
/**
 * RacquetGrid.
 *
 * This file adds functions to the RacquetGrid theme.
 *
 * @package RacquetGrid
 * @author  marybaum
 * @license GPL-2.0+
 * @link    http://www.racquetpress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'rg_localization_setup' );
function rg_localization_setup(){
	load_child_theme_textdomain( 'racquetgrid', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'RacquetGrid' );
define( 'CHILD_THEME_URL', 'http://www.racquetpress.com/' );
define( 'CHILD_THEME_VERSION', '1.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'rg_enqueue_scripts_styles' );
function rg_enqueue_scripts_styles() {

	wp_enqueue_style( 'rg-fonts', '//fonts.googleapis.com/css?family=Taviraj:200,400,600,800', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'rg2-fonts', '//fonts.googleapis.com/css?family=Prompt:500,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'rg-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'rg-responsive-menu',
		'genesis_responsive_menu',
		rg_responsive_menu_settings()
	);

	// Backstretch.

	if ( is_singular( 'post' ) && has_post_thumbnail() ) {

		wp_enqueue_script( 'rgrid-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0', true );

		wp_enqueue_script( 'rgrid-backstretch-set', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch-set.js' , array( 'jquery', 'rgrid-backstretch' ), '1.0.0', true );

	}

	//* Localize Backstretch script

	add_action( 'genesis_after_entry', 'rgrid_set_background_image' );
	function rgrid_set_background_image() {

		$image = array( 'src' => has_post_thumbnail() ? genesis_get_image( array( 'format' => 'url' ) ) : '' );

		wp_localize_script( 'rgrid-backstretch-set', 'BackStretchImg', $image );

	}

}

// Define our responsive menu settings.
function rg_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'rg' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'rg' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add a body class for the category
add_filter( 'body_class', 'rg_body_class_add_categories' );
function rg_body_class_add_categories( $classes ) {

	// Get the categories assigned to this post
	$categories = get_the_category();

	// Loop over each category in the $categories array
	foreach ( $categories as $current_category ) {

		// Add the current category's slug to the $body_classes array
		$classes[] = $current_category->slug;

	}

	// Return the $body_classes array
	return $classes;
}

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

//* Unregister layout settings.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister sidebars.
unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

//* Force full-width content layout
add_filter( 'genesis_pre_get_option_site_layout' , '__genesis_return_full_width_content' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after-entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 600, 600, TRUE );
add_image_size( 'action' , 1024, 700, true );
add_image_size( 'giant' , 1920, 900, false  );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'rg' ), 'secondary' => __( 'Footer Menu', 'rg' ) ) );

// Move the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

/* Make the secondary navigation menu just one level deep.
add_filter( 'wp_nav_menu_args', 'rg_secondary_menu_args' );
function rg_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}
}

	$args['depth'] = 1;

	return $args;
*/

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	//'subnav',
	//'footer-widgets',
	'footer',
) );

//* Custom breadcrumbs arguments
add_filter('genesis_breadcrumb_args', 'rgrid_breadcrumb_args');
function rgrid_breadcrumb_args($args) {
	$args['sep'] = ' &raquo; ';
	$args['list_sep'] = ', ';
	// Genesis 1.5 and later
	$args['display'] = true;
	$args['labels']['prefix'] = __('You are here: ', 'rgrid');
	$args['labels']['author'] = __(' ', 'rgrid');
	$args['labels']['category'] = __(' ', 'rgrid');
	// Genesis 1.6 and later
	$args['labels']['tag'] = __(' ', 'rgrid');
	$args['labels']['date'] = __(' ', 'rgrid');
	$args['labels']['search'] = __('Find ', 'rgrid');
	$args['labels']['tax'] = __(' ', 'rgrid');
	$args['labels']['post_type'] = __(' ', 'rgrid');
	$args['labels']['404'] = __('404', 'rgrid');
	// Genesis 1.5 and later
	return $args;
}




	// Add body class for single Posts and static Pages with Featured images...

	add_filter( 'body_class', 'rgrid_featured_img_body_class' );
	function rgrid_featured_img_body_class( $classes ) {

		if (  is_singular( array ('post' , 'page' ) ) && has_post_thumbnail() )  {
			$classes[] = 'has-pic';
		}
		return $classes;
	}

	//...and without them.

	add_filter( 'body_class' , 'rgrid_nopic' );

	function rgrid_nopic( $classes ) {
		if (  is_singular( array ('post' , 'page' ) ) && !has_post_thumbnail() )  {
			$classes[] = 'no-pic';
		}
		return $classes;
	}

	// hook entry bgd to loop

	add_action( 'genesis_after_header', 'rgrid_entry_bgd' );
	function rgrid_entry_bgd() {
		if ( (	is_singular( 'post' ) ) && has_post_thumbnail() ) {
			echo '<div class="entry-background">' . '<h1>' . genesis_do_post_title() .  '</h1>' . '</div>';
		}
	}

	//lose the background image on archive pages

	if( is_page( 'archive' ) ) {

		remove_action( 'genesis_after_header' , 'rgrid_entry_bgd' );

		add_action( 'genesis_after_header', 'genesis_do_loop' );
	}

/**
 * Show Featured Image above Post Titles
 * Scope: Posts page (index)
 * @author Sridhar Katakam
 * @link   http://sridharkatakam.com/display-featured-images-post-titles-posts-page-genesis/
 */
	add_action( 'genesis_before_entry', 'rgrid_postimg_above_title' );

	function rgrid_postimg_above_title() {

		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

		add_action( 'genesis_entry_header', 'rgrid_postimg', 9 );
	}

	function rgrid_postimg() {
		echo '<a href="' . get_permalink() . '">' . genesis_get_image( array( 'size' => 'square' ) ). '</a>';
	}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'rg_author_box_gravatar' );
function rg_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'rg_comments_gravatar' );
function rg_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'rg_post_info_filter' );
function rg_post_info_filter($post_info) {
	$post_info = '[post_edit]';
	return $post_info;
}

//* Nuke the goddamn entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'homegrid1',
	'name'        => __( 'Home Grid-area 1', 'racquetgrid' ),
	'description' => __( 'This is home Grid-area 1.', 'racquetgrid' ),
	'before_title'=> __( '<h4>' , 'racquetgrid'),
	'after_title' => __( '</h4>' , 'racquetgrid' ),
) );
genesis_register_sidebar( array(
	'id'          => 'homegrid2',
	'name'        => __( 'Home Grid-area 2', 'racquetgrid' ),
	'description' => __( 'This is home Grid-area 2.', 'racquetgrid' ),
	'before_title'=> __( '<h4>' , 'racquetgrid'),
	'after_title' => __( '</h4>' , 'racquetgrid' ),
) );
genesis_register_sidebar( array(
	'id'          => 'homegrid3',
	'name'        => __( 'Home Grid-area 3', 'racquetgrid' ),
	'description' => __( 'This is home Grid-area 3.', 'racquetgrid' ),
	'before_title'=> __( '<h4>' , 'racquetgrid'),
	'after_title' => __( '</h4>' , 'racquetgrid' ),
) );
genesis_register_sidebar( array(
	'id'          => 'homegrid4',
	'name'        => __( 'Home Grid-area 4', 'racquetgrid' ),
	'description' => __( 'This is home Grid-area 4.', 'racquetgrid' ),
	'before_title'=> __( '<h4>' , 'racquetgrid'),
	'after_title' => __( '</h4>' , 'racquetgrid' ),
) );
genesis_register_sidebar( array(
	'id'          => 'homegrid5',
	'name'        => __( 'Home Grid-area 5', 'racquetgrid' ),
	'description' => __( 'This is home Grid-area 5.', 'racquetgrid' ),
	'before_title'=> __( '<h4>' , 'racquetgrid'),
	'after_title' => __( '</h4>' , 'racquetgrid' ),
) );
