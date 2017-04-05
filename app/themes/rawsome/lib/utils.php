<?php

/**
 * Class Utils
 *
 * Handy utils to use throughout the entire site.
 */
Class Utils {
    public static function isset_or(&$var, $default=''){
        return (isset($var))? $var : $default;
    }

    public static function get_id_by_slug($page_slug) {
        $page = get_page_by_path($page_slug);
        if ($page) {
            return $page->ID;
        } else {
            return null;
        }
    }

    public static function seo_url($string){
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }
    
    public static function get_url(){
        $s = $_SERVER;
        $use_forwarded_host = false;
        $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
        $sp       = strtolower( $s['SERVER_PROTOCOL'] );
        $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
        $port     = $s['SERVER_PORT'];
        $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
        $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
        $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
        $request = $s['REQUEST_URI'];

        $templer_action_loc = strpos($request, 'templer_action=');
        if ($templer_action_loc !== false){
            $next_query = strpos($request,'&', $templer_action_loc);
            if ($next_query !== false){
                $request = substr($request, 0, $templer_action_loc).substr($request, $next_query);
            } else {
                $request = substr($request, 0, $templer_action_loc);
            }
        }
        return $protocol . '://' . $host . $request;
    }

}

