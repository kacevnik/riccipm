<?php

class Wp_Media_Folder{
    
            function __construct() {
        add_action('init', array($this, 'wpmf_session_start'), 1);
        add_action('init', array($this, 'wpmf_load_langguage'), 1);
        if(is_plugin_active('wp-sweep/wp-sweep.php')){
            add_action('admin_init', array($this, 'wpmf_update_count_term'));
        }
        
        if(!get_option('_wpmf_import_notice_flag', false)){
                add_action( 'admin_notices', array($this, 'wpmf_whow_notice'), 3 );
        }
        
        if(!get_option('wpmf_use_taxonomy', false)){
                add_option('wpmf_use_taxonomy', 1, '', 'yes' );
        }
        add_action( 'wp_ajax_wpmf_import', array($this,'wpmf_import_categories') );
        add_action( 'restrict_manage_posts', array($this, 'wpmf_add_image_category_filter') );
        add_action('pre_get_posts', array($this, 'wpmf_pre_get_posts1'));
        global $pagenow;
        if($pagenow == 'upload.php'){
            add_action( 'admin_enqueue_scripts', array($this, 'wpmf_load_custom_wp_admin_script') );
        }
        add_action( 'wp_enqueue_media', array($this, 'wpmf_load_custom_wp_admin_script') );
        if ( is_admin() ){
            add_action( 'admin_head', array($this, 'wpmf_admin_head'));
        }
        add_action( 'pre_get_posts', array($this, 'wpmf_pre_get_posts') , 0, 1 );
        add_action('wp_ajax_change_folder', array($this, 'wpmf_change_folder'));
        add_filter( 'wp_generate_attachment_metadata', array($this, 'wpmf_after_upload'), 10, 2 );
        add_action('wp_ajax_add_folder', array($this, 'wpmf_add_folder') );
        add_action('wp_ajax_edit_folder', array($this, 'wpmf_edit_folder') );
        add_action('wp_ajax_delete_folder', array($this, 'wpmf_delete_folder') );
        add_action('wp_ajax_move_file', array($this, 'wpmf_move_file') );
        add_action('wp_ajax_move_folder', array($this, 'wpmf_move_folder') );
        add_action('wp_ajax_get_terms', array($this, 'wpmf_get_terms') );
        add_action('admin_footer', array($this,'add_editor_footer'));
        add_action('wp_ajax_wpmf_change_view', array($this,'wpmf_change_view'));
        add_action('wp_ajax_wpmf_remove_view', array($this,'wpmf_remove_view'));
        add_action('wp_ajax_wpmf_gallery_get_image', array($this,'wpmf_gallery_get_image'));
        add_action( 'shutdown', array($this,'wpmf_svgs_thumbs_filter'), 0 );
        add_filter( 'wpmf_afinal_output', array($this,'wpmf_svgs_final_output'));
        add_filter( 'upload_mimes', array($this,'wpmf_svgs_upload_mimes'));
    }
    
    public function wpmf_update_count_term(){
        global $wpdb;
        $terms = get_terms( WPMF_TAXO, array('hide_empty'=> false));	
        if(!empty($terms)){
            foreach ($terms as $term){
                $object_in_term = get_objects_in_term($term->term_id, WPMF_TAXO);
                $count_object = count($object_in_term);
                $term_child = get_term_children($term->term_id, WPMF_TAXO);
                $count_term_child = count($term_child);
                $count = $count_object + $count_term_child;
                $wpdb->update( $wpdb->term_taxonomy, compact( 'count' ), array( 'term_taxonomy_id' => $term->term_id ) );
            }
        }
    }
    
    public function wpmf_svgs_upload_mimes($mimes = array()) {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
        return $mimes;
    }
	
    public function wpmf_svgs_thumbs_filter() {

        $final = '';
        $ob_levels = count( ob_get_level() );

        for ( $i = 0; $i < $ob_levels; $i++ ) {

            $final .= ob_get_clean();

        }
        echo apply_filters( 'wpmf_afinal_output', $final );
    }


    public function wpmf_svgs_final_output( $content ) {
        $content = str_replace(
                '<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
                '<# } else if ( \'svg+xml\' === data.subtype ) { #>
                        <img class="details-image" src="{{ data.url }}" draggable="false" />
                        <# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',

                $content
        );

        $content = str_replace(
                '<# } else if ( \'image\' === data.type && data.sizes ) { #>',
                '<# } else if ( \'svg+xml\' === data.subtype ) { #>
                        <div class="centered">
                                <img src="{{ data.url }}" class="thumbnail" draggable="false" />
                        </div>
                <# } else if ( \'image\' === data.type && data.sizes ) { #>',

                $content
        );

        return $content;
    }
    
    public function wpmf_gallery_get_image(){
        global $wpdb;
        
        if(!empty($_POST['ids']) && isset($_POST['wpmf_orderby']) && isset($_POST['wpmf_order'])){
            $ids = $_POST['ids'];
            $wpmf_orderby = $_POST['wpmf_orderby'];
            $wpmf_order = $_POST['wpmf_order'];
            if($wpmf_orderby == 'title' || $wpmf_orderby == 'date'){
                $wpmf_orderby = 'post_'.$wpmf_orderby;
                $posts = $wpdb->get_results("SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type='attachment' AND ID IN ($ids) ORDER BY $wpmf_orderby $wpmf_order");
                wp_send_json($posts);
            }
            
            wp_send_json(false);
            
        }
        
        wp_send_json(false);
        
    }
    
    public function wpmf_load_langguage(){
        $domain = 'wpmf';
        $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
        load_plugin_textdomain( $domain, false, dirname( plugin_basename( WPMF_FILE ) ) . '/languages/' );
    }


    public function wpmf_session_start() {
        ob_start();
        if ( ! session_id() ) {
           @session_start();
        }
     }
    
