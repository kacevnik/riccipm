<?php get_header() ?>
<header class="main_header">
		<div class="container">
			<div class="row slogan">
				<?php dynamic_sidebar('header_slogan_sidebar'); ?>
				<a class="logotext" href="/">Организация, координация и контроль работ<br>по проектированию, строительству и внутренней отделке</a>

				<div class="videoblock">
				<?php dynamic_sidebar('header_vieo_btn_sidebar'); ?>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</header>
<aside class="text_layer">
	<div class="container">
		<div class="row">
		<?php	dynamic_sidebar('menu_slogan'); ?>
		</div>
	</div>
</aside>
	<!-- NAVIGATION CONTENT HTML -->
	<nav class="main_navigation">

		<?php wp_nav_menu( 
		array( 
		'theme_location' => 'main_menu',
		'fallback_cb'=> 'category_menu',
		'container' => 'ul',
		'menu_id' => 'nav',
		'menu_class' => 'navigation') 
		);
		?>
	</nav>	


	<!-- MAIN CONTENT HTML -->
<section class="main_content">
	<div class="container">
		<div class="row row_status">

		 <!-- Узнаем количество квадратных метров -->
		 <?php global $wpdb2;

			$meta_key = 'project__space';
			$counter=$wpdb->get_var($wpdb->prepare("SELECT sum(meta_value) FROM $wpdb->postmeta WHERE meta_key = %s", $meta_key));
			$counter_count=$wpdb->get_var($wpdb->prepare("SELECT COUNT(distinct meta_value) FROM $wpdb->postmeta WHERE meta_key = %s", $meta_key));
			// echo 'Всего проектов: '. $counter_count; выводит количество записей
			?>
 
			<p class="status"><span class="counter"><?php echo number_format((float)$counter, 1, '.', '') ; ?></span>м<sup>2</sup> <br> реализованных специалистами проектов</p>
						<a target="_blank" class="down_pdf" href="/S.A.Ricci_PM_project_list_20170914.pdf">
			<img class="alignnone wp-image-22 size-full" src="https://riccipm.ru/wp-content/uploads/2018/06/pdf.png" alt="" width="25" height="32" />Скачать буклет</a>
			<a class="go_to_all_category" href="/proekty"><?php	dynamic_sidebar('go_to_all_category'); ?> </a>

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
									'numberposts' => 240,
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
										<a href="<?php the_permalink() ?>" rel="bookmark">
										<?php 		if ( function_exists( 'add_theme_support' ) )
			the_post_thumbnail( array('','370'), array('class' => 'item__thumbnail') ); ?>
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
	<div class="point_enter"></div>	<!--Этот DIV является меткой для вставки кнопки-->	
								</div><!--End tabs container-->

								<div id="T2" class="tabs_global tab_item"> 	<!-- Код вкладки №2 -->


												<!-- вывод постов компонентом	 -->
												<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 36,
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
										<a href="<?php the_permalink() ?>" rel="bookmark">
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


									<div class="point_enter"></div>	<!--Этот DIV является меткой для вставки кнопки-->	
									</div><!--End tabs container-->

									<div id="T3" class="tabs_global tab_item"> 	<!-- Код вкладки №3 -->

									<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 36,
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
										<a href="<?php the_permalink() ?>" rel="bookmark">
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
										<div class="point_enter"></div>	<!--Этот DIV является меткой для вставки кнопки-->	
										</div><!--End tabs container-->

										<div id="T4" class="tabs_global tab_item"> 	<!-- Код вкладки №4 -->

					 			<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 36,
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
										<a href="<?php the_permalink() ?>" rel="bookmark">
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
										<div class="point_enter"></div>	<!--Этот DIV является меткой для вставки кнопки-->	
										</div><!--End tabs container-->
										<div id="T5" class="tabs_global tab_item"> 	<!-- Код вкладки №5 -->

									<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 36,
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
										<a href="<?php the_permalink() ?>" rel="bookmark">
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
											<div class="point_enter"></div>	<!--Этот DIV является меткой для вставки кнопки-->	
										</div><!--End tabs container-->
										
										<div id="T6" class="tabs_global tab_item"> 	<!-- Код вкладки №6 -->

									 			<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 36,
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
										<a href="<?php the_permalink() ?>" rel="bookmark">
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
														<div class="point_enter"></div>	<!--Этот DIV является меткой для вставки кнопки-->	
										</div><!--End tabs container-->

										<div id="T7" class="tabs_global tab_item"> 	<!-- Код вкладки №7 -->
													<!-- вывод постов компонентом	 -->
			<?php
								// параметры по умолчанию
								$args = array(
									'numberposts' => 36,
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
										<a href="<?php the_permalink() ?>" rel="bookmark">
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
				 
										<div class="point_enter"></div>	<!--Этот DIV является меткой для вставки кнопки-->	


</div><!--End tabs container-->

									
			</div><!--End row-->
			<div class="clear"></div>
	</div> <!-- container off -->
</section>

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

<?php get_sidebar(); ?>  


<?php get_footer();  ?>


