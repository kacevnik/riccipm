<?php

/**
* Основные параметры WordPress.
*
* Скрипт для создания wp-config.php использует этот файл в процессе
* установки. Необязательно использовать веб-интерфейс, можно
* скопировать файл в "wp-config.php" и заполнить значения вручную.
*
* Этот файл содержит следующие параметры:
*
* * Настройки MySQL
* * Секретные ключи
* * Префикс таблиц базы данных
* * ABSPATH
*
* @link https://codex.wordpress.org/Editing_wp-config.php
*
* @package WordPress
*/

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'vagrant');

/** Имя пользователя MySQL */
define('DB_USER', 'vagrant');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'password');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/** Отключить ревизии постов. Ревизий 0 */
define('WP_POST_REVISIONS', 0);

/**#@+
* Уникальные ключи и соли для аутентификации.
*
* Смените значение каждой константы на уникальную фразу.
* Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
* Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
*
* @since 2.6.0
*/
define('AUTH_KEY', 'Jfo/iGetmLD+OhumTJcwBAM5M7V33ob2oinOlT9AWYPir/ud4Dr4aU/HftMiKe74');
define('SECURE_AUTH_KEY', 'BZLvW4HHnEKCJJ9zwO4XjBSQ0AWj1oqObT9fx645G+l64xJKrhoICmiq76xR0PzC');
define('LOGGED_IN_KEY', 'jqtpLYxKEkXjrkhAaOLbvcNZi7MsoPOLbgLvSmN6t32CFTA/Tk9+cP8ExXDsy4OU');
define('NONCE_KEY', 'zE6mOYYtEkFtmQrPktZmN4UMIxusZjOgp822GpDBFc+VvxYxy092OstQO4Jgw2Qz');
define('AUTH_SALT', '0+ar39Hcl/Rj5MHKqdvOtpd3ibJ9ZUDZ2jeP7P+mTPFAMVp4e1saIh25CDIIpLNQ');
define('SECURE_AUTH_SALT', 'JZy47EPztW++3yk5VSJxqAXzOMh2prPxMfOokK/15mSYUl8p9eCCnIt4WfURb49q');
define('LOGGED_IN_SALT', 'McGT/trdm2J+d/18AHXM/rWaUJ+9SW0uY3L9+1ccjU8bmObAWCiBltMGNo5gNxA/');
define('NONCE_SALT', 'WKZ/UCLyplAOVAwvVnQR/PyzHjD5sRtIoEAOT8HIbEWwsiFSH8R2qAHCaHMzFYX8');

/**#@-*/

/**
* Префикс таблиц в базе данных WordPress.
*
* Можно установить несколько сайтов в одну базу данных, если использовать
* разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
*/
$table_prefix = 'wp_';

/**
* Для разработчиков: Режим отладки WordPress.
*
* Измените это значение на true, чтобы включить отображение уведомлений при разработке.
* Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
* в своём рабочем окружении.
*
* Информацию о других отладочных константах можно найти в Кодексе.
*
* @link https://codex.wordpress.org/Debugging_in_WordPress
*/
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
