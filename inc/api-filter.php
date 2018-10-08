<?php
/**
 * Filter API routes.
 *
 * @package LittleBot Next
 */

add_filter( 'rest_prepare_post', 'littlebot_filter_rest' );
add_filter( 'rest_prepare_page', 'littlebot_filter_rest' );

/**
 * Set and unset REST response keys.
 *
 * @param object $response The response object.
 * @return object
 */
function littlebot_filter_rest( $response ) {
    $unset = array(
        'modified',
        'modified_gmt',
        'guid',
        'type',
        'excerpt',
        'comment_status',
        'ping_status',
        'sticky',
        'template',
        'format',
        'tags',
        'curies',
        'menu_order',
        'featured_media',
        'parent',
        'author',
    );

    foreach ( $unset as $value ) {
        unset( $response->data[ $value ] );
    }

    return $response;
}
