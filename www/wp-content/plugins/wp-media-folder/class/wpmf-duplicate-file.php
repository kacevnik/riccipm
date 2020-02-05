<?php

class Wpmf_duplicate_file {

    function __construct() {
        add_action('wp_enqueue_media',array($this , "wpmf_enqueue_admin_scripts"));
        add_filter("attachment_fields_to_edit", array($this, "wpmf_attachment_fields_to_edit"), 100, 2);
        add_action('wp_ajax_wpmf_duplicate_file',array($this,'wpmf_duplicate_file'));
    }
    
    function wpmf_enqueue_admin_scripts() {
        global $pagenow,$current_screen;
        if(!current_user_can('upload_files')) return;
        if(is_admin() && ($current_screen->base == 'settings_page_option-folder' || $pagenow == 'media-new.php')) return;
        wp_enqueue_script('duplicate-image');
        wp_enqueue_style('duplicate-style', plugins_url('assets/css/style_duplicate_file.css', dirname(__FILE__)),array(), WPMF_VERSION);
    }
    
    function wpmf_attachment_fields_to_edit($form_fields, $post) {
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            return $form_fields;
        }
        $form_fields['wpmfduplicate'] = array(
                'label' => '',
                'input' => 'html',
                'html' => '<div class="wpmf_wrap_duplicate"><input type="submit" value="' . __('Duplicate', 'wpmf') . '" class="button-primary wpmf_btn_duplicate"/><span class="spinner wpmf_spinner_duplicate"></span><p class="wpmf_message_duplicate"></p></div>'
            );
        
        return $form_fields;
    }
    
    public function wpmf_duplicate_file(){
        if(isset($_POST['id'])){
            $post = get_post($_POST['id']);
            if(empty($post)) wp_send_json(array('status' => false , 'message' => __('This post is not exists','wpmf')));
            $terms_parent = get_the_terms($post,WPMF_TAXO);
            $alt_post = get_post_meta($_POST['id'], '_wp_attachment_image_alt');
            $file_path = get_attached_file($_POST['id']);
            if(!file_exists($file_path)) wp_send_json(array('status' => false , 'message' => __('File is not exists','wpmf')));
            $infos_url = pathinfo($post->guid);
            $mime_type = get_post_mime_type( $_POST['id'] );
            $infos_path = pathinfo($file_path);
            $name = $infos_path['basename'];
            $uploads = wp_upload_dir();
            $content = @file_get_contents($file_path);
            $filename = wp_unique_filename( $uploads['path'], $name );
            $upload = file_put_contents($infos_path['dirname'].'/'.$filename, $content);
            if($upload){
                $attachment = array(
                    'guid' => $infos_url['dirname'].'/'. $filename,
                    'post_mime_type' => $mime_type,
                    'post_title' => $post->post_title,
                    'post_content' => $post->post_content,
                    'post_excerpt' => $post->post_excerpt,
                    'post_status' => 'inherit'
                );

                // insert attachment
                $attach_id = wp_insert_attachment($attachment,$infos_path['dirname'].'/'.$filename);
                $attach_data = wp_generate_attachment_metadata($attach_id,$infos_path['dirname'].'/'.$filename);
                wp_update_attachment_metadata($attach_id, $attach_data);
                update_post_meta($attach_id, '_wp_attachment_image_alt', $alt_post);
                
                // set term
                if(!empty($terms_parent)){
                    foreach ($terms_parent as $term){
                        wp_set_object_terms($attach_id, $term->term_id, WPMF_TAXO , true);
                    }
                }
                wp_send_json(array('status' => true , 'message' => __('Duplicated file ','wpmf').$name));
            }
            wp_send_json(array('status' => false , 'message' => __('Error duplicated file','wpmf')));
        }
    }

}