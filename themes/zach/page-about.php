<?php
/**
 *Template Name: Home
 *
 * @package Zach_Alexander
 */
get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

		<section class="about-info-container">
			<div class="business-card">
				<img src="<?php echo get_stylesheet_directory_uri() . '/images/avatar.png';?>">
				<h2>My name is Zach Alexander</h2>
				<p class="self-summary">I'm a full-stack web developer</p>
				<p class="self-summary">I live in Brooklyn, NY</p>
				<div class="down-arrow"></div>
				<p class="arrow-instructions">Click or scroll to continue</p>
			</div>

			<div class="primary-skills">
				<h2>Interests</h2>
			</div>

			<div class="experience">
			</div>

			<div class="notable-projects">
			</div>

			<div class="hobbies">

			</div>
		</section>

		<div class="about-background">
			<div class="overlooking-water">
				<img src="<?php echo get_stylesheet_directory_uri() . '/images/overlooking-water.jpg' ?>">
			</div>
			<div class="edc">
				<img src="<?php echo get_stylesheet_directory_uri() . '/images/edc.png' ?>">
			</div>
		</div>

	</div>
</section>

<?php
get_footer();