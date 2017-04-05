<?php
/**
 * These functions extend existing api endpoints or add new endpoints.
 */
namespace Knack\Rawsome\Api;

/**
 * 
 * @param type $response
 * @return type
 * 
 * Example function to show how to extend the api response;
 */
function add_author_data_to_rest( $response ) {    
    // Set author's name (instead of just an id-number).   
    $author = get_userdata( $response->data['author'] );
    $response->data['author'] = array(      
        'id' => $author->ID,        
        'link' => get_author_posts_url( $author->ID ),      
        'name' => $author->data->display_name  
    );
    return $response;
}
add_filter( 'rest_prepare_post', __NAMESPACE__ . '\\add_author_data_to_rest' );
add_filter( 'rest_prepare_page', __NAMESPACE__ . '\\add_author_data_to_rest' );
//add_filter( 'rest_prepare_book', __NAMESPACE__ . '\\add_author_data_to_rest' );
