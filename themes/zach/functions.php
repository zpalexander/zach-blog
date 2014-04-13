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


// Enqueue scripts and stylesheets
add_action( 'wp_enqueue_scripts', 'zach_scripts_styles' );
function zach_scripts_styles() {
	// Enqueue main stylesheet
	wp_enqueue_style( 'main-style', get_template_directory_uri() . "/css/style.css");
	// Enqueue normalizing stylesheet
	wp_enqueue_style('normalize-style', get_template_directory_uri() . "/css/normalize.css");

	if ( is_front_page() ) {
		wp_enqueue_script( 'home', get_template_directory_uri() . "/js/home.js", array( 'jquery' ) );
	}

	// Enqueue isotope on photos page
	if ( is_page( 'photos' ) ) {
		wp_enqueue_script( 'isotope', get_template_directory_uri() . "/js/jquery.isotope.min.js", array( 'jquery' ) );
		wp_enqueue_script( 'photos-script', get_template_directory_uri() . "/js/photos.js", array( 'jquery', 'isotope') );
	}
}


