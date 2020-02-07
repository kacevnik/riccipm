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
get_header();
?>
	<!-- MAIN CONTENT HTML -->
<section class="main_content">
	<div style="padding-top: 50px;" class="topic"><h2>Ошибка 404</h2></div> 
	<div class="container">
		<div class="row">
			<div class="text-article">
				<img style="text-align: center;" src="/wp-content/themes/s-a-ricci/img/404.png" alt="404">	
				<p>Страница по данной ссылке была удалена или не существовала.</p>
				<a href="/">На главную</a>
		
			</div>
		</div>

			<div class="clear"></div>
	</div> <!-- container off -->
</section>

<?php
get_footer();
