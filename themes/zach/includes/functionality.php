<?php

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

	$meta_boxes['post_image_metabox'] = array(
		'id' => 'post_image_metabox',
		'title' => __( 'Post Image', 'cmb' ),
		'pages' => array( 'post', ), // Post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields' => array(
			array(
				'name' 	=> __( "Put 'er here", 'cmb' ),
				'desc' 	=> __( '', 'cmb' ),
				'id' 	=> $prefix . 'post_image',
				'type' 	=> 'file',
			)
		)
	);

	return $meta_boxes;
}