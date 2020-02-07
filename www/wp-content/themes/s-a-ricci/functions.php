<?php
/**
 * S.A.Ricci functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package S.A.Ricci
 */

if ( ! function_exists( 's_a_ricci_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function s_a_ricci_setup() {


		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'custom-logo' ); // Добавляет возможность вставлять свое лого из админки
		add_theme_support( 'post-thumbnails' ); // Добавляет возможность вставлять свое превью поста thumbnail из админки
		add_image_size( 'object_prewiev', 370, 9999);// записи постов 370 в ширину и без ограничения в высоту
		add_image_size( 'direction_prewiev', 170, 9999);// записи постов 350 в ширину и без ограничения в высоту
		

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 's-a-ricci' ),
			'main-menu' => 'Главное меню',
		) );

		function change_email($email) {
			return 'noreply@riccipm.ru';
		}
		 
		add_filter('wp_mail_from','change_email');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 's_a_ricci_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 's_a_ricci_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
// переопределяет стандартную разметку виджета 

 //убирает заголовки
add_filter( 'widget_title', 'hide_widget_title' );
function hide_widget_title( $title ) {
    if ( empty( $title ) ) return '';
    if ( $title[0] == '!' ) return '';
    return $title;
}

// Мои виджеты

// регистрация виджета
function register_my_widgets(){
	register_sidebar( array(
		'name' => 'Шапка сайта, кнопка и телефон',
		'id'            => "header_buttons_sidebar",
		'description'   => 'виджет кнопок в шапке сайта',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Шапка сайта, слоган',
		'id'            => "header_slogan_sidebar",
		'description'   => 'виджет слогана сайта',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Шапка, кнопка смотреть видео',
		'id'            => "header_vieo_btn_sidebar",
		'description'   => 'виджет кнопки youtube',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Меню, заголовок над блоками меню',
		'id'            => "menu_slogan",
		'description'   => 'заголовок над меню',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Кнопка на страницу проектов',
		'id'            => "go_to_all_category",
		'description'   => 'текст кнопки',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Настройка вкладок',
		'id'            => "tabs_owner",
		'description'   => 'текст вкладок и встурительный текст',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	
	register_sidebar( array(
		'name' => 'Вкладка видео',
		'id'            => "tab_video",
		'description'   => 'добавить/удалить видео',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Вкладка Письменные отзывы',
		'id'            => "tab_reviews",
		'description'   => 'добавить/удалить фото',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );
	
	register_sidebar( array(
		'name' => 'Форма отправки заявки',
		'id'            => "form_widget",
		'description'   => 'html код формы',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Яндекс карта',
		'id'            => "map_section",
		'description'   => 'код карты',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Директор',
		'id'            => "director_section",
		'description'   => 'редакировать блок директора',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Instagram',
		'id'            => "instagram_section",
		'description'   => 'Виджет instagram',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<p style="display:none" class="widgettitle">',
		'after_title'   => "</p>\n",
	) );

	register_sidebar( array(
		'name' => 'Footer кнопки',
		'id'            => "footer_section",
		'description'   => 'footer info',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<h2 style="display:none" class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );

	register_sidebar( array(
		'name' => 'Условия обработки данных ',
		'id'            => "popup_section",
		'description'   => 'Во всплывающем окне из формы',
		'class'         => '',
		'before_widget' => ' ',
		'after_widget'  => ' ',
		'before_title'  => '<p style="display:none" class="widgettitle">',
		'after_title'   => "</p>\n",
	) );
}
add_action( 'widgets_init', 'register_my_widgets' ); // команда инициализации виджета
 
 
// Мои настройки***



// Подключение стилей и скриптов
add_action( 'wp_enqueue_scripts', 's_a_ricci_styles_head' );
add_action( 'wp_footer', 's_a_ricci_scripts_footer' );
// Стили
function s_a_ricci_styles_head(){
	wp_enqueue_style( 'style', get_stylesheet_uri());
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css');
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/libs/slick/slick.css');
	wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/libs/slick/slick-theme.css');
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/libs/fancybox/jquery.fancybox.min.css');
	wp_enqueue_style( 'unitegallery', get_template_directory_uri() . '/libs/unitegallery/unite-gallery.css');
	wp_enqueue_style( 'unitegallery', get_template_directory_uri() . '/libs/unitegallery/ug-theme-default.css');
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/main.css');
	
}
	// скрипты
function s_a_ricci_scripts_footer(){
	wp_enqueue_script( 'fontawesome', get_template_directory_uri() . '/libs/fontawesome-all.min.js');
	wp_enqueue_script( 'unitegallery', get_template_directory_uri() . '/libs/unitegallery/unitegallery.js');
	wp_enqueue_script( 'ug-theme-unitegallery', get_template_directory_uri() . '/libs/unitegallery/ug-theme-default.js');
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/libs/slick/slick.min.js');
	wp_enqueue_script( 'youtube', get_template_directory_uri() . '/js/youtube.js');
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/libs/waypoints-1.6.2.min.js');
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/libs/fancybox/jquery.fancybox.min.js');
	wp_enqueue_script( 'vanilla', get_template_directory_uri() . '/libs/jquery.maskedinput.min.js');
	// wp_enqueue_script( 'vanilla', get_template_directory_uri() . '/libs/vanilla-masker.min.js');
	wp_enqueue_script( 'spincrement', get_template_directory_uri() . '/libs/jquery.spincrement.js');
	wp_enqueue_script( 'commonfile', get_template_directory_uri() . '/js/common.js');
}

//  
 // Отключаем jQuery WordPress
 wp_deregister_script( 'jquery-core' );

// Регистрация jQuery
add_action( 'wp_enqueue_scripts', 'jquery_script_method' );
function jquery_script_method() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/libs/jquery/dist/jquery-2.2.4.min.js', false, null, true );
	wp_enqueue_script( 'jquery' );
} 

//Заменим разделитель title на страницах
add_filter( 'document_title_separator', function(){ return ' | '; } );

// MENU

//Произвольное меню
	// This theme uses wp_nav_menu() in two locations.
	add_action('after_setup_theme', function(){
		register_nav_menus( array(
			'main_menu' => 'Меню в виде блоков',
			'tab_menu' => 'Меню в табах'
		) );
	});

function main_menu(){
	echo '<ul>';
	wp_list_pages('title_li=&');
	echo '</ul>';
}


// Хлебные крошки
/*
 * "Хлебные крошки" для WordPress
 * автор: Dimox
 * версия: 2017.01.21
 * лицензия: MIT
*/
function dimox_breadcrumbs() {

  /* === ОПЦИИ === */
  $text['home'] = 'Главная'; // текст ссылки "Главная"
  $text['category'] = '%s'; // текст для страницы рубрики
  $text['search'] = 'Результаты поиска по запросу "%s"'; // текст для страницы с результатами поиска
  $text['tag'] = 'Записи с тегом "%s"'; // текст для страницы тега
  $text['author'] = 'Статьи автора %s'; // текст для страницы автора
  $text['404'] = 'Ошибка 404'; // текст для страницы 404
  $text['page'] = 'Страница %s'; // текст 'Страница N'
  $text['cpage'] = 'Страница комментариев %s'; // текст 'Страница комментариев N'

  $wrap_before = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // открывающий тег обертки
  $wrap_after = '</div><!-- .breadcrumbs -->'; // закрывающий тег обертки
  $sep = '/'; // разделитель между "крошками"
  $sep_before = '<span class="sep">'; // тег перед разделителем
  $sep_after = '</span>'; // тег после разделителя
  $show_home_link = 1; // 1 - показывать ссылку "Главная", 0 - не показывать
  $show_on_home = 0; // 1 - показывать "хлебные крошки" на главной странице, 0 - не показывать
  $show_current = 1; // 1 - показывать название текущей страницы, 0 - не показывать
  $before = '<span class="current">'; // тег перед текущей "крошкой"
  $after = '</span>'; // тег после текущей "крошки"
  /* === КОНЕЦ ОПЦИЙ === */

  global $post;
  $home_url = home_url('/');
  $link_before = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
  $link_after = '</span>';
  $link_attr = ' itemprop="item"';
  $link_in_before = '<span itemprop="name">';
  $link_in_after = '</span>';
  $link = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
  $frontpage_id = get_option('page_on_front');
  $parent_id = ($post) ? $post->post_parent : '';
  $sep = ' ' . $sep_before . $sep . $sep_after . ' ';
  $home_link = $link_before . '<a href="' . $home_url . '"' . $link_attr . ' class="home">' . $link_in_before . $text['home'] . $link_in_after . '</a>' . $link_after;

  if (is_home() || is_front_page()) {

    if ($show_on_home) echo $wrap_before . $home_link . $wrap_after;

  } else {

    echo $wrap_before;
    if ($show_home_link) echo $home_link;

    if ( is_category() ) {
      $cat = get_category(get_query_var('cat'), false);
      if ($cat->parent != 0) {
        $cats = get_category_parents($cat->parent, TRUE, $sep);
        $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        if ($show_home_link) echo $sep;
        echo $cats;
      }
      if ( get_query_var('paged') ) {
        $cat = $cat->cat_ID;
        echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
      }

    } elseif ( is_search() ) {
      if (have_posts()) {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['search'], get_search_query()) . $after;
      } else {
        if ($show_home_link) echo $sep;
        echo $before . sprintf($text['search'], get_search_query()) . $after;
      }

    } elseif ( is_day() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $sep;
      echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));
      if ($show_current) echo $sep . $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      if ($show_home_link) echo $sep;
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'));
      if ($show_current) echo $sep . $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      if ($show_home_link) echo $sep;
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        printf($link, $home_url . $slug['slug'] . '/', $post_type->labels->singular_name);
        if ($show_current) echo $sep . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $sep);
        if (!$show_current || get_query_var('cpage')) $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        echo $cats;
        if ( get_query_var('cpage') ) {
          echo $sep . sprintf($link, get_permalink(), get_the_title()) . $sep . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
        } else {
          if ($show_current) echo $before . get_the_title() . $after;
        }
      }

    // custom post type
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      if ( get_query_var('paged') ) {
        echo $sep . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . $post_type->label . $after;
      }

    } elseif ( is_attachment() ) {
      if ($show_home_link) echo $sep;
      $parent = get_post($parent_id);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      if ($cat) {
        $cats = get_category_parents($cat, TRUE, $sep);
        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_page() && !$parent_id ) {
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_page() && $parent_id ) {
      if ($show_home_link) echo $sep;
      if ($parent_id != $frontpage_id) {
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          if ($parent_id != $frontpage_id) {
            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          }
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo $breadcrumbs[$i];
          if ($i != count($breadcrumbs)-1) echo $sep;
        }
      }
      if ($show_current) echo $sep . $before . get_the_title() . $after;

    } elseif ( is_tag() ) {
      if ( get_query_var('paged') ) {
        $tag_id = get_queried_object_id();
        $tag = get_tag($tag_id);
        echo $sep . sprintf($link, get_tag_link($tag_id), $tag->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_current) echo $sep . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
      }

    } elseif ( is_author() ) {
      global $author;
      $author = get_userdata($author);
      if ( get_query_var('paged') ) {
        if ($show_home_link) echo $sep;
        echo sprintf($link, get_author_posts_url($author->ID), $author->display_name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
      } else {
        if ($show_home_link && $show_current) echo $sep;
        if ($show_current) echo $before . sprintf($text['author'], $author->display_name) . $after;
      }

    } elseif ( is_404() ) {
      if ($show_home_link && $show_current) echo $sep;
      if ($show_current) echo $before . $text['404'] . $after;

    } elseif ( has_post_format() && !is_singular() ) {
      if ($show_home_link) echo $sep;
      echo get_post_format_string( get_post_format() );
    }

    echo $wrap_after;

  }
} // end of dimox_breadcrumbs()

