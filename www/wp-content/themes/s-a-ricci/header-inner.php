<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package S.A.Ricci
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!-- <base href="/"> -->
	<meta name="description" content="S.A.Ricci Project Management">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- <meta name="viewport" content="1230, initial-scale=1"> -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!-- Custom Browsers Color Start -->
	<meta name="theme-color" content="#2e3740">
<!-- Подключение стилей css вынесено в functions.php-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!-- Header inner HTML -->
	<header class="main_header">
	<div class="container">
		<div class="row row_buttons">
			<?php the_custom_logo( $blog_id ); ?><!-- Logo img here -->
			<div class="slogan">
			<?php get_bloginfo ('description'); ?>
					<h2>Управление проектами <br>	и инженерное сопровождение строительства</h2>	
				</div>
				<?php	dynamic_sidebar('header_buttons_sidebar'); ?>
		</div>
	</div>
</header>