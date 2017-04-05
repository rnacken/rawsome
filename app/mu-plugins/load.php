<?php 

/**
 * Loop through all composer mu-plugins and activate them by requiring.
 */
function load_mu_plugins(){
    $composer_path = ABSPATH . '../composer.json';
    if (file_exists($composer_path)) {
      $composer = json_decode(file_get_contents($composer_path), true);
    } else {
      $composer = []; 
    }
    if (isset($composer['extra']) && isset($composer['extra']['mu-plugins-load']) && is_array($composer['extra']['mu-plugins-load'])){
        foreach($composer['extra']['mu-plugins-load'] as $mu_plugin){
            if (file_exists(WPMU_PLUGIN_DIR . $mu_plugin)){
                require WPMU_PLUGIN_DIR . $mu_plugin;
            }
        }
    }
}
load_mu_plugins();