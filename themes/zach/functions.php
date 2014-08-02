<?php
/**
 *
 * @package Zach_Alexander
 */



 /**
  * Custom metabox setup.
  *
  * @since 0.1.0
  */
 require(dirname( __FILE__ ).'/includes/functionality.php');

/**
 *
 * Hide admin bar
 */
show_admin_bar( false );


/**
 *
 * Enqueue scripts and stylesheets
 *
 */
add_action( 'wp_enqueue_scripts', 'zach_scripts_styles' );
function zach_scripts_styles() {
	// Enqueue main stylesheet
	wp_enqueue_style( 'main-style', get_template_directory_uri() . "/style.css");
	// Enqueue header script on all pages
	// wp_enqueue_script( 'nav', get_template_directory_uri() . "/js/minified/nav.min.js", array( 'jquery' ) );

	if ( is_front_page() ) {
		wp_enqueue_script( 'home', get_template_directory_uri() . "/js/minified/home.min.js", array( 'jquery' ) );
	}

	// Enqueue isotope on photos page
	if ( is_page( 'photos' ) ) {
		wp_enqueue_script( 'photos', get_template_directory_uri() . "/js/minified/photos.min.js", array( 'jquery' ) );
	}

	if ( is_page( 'about' ) ) {
		wp_enqueue_script( 'about', get_template_directory_uri() . "/js/minified/about.min.js", array( 'jquery') );
	}

	if ( is_home() ) {
		wp_enqueue_script( 'blog', get_template_directory_uri() . "/js/minified/blog.min.js", array( 'jquery' ) );
	}

	if ( is_single() ) {
		wp_enqueue_script( 'single', get_template_directory_uri() . "/js/minified/single.min.js", array( 'jquery' ) );
	}
}


function blog_posts_query($filter) {
	$query = new WP_Query( "cat=$filter" );
	return $query;
}

