<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Zach_Alexander
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '| Zach Alexander', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >
<div id="page" class="hfeed site">
	<?php if ( get_header_image() ) : ?>
	<div id="site-header">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
		</a>
	</div>
	<?php endif; ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="header-main">
			<img class="header-hamburger" src="<?php echo get_stylesheet_directory_uri() . '/images/hamburger-icon.png' ?>">
			<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>

			<nav id="primary-navigation" class="site-navigation primary-navigation" role="navigation">
				<ul class="list-reset">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<li <?php if (is_front_page()) echo 'class="active-nav"'; ?>>
							Home
						</li>
					</a>
					<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" rel="about">
						<li <?php if (is_page('about')) echo 'class="active-nav"'; ?>>
							About
						</li>
					</a>
					<!--
					<a href="<?php //echo esc_url( home_url( '/photos' ) ); ?>" rel="photos">
						<li <?php //if (is_page('photos')) echo 'class="active-nav"'; ?>>
							Photos
						</li>
					</a>
					-->
					<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" rel="blog">
						<li <?php if (is_home() || is_single()) echo 'class="active-nav"'; ?>>
							Blog
						</li>
					</a>

				</ul>
			</nav>
		</div>
	</header><!-- #masthead -->

	<div id="main" class="site-main">
