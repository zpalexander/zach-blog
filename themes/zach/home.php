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

		<?php $the_query = blog_posts_query(); ?>
		<?php if ( $the_query->have_posts() ) : ?>
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

			<!-- Individual blog post container -->
			<div class="blog-post-teaser-container">
				<div class="blog-post-teaser-info">
					<a href="<?php the_permalink() ?>"><h2><?php the_title(); ?></h2></a>
					<span class="blog-teaser-date"><?php echo get_the_date(); ?></span>
					<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'blog-thumb' ); ?></a>
					<div class="blog-teaser-text"><?php print blog_posts_blurb(get_the_content(), get_permalink()); ?></div>
				</div>
				<?php if ($categories = blog_post_categories(get_the_ID())): ?>
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
			<!-- Line to separate each blog post -->
			<?php if (!( ($the_query->current_post+1) == $the_query->post_count)) : ?>
				<hr/>
				<?php endif; ?>
			<?php endwhile; ?>
			<!-- pagination here -->
			<?php if ($the_query->max_num_pages > 1): ?>
				<?php //echo '<PRE/>'; var_dump($the_query->max_num_pages); die(); ?>
  			<nav class="prev-next-posts">
    			<div class="prev-posts-link">
      			<?php print get_next_posts_link( 'Older Entries', $the_query->max_num_pages + 1 ); ?>
    			</div>
    			<div class="next-posts-link">
      			<?php print get_previous_posts_link( 'Newer Entries' ); ?>
    			</div>
  			</nav>
			<?php endif; ?>
		<?php wp_reset_postdata(); ?>
		<?php else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
