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
					<p class="status">Реализованные проекты</p>
				</div>
		<div class="row">
					
						<ul class="tabs_project_list">
							<li><a title="все проекты">Все</a></li>
							<li><a title="Техническое обследование"><?php echo get_cat_name(3);?></a></li>
							<li><a title="Строительный контроль"><?php echo get_cat_name(5);?></a></li>
							<li><a title="Отделка и ремонт"><?php echo get_cat_name(6);?></a></li>
							<li><a title="Дизайн-проект"><?php echo get_cat_name(7);?></a></li>
							<li><a title="Оптимизация стоимости"><?php echo get_cat_name(8);?></a></li>
							<li><a title="Согласования"><?php echo get_cat_name(9);?></a></li>
						</ul>


							<div id="T1" class="tabs_global tab_item"> 	<!-- Код вкладки №1 -->

			<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 700,
									'category'    => ('2'), // берем из родительской категории
									'orderby'     => 'date',
									'order'       => 'DESC',
									'post_type'   => 'post',
									'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
								);

								$posts = get_posts( $args );
								foreach($posts as $post){ setup_postdata($post);
									?>
										<!-- card -->
										<div class="tabs_container__item">
										<a href="<?php the_permalink() ?>" rel="details">
										<img class="item__thumbnail" src="<?php the_post_thumbnail_url('object_prewiev'); ?>" alt="изображение проекта">
										<h4><?php the_title(); ?></h4>
											<span class="item_city"><?php the_field( "project__adres" ); ?></span>
											<span class="overley"></span>
										</a>
									</div>	<!-- end card -->
									<?php	
								}
								wp_reset_postdata(); // сброс
								?>

								<!-- вывод окончен	 -->
		
								</div><!--End tabs container-->

								<div id="T2" class="tabs_global tab_item"> 	<!-- Код вкладки №2 -->


												<!-- вывод постов компонентом	 -->
												<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 99,
									'category'    => ('3'), // берем из 3
									'orderby'     => 'date',
									'order'       => 'DESC',
									'post_type'   => 'post',
									'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
								);

								$posts = get_posts( $args );
								foreach($posts as $post){ setup_postdata($post);
									?>
										<!-- card -->
										<div class="tabs_container__item">
										<a href="<?php the_permalink() ?>" rel="details">
										<img class="item__thumbnail" src="<?php the_post_thumbnail_url('object_prewiev'); ?>" alt="изображение проекта">
										<h4><?php the_title(); ?></h4>
											<span class="item_city"><?php the_field( "project__adres" ); ?></span>
											<span class="overley"></span>
										</a>
									</div>	<!-- end card -->
									<?php	
								}
								wp_reset_postdata(); // сброс
								?>

								<!-- вывод окончен	 -->


										
									</div><!--End tabs container-->

									<div id="T3" class="tabs_global tab_item"> 	<!-- Код вкладки №3 -->

									<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 99,
									'category'    => ('5'), // берем из соответсвующей категории
									'orderby'     => 'date',
									'order'       => 'DESC',
									'post_type'   => 'post',
									'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
								);

								$posts = get_posts( $args );
								foreach($posts as $post){ setup_postdata($post);
									?>
										<!-- card -->
										<div class="tabs_container__item">
										<a href="<?php the_permalink() ?>" rel="details">
										<img class="item__thumbnail" src="<?php the_post_thumbnail_url('object_prewiev'); ?>" alt="изображение проекта">
										<h4><?php the_title(); ?></h4>
											<span class="item_city"><?php the_field( "project__adres" ); ?></span>
											<span class="overley"></span>
										</a>
									</div>	<!-- end card -->
									<?php	
								}
								wp_reset_postdata(); // сброс
								?>
											
										</div><!--End tabs container-->

										<div id="T4" class="tabs_global tab_item"> 	<!-- Код вкладки №4 -->

					 			<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 99,
									'category'    => ('6'), // берем из соответсвующей категории
									'orderby'     => 'date',
									'order'       => 'DESC',
									'post_type'   => 'post',
									'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
								);

								$posts = get_posts( $args );
								foreach($posts as $post){ setup_postdata($post);
									?>
										<!-- card -->
										<div class="tabs_container__item">
										<a href="<?php the_permalink() ?>" rel="details">
										<img class="item__thumbnail" src="<?php the_post_thumbnail_url('object_prewiev'); ?>" alt="изображение проекта">
										<h4><?php the_title(); ?></h4>
											<span class="item_city"><?php the_field( "project__adres" ); ?></span>
											<span class="overley"></span>
										</a>
									</div>	<!-- end card -->
									<?php	
								}
								wp_reset_postdata(); // сброс
								?>
											
										</div><!--End tabs container-->
										<div id="T5" class="tabs_global tab_item"> 	<!-- Код вкладки №5 -->

									<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 99,
									'category'    => ('7'), // берем из соответсвующей категории
									'orderby'     => 'date',
									'order'       => 'DESC',
									'post_type'   => 'post',
									'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
								);

								$posts = get_posts( $args );
								foreach($posts as $post){ setup_postdata($post);
									?>
										<!-- card -->
										<div class="tabs_container__item">
										<a href="<?php the_permalink() ?>" rel="details">
										<img class="item__thumbnail" src="<?php the_post_thumbnail_url('object_prewiev'); ?>" alt="изображение проекта">
										<h4><?php the_title(); ?></h4>
											<span class="item_city"><?php the_field( "project__adres" ); ?></span>
											<span class="overley"></span>
										</a>
									</div>	<!-- end card -->
									<?php	
								}
								wp_reset_postdata(); // сброс
								?>
												
										</div><!--End tabs container-->
										
										<div id="T6" class="tabs_global tab_item"> 	<!-- Код вкладки №6 -->

									 			<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 99,
									'category'    => ('8'), // берем из соответсвующей категории
									'orderby'     => 'date',
									'order'       => 'DESC',
									'post_type'   => 'post',
									'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
								);

								$posts = get_posts( $args );
								foreach($posts as $post){ setup_postdata($post);
									?>
										<!-- card -->
										<div class="tabs_container__item">
										<a href="<?php the_permalink() ?>" rel="details">
										<img class="item__thumbnail" src="<?php the_post_thumbnail_url('object_prewiev'); ?>" alt="изображение проекта">
										<h4><?php the_title(); ?></h4>
											<span class="item_city"><?php the_field( "project__adres" ); ?></span>
											<span class="overley"></span>
										</a>
									</div>	<!-- end card -->
									<?php	
								}
								wp_reset_postdata(); // сброс
								?>
															
										</div><!--End tabs container-->

										<div id="T7" class="tabs_global tab_item"> 	<!-- Код вкладки №7 -->
													<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 99,
									'category'    => ('9'), // берем из соответсвующей категории
									'orderby'     => 'date',
									'order'       => 'DESC',
									'post_type'   => 'post',
									'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
								);

								$posts = get_posts( $args );
								foreach($posts as $post){ setup_postdata($post);
									?>
										<!-- card -->
										<div class="tabs_container__item">
										<a href="<?php the_permalink() ?>" rel="details">
										<img class="item__thumbnail" src="<?php the_post_thumbnail_url('object_prewiev'); ?>" alt="изображение проекта">
										<h4><?php the_title(); ?></h4>
											<span class="item_city"><?php the_field( "project__adres" ); ?></span>
											<span class="overley"></span>
										</a>
									</div>	<!-- end card -->
									<?php	
								}
								wp_reset_postdata(); // сброс
								?>
				 
											


</div><!--End tabs container-->

									
			</div><!--End row-->
			<div class="clear"></div>
	</div> <!-- container off -->
</section>
 
<?php
get_footer();

