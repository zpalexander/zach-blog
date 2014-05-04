<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>
<div class="sidebar">
	<div class="sidebar-content">
		<h2 class="blog-categories-header">Categories</h2>
		<ul class="blog-categories-list list-reset">
			<!-- All posts link -->
			<li>
				<a href="<?php echo get_site_url() . '/blog'; ?>">
					All Posts
				</a>
			</li>
			<?php
				$category_array = get_categories();
				foreach ($category_array as $category) {
			?>

			<li>
				<a href="<?php echo get_site_url() . '/blog?cat=' . $category->term_id  ?>"> 
					<?php echo $category->name ?>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div><!-- #secondary -->