// Хлебные крошки



/*
 * Функция создает дубликат поста в виде черновика и редиректит на его страницу редактирования
 */
function true_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'true_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('Нечего дублировать!');
	}
 
	/*
	 * получаем ID оригинального поста
	 */
	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	/*
	 * а затем и все его данные
	 */
	$post = get_post( $post_id );
 
	/*
	 * если вы не хотите, чтобы текущий автор был автором нового поста
	 * тогда замените следующие две строчки на: $new_post_author = $post->post_author;
	 * при замене этих строк автор будет копироваться из оригинального поста
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * если пост существует, создаем его дубликат
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * массив данных нового поста
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'publish', // черновик, если хотите сразу публиковать - замените на publish
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
 
		/*
		 * создаем пост при помощи функции wp_insert_post()
		 */
		$new_post_id = wp_insert_post( $args );
 
		/*
		 * присваиваем новому посту все элементы таксономий (рубрики, метки и т.д.) старого
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // возвращает массив названий таксономий, используемых для указанного типа поста, например array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
 
		/*
		 * дублируем все произвольные поля
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
 
 
		/*
		 * и наконец, перенаправляем пользователя на страницу редактирования нового поста
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Ошибка создания поста, не могу найти оригинальный пост с ID=: ' . $post_id);
	}
}
add_action( 'admin_action_true_duplicate_post_as_draft', 'true_duplicate_post_as_draft' );
 
/*
 * Добавляем ссылку дублирования поста для post_row_actions
 */
