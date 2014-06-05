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
				<p class="self-summary">I live in Brooklyn, NY</p>
				<a href="<?php echo esc_url( home_url( 'wp-content/uploads/2014/06/zach-alexander-resume.pdf' ) ); ?>" rel="cv">
					<div class="download-cv-button">Download my CV</div>
				</a>
				<div class="down-arrow"></div>
				<p class="arrow-instructions">Scroll to continue</p>
			</div>

			<div class="about-sections">
				<div id="primary-skills" class="primary-skills">
					<!--
					<div class="skill-carousel-wrapper">
						<ul class="skill-carousel list-reset">
							<li class="skill-title-card">-->
								<?php include( TEMPLATEPATH . '/about-partials/skill-title-card.php' ); ?>
							<!--</li>
							<li class="skill-front-end-dev">
							</li>
						</ul>
					</div>
					<span class="skill-carousel-prev">&#9668;</span>
					<span class="skill-carousel-next">&#9654;</span>
				</div>
				-->

				<!-- Inspiration for this section at http://www.behance.net/gallery/My-Resume/6217587 -->
				<div class="experience">
					<?php include( TEMPLATEPATH . '/about-partials/experience.php'); ?>
				</div>

				<div class="notable-projects">
				</div>

				<div class="hobbies">

				</div>
			</div>
		</section>

		<div class="about-background">
			<div class="overlooking-water">
				<img src="<?php echo get_stylesheet_directory_uri() . '/images/overlooking-water.jpg' ?>">
			</div>
		</div>

	</div>
</section>

<?php
get_footer();
