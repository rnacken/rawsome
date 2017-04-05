<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php // wp_title will be deprecated. This is just for theme backward compatibility with < wp4.4. see https://make.wordpress.org/core/2015/10/20/document-title-in-4-4/
    if ( ! function_exists( '_wp_render_title_tag' ) ) :
        function theme_slug_render_title() {
    ?>
        <title><?php wp_title( '-', true, 'right' ); ?></title>
    <?php
        }
        add_action( 'wp_head', 'theme_slug_render_title' );
    endif; ?>
        
    <?php wp_head(); ?>
</head>
