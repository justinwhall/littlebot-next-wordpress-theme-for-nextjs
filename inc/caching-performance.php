<?php
/**
 * Filter API routes.
 *
 * @package LittleBot Next
 */

/**
 * Cached version of get_page_by_path so that we're not making unnecessary SQL all the time
 *
 * @param string $page_path Page path
 * @param string $output Optional. Output type; OBJECT*, ARRAY_N, or ARRAY_A.
 * @param string $post_type Optional. Post type; default is 'page'.
 * @return WP_Post|null WP_Post on success or null on failure
 * @link http://vip.wordpress.com/documentation/uncached-functions/ Uncached Functions
 */
function wpcom_vip_get_page_by_path( $page_path, $output = OBJECT, $post_type = 'page' ) {
    if ( is_array( $post_type ) )
        $cache_key = sanitize_key( $page_path ) . '_' . md5( serialize( $post_type ) );
    else
        $cache_key = $post_type . '_' . sanitize_key( $page_path );
    $page_id = wp_cache_get( $cache_key, 'get_page_by_path' );
    if ( $page_id === false ) {
        $page = get_page_by_path( $page_path, $output, $post_type );
        $page_id = $page ? $page->ID : 0;
        if ( $page_id ===0 ) {
            wp_cache_set( $cache_key, $page_id, 'get_page_by_path', ( 1 * HOUR_IN_SECONDS + mt_rand(0, HOUR_IN_SECONDS) )  ); // We only store the ID to keep our footprint small
        } else {
            wp_cache_set( $cache_key, $page_id, 'get_page_by_path', ( 12 * HOUR_IN_SECONDS + mt_rand(0, HOUR_IN_SECONDS) )); // We only store the ID to keep our footprint small
        }
    }
    if ( $page_id )
        return get_page( $page_id, $output );
    return null;
}
