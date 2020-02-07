<?php
/*
Template Name: Шаблон отзывов
*/
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
	<section class="reviews">
	<div class="container">
		<div class="row row_reviews">
		<?php	dynamic_sidebar('tabs_owner'); ?>
		</div>
		<div class="row row_reviews_content">
			<div class="text_tab">
				<?php	dynamic_sidebar('tab_video'); ?>
				</div>
			<div class="text_tab"> 
					<div class="wrapper">
					<?php	dynamic_sidebar('tab_reviews'); ?>
						</div>	
			</div>
		</div>
	</div>
</section>


<?php
get_sidebar();
get_footer();