    public function wpmf_load_custom_wp_admin_script() {
        global $pagenow,$current_screen;
        if(!current_user_can('upload_files')) return;
        if(is_admin() && ($current_screen->base == 'settings_page_option-folder' || $pagenow == 'media-new.php')) return;
        
        wp_enqueue_script('jquery');
        wp_enqueue_script( array('jquery-ui-draggable','jquery-ui-droppable') );
        wp_register_script('wpmf-script', plugins_url( '/assets/js/script.js', dirname(__FILE__) ),array('jquery','plupload'),WPMF_VERSION);
        wp_enqueue_script('wpmf-script');
        
        wp_register_script('wpmf-filter-display-media', plugins_url( '/assets/js/wpmf-display-media.js', dirname(__FILE__) ),array('jquery','plupload'),WPMF_VERSION);
        wp_register_script('duplicate-image', plugins_url('assets/js/duplicate-image.js', dirname(__FILE__)), array('jquery'), WPMF_VERSION, true);
        wp_register_script('wpmf-fillter-size', plugins_url( '/assets/js/fillter-size.js', dirname(__FILE__) ),array('jquery','plupload'),WPMF_VERSION);
        wp_register_script('wpmf-bg_folder', plugins_url( '/assets/js/wpmf-background-folder.js', dirname(__FILE__) ),array('jquery','plupload'),WPMF_VERSION);
        
        wp_localize_script('wpmf-script', 'wpmflang', $this->wpmf_localize_script());
        wp_localize_script('wpmf-filter-display-media', 'wpmflang', $this->wpmf_localize_script());
        wp_localize_script('duplicate-image', 'wpmflang', $this->wpmf_localize_script());
        wp_localize_script('wpmf-fillter-size', 'wpmflang', $this->wpmf_localize_script());
        
        if(is_admin()){
            if($pagenow == 'customize.php' || $current_screen->base == 'toplevel_page_wptm'){
                $this->wpmf_admin_head();
            }
        }else{
            $this->wpmf_admin_head();
        }
        wp_enqueue_style('wpmf-jaofiletree',plugins_url( '/assets/css/jaofiletree.css', dirname(__FILE__) ),array(), WPMF_VERSION);
        wp_enqueue_style('wpmf-material-design-iconic-font.min',plugins_url( '/assets/css/material-design-iconic-font.min.css', dirname(__FILE__) ),array(), WPMF_VERSION);
        wp_enqueue_style('wpmf-style',plugins_url( '/assets/css/style.css', dirname(__FILE__) ),array(), WPMF_VERSION);   
    }
    
    public function wpmf_localize_script(){
        global $pagenow;
        $option_override = get_option('wpmf_option_override');
        $option_duplicate = get_option('wpmf_option_duplicate');
        $filetype = $this->wpmf_get_filetype();
        $zip = array('zip','rar','ace','arj','bz2','cab','gzip','iso','jar','lzh','tar','uue','xz','z','7-zip');
        $pdf = array('pdf');
        $count_zip = $this->wpmf_count_ext($zip,'application');
        $count_pdf = $this->wpmf_count_ext($pdf,'application/pdf');
        
        $wpmfdisplay_media = array('yes' => 'Yes');
        if(isset($_SESSION['wpmf_display_media'])){
            $display = $_SESSION['wpmf_display_media'];
        }else{
            $display = '';
        }
        
        $terms = $this->get_attachment_terms();
        $parents_array = $this->get_parrents_array($terms['attachment_terms']);
        $usegellery = get_option('wpmf_usegellery'); 
        $get_plugin_enhanced_media = strpos(json_encode(get_option( 'active_plugins' )),'enhanced-media-library.php' );
        $option_media_remove = get_option('wpmf_option_media_remove');
        $option_seach = get_option('wpmf_option_searchall');
        
        $curent_view = $this->wpmf_get_media_view();
        $cook_order_media = $this->wpmf_get_cookie_media($pagenow,$curent_view);
        $cook_order_f = $this->wpmf_get_cookie_folder();
        $s_dimensions = get_option('wpmf_selected_dimension');
        $size = json_decode($s_dimensions);
        $s_weights = get_option('wpmf_weight_selected');
        $weight = json_decode($s_weights);
        $order_folder = array('name-ASC' => __('Name (Ascending)','wpmf'),'name-DESC' => __('Name (Descending)','wpmf'),'id-ASC' => __('ID (Ascending)','wpmf') ,'id-DESC' => __('ID (Descending)','wpmf'));
        $order_media = array('date|asc' => __('Date (Ascending)','wpmf'),
                            'date|desc' => __('Date (Descending)','wpmf'),
                            'title|asc' => __('Title (Ascending)','wpmf'),
                            'title|desc' => __('Title (Descending)','wpmf'),
                            'size|asc' => __('Size (Ascending)','wpmf'),
                            'size|desc' => __('Size (Descending)','wpmf'),
                            'filetype|asc' => __('File type (Ascending)','wpmf'),
                            'filetype|desc' => __('File type (Descending)','wpmf'),
            );
        if(isset($_SESSION['wpmf_folder_order']) && isset($_SESSION['wpmf_folder_orderby'])){
            $order_selected = $_SESSION['wpmf_folder_orderby'].'-'.$_SESSION['wpmf_folder_order'];
        }else{
            $order_selected = 'name-asc';
        }
        
        return array(
                'create_folder' => __('Create Folder', 'wpmf'),
                'media_folder' =>__('Media Library', 'wpmf'),
                'promt' => __('Please give a name to this new folder', 'wpmf'),
                'new_folder' => __('New folder','wpmf'),
                'alert_add' => __('A term with the name and slug already exists with this parent.','wpmf'),
                'alert_delete' => __('Are you sure to want to delete this folder','wpmf'),
                'alert_delete_all' => __('This folder contains other sub folders and files. Are you sure want to delete it ?','wpmf'),
                'alert_delete1' => __('this folder contains sub-folder, delete sub-folders before','wpmf'),
                'display_media' => __('Display only my own media','wpmf'),
                'create_gallery_folder'=> __('Create a gallery from folder','wpmf'),
                'home' => __('Home','wpmf'),
                'youarehere' => __('You are here','wpmf'),
                'back' => __('Back','wpmf'),
                'dragdrop' => __('Drag and Drop me hover a folder','wpmf'),
                'smallview' => __('Small View','wpmf'),
                'pdf' => __('PDF','wpmf'),
                'zip' => __('Zip & archives','wpmf'),
                'other' => __('Other','wpmf'),
                'error_replace' => __('To replace a media and keep the link to this media working, it must be in the same format, ie. jpg > jpg, zip > zip� Thanks!','wpmf'),
                'uploaded_to_this' => __('Uploaded to this ','wpmf'),
                'mimetype' => __('All media items','wpmf'),
                'override' => $option_override,
                'duplicate' => $option_duplicate,
                'wpmf_file' => $filetype,
                'wpmfcount_zip' => $count_zip,
                'wpmfcount_pdf' => $count_pdf,
                'wpmf_display_media' => json_encode($wpmfdisplay_media),
                'no_media_label' => __('No','wpmf'),
                'yes_media_label' => __('Yes','wpmf'),
                'wpmf_selected_dmedia' => $display,
                'wpmf_categories' => $terms['attachment_terms'] ,
                'wpmf_categories_order' => $terms['attachment_terms_order'],
                'parents_array' => $parents_array,
                'wpmf_images_path' => plugins_url( 'assets/images', dirname(__FILE__) ),
                'taxo' => $terms['taxo'],
                'wpmf_role' => $terms['role'],
                'wpmf_active_media' => $terms['wpmf_active_media'],
                'term_root_username' => $terms['term_root_username'],
                'term_root_id' => $terms['term_root_id'],
                'wpmf_pagenow' => $terms['wpmf_pagenow'],
                'usegellery' => $usegellery,
                'enhanced_media_plugin' => $get_plugin_enhanced_media,
                'wpmf_post_type' => $terms['wpmf_post_type'],
                'wpmf_curent_userid' => get_current_user_id(),
                'wpmf_post_mime_type' => $terms['post_mime_types'],
                'wpmf_type' => $terms['post_type'],
                'wpmfview' => @$terms['wpmfview'],
                'site_url' => get_site_url().'/wp-admin/upload.php?mode=grid',
                'useorder' => $terms['useorder'],
                'wpmf_remove_media' => @$option_media_remove,
                'wpmf_search' => $option_seach,
                'ajaxurl' => admin_url('admin-ajax.php'),
                'wpmf_search' => $option_seach,
                'wpmf_size' => $size,
                'size' => @$_GET['attachment_size'],
                'wpmf_weight' => $weight,
                'weight' => @$_GET['attachment_weight'],
                'order_folder' => $order_folder,
                'order_media' => $order_media,
                'order_f' => $order_selected,
                'wpmf_order_media' => $cook_order_media,
                'wpmf_order_f' => $cook_order_f,
            );
    }
    
