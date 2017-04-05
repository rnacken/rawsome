<?php

/**
 * options page in admin cms
 * */
if( function_exists('acf_add_options_page') && function_exists('acf_add_options_sub_page')) {
    acf_add_options_page();
    acf_add_options_sub_page('General');
}


// add match rule for slugs
add_filter('acf/location/rule_types', 'acf_location_rules_types');
function acf_location_rules_types($choices) {
    $choices['Page']['slug'] = 'Page Slug';
    return $choices;
}

add_filter('acf/location/rule_values/slug', 'acf_location_rules_values_slug');
function acf_location_rules_values_slug($choices) {
    $pages = get_pages(array(
        'post_type' => 'page'
    ));
    if ($pages) {
        foreach ($pages as $page) {
            $choices[$page->post_name] = $page->post_name;
        }
    }
    return $choices;
}

add_filter('acf/location/rule_match/slug', 'acf_location_rules_match_slug', 10, 3);
function acf_location_rules_match_slug($match, $rule, $options) {
    global $post;
    if ($post){
        $post_slug = $post->post_name;
        $selected_slug = $rule['value'];

        if ($rule['operator'] == "==") {
            $match = ($post_slug == $selected_slug);
        } elseif ($rule['operator'] == "!=") {
            $match = ($post_slug != $selected_slug);
        }

        return $match;
    }
    return false;
}