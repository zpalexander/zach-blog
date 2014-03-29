<?php
/**
 * This is the blog page
 * 
 * @package Zach_Alexander
 */

get_header(); ?>

<div id="main-content" class="main-content">
	<div id="primary" class="content-area">
		<div id="content" class="blog-page-content" role="main">

		<?php

			if ( have_posts() ) :
				// Start the Loop.
				while ( have_posts() ) : the_post();
		?>
		<div class="blog-post-teaser-container">	
			
			<a href="<?php the_permalink() ?>"><h2><?php the_title(); ?></h2></a>
			<span><?php echo get_the_date(); ?></span>
			<a href="<?php the_permalink() ?>">
			<img class="blog-teaser-image" 
				src="<?php $id = get_the_ID();
				echo get_post_meta($id, '_zach_post_image', TRUE); ?>"
			>
			</a>
			<div class="blog-teaser-text"><?php 
				$content = get_the_content(); 
				$content_limited = substr($content, 0, -2300) . '.....';
				echo $content_limited;
			?></p>
		</div>
		</div>

		<?php
				endwhile;
				// Previous/next post navigation.

			else :
			endif;
		?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();