    public function get_parrents_array($attachment_terms) {
        $wcat = isset($_GET['wcat'])?$_GET['wcat']:'0';
        $parents = array();
        $pCat = (int)$wcat;
        while($pCat != 0 ) {
            $parents[]  = $pCat;
            $pCat = (int)$attachment_terms[$pCat]['parent_id'];                        
        }
        
        $parents_array = array_reverse($parents);
        return $parents_array;
    }
    
    public function get_attachment_terms(){
        global $pagenow , $current_user , $post;
        $taxo = $this->wpmf_get_taxonomy();
        $attachment_terms = array();
	$terms = get_categories(array('hide_empty'=>false,'taxonomy'=>$taxo , 'pll_get_terms_not_translated' =>1));
	$terms = $this->generatePageTree($terms);
	$terms = $this->parent_sort($terms);
        $term_rootId = 0;
        
        $attachment_terms_order= array();
        $wpmf_create_folder = get_option('wpmf_create_folder');
        $wpmf_active_media = get_option('wpmf_active_media');
        $user_roles = $current_user->roles;
        $role = array_shift($user_roles);
        $term_root_username = '';
        $wpmf_create_folder = get_option('wpmf_create_folder');
        if($role == 'administrator' || $wpmf_active_media == 0){
            $attachment_terms[] = array( 'id' => 0, 'label' => __('No Categories','wpmf') , 'slug' => '' , 'parent_id' => 0);
            $attachment_terms_order[] = '0';
        }else{
            if($wpmf_create_folder == 'user'){
                $term_root_username = $current_user->user_login;
            }elseif($wpmf_create_folder == 'role'){
                $term_root_username = $role;
            }
            $wpmfterm = $this->wpmf_term_root();
            if(!empty($wpmfterm)){
                $term_rootId = $wpmfterm['term_rootId'];
                $term__label = $wpmfterm['term_label'];
                $term__parent = $wpmfterm['term_parent'];
                $term_slug = $wpmfterm['term_slug'];
                $attachment_terms[$term_rootId] = array( 'id' => $term_rootId, 'label' => $term__label , 'slug' => $term_slug , 'parent_id' => $term__parent);
                $attachment_terms_order[] = $term_rootId;
            }else{
                $attachment_terms[] = array( 'id' => 0, 'label' => __('No Categories','wpmf') , 'slug' => '' , 'parent_id' => 0);
                $attachment_terms_order[] = 0;
            }
        }
        
        if(isset($wpmf_active_media) && $wpmf_active_media == 1 && $role !='administrator'){
            $wpmfterm = $this->wpmf_term_root();
            if(!empty($wpmfterm)){
                $term_rootId = $wpmfterm['term_rootId'];
            }else{
                $term_rootId = 0;
            }
            
            $terms = get_categories(array('hide_empty'=>false,'parent' => $term_rootId,'taxonomy'=>$taxo));
            $current_role = $this->wpmf_get_roles(get_current_user_id());
            foreach ( $terms as $term ){
                if($wpmf_create_folder == 'user'){
                    if($term->term_group == get_current_user_id()){
                        if($term->name == $current_user->user_login || $term->category_parent !=0){
                            $attachment_terms[$term->term_id] = array( 'id' => $term->term_id, 'label' => $term->name, 'slug' => $term->slug, 'parent_id' => $term->category_parent, 'depth'=>$term->depth ,'term_group' => $term->term_group);
                            $attachment_terms_order[] = $term->term_id;
                        }
                    }
                }else{
                    $role = $this->wpmf_get_roles($term->term_group);
                    if($current_role == $role){
                        $attachment_terms[$term->term_id] = array( 'id' => $term->term_id, 'label' => $term->name, 'slug' => $term->slug, 'parent_id' => $term->category_parent, 'depth'=>$term->depth ,'term_group' => $term->term_group);
                        $attachment_terms_order[] = $term->term_id;
                    }
                }
                
            }
            
        }else{
            foreach ( $terms as $term ){
                $attachment_terms[$term->term_id] = array( 'id' => $term->term_id, 'label' => $term->name, 'slug' => $term->slug, 'parent_id' => $term->category_parent, 'depth'=>$term->depth , 'term_group' => $term->term_group);
                $attachment_terms_order[] = $term->term_id;
            }
        }
        
        $post_mime_types = get_post_mime_types();
        $useorder = get_option('wpmf_useorder');
        if(!$useorder || $useorder == 0 || $useorder == ''){
            unset($_SESSION['wpmfview']);
        }        
        
        global $post;
        if(!empty($post) && !empty($post->post_type)){
            $post_type = $post->post_type;
        }else{
            $post_type = '';
        }
 
        
        if(empty($_SESSION['wpmfview'])){
            $wpmfview = 'wpmf_default';
        }else{
            $wpmfview = $_SESSION['wpmfview'];
        }
        
        if(in_array('js_composer/js_composer.php', get_option('active_plugins'))){
            $wpmf_post_type = 1;
        }else{
            $wpmf_post_type = 0;
        }
        
        return array('role' => $role,
                'wpmf_active_media' => $wpmf_active_media,
                'taxo' => $taxo,
                'term_root_username' => $term_root_username,
                'term_root_id' => $term_rootId,
                'attachment_terms' => $attachment_terms ,
                'attachment_terms_order' => $attachment_terms_order,
                'wpmf_pagenow' => $pagenow,
                'post_mime_types' => $post_mime_types,
                'useorder' => $useorder,
                'post_type' => $post_type,
                'wpmfview' => $wpmfview,
                'wpmf_post_type' => $wpmf_post_type
            );
    }

