<?php

namespace Knack\Rawsome\Titles;

/**
 * Page titles
 */
function title() { 
    if (is_archive()) { // archive pages
        return get_menu_title('primary_navigation');
    } elseif (is_home()) { // & posts-archive
        return get_menu_title('primary_navigation');
    } elseif (is_search()) {
        return sprintf(__('Search Results for %s', 'rawsome'), get_search_query());
    } elseif (is_404()) {
        return __('Not Found', 'rawsome');
    } else {
        return get_menu_title('primary_navigation');
    }
}

/**
 * 
 * @global type $post
 * @param type $loc
 * @return type
 * 
 * This function will take the (custom) label of the post from the primary menu. 
 */
function get_menu_title( $loc ) {
    global $post;
    $locs = get_nav_menu_locations();

    $menu = isset($locs[$loc])? wp_get_nav_menu_object( $locs[$loc] ) : false;
    $name = '';
    if($menu) {
        $items = wp_get_nav_menu_items($menu->term_id);
        foreach ($items as $k => $v) {
            // Check if this menu item links to the current page
            if ($items[$k]->url == $_SERVER['REQUEST_URI']) {
                $name = $items[$k]->title;
                break;
            }
        }
    }
    if ($name === ''){ $name = get_the_title(); }   // fall back to title if not found in menu
    return $name;
}


function custom_wp_title($title){
    return title() . ' - ' . get_bloginfo('name');
}
add_filter( 'pre_get_document_title', __NAMESPACE__ . '\\custom_wp_title', 10 );
add_filter( 'wp_title', __NAMESPACE__ . '\\custom_wp_title');   // deprecated, but just for theme backward compatibility (pre wp 4.4)