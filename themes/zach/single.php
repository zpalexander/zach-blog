<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
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
