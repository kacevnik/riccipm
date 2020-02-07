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
			<div class="project-article">
				<div class="article__text">
				<?php the_content(); ?> <!-- вывод содержимого на страницу-->
				</div>
				 <div class="article__client">
						<span>Заказчик</span>
						<img src="<?php the_field('project__client') ?>" alt="client">
				 </div>
				  <div class="article__info">
						<span class="project__adres">Адрес:</span><p><?php the_field('project__adres') ?></p>
						<span class="project__type">Вид работ:</span><p><?php the_field('project__type') ?></p>
						<span class="project__space">Площадь:</span><p><span class="amount_space"><?php the_field('project__space') ?> м2</span></p>
						<span class="project__date">Сроки:</span><p class="date_p"><?php the_field('project__date') ?></p>
							 <?php if( get_field("drive_project") ): ?>
							<span class="project__date">Управление проектом:</span><p class="amount_space"><?php the_field('drive_project') ?></p>
							<?php endif; ?>
					  
					</div>
			</div>

		</div>
		
	</div> <!-- container off -->
 
	<div class="project__article__gallery">
		
	<div id="gallery">

<?php
//Get the images ids from the post_metadata
$images = acf_photo_gallery('project_gallery', $post->ID);
//Check if return array has anything in it
if( count($images) ):
//Cool, we got some data so now let's loop over it
foreach($images as $image):
$id = $image['id']; // The attachment id of the media
$title = $image['title']; //The title
$caption= $image['caption']; //The caption
$full_image_url= $image['full_image_url']; //Full size image url
$full_image_url = acf_photo_gallery_resize_image($full_image_url, 1170, 700); //Resized size to 262px width by 160px height image url
$thumbnail_image_url= $image['thumbnail_image_url']; //Get the thumbnail size image url 150px by 150px
$url= $image['url']; //Goto any link when clicked
$target= $image['target']; //Open normal or new tab
$alt = get_field('photo_gallery_alt', $id); //Get the alt which is a extra field (See below how to add extra fields)
$class = get_field('photo_gallery_class', $id); //Get the class which is a extra field (See below how to add extra fields)
?>


				<img src="<?php echo $full_image_url; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>">
				<?php endforeach; endif; ?>	
				</div>
	</div>
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
