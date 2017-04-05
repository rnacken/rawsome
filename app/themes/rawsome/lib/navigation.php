<?php
/**
 * Add 'active' class to current menu item (for Bootstrap)
 */
add_filter('nav_menu_css_class', 'special_nav_class', 10, 2);
function special_nav_class($classes, $item) {
    if (in_array('current-menu-item', $classes)) {
        $classes[] = 'active ';
    }
    $account_page = get_page_by_path('account');
    $account_id = isset($account_page->ID)? $account_page->ID : false;

    if (isset($item->object_id) && intval($item->object_id) === $account_id){
        $classes[] = 'menu-item-for-logged-in';
    }
    return $classes;
}

// highlight active custom post in nav
add_filter('nav_menu_css_class', 'namespace_menu_classes', 10, 2);
function namespace_menu_classes($classes, $item) {
    $custom_post_types = array('vacatures');            // add custom post types
    foreach ($custom_post_types as $custom_post_type) {
        if (get_post_type() == $custom_post_type) {
            $classes = str_replace('current_page_parent', '', $classes);
            if (strpos($item->post_name, $custom_post_type) > -1) {
                $classes = str_replace('menu-item', 'menu-item active current_page_parent', $classes);
            }
        }
    }
    return $classes;
}


add_filter( 'wp_nav_menu', 'new_nav_menu_items2' );
function new_nav_menu_items2($items) {
    if (strpos($items, 'menu-primary-menu') > 0){
        $menu_start = substr($items, 0, strpos($items, '<li '));
        $menu_end = substr($items, strpos($items, '<li '));
        $menu_middle = '<li id="menu-item-54" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-54 menu-item-for-logged-in"><a href="'.get_permalink(get_page_by_path('account')).'">'.__('Mijn account','templer').'</a>
            <ul class="sub-menu">';
        $menu_middle .= '<li id="menu-item-10001" class="menu-item-for-staff custom-templer-menu-item menu-item-for-logged-in menu-item-2"><a href="'.get_permalink(get_page_by_path('account')).'/?tab=vacancies">'.__('Vacatures', 'templer').'</a></li>';
        $menu_middle .= '<li id="menu-item-10002" class="menu-item-for-temps custom-templer-menu-item menu-item-for-logged-in menu-item-2"><a href="'.get_permalink(get_page_by_path('account')).'/?tab=applications">'.__('Sollicitaties', 'templer').'</a></li>';
        //$menu_middle .= '<li id="menu-item-10003" class="menu-item-for-staff custom-templer-menu-item menu-item-for-logged-in menu-item-2"><a href="'.get_permalink(get_page_by_path('account')).'/?tab=temps">'.__('Temps', 'templer').'</a></li>';
        $menu_middle .= '<li id="menu-item-10004" class="custom-templer-menu-item menu-item-for-logged-in menu-item-2"><a href="'.get_permalink(get_page_by_path('account')).'/?tab=profile">'.__('Profiel', 'templer').'</a></li>';
        $menu_middle .= '<li id="menu-item-10005" class="custom-templer-menu-item menu-item-for-logged-in menu-item-2"><a href="?templer_action=logout">'.__('Log uit', 'templer').'&nbsp;&nbsp;<i class="fa fa-sign-out"></i></a></li>';
        $menu_middle .= '</ul>
            </li>';
        return $menu_start.$menu_middle.$menu_end;
    } else {
        return $items;
    }
}

/**
 * Add custom post type to menu options
 * http://stackoverflow.com/questions/20879401/how-to-add-custom-post-type-archive-to-menu
 */
add_action('admin_head-nav-menus.php', __NAMESPACE__ . '\\wpclean_add_metabox_menu_posttype_archive');
function wpclean_add_metabox_menu_posttype_archive() {
    add_meta_box('wpclean-metabox-nav-menu-posttype', 'Custom Post Type Archives', 'wpclean_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
}

function wpclean_metabox_menu_posttype_archive() {
    $post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');
    if ($post_types) :
        $items = array();
        $loop_index = 999999;

        foreach ($post_types as $post_type) {
            $item = new stdClass();
            $loop_index++;

            $item->object_id = $loop_index;
            $item->db_id = 0;
            $item->object = 'post_type_' . $post_type->query_var;
            $item->menu_item_parent = 0;
            $item->type = 'custom';
            $item->title = $post_type->labels->name;
            $item->url = get_post_type_archive_link($post_type->query_var);
            $item->target = '';
            $item->attr_title = '';
            $item->classes = array();
            $item->xfn = '';

            $items[] = $item;
        }
        $walker = new Walker_Nav_Menu_Checklist(array());

        echo '<div id="posttype-archive" class="posttypediv">';
        echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
        echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
        echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object)array('walker' => $walker));
        echo '</ul>';
        echo '</div>';
        echo '</div>';

        echo '<p class="button-controls">';
        echo '<span class="add-to-menu">';
        echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
        echo '<span class="spinner"></span>';
        echo '</span>';
        echo '</p>';

    endif;
}

/**
 * 
 * @global type $wp_rewrite
 * @return type
 * 
 * Nice search (http://txfx.net/wordpress-plugins/nice-search/)
 */
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

add_action( 'template_redirect', 'cws_nice_search_redirect' );

// Hotfix for http://core.trac.wordpress.org/ticket/13961 for WP versions less than 3.5
if ( version_compare( $wp_version, '3.5', '<=' ) ) {
	function cws_nice_search_urldecode_hotfix( $q ) {
		if ( $q->get( 's' ) && empty( $_GET['s'] ) && is_main_query() )
			$q->set( 's', urldecode( $q->get( 's' ) ) );
	}
	add_action( 'pre_get_posts', 'cws_nice_search_urldecode_hotfix' );
}
