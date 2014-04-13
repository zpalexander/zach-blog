<?php
/**
 *Template Name: Home
 *
 * @package Zach_Alexander
 */
get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="photo-content" role="main">
		<div class="photo-container">
		<?php 
			$query_args = array(
				'posts_per_page'   => 12,
				'offset'           => 0,
				'category'         => '',
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'include'          => '',
				'exclude'          => '',
				'meta_value'       => '',
				'post_type'        => 'photo',
				'post_status'      => 'publish',
				'suppress_filters' => true ); 
			$photos_array = get_posts($query_args);

			if ($photos_array) {
				foreach($photos_array as $photo_post) {
		?>
					<div class="photo">
						<div class="photo-info">
							<h4><?php echo $photo_post->post_title ?></h4>
							<span>
								<?php 
									$raw_date = $photo_post->post_date; 
									$refined_date = explode(' ', $raw_date);
									echo $refined_date[0];
								?>
							</span>
						</div>
						<img src="<?php echo get_post_meta($photo_post->ID, '_zach_photo_file', TRUE) ?>">
					</div>
		<?php
				}
			}
		?>
			
		</div>
	</div>
	<div class="fullscreen-photo"></div>
</section>

<?php
get_footer();