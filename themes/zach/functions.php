<?php
/**
 * @package Zach_Alexander
 */



 /**
  * Custom metabox setup.
  *
  * @since 0.1.0
  */
 require(dirname( __FILE__ ).'/includes/functionality.php');

/**
 * Hide admin bar
 */
show_admin_bar( false );

/**
 * Add post thumbnail image support
 */
add_theme_support( 'post-thumbnails' );
add_image_size( 'blog-thumb', 350, 300 );


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
	wp_enqueue_script( 'nav', get_template_directory_uri() . "/js/minified/nav.min.js", array( 'jquery' ) );

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
		wp_enqueue_script( 'lazyload', get_template_directory_uri() . "/js/minified/jquery.lazyload.min.js", array('jquery') );
	}
}


/**
 * Returns blog posts filtered by category
 * @return [object] [Returns a WordPress query object]
 */
function blog_posts_query() {
	$filter = isset($_GET['cat']) ? $_GET['cat'] : NULL;
	$query = new WP_Query( "cat=$filter" );
	return $query;
}

/**
 * Returns the first 500 characters of a blog post
 * @param  [string] $body      [The original body text of the post]
 * @param  [string] $permalink [The permalink to the post]
 * @return [string]            [The first 500 characters of the post]
 */
function blog_posts_blurb($body, $permalink) {
	return substr($body, 0, 500) . '<a href="' . $permalink . '">.....</a>';
}

/**
 * Returns the permalink to the image of a blog post
 * @param  [int] $id [The post id of the post]
 * @return [string]     [A permalink to the image]
 */
function blog_post_image($id) {
	return get_post_meta($id, '_zach_post_image', TRUE);
}

/**
 * Returns an array of blog post categories for a given post
 * @param  [int] $id [The post id of the post]
 * @return [type]     [An array of category names and their associated display sort URLs]
 */
function blog_post_categories($id) {
	$categories = wp_get_post_categories(get_the_ID());
	$site_url = get_site_url();
	$output = array();
	if ( $categories[0] == 'Uncategorized' ) {
		return FALSE;
	}
	foreach ( $categories as $category ) {
		$category_name = get_category($category)->name;
		$category_url = $site_url . '/blog?cat=' . $category;
		$output[$category_name] =  $category_url;
	}
	return $output;
}

