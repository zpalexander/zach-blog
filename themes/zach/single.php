<?php
/**
 * This is the single post page
 *
 * @package Zach_Alexander
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
			?>
			<div class="blog-post-wrapper">
				<h1><?php the_title(); ?></h1>
				<p class="blog-post-date"><?php the_date(); ?></p>
				<?php 
					$categories = wp_get_post_categories(get_the_ID(), array( 'fields' => 'names' ));
					if ( $categories[0] != 'Uncategorized' ) {
						echo '<p class="blog-tags">';
							echo '<img src="' . get_stylesheet_directory_uri() . '/images/tag-icon.png ?>">';
							foreach ( $categories as $category )
								echo '<span class="blog-post-category">' . $category . '</span>';
						echo '</p>';
					}
				?>
				<img class="blog-post-image" 
					src="<?php $id = get_the_ID();
					echo get_post_meta($id, '_zach_post_image', TRUE); ?>"
				>
				<div class="blog-post-content">
					<?php the_content(); ?>
				</div>

				<?php endwhile; ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
