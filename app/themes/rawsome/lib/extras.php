<?php

namespace Knack\Rawsome\Extras;

use Knack\Rawsome\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }
  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'rawsome') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

 // Prevent unwanted next and prev link downloads
if(function_exists('remove_action')) { 
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); 
}

/** 
 * disable pings 
 */
function no_self_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
}
add_action( 'pre_ping', __NAMESPACE__ . '\\no_self_ping' );


function cws_nice_search_redirect() {
    global $wp_rewrite;
    if ( !isset( $wp_rewrite ) || !is_object( $wp_rewrite ) || !$wp_rewrite->using_permalinks() )
        return;

    $search_base = $wp_rewrite->search_base;
    if ( is_search() && !is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$search_base}/" ) === false ) {
        wp_redirect( home_url( "/{$search_base}/" . urlencode( get_query_var( 's' ) ) ) );
        exit();
    }
}

add_action( 'template_redirect', __NAMESPACE__ . '\\cws_nice_search_redirect' );

// Hotfix for http://core.trac.wordpress.org/ticket/13961 for WP versions less than 3.5
if ( version_compare( $wp_version, '3.5', '<=' ) ) {
    function cws_nice_search_urldecode_hotfix( $q ) {
        if ( $q->get( 's' ) && empty( $_GET['s'] ) && is_main_query() )
            $q->set( 's', urldecode( $q->get( 's' ) ) );
    }
    add_action( 'pre_get_posts', __NAMESPACE__ . '\\cws_nice_search_urldecode_hotfix' );
}
