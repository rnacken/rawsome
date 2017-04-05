<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
    'lib/utils.php', // handy stuff
    'lib/il8n.php', // qTranslateX setup
    'lib/api.php',  // api extensions
    'lib/text.php',
    'lib/navigation.php', // extra menu options & redirects
    'lib/admin.php', // Admin edits
    'lib/assets.php', // Scripts and stylesheets
    'lib/extras.php', // Custom functions
    'lib/setup.php', // Theme setup
    'lib/titles.php', // Page titles
    'lib/wrapper.php', // Theme wrapper class
    'lib/shortcodes.php', // egister shortcodes
    'lib/acf_options.php', // custom acf rules
    'lib/custom_post_types.php',
    'lib/user.php',
    'lib/mce.php'
];

foreach ($sage_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'rawsome'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);