function true_duplicate_post_link( $actions, $post ) {
	if (current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="admin.php?action=true_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Дублировать этот пост" rel="permalink">Дублировать</a>';
	}
	return $actions;
}
 
add_filter( 'post_row_actions', 'true_duplicate_post_link', 10, 2 );




// удаление смайликов
// REMOVE EMOJI ICONS
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


if( 'Disable REST API' ){

	// Отключаем сам REST API
	add_filter( 'rest_enabled', '__return_false' );

	// Отключаем фильтры REST API
	remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );
	remove_action( 'wp_head',                    'rest_output_link_wp_head', 10 );
	remove_action( 'template_redirect',          'rest_output_link_header', 11 );
	remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
	remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
	remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
	remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
	remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
	remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

	// Отключаем события REST API
	remove_action( 'init',          'rest_api_init' );
	remove_action( 'rest_api_init', 'rest_api_default_filters', 10 );
	remove_action( 'parse_request', 'rest_api_loaded' );

	// Отключаем Embeds связанные с REST API
	remove_action( 'rest_api_init',          'wp_oembed_register_route'              );
	remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10 );

	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	// если собираетесь выводить вставки из других сайтов на своем, то закомментируйте след. строку.
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );

}



// удалить атрибут type у scripts и styles
add_filter('style_loader_tag', 'clean_style_tag');
function clean_style_tag($src) {
    return str_replace("type='text/css'", '', $src);
}

add_filter('script_loader_tag', 'clean_script_tag');
function clean_script_tag($src) {
    return str_replace("type='text/javascript'", '', $src);
}

add_action( 'init', 'registr_note_post_type' );
function registr_note_post_type(){
	register_post_type( 'blog', array(
		'labels'             => array(
			'name'               => 'Блог', // Основное название типа записи
			'singular_name'      => 'Запись блога', // отдельное название записи типа Book
			'add_new'            => 'Добавить новый Note',
			'add_new_item'       => 'Добавить новый Note',
			'edit_item'          => 'Редактировать Note',
			'new_item'           => 'Новый Note',
			'view_item'          => 'Посмотреть Note',
			'search_items'       => 'Найти Note',
			'not_found'          =>  'Notes не найдено',
			'not_found_in_trash' => 'В корзине Notes не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'Блог'

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title','editor','author','thumbnail','excerpt','comments')
	) );
}
