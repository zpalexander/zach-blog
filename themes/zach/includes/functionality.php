<?php

add_action( 'init', 'create_photo_post_type' );
/**
 * Register Custom Post Types
 *
 */
function create_photo_post_type() {
	register_post_type( 'photo',
		array(
			'exclude_from_search' => false,
			'hierarchical' => false,
			'labels' => array(
				'add_new' => _('Add New Photo'),
				'add_new_item' => __('Add New Photo'),
				'edit' => __( 'Edit' ),
				'edit_item' => __('Edit Photo'),
				'menu_name' => _('Photos'),
				'all_items' => 'Photos',
				'name' => _('Photos'),
				'new_item' => __('New Photo'),
				'not_found' =>  __('No Photos found'),
				'not_found_in_trash' => __('No Photos found in Trash'),
				'parent' => __( 'Parent Photo' ),
				'search_items' => __('Search Photos'),
				'singular_name' => _('Photo'),
				'view' => __( 'View Photo' ),
				'view_item' => __('View Photo'),
			),
			'menu_position' => 30,
			'hierarchical' => true,
			'public' => true,
			'rewrite' => false,
			'show_ui' => true,
			'supports' => array('title', 'revisions' )
  		)
	);
}






add_action( 'init', 'zach_require_cmb' );
/**
 * Require Custom Meta boxes
 *
 * @since 0.1.0
 */
function zach_require_cmb() {
	require_once( dirname( __FILE__ ) . '/cmb/init.php' );
}

add_filter( 'cmb_meta_boxes', 'zach_metaboxes' );

/**
 * Add custom meta box structure.
 *
 * @since 0.1.0
 *
 * @param  array  $meta_boxes [description]
 * @return [type]             [description]
 */
function zach_metaboxes( array $meta_boxes ) {

	$prefix = '_zach_';

	$meta_boxes['photo_image_metabox'] = array(
		'id' => 'photo_image_metabox',
		'title' => __( 'Photo File', 'cmb' ),
		'pages' => array( 'photo', ), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields' => array(
			array(
				'name' 	=> __( "Image file", 'cmb' ),
				'desc' 	=> __( '', 'cmb' ),
				'id' 	=> $prefix . 'photo_file',
				'type' 	=> 'file',
			),
			array(
				'name' 	=> __( "Photo location", 'cmb' ),
				'desc'	=> __( '', 'cmb' ),
				'id'	=> $prefix . 'photo_location',
				'type'	=> 'text',
			)
		)
	);



	return $meta_boxes;
}
