<?php

require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');

function university_custom_rest(){
    register_rest_field('post','authorName',[
        'get_callback' => function () {return get_the_author();}
    ]);

    register_rest_field('note','userNoteCount',[
        'get_callback' => function () {return count_user_posts(get_current_user_id(), 'note');}
    ]);
}

add_action('rest_api_init', 'university_custom_rest');
function pageBanner($args = null){
    if(!$args['title']){
        $args['title'] = get_the_title();
    }
    if(!$args['subtitle']){
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if(!$args['photo']){
        if(get_field('page_banner_background_image')){
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        }else{
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
            <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
            </div>
        </div>  
    </div>
    
    
    <?php }

function university_files(){
    //wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
    //wp_enqueue_script('main-university-js',get_theme_file_uri('/js/scripts.js'),array('jquery'),microtime(),true);
    wp_enqueue_script('main-university-js',get_theme_file_uri('/js/scripts.js'),array('jquery'),microtime(),true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri(),NULL,microtime());
    wp_localize_script('main-university-js', 'universityData',array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    )); 
}
add_action('wp_enqueue_scripts' , 'university_files');
function university_features(){
    // register_nav_menu('headerMenuLocation','Header Menu Location');
    // register_nav_menu('footerLocationOne','Footer Location One');
    // register_nav_menu('footerLocationTwo','Footer Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPotrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}
add_action('after_setup_theme','university_features');


function university_adjust_queries($query){
    if(!is_admin() && is_post_type_archive('campus') && $query->is_main_query()){
        $query->set('posts_per_page', -1);
    }
    if(!is_admin() && is_post_type_archive('program') && $query->is_main_query()){
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }
    //if(!is_admin() && is_post_type_archive('event') && $query->is_main_query()){
        // $today = date('Ymd');
        //$query->set('meta_key', 'event_date',);
        //$query->set('orderby', 'meta_value_num');
        //$query->set('order', 'ASC');
        //$query->set('meta_query', [
            // 'key' => 'event_date',
            // 'compare' => '>=',
            // 'value' => $today, 
            // 'type' => numeric
         // ]);
    //}

}
add_action('pre_get_posts' , 'university_adjust_queries');


// function universityMapKey($api){
//     $api['key'] = 'ba1d9389f3206b2a';
//     return $api;
// }
// add_filter('acf/fields/google_map/api', 'universityMapKey');

// REDIRECT OF SUBSCIBERS TO HOMEPAGE AND NOT ON ADMIN DASHBOARD
add_action('admin_init','redirectSubsToFrontend');

function redirectSubsToFrontend(){
    $ourCurrentUser = wp_get_current_user();
    if(count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber'){
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('wp_loaded','noSubsAdminBar');

function noSubsAdminBar(){
    $ourCurrentUser = wp_get_current_user();
    if(count($ourCurrentUser->roles) == 1 && $ourCurrentUser->roles[0] == 'subscriber'){
        show_admin_bar(false);
    }
}

// Customize login screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl(){
    return esc_url(site_url('/'));
}
add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS(){
    wp_enqueue_style('university_main_styles', get_stylesheet_uri(),NULL,microtime());
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}
add_filter('login_headertitle' , 'ourLoginTitle');

function ourLoginTitle(){
    return get_bloginfo('name');
}

// Force note posts to be private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data,$postarr){
    if(count_user_posts(get_current_user_id(), 'note') > 4 && !$postarr['ID']){
        die("You Have Reached Your Note Limit.");
    }
    if($data['post_type'] == 'note'){
        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }
    if($data['post_type'] == 'note' && $data['post_status'] != 'trash'){
        $data['post_status'] = "private";
    }
    return $data;
}