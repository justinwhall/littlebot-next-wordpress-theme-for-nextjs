<?php
/**
 * Allow GET requests from * origin
 * Thanks to https://joshpress.net/access-control-headers-for-the-wordpress-rest-api/
 */
add_action( 'rest_api_init', function () {

    remove_filter( 'rest_pre_serve_request', 'rest_send_cors_headers' );

    add_filter( 'rest_pre_serve_request', function ( $value ) {
        header( 'Access-Control-Allow-Origin: ' . get_frontend_origin() );
        header( 'Access-Control-Allow-Methods: GET' );
        header( 'Access-Control-Allow-Credentials: true' );

        /**
         * Tell browsers not to cache REST requests if nocache param is set.
         * This is used for previews as we _always_ want the latest response.
         */
        if ( isset( $_GET['nocache'] ) ) {
            header( 'Cache-Control: no-cache, no-store, must-revalidate' );
        }

        return $value;
    });
}, 15 );
