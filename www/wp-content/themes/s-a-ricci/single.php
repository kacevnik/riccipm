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

	<div class="topic"><h2><?php the_title(); ?></h2></div> 
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
						<span class="project__space">Прощадь:</span><p><span class="amount_space"><?php the_field('project__space') ?></span>  м2</p>
						<span class="project__date">Сроки:</span><p><?php the_field('project__date') ?></p>
					  

					  
					  
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
// $full_image_url = acf_photo_gallery_resize_image($full_image_url, 1170, 700); //Resized size to 262px width by 160px height image url
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

<?php
 $pred_post = get_previous_post(); // получили и записали в переменную объект предыдущего поста
 $next_post = get_next_post(); // получили и записали в переменную объект следующего поста
?>

	<div class="pagination">
			<a class="go_to_prev_project" href="<?php echo get_permalink( $pred_post ); ?>"><i class="fas fa-long-arrow-alt-left"></i> Предыдущий проект</a>
			<a class="go_to_next_project" href="<?php echo get_permalink( $next_post ); ?>"><i class="fas fa-long-arrow-alt-right"></i> Следующий проект</a>
			<?php endwhile; /* rewind or continue if all posts have been fetched */ ?>
<?php else : ?>
<?php endif; ?>	
	</div>
</section>

<?php
get_sidebar();
get_footer();