    public function wpmf_whow_notice(){
        if(current_user_can('manage_options')){
            echo '<script type="text/javascript">'.PHP_EOL
                    . 'function importWpmfTaxonomy(doit,button){'.PHP_EOL
                        .'jQuery(button).find(".spinner").show().css({"visibility":"visible"});'.PHP_EOL
                        .'jQuery.post(ajaxurl, {action: "wpmf_import",doit:doit}, function(response) {'.PHP_EOL
                            .'jQuery(button).closest("div#wpmf_error").hide();'.PHP_EOL
                            .'if(doit===true){'.PHP_EOL
                                .'jQuery("#wpmf_error").after("<div class=\'updated\'> <p><strong>'. __('Categories imported into WP Media Folder. Enjoy!!!','wpmf') .'</strong></p></div>");'.PHP_EOL
                            .'}'.PHP_EOL
                        .'});'.PHP_EOL
                    . '}'.PHP_EOL
                . '</script>';
            echo '<div class="error" id="wpmf_error">'
                    . '<p>'
                    . __('You\'ve just installed WP Media Folder, to save your time we can import your media categories into WP Media Folder','wpmf')
                        . '<a href="#" class="button button-primary" style="margin: 0 5px;" onclick="importWpmfTaxonomy(true,this);" id="wmpfImportBtn">'.__('Import categories now','wpmf').' <span class="spinner" style="display:none"></span></a> or <a href="#" onclick="importWpmfTaxonomy(false,this);" style="margin: 0 5px;" class="button">'.__('No thanks ','wpmf').' <span class="spinner" style="display:none"></span></a>'
                    . '</p>'
                . '</div>';
        }
    }
    
    function wpmf_import_categories(){
        $option_import_taxo = get_option('_wpmf_import_notice_flag');
        if(isset($option_import_taxo) && $option_import_taxo == 'yes'){
            die();
        }
        if($_POST['doit']==='true'){
            $terms = get_terms( 'category', array(
                            'orderby'       => 'name',
                            'order'         => 'ASC',
                            'hide_empty'    => false,
                            'child_of'	=> 0
                    ) );

            $termsRel = array('0'=>0);
            foreach ($terms as $term) {
                $inserted = wp_insert_term($term->name, WPMF_TAXO,array('slug'=>wp_unique_term_slug($term->slug,$term)));
                if ( is_wp_error($inserted) ) {
                    wp_send_json($inserted->get_error_message());
                }
                $termsRel[$term->term_id] = $inserted['term_id'];
            }
            foreach ($terms as $term) {
                wp_update_term($termsRel[$term->term_id], WPMF_TAXO,array('parent'=>$termsRel[$term->parent]));
            }

            //update attachments
            $attachments = get_posts(array('posts_per_page'=>-1,'post_type'=>'attachment'));
            foreach ($attachments as $attachment) {
                $terms = wp_get_post_terms($attachment->ID,'category');
                $termsArray = array();
                foreach ($terms as $term) {
                    $termsArray[] = $termsRel[$term->term_id];
                }
                if($termsArray != null){
                    wp_set_post_terms( $attachment->ID, $termsArray, WPMF_TAXO);
                }
            }
        }
        if($_POST['doit']==='true'){
            update_option('_wpmf_import_notice_flag', 'yes');
        }else{
            update_option('_wpmf_import_notice_flag', 'no');
        }
        die();
    }
    
    public  function wpmf_add_image_category_filter() {
        global $pagenow;
        $taxo = $this->wpmf_get_taxonomy();
        if ( $pagenow == 'upload.php' ) {
            $wpmf_active_media = get_option('wpmf_active_media');
            $user_data = get_userdata( get_current_user_id() );
            $user_roles = $user_data->roles;
            $role = array_shift($user_roles);
            if($role != 'administrator' && $wpmf_active_media == 1){
                $wpmfterm = $this->wpmf_term_root();
                $term_rootId = $wpmfterm['term_rootId'];
                $term_label = $wpmfterm['term_label'];
                $dropdown_options = array( 'show_option_none'=> $term_label , 'option_none_value' => $term_rootId, 'hide_empty' => false, 'hierarchical' => true, 'orderby' => 'name', 'taxonomy'=>$taxo, 'class'=>'wpmf-categories', 'name' => 'wcat', 'selected' => (int)(isset($_GET['wcat'])?$_GET['wcat']:0) );
            }else{
                $dropdown_options = array( 'show_option_none'=> __( 'No Categories', 'wpmf' ) , 'option_none_value' => 0, 'hide_empty' => false, 'hierarchical' => true, 'orderby' => 'name', 'taxonomy'=>$taxo, 'class'=>'wpmf-categories', 'name' => 'wcat', 'selected' => (int)(isset($_GET['wcat'])?$_GET['wcat']:0) );
            }
            
            wp_dropdown_categories( $dropdown_options );
        }
    }
    
    public function wpmf_pre_get_posts1($query){
        global $pagenow;
        $option_seach = get_option('wpmf_option_searchall');
        $taxo = $this->wpmf_get_taxonomy();
        if ( $pagenow == 'upload.php' ) {
            if($option_seach == 0 || (empty($_GET['s']) && $option_seach==1)){
                if(isset($_GET['wcat']) && (int)$_GET['wcat']!==0){
                    $query->tax_query->queries[] = array(
                                'taxonomy' => $taxo,
                                'field'    => 'term_id',
                                'terms'    => (int)$_GET['wcat'],
                                'include_children' => false
                        );
                    $query->query_vars['tax_query'] = $query->tax_query->queries;
                }else{
                    $wpmf_active_media = get_option('wpmf_active_media');
                    $user_data = get_userdata( get_current_user_id() );
                    $user_roles = $user_data->roles;
                    $role = array_shift($user_roles);
                    if($wpmf_active_media == 1 && $role !='administrator'){
                        $wpmfterm = $this->wpmf_term_root();
                        $term_rootId = $wpmfterm['term_rootId'];
                        $query->tax_query->queries[] = array(
                                'taxonomy' => $taxo,
                                'field'    => 'term_id',
                                'terms'    => (int)$term_rootId,
                                'include_children' => false
                        );
                        $query->query_vars['tax_query'] = $query->tax_query->queries;
                    }else{
                        $terms = get_categories(array('hide_empty'=>false,'taxonomy'=>$taxo));
                        $cats = array();
                        foreach ($terms as $term) {
                            if(!empty($term->term_id)){
                                $cats[] = $term->term_id;
                            }
                        }
                        $query->tax_query->queries[] = array(
                                'taxonomy' => $taxo,
                                'field'    => 'term_id',
                                'terms'    => $cats,
                                'operator' => 'NOT IN',
                                'include_children' => false
                            );
                        $query->query_vars['tax_query'] = $query->tax_query->queries;
                    }
                }
            }
        }
    }
 
