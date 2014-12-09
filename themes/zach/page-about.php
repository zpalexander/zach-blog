<?php
/**
 *Template Name: Home
 *
 * @package Zach_Alexander
 */
get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content about-content" role="main">
		<section class="about-container">
			<div class="business-card">
				<img src="<?php echo get_stylesheet_directory_uri() . '/images/avatar.png';?>">
				<h2>My name is Zach Alexander</h2>
				<p class="self-summary">I'm a full-stack web developer</p>
				<p class="self-summary">I live in Beijing, China</p>
				<a href="<?php echo esc_url( home_url( 'wp-content/uploads/2014/07/zach-alexander-resume.pdf' ) ); ?>" rel="cv">
					<div class="download-cv-button">Download My CV</div>
				</a>
			</div>
		</section>
	</div>
</section>

<?php
get_footer();
