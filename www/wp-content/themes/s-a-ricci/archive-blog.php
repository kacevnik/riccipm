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
	<div class="container">
		<div class="row row_status">
			<?php if (have_posts()) { ?>
				<?php while (have_posts()) { the_post(); ?> <!-- Вывод из базы-->
					<!-- card -->
					<div class="tabs_container__item">
						<a href="<?php the_permalink() ?>" rel="details">
							<img class="item__thumbnail" src="<?php the_post_thumbnail_url('object_prewiev'); ?>" alt="изображение поста">
								<h4><?php the_title(); ?></h4>
											<span class="item_city"><?php the_field( "project__adres" ); ?></span>
											<span class="overley"></span>
						</a>
					</div>	<!-- end card -->
				<?php }} ?>
				 
											


</div><!--End tabs container-->

									
			</div><!--End row-->
			<div class="clear"></div>
	</div> <!-- container off -->
</section>
 
<?php
get_sidebar();
get_footer();

