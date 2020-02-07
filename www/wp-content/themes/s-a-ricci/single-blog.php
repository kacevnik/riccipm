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

	 
	<div class="container">
		<div class="topic" style="margin-top: 50px;"><h1><?php the_title(); ?></h1></div>
			<div class="row">
				<div class="article__text">
					<?php the_content(); ?> <!-- вывод содержимого на страницу-->
				</div>
			</div>	
		</div> <!-- container off -->
 
		<div class="pagination">
<?php
/**
 * Зацикленный вывод предыдущего и следующего поста в WordPress
 */
if( get_adjacent_post(false, '', true) ) { 
  previous_post_link('%link', '<i class="fas fa-long-arrow-alt-left"></i> Предыдущий пост' ); 
}
else { 
	$first = new WP_Query('posts_per_page=1&order=DESC');
	$first->the_post();

	echo '<a class="go_to_prev_project" href="' . get_permalink() . '">← Предыдущий пост</a>';

	wp_reset_postdata();
}; 

if( get_adjacent_post(false, '', false) ) { 
	next_post_link('%link', 'Следующий пост <i class="fas fa-long-arrow-alt-right"></i> ' ); 
}
else { 
	$last = new WP_Query('posts_per_page=1&order=ASC');
	$last->the_post();

	echo '<a href="' . get_permalink() . '">Следующий пост →</a>';

	wp_reset_postdata();
}; 
?>

	
	
			<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
<?php else : ?>
<?php endif; ?>	
	</div>
</section>

<?php
get_sidebar();
get_footer();