    function wpmf_admin_head(){  
        ?>
        <style>#wp-wpmf-editor-wrap{display:none !important;}</style>
        <?php
        if(!current_user_can('upload_files')) return;
        
        $option_seach = get_option('wpmf_option_searchall');
        $media_view = $this->wpmf_get_media_view();
        if(isset($_GET['s']) && $_GET['s'] != '' && $option_seach == 1 && $media_view == 'list'){
            echo '<style>.wpmf-attachments-browser{display:none !important;}</style>';
        }        
        
	?>
        <style>#wp-wpmf-editor-wrap{display:none !important;}</style>
	<?php
    }
    
    public function add_editor_footer() {
        wp_editor( '', 'wpmf-editor', array('media_buttons' => false,'editor_class' => 'wpmf-editor','tinymce' => false) );
    }
    
    public function getRecursiveTerms($taxonomy,$term=0){
        $terms = get_terms( $taxonomy, array(
                            'orderby'       => 'name',
                            'order'         => 'ASC',
                            'hide_empty'    => true,
                            'child_of'	=> $term
                    ) );
        return $terms;
    }
    
    public function wpmf_pre_get_posts( $query ){
        
        $option_seach = get_option('wpmf_option_searchall');
       $taxo = $this->wpmf_get_taxonomy();
       if ( !isset( $query->query_vars['post_type'] ) || $query->query_vars['post_type'] != 'attachment')
	       return;
  
        if(isset($_REQUEST['query']['orderby']) && $_REQUEST['query']['orderby'] == 'menu_order ID'){
            
        }else{
            $taxonomies = apply_filters( 'attachment-category', get_object_taxonomies('attachment', 'objects' ) );
            if ( !$taxonomies ) return;
            foreach ( $taxonomies as $taxonomyname => $taxonomy ) :
                if($taxonomyname == $taxo){
                     if($option_seach == 0 || (empty($_REQUEST['query']['s']) && $option_seach==1)){
                         if ( isset( $_REQUEST['query']['wpmf_taxonomy']) && $_REQUEST['query']['term_slug'] ){    
                             $query->set('tax_query', array(
                                 array(
                                     'taxonomy' => $taxonomyname,
                                     'field' => 'slug',
                                     'terms' => $_REQUEST['query']['term_slug'],
                                     'include_children' => false
                                     )
                                 )
                             );
                         }elseif ( isset( $_REQUEST[$taxonomyname] ) && is_numeric( $_REQUEST[$taxonomyname] ) && intval( $_REQUEST[$taxonomyname] ) != 0 ){
                                 $term = get_term_by( 'id', $_REQUEST[$taxonomyname], $taxonomyname );
                                 if ( is_object( $term ) )
                                         set_query_var( $taxonomyname, $term->slug );
                         }elseif(isset( $_REQUEST['query']['wpmf_taxonomy'] ) && $_REQUEST['query']['term_slug'] == ''){
                              $terms = get_terms($taxonomyname,array('hide_empty'=>false,'hierarchical'=>false));
                              $unsetTags = array();
                              foreach ($terms as $term){
                                  $unsetTags[] = $term->slug;
                              }
                              $query->set('tax_query', array(
                                      array(
                                          'taxonomy' => $taxonomyname,
                                          'field' => 'slug',
                                          'terms' => $unsetTags,
                                          'operator' => 'NOT IN',
                                          'include_children' => false,
                                          )
                                      )
                                  );
                         }
                     }
                }

            endforeach;
        }
       
        global $current_user, $wpdb;
        $user_roles = $current_user->roles;
        $role = array_shift($user_roles);
        $roles = array('administrator','editor','author');
        $wpmf_create_folder = get_option('wpmf_create_folder');
        $wpmf_active_media = get_option('wpmf_active_media');
        $id_author = get_current_user_id();
        
        if($role == 'administrator'){
            if(isset($_SESSION['wpmf_display_media']) && $_SESSION['wpmf_display_media'] == 'yes'){
                $query->query_vars['author'] = $id_author;
            }
        }elseif(isset($wpmf_active_media) && $wpmf_active_media == 1){
            if($wpmf_create_folder == 'user'){
                $query->query_vars['author'] = $id_author;
            }else{
                $current_role = $this->wpmf_get_roles(get_current_user_id());
                $user_query = new WP_User_Query( array( 'role' => $current_role ) );
                $user_lists = $user_query->get_results();
                $user_array = array();
                
                foreach ($user_lists as $user){
                    $user_array[] = $user->data->ID;
                }
                
                $query->query_vars['author__in'] = $user_array;
            }
        }
        
   return $query;
}
	
//add_filter( 'the_posts','wpmf_post_results'  );
public function wpmf_post_results($posts){   
    $taxo = $this->wpmf_get_taxonomy();
    if (defined('DOING_AJAX') && DOING_AJAX && $_REQUEST['action']==='query-attachments') {
	if ( isset( $_REQUEST['query']['category'] ) ){
	    $parent = $_REQUEST['query']['category']['term_id'];
	}else{
	    $parent = 0;
	}
	$terms = get_terms( $taxo, array(
			    'orderby'       => 'name',
			    'order'         => 'ASC',
			    'parent'	    => $parent,
			    'hide_empty'    => false
			    )
			);
	$ij = 1;
	if(!empty($terms)){
	    foreach ($terms as $term) {
		$post = new stdClass();
		$post->ID = -$ij;
		$post->comment_count = 0;
		$post->comment_status = 'open';
		$post->filter = 'raw';
		$post->guid = $term->name;
		$post->menu_order = 0;
		$post->ping_status = 'open';
		$post->pinged = '';
		$post->post_author = '1';
		$post->post_content = $term->name;
		$post->post_content_filtered = '';
		$post->post_date = '2014-10-02 03:49:36';
		$post->post_date_gmt = '2014-10-02 03:49:36';
		$post->post_excerpt = '';
		$post->post_mime_type = 'application/xxx-folder';
		$post->post_modified = '2014-10-02 03:49:36';
		$post->post_modified_gmt = '2014-10-02 03:49:36';
		$post->post_name = $term->slug;
		$post->post_parent = 0;
		$post->post_password = '';
		$post->post_status = 'inherit';
		$post->post_title = $term->name;
		$post->post_type = 'attachment';
		$post->to_ping = '';
		$post = new WP_Post($post);
		$ij++;
	    }	
	}
	array_splice($posts, 40);
    }
    return $posts;
}

