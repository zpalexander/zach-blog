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
			<?php while ( have_posts() ) : the_post(); ?>
			<div class="blog-post-wrapper">
				<h1><?php the_title(); ?></h1>
				<p class="blog-post-date"><?php the_date(); ?></p>
				<?php $categories = wp_get_post_categories(get_the_ID()); ?>
				<?php if ( $categories[0] != 'Uncategorized' ) : ?>
					<p class="blog-tags">
						<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/tag-icon.png">
						<?php foreach ( $categories as $category ) : ?>
							<?php $filter_url = get_site_url() . '/blog?cat=' . $category; ?>
							<a href='<?php echo $filter_url ?>'>
							<span class="blog-post-category"><?php echo get_category($category)->name; ?></span>
							</a>
						<?php endforeach; ?>
					</p>
				<?php endif; ?>
				<img class="blog-post-image" src="<?php echo blog_post_image($post->ID) ?>">
				<div class="blog-post-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
			<?php endwhile; ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
