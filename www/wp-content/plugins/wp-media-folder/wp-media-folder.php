<?php
/*
Plugin Name: WP Media folder
Plugin URI: http://www.joomunited.com
Description: WP media Folder is a WordPress plugin that enhance the WordPress media manager by adding a folder manager inside.
Author: Joomunited
Version: 3.5.5
Author URI: http://www.joomunited.com
Licence : GNU General Public License version 2 or later; http://www.gnu.org/licenses/gpl-2.0.html
Copyright : Copyright (C) 2014 JoomUnited (http://www.joomunited.com). All rights reserved.
*/
// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );
if (!defined('WP_MEDIA_FOLDER_PLUGIN_DIR'))
    define('WP_MEDIA_FOLDER_PLUGIN_DIR', plugin_dir_path(__FILE__));

if ( ! defined( 'WPMF_FILE' ) ) {
	define( 'WPMF_FILE', __FILE__ );
}

if ( ! defined( 'WPMF_TAXO' ) ) {
    define( 'WPMF_TAXO', 'wpmf-category' );
}

define( 'WPMF_GALLERY_PREFIX', 'wpmf_gallery_' );
define( '_WPMF_GALLERY_PREFIX', '_wpmf_gallery_' );
define( 'WPMF_GALLERY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPMF_DOMAIN', 'wpmf' );
define( 'WPMF_URL', plugin_dir_url ( __FILE__ ) );
define( 'WPMF_VERSION', '3.5.5' );
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
register_activation_hook( __FILE__, 'wp_media_folder_install' );
function wp_media_folder_install(){
    global $wpdb;
    $query = "INSERT INTO ".$wpdb->prefix."postmeta (post_id, meta_key, meta_value) VALUES ";
    $limit = 100;
    $values = array();
            $place_holders = array();
    $total = $wpdb->get_var("SELECT COUNT(posts.ID) as total FROM ".$wpdb->prefix."posts as posts
               WHERE   posts.post_type = 'attachment'");

    $j = ceil((int)$total/$limit);
    for($i = 1;$i<=$j; $i++){

        $ofset = ($i-1)*$limit;
        $attachments = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts as posts
               WHERE   posts.post_type     = 'attachment' LIMIT $limit OFFSET $ofset");

        foreach ($attachments as $attachment){

            $wpmf_size_filetype = wpmf_get_sizefiletype($attachment->ID);
            $size = $wpmf_size_filetype['size'];
            $ext = $wpmf_size_filetype['ext'];
            if(!get_post_meta($attachment->ID,'wpmf_size') ){
                array_push($values, $attachment->ID, 'wpmf_size',$size);
                $place_holders[] = "('%d', '%s', '%s')";
            }

            if(!get_post_meta($attachment->ID,'wpmf_filetype')){
                array_push($values, $attachment->ID, 'wpmf_filetype',$ext);
                $place_holders[] = "('%d', '%s', '%s')";
            }   
        }

        if(count($place_holders)>0) {
            $query = "INSERT INTO ".$wpdb->prefix."postmeta (post_id, meta_key, meta_value) VALUES ";
            $query .= implode(', ', $place_holders);
            $wpdb->query( $wpdb->prepare("$query ", $values));      
             $place_holders = array();
                $values = array();
        }
    }
}

function wpmf_get_sizefiletype($pid){
    $wpmf_size_filetype = array();
    $meta = get_post_meta($pid,'_wp_attached_file');
    $upload_dir = wp_upload_dir();
    $url_attachment = $upload_dir['basedir'].'/'.$meta[0];
    if( file_exists( $url_attachment ) ) {
        $size = filesize($url_attachment);
        $filetype = wp_check_filetype($url_attachment);
        $ext = $filetype['ext'];
    }else{
        $size = 0;
        $ext = '';
    }
    $wpmf_size_filetype['size'] = $size;
    $wpmf_size_filetype['ext'] = $ext;

    return $wpmf_size_filetype;
}

require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/class-media-folder.php' );
$GLOBALS['wp_media_folder'] = new Wp_Media_Folder;
require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/class-wp-foldel-option.php' );
new Media_Folder_Option;
require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/wpmf-display-own-media.php' );
new Wpmf_Display_Own_Media;
$useorder = get_option('wpmf_useorder');
if(isset($useorder) && $useorder == 1){
    require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/wpmf-orderby-media.php' );
    new Wpmf_Add_Columns_Media;
    require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/wpmf-fillter-size.php' );
    new Wpmf_Fillter_Size;
}

$option_override = get_option('wpmf_option_override');
if(isset($option_override) && $option_override == 1){
    require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/wpmf-replace-image.php' );
    new Wpmf_replace_file;
}

$option_duplicate = get_option('wpmf_option_duplicate');
if(isset($option_duplicate) && $option_duplicate == 1){
    require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/wpmf-duplicate-file.php' );
    new Wpmf_duplicate_file;
}

$wpmf_media_rename = get_option('wpmf_media_rename');
if(isset($wpmf_media_rename) && $wpmf_media_rename == 1){
    require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . 'class/class-media-rename.php' );
    new Wpmf_Media_Rename;
}

require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/wpmf-background-folder.php' );
new Wpmf_Background_Folder;

//config section        
if(!defined('JU_BASE')){
    define( 'JU_BASE', 'https://www.joomunited.com/' );
}

$remote_updateinfo =   JU_BASE.'juupdater_files/wp-media-folder.json';
 //end config

require 'juupdater/juupdater.php';
$UpdateChecker = Jufactory::buildUpdateChecker(
       $remote_updateinfo,
        __FILE__
);

$usegellery = get_option('wpmf_usegellery');
if(isset($usegellery) && $usegellery == 1){
    require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/wpmf-display-gallery.php' );
    new Wpmf_Display_Gallery;
}

$wpmf_option_singlefile = get_option('wpmf_option_singlefile');
if(isset($wpmf_option_singlefile) && $wpmf_option_singlefile == 1){
    require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/wpmf-single-file.php' );
    new Single_File();
}
        
add_action( 'init', 'wpmf_register_taxonomy_for_images', 0);
function wpmf_register_taxonomy_for_images() {
    register_taxonomy('wpmf-category', 'attachment',array(
        'hierarchical'=>true,
        'show_in_nav_menus'=>false,
        'show_ui'=>false,
        'public' => false,
        'labels' => array(
                        'name'				=> __('WPMF Categories', 'wpmf'),
                        'singular_name'		=> __('WPMF Category', 'wpmf'),
                        'menu_name'			=> __('WPMF Categories', 'wpmf'),
                        'all_items'			=> __('All WPMF Categories', 'wpmf'),
                        'edit_item'			=> __('Edit WPMF Category', 'wpmf'),
                        'view_item'			=> __('View WPMF Category', 'wpmf'),
                        'update_item'		=> __('Update WPMF Category', 'wpmf'),
                        'add_new_item'		=> __('Add New WPMF Category', 'wpmf'),
                        'new_item_name'		=> __('New WPMF Category Name', 'wpmf'),
                        'parent_item'		=> __('Parent WPMF Category', 'wpmf'),
                        'parent_item_colon'	=> __('Parent WPMF Category:', 'wpmf'),
                        'search_items'		=> __('Search WPMF Categories', 'wpmf'),
                ),
        ));
}
