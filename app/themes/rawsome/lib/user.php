<?php

/**
 * block profile access for anybody who is not admin
 */
//add_action( 'init', 'blockusers_init' );
//function blockusers_init() {
//    if ( is_admin() && ! current_user_can( 'administrator' ) &&
//        ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
//        wp_redirect( home_url() );
//        exit;
//    }
//}


/**
 * adds classes for body that tells you roles; easy for css
 */
if ( is_user_logged_in() ) {
    add_filter('body_class','add_role_to_body');
    add_filter('admin_body_class','add_role_to_body');
}
function add_role_to_body($classes) {
    $current_user = new WP_User(get_current_user_id());
    $user_role = array_shift($current_user->roles);
    if (is_admin()) {
        $classes .= 'role-'. $user_role;
    } else {
        $classes[] = 'role-'. $user_role;
    }
    return $classes;
}