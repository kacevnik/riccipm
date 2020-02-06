<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package S.A.Ricci
 */

get_header();
?>

	<!-- Breadcrumbs HTML -->
	<aside class="breadcrumbs">
		<div class="container">
			<div class="row">
			<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
			</div>
		</div>
		<div class="clear"></div>
	</aside>


	<!-- MAIN CONTENT HTML -->
<section class="main_content">
	<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?> <!-- Вывод из базы-->
	<div class="topic"><h1><?php the_title(); ?></h1></div> 
	<div class="container">
		<div class="row">
			<div class="text-article">
			<?php the_content(); ?> <!-- вывод содержимого на страницу-->
			</div>
		</div>
		<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>

 
<?php else : ?>
<?php endif; ?>	
			<div class="clear"></div>
	</div> <!-- container off -->
</section>

<?php
get_sidebar();
get_footer();
