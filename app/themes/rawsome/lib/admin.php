<?php

namespace Knack\Rawsome\Admin;

/**
 * Changes to wp-admin
 */

// remove admin bar
add_filter('show_admin_bar', '__return_false');

// remove acf from not-development
if (WP_ENV !== 'development'){
    add_filter('acf/settings/show_admin', '__return_false');
}


/**
 * disable unused menu items:
 */
function remove_menus() {
//    remove_menu_page( 'index.php' );                  //Dashboard
//    remove_menu_page( 'edit.php' );                   //Posts
//    remove_menu_page( 'upload.php' );                 //Media
//    remove_menu_page( 'edit.php?post_type=page' );    //Pages
//  remove_menu_page('edit-comments.php'); //Comments
//    remove_menu_page( 'themes.php' );                 //Appearance
//    remove_menu_page( 'plugins.php' );                //Plugins
//    remove_menu_page( 'users.php' );                  //Users
//    remove_menu_page( 'tools.php' );                  //Tools
//    remove_menu_page( 'options-general.php' );        //Settings
}
add_action('admin_menu', __NAMESPACE__ . '\\remove_menus');

/**
 * Remove meta boxes from Post and Page Screens
 */
function customize_meta_boxes() {
    /* These remove meta boxes from POSTS */
    //remove_post_type_support("post","excerpt"); //Remove Excerpt Support
    //remove_post_type_support("post","author"); //Remove Author Support
    //remove_post_type_support("post","revisions"); //Remove Revision Support
    //remove_post_type_support("post","comments"); //Remove Comments Support
    //remove_post_type_support("post","trackbacks"); //Remove trackbacks Support
    //remove_post_type_support("post","editor"); //Remove Editor Support
    //remove_post_type_support("post","custom-fields"); //Remove custom-fields Support
    //remove_post_type_support("post","title"); //Remove Title Support

    /* These remove meta boxes from PAGES */
    //remove_post_type_support("page","revisions"); //Remove Revision Support
    //remove_post_type_support("page","comments"); //Remove Comments Support
    //remove_post_type_support("page","author"); //Remove Author Support
    //remove_post_type_support("page","trackbacks"); //Remove trackbacks Support
    //remove_post_type_support("page","custom-fields"); //Remove custom-fields Support
}
add_action('admin_init', __NAMESPACE__ . '\\customize_meta_boxes');

/**
 * Remove superfluous elements from the admin bar (uncomment as necessary)
 */
function remove_admin_bar_links() {
    global $wp_admin_bar;
    //$wp_admin_bar->remove_menu('wp-logo');
    //$wp_admin_bar->remove_menu('updates');	
    //$wp_admin_bar->remove_menu('my-account');
    //$wp_admin_bar->remove_menu('site-name');
    //$wp_admin_bar->remove_menu('my-sites');
    //$wp_admin_bar->remove_menu('get-shortlink');
    //$wp_admin_bar->remove_menu('edit');
    //$wp_admin_bar->remove_menu('new-content');
    //$wp_admin_bar->remove_menu('comments');
    //$wp_admin_bar->remove_menu('search');
}
add_action('wp_before_admin_bar_render', __NAMESPACE__ . '\\remove_admin_bar_links');

/**
 * Remove customize from appearance
 */
function remove_customize_page(){
    global $submenu;
    unset($submenu['themes.php'][6]); // remove customize link
}
add_action( 'admin_menu', __NAMESPACE__ . '\\remove_customize_page');

/**
 * Remove post type support
 */
function my_remove_post_stuff() {
    remove_post_type_support( 'post', 'post-formats' ); // no more post-formats (quotes, media, etc)
    unregister_taxonomy_for_object_type('post_tag', 'post'); // no more tags
}
add_action( 'init', __NAMESPACE__ . '\\my_remove_post_stuff', 10 );


/**
 *	Replace the default welcome 'Howdy' in the admin bar with something more professional.
 */
function admin_bar_replace_howdy($wp_admin_bar) {
    $account = $wp_admin_bar->get_node('my-account');
    $replace = str_replace('Howdy,', 'Welcome,', $account->title);            
    $wp_admin_bar->add_node(array('id' => 'my-account', 'title' => $replace));
}
add_filter('admin_bar_menu', __NAMESPACE__ . '\\admin_bar_replace_howdy', 25);