    public function wpmf_change_folder(){  
        global $current_user;
        $wpmfjson = array();
        $id = (int)$_POST['id'] | 0;
        $_SESSION['wpmf-current-folder'] = $id;
        $taxo = Wp_Media_Folder::wpmf_get_taxonomy();
        
        if(isset($_COOKIE['wpmf_folder_order']) && empty($_SESSION['wpmf_folder_orderby']) && empty($_SESSION['wpmf_folder_order'])){
            $sortbys = explode('-', $_COOKIE['wpmf_folder_order']);
            $orderby = $sortbys[0];
            $order = $sortbys[1];
        }else{
            if(isset($_SESSION['wpmf_folder_orderby'])){
                $orderby = $_SESSION['wpmf_folder_orderby'];
            }else{
                $orderby = 'name';
            }

            if(isset($_SESSION['wpmf_folder_order'])){
                $order = $_SESSION['wpmf_folder_order'];
            }else{
                $order = 'ASC';
            }
        }
        
        $terms_child = get_terms( $taxo, array('orderby'=> $orderby,'order'=> $order,'parent'=> $id,'hide_empty'=> false));
        $wpmfjson['terms'] = array();
        
        $wpmf_create_folder = get_option('wpmf_create_folder');
        $wpmf_active_media = get_option('wpmf_active_media');
        $user_roles = $current_user->roles;
        $role = array_shift($user_roles);
        if(($role !='administrator' && isset($wpmf_active_media) && $wpmf_active_media == 1) || ($role =='administrator' && isset($_SESSION['wpmf_display_media']) && $_SESSION['wpmf_display_media'] =='yes')){
            $id1 = array();
            $current_role = $this->wpmf_get_roles(get_current_user_id());
            foreach ($terms_child as $term){
                
                if($wpmf_create_folder == 'user'){
                    if($term->term_group == get_current_user_id()){
                        $wpmfjson['terms'][] = $term;
                        $id1[] = $term->term_id;
                    }
                }else{
                    $role = $this->wpmf_get_roles($term->term_group);
                    if($current_role == $role){
                        $wpmfjson['terms'][] = $term;
                        $id1[] = $term->term_id;
                    }
                }
            }
            $wpmfjson['id1'] = $id1;
        }else{
            $wpmfjson['terms'] = $terms_child;
        }
        $option_bgfolder = get_option('wpmf_field_bgfolder');
        $wpmfjson['option_bgfolder'] = $option_bgfolder;
        wp_send_json($wpmfjson);
    }

    /* */
    public function wpmf_after_upload($metadata, $attachment_id) {
        $taxo = $this->wpmf_get_taxonomy();
        $parent = isset($_SESSION['wpmf-current-folder']) ?(int)$_SESSION['wpmf-current-folder']: 0;
        
        $post_upload = get_post($attachment_id);
        if(!empty($post_upload) && strpos($post_upload->post_content, 'wpmf-nextgen-image') == false && strpos($post_upload->post_content, '[wpmf-ftp-import]') == false){
            if($parent){
                wp_set_object_terms($attachment_id,$parent,$taxo,true);
            }
        }
        
        
        if(!empty($attachment_id)){
            $this->wpmf_add_sizefiletype($attachment_id);
            $this->wpmf_add_attachment_langguages($attachment_id,$parent,$taxo);
        }
        
        return $metadata;
    }
    
