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
			$the_query = blog_posts_query();
			if ( $the_query->have_posts() ) :
				while ( $the_query->have_posts() ) : $the_query->the_post();
		?>
		<div class="blog-post-teaser-container">

			<div class="blog-post-teaser-info">
				<a href="<?php the_permalink() ?>"><h2><?php the_title(); ?></h2></a>
				<span class="blog-teaser-date"><?php echo get_the_date(); ?></span>
				<a href="<?php the_permalink() ?>">
					<img class="blog-teaser-image" src="<?php print blog_post_image(get_the_ID()); ?>">
				</a>
				<div class="blog-teaser-text">
					<?php print blog_posts_blurb(get_the_content(), get_permalink()); ?>
				</div>
			</div>

			<?php $categories = blog_post_categories(get_the_ID()); ?>
			<?php if ($categories): ?>
				<p class="blog-teaser-tags">
					<img src="<?php print get_stylesheet_directory_uri(); ?>/images/tag-icon.png">
					<?php foreach ($categories as $category_name => $category_url): ?>
						<a href="<?php print $category_url; ?>">
							<span class="blog-post-category"><?php print $category_name; ?></span>
						</a>
					<?php endforeach; ?>
				</p>
			<?php endif; ?>
		</div>

		<?php if (!( ($the_query->current_post+1) == $the_query->post_count)) : ?>
			<hr/>
		<?php endif; ?>

		<?php
				endwhile;
				// Previous/next post navigation.
			endif;
		?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
