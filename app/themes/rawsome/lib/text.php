<?php

define('UNKNOWN_LABEL', __('Onbekend', 'rawsome'));

Class Text {
    /**
     * Add strings for translations
     */
    public static function init(){
        
    }

    /**
     * 
     * @param type $str
     * @param type $vars
     * @return type
     * Returns string with special content entered, like %firstname%
     */
    public static function print_str($str, $vars = array()){
        if (!$str || strlen(trim($str))===0) return (WP_ENV === 'development')?  __('[missing message]', 'templer') : '';
        $user_meta = get_user_meta(get_current_user_id());
        $vars['%lastname%'] = $user_meta['last_name'][0];
        $vars['%firstname%'] = $user_meta['first_name'][0];

        foreach($vars as $key => $value){
            $str = str_replace($key, $value, $str);
        }
        return $str;
    }
}

Text::init();