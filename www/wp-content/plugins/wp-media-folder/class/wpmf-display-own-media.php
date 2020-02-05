<?php
require_once( WP_MEDIA_FOLDER_PLUGIN_DIR . '/class/class-media-folder.php' );
class Wpmf_Display_Own_Media {

    function __construct() {
        global $pagenow;
        if($pagenow == 'upload.php'){
            add_action( 'admin_enqueue_scripts', array($this, 'wpmf_load_custom_wp_admin_script') );
        }
        add_action( 'wp_enqueue_media', array($this, 'wpmf_load_custom_wp_admin_script') );
        add_action('wp_ajax_display_media', array($this, 'wpmf_display_media') );
    }
    
    public function wpmf_load_custom_wp_admin_script() {
        global $pagenow,$current_screen;
        if(!current_user_can('upload_files')) return;
        if(is_admin() && ($current_screen->base == 'settings_page_option-folder' || $pagenow == 'media-new.php')) return;
        wp_enqueue_script('wpmf-filter-display-media');
    }
    
    function wpmf_display_media(){
        if(isset($_POST['wpmf_display_media'])){
            $_SESSION['wpmf_display_media'] = $_POST['wpmf_display_media'];
        }
    }
}
?>