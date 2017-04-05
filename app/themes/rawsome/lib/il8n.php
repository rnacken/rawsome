<?php
/**
 * Set default qtranslateX options
 */

if (in_array(get_option('qtranslate_header_css_on', false), array(false, 0))){
    update_option('qtranslate_header_css_on', 0, true);
}
if (in_array(get_option('qtranslate_hide_default_language', false), array(false, 0))){
    update_option('qtranslate_hide_default_language', 0, true);
}