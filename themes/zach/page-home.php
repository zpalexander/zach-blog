<?php
/**
 *Template Name: Home
 *
 * @package Zach_Alexander
 */
get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">
		<ul class="social-media-container list-reset">
			<li>
			<a href="https://www.twitter.com/zpalexander">
				<img class="social-media-link twitter" src="<?php echo get_stylesheet_directory_uri() ?>/images/sm-icons/twitter-96.png" >
			</a>
			</li>
			<li>
			<a href="https://www.linkedin.com/pub/zachary-alexander/85/44/3b4">
				<img class="social-media-link linkedin" src="<?php echo get_stylesheet_directory_uri() ?>/images/sm-icons/linkedin-96.png" >
			</a>
			</li>
			<li>
				<a href="http://www.instagram.com/zpalexander">
					<img class="social-media-link instagram" src="<?php echo get_stylesheet_directory_uri() ?>/images/sm-icons/instagram-96.png" >
				</a>
			</li>
			<li>
			<a href="mailto:zpalexander@gmail.com">
				<img class="social-media-link email" src="<?php echo get_stylesheet_directory_uri() ?>/images/sm-icons/email-96.png" >
			</a>
			</li>
		</ul>
	</div>
</section>

<?php
get_footer();