    public function wpmf_add_attachment_langguages($attachment_id,$parent,$taxo) {
        if(defined('ICL_SITEPRESS_VERSION')){
            global $wpdb,$sitepress;
            $trid = $sitepress->get_element_trid( $attachment_id, 'post_attachment' );
            if ( $trid ) {
                    $translations = $sitepress->get_element_translations( $trid, 'post_attachment', true, true, true );
                    foreach ( $translations as $translation ) {
				if ( $translation->element_id != $attachment_id ) {
                                    wp_set_object_terms($translation->element_id,$parent,$taxo,true);
                                    $this->wpmf_add_sizefiletype($translation->element_id);
                                }
                    }
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
    
    public function wpmf_add_sizefiletype($attachment_id){
        $wpmf_size_filetype = $this->wpmf_get_sizefiletype($attachment_id);
        $size = $wpmf_size_filetype['size'];
        $ext = $wpmf_size_filetype['ext'];
        if(!get_post_meta($attachment_id,'wpmf_size')){
            add_post_meta( $attachment_id, 'wpmf_size', $size ); 
        }

        if(!get_post_meta($attachment_id,'wpmf_filetype')){
            add_post_meta( $attachment_id, 'wpmf_filetype', $ext ); 
        }
    }

    /** Add a new folder via ajax **/
    public function wpmf_add_folder(){
        $taxo = $this->wpmf_get_taxonomy();
        if(isset($_POST['name']) && $_POST['name']){
            $term = esc_attr($_POST['name']);
        }else{
            $term = __('New folder','wpmf');
        }
        $termParent = (int)$_POST['parent'] | 0;
        $id_author = get_current_user_id();
        $inserted = wp_insert_term($term, $taxo,array('parent'=>$termParent));
        if ( is_wp_error($inserted) ) {
            // oops WP_Error obj returned, so the term existed prior
            wp_send_json($inserted->get_error_message());
        }else{
            $updateted = wp_update_term( $inserted['term_id'], $taxo, array('term_group' => $id_author) );
            $termInfos = get_term($updateted['term_id'],$taxo);
            wp_send_json($termInfos);
        }
    }


    /** Edit folder via ajax **/
    public function wpmf_edit_folder(){
        $taxo = $this->wpmf_get_taxonomy();
        $term = esc_attr($_POST['name']);
        if(!$term){
            return;
        }     
        //check duplicate name
        $siblings = get_terms($taxo, array('fields' => 'names', 'get' => 'all', 'parent' => (int)$_POST['parent_id']));
        if (in_array($term, $siblings)) {
            return wp_send_json(false);
        }
        $termInfos = wp_update_term((int)$_POST['id'],$taxo,array('name'=>$term));     
         if($termInfos instanceof WP_Error){
            wp_send_json($termInfos->get_error_messages());
        }else{
             $termInfos = get_term($termInfos['term_id'],$taxo);
            wp_send_json($termInfos);
        }    
    //   
    }

    /** Edit folder via ajax **/
    public function wpmf_delete_folder(){
        $taxo = $this->wpmf_get_taxonomy();
        $option_media_remove = get_option('wpmf_option_media_remove');
        $bgfolder = get_option('wpmf_field_bgfolder');
        $wpmf_list_sync_media = get_option('wpmf_list_sync_media');
        $wpmf_ao_lastRun = get_option('wpmf_ao_lastRun');
        if($option_media_remove == 1){
            $childs = get_term_children((int)$_POST['id'],$taxo);
            $childs[] = (int)$_POST['id'];

            foreach ($childs as $child){
                $childs_media = get_objects_in_term($child, $taxo);
                foreach ($childs_media as $media){
                    wp_delete_attachment($media);
                }
                if(isset($bgfolder[$child])) unset($bgfolder[$child]);
                wp_delete_term($child,$taxo);
                if(isset($wpmf_list_sync_media[$child])) unset($wpmf_list_sync_media[$child]);
                if(isset($wpmf_ao_lastRun[$child])) unset($wpmf_ao_lastRun[$child]);
            }
            update_option('wpmf_list_sync_media', $wpmf_list_sync_media);
            update_option('wpmf_ao_lastRun', $wpmf_ao_lastRun);
            update_option('wpmf_field_bgfolder', $bgfolder);
            wp_send_json(array('type' => 'all' , 'fids' => $childs));
        }else{
            $childs = get_term_children((int)$_POST['id'],$taxo);
            if(is_array($childs) && count($childs)>0){
                wp_send_json(array('type' => 'one','status' => false));
            }else{
                $child = get_term_children((int)$_POST['parent'],$taxo);
                if(isset($wpmf_list_sync_media[(int)$_POST['id']])) unset($wpmf_list_sync_media[(int)$_POST['id']]);
                if(isset($wpmf_ao_lastRun[(int)$_POST['id']])) unset($wpmf_ao_lastRun[(int)$_POST['id']]);
                if(isset($bgfolder[(int)$_POST['id']])) unset($bgfolder[(int)$_POST['id']]);
                update_option('wpmf_field_bgfolder', $bgfolder);	
                update_option('wpmf_list_sync_media', $wpmf_list_sync_media);
                update_option('wpmf_ao_lastRun', $wpmf_ao_lastRun);
                wp_send_json(array('type' => 'one','status' => wp_delete_term((int)$_POST['id'],$taxo),'count_child' => count($child)));
            }
        }
    }

    /** Move a file via ajax **/
    public function wpmf_move_file(){
        
        $taxo = $this->wpmf_get_taxonomy();
        $return = true;
        $ids = explode(',', $_POST['ids']);
        foreach ($ids as $id){
            if(defined('ICL_SITEPRESS_VERSION')){
                global $sitepress;
                $trid = $sitepress->get_element_trid( $id, 'post_attachment' );
                if ( $trid ) {
                    $translations = $sitepress->get_element_translations( $trid, 'post_attachment', true, true, true );
                    foreach ( $translations as $translation ) {
                        if ( $translation->element_id != $id ) {
                            wp_delete_object_term_relationships((int)$translation->element_id, $taxo);
                            wp_set_object_terms((int)$translation->element_id,(int)$_POST['id_category'],$taxo,true);
                        }
                    }
                }
            }
            
            wp_delete_object_term_relationships((int)$id, $taxo);
            if((int)$_POST['id_category'] === 0 || wp_set_object_terms((int)$id,(int)$_POST['id_category'],$taxo,true)){

            }else{
                $return = false;
            }
        }
        wp_send_json($return);
    }

    /** Move a folder via ajax **/
    public function wpmf_move_folder(){
        $_SESSION['wpmf_child'] = array();
        $this->get_folder_child($_POST['id']);
        if(in_array((int)$_POST['id_category'], $_SESSION['wpmf_child'])){
            unset($_SESSION['wpmf_child']);
            return wp_send_json(array('status' => false, 'wrong' => 'wrong'));
        }
        
        $taxo = $this->wpmf_get_taxonomy();
        //check duplicate name
        $term = esc_attr($_POST['name']);
        $siblings = get_terms($taxo, array('fields' => 'names', 'get' => 'all', 'parent' => (int)$_POST['id_category']));
        if (in_array($term, $siblings)) {
            return wp_send_json(false);
        }

        $r = wp_update_term((int)$_POST['id'],$taxo,array('parent'=>(int)$_POST['id_category']));
        if($r instanceof WP_Error){
            wp_send_json(false);
        }else{
            $child_id = get_term_children((int)$_POST['id'],$taxo);
            $child_id_category = get_term_children((int)$_POST['id_category'],$taxo);
            $child_parent_id = get_term_children((int)$_POST['parent_id'],$taxo);
            wp_send_json(array('status' => true, 'count_id'=>count($child_id), 'id_category'=>count($child_id_category), 'parent_id'=>count($child_parent_id),));
        }    
    }

    public function generatePageTree($datas, $parent = 0, $depth=0, $limit=0){
            if($limit > 1000) return ''; // Make sure not to have an endless recursion
            $tree = array();
            for($i=0, $ni=count($datas); $i < $ni; $i++){
                if(!empty($datas[$i])){
                    if($datas[$i]->parent == $parent){
                        //$datas[$i]->name = str_repeat('&nbsp;&nbsp;',$depth).$datas[$i]->name;
                        $datas[$i]->name = $datas[$i]->name;
                        $datas[$i]->depth = $depth;
                        $tree[] = $datas[$i];
                        $t = $this->generatePageTree($datas, $datas[$i]->term_id, $depth+1, $limit++);
                            $tree = array_merge($tree,$t);
                    }
                }
            }
            return $tree;
    }

    /**
     * sort parents before children
     * http://stackoverflow.com/questions/6377147/sort-an-array-placing-children-beneath-parents
     *
     * @param array   $objects input objects with attributes 'id' and 'parent'
     * @param array   $result  (optional, reference) internal
     * @param integer $parent  (optional) internal
     * @param integer $depth   (optional) internal
     * @return array           output
     */
    public function parent_sort(array $objects, array &$result=array(), $parent=0, $depth=0) {
        foreach ($objects as $key => $object) {
            if ($object->parent == $parent) {
                $object->depth = $depth;
                array_push($result, $object);
                unset($objects[$key]);
                $this->parent_sort($objects, $result, $object->term_id, $depth + 1);
            }
        }
        return $result;
    }

    //Folder tree
    public function wpmf_get_terms(){
        global $current_user;
        $taxo = $this->wpmf_get_taxonomy();
        $dir = '/';
        if (!empty($_GET['dir'])) {
            $dir = $_GET['dir'];
            if ($dir[0] == '/') {
                $dir = '.' . $dir . '/';
            }
        }
        $dir = str_replace('..', '', $dir);
        $root = dirname(__FILE__) . '/../';
        $dirs = $fi = array();
        $id = 0;
        if(!empty($_GET['id'])){
            $id = (int)$_GET['id'];
        }
        
        if(isset($_COOKIE['wpmf_folder_order']) && empty($_SESSION['wpmf_folder_orderby']) && empty($_SESSION['wpmf_folder_order'])){
            $sortbys = explode('-', $_COOKIE['wpmf_folder_order']);
            $orderby = $sortbys[0];
            $order = $sortbys[1];
        }else{
            if(isset($_SESSION['wpmf_folder_orderby'])){
                $orderby = $_SESSION['wpmf_folder_orderby'];
            }else{
                $orderby = 'name';
            }

            if(isset($_SESSION['wpmf_folder_order'])){
                $order = $_SESSION['wpmf_folder_order'];
            }else{
                $order = 'ASC';
            }
        }
        
        $files = get_terms( $taxo, array('orderby'=> $orderby,'order'=> $order,'parent'=> $id,'hide_empty'=> false));
        $wpmf_active_media = get_option('wpmf_active_media');
        $wpmf_create_folder = get_option('wpmf_create_folder');
        $user_roles = $current_user->roles;
        $role = array_shift($user_roles);
        $current_role = $this->wpmf_get_roles(get_current_user_id());
        foreach ($files as $file) {
            if(($role !='administrator' && isset($wpmf_active_media) && $wpmf_active_media == 1) || ($role =='administrator' && isset($_SESSION['wpmf_display_media']) && $_SESSION['wpmf_display_media'] =='yes')){
                if($wpmf_create_folder == 'user'){
                    if($file->term_group == get_current_user_id()){
                        $child = get_term_children((int)$file->term_id,$taxo);
                        $countchild = count($child);
                        $dirs[] = array('type' => 'dir', 'dir' => $dir, 'file' => $file->name ,'id' => $file->term_id,'parent_id' => $file->parent,'count_child' => $countchild , 'term_group' => $file->term_group);
                    }
                }else{
                    $role = $this->wpmf_get_roles($file->term_group);
                    if($current_role == $role){
                        $dirs[] = array('type' => 'dir', 'dir' => $dir, 'file' => $file->name ,'id' => $file->term_id,'parent_id' => $file->parent,'count_child' => $countchild , 'term_group' => $file->term_group);
                    }
                }
            }else{
                $child = get_term_children((int)$file->term_id,$taxo);
                $countchild = count($child);
                $dirs[] = array('type' => 'dir', 'dir' => $dir, 'file' => $file->name ,'id' => $file->term_id,'parent_id' => $file->parent,'count_child' => $countchild , 'term_group' => $file->term_group);
            }
        }
        
        if(count($dirs)<0){
            wp_send_json('not empty');
        }else{
            wp_send_json($dirs);
        }
    }
    
    public function wpmf_get_roles($userId){
        $userdata = get_userdata($userId);
        $role = $userdata->roles[0];
        return $role;
    }


    public static function wpmf_get_taxonomy() {
        $taxo = WPMF_TAXO;
        return $taxo;
    }
    
    public function wpmf_term_root(){
        global $current_user;
        $taxo = $this->wpmf_get_taxonomy();
        $term_roots = get_terms( $taxo, array('parent'=> 0 , 'hide_empty'=> false));	
        $wpmfterm = array();
        
        $user_roles = $current_user->roles;
        $role = array_shift($user_roles);
        if(count($term_roots) > 0 ){
            $wpmf_create_folder = get_option('wpmf_create_folder');
            if($wpmf_create_folder == 'user'){
                foreach ($term_roots as $term){
                    if($term->name == $current_user->user_login && $term->term_group == get_current_user_id()){
                        $wpmfterm['term_rootId'] = $term->term_id;
                        $wpmfterm['term_label'] = $term->name;
                        $wpmfterm['term_parent'] = $term->parent;
                        $wpmfterm['term_slug'] = $term->slug;
                    }
                }
            }else{
                foreach ($term_roots as $term){
                    if($term->name == $role && strpos($term->slug, '-wpmf-role') != false){
                        $wpmfterm['term_rootId'] = $term->term_id;
                        $wpmfterm['term_label'] = $term->name;
                        $wpmfterm['term_parent'] = $term->parent;
                        $wpmfterm['term_slug'] = $term->slug;
                    }
                }
            }
        }
        return $wpmfterm;
    }
    
    public function wpmf_remove_view(){
        if(isset($_SESSION['wpmfview'])){
            unset($_SESSION['wpmfview']);
        }
    }
    public function wpmf_change_view(){
        $_SESSION['wpmfview'] = 'small';
    }
    
    public function get_folder_child($id_parent){      
        $taxo = $this->wpmf_get_taxonomy();
        $folder_childs = get_terms( $taxo, array('parent'=> (int)$id_parent,'hide_empty'=> false));
        if(count($folder_childs) > 0 ){
            foreach ($folder_childs as $child){
                $_SESSION['wpmf_child'][] = $child->term_id;
                $this->get_folder_child($child->term_id);
            }
        }
    }
    
    public function wpmf_get_media_view(){
        global $wpdb;
        $views = get_user_meta(get_current_user_id(),$wpdb->prefix.'media_library_mode');
        if(!empty($views)){
            $curent_view = $views[0];
        }else{
            $curent_view = 'grid';
        }
        return $curent_view;
    }
    
    public function wpmf_count_ext($exts,$app){
        global $wpdb;
        $attachments = array();
        if($app == 'application/pdf'){
            $sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix.'posts'." WHERE post_type = %s AND post_mime_type= %s ",array('attachment','application/pdf'));
            $attachments = $wpdb->get_results($sql);
        }else{
            $sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix.'posts'." WHERE post_type = %s AND post_mime_type IN ('application/zip','application/rar','application/ace','application/arj','application/bz2','application/cab','application/gzip','application/iso','application/jar','application/lzh','application/tar','application/uue','application/xz','application/z','application/7-zip') ",array('attachment'));
            $attachments = $wpdb->get_results($sql);
        }
    
    return count($attachments);
    }
    
    public function wpmf_get_filetype(){
        if(isset($_GET['attachment-filter'])){
            if($_GET['attachment-filter'] == 'wpmf-zip' || $_GET['attachment-filter'] == 'wpmf-pdf' || $_GET['attachment-filter']=='wpmf-other'){
                $filetype = $_GET['attachment-filter'];
            }else{
                $filetype = '';
            }
        }else{
            $filetype = '';
        }
        
        return $filetype;
    }
    
    public function wpmf_get_cookie_media($pagenow,$curent_view){
        if($pagenow == 'upload.php'){
            if(isset($_COOKIE[$curent_view."wpmf_media_order"])){
                $cook_order_media = $_COOKIE[$curent_view."wpmf_media_order"];
            }else{
                $cook_order_media = '';
            }
        }else{
            if(isset($_COOKIE["gridwpmf_media_order"])){
                $cook_order_media = $_COOKIE["gridwpmf_media_order"];
            }else{
                $cook_order_media = '';
            }
        }
        
        return $cook_order_media;
    }
    
    public function wpmf_get_cookie_folder(){
        if(isset($_COOKIE['wpmf_folder_order'])){
            $cook_order_f = $_COOKIE['wpmf_folder_order'];
        }else{
            $cook_order_f = '';
        }
        
        return $cook_order_f;
    }
}
?>