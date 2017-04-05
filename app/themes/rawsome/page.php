<?php while (have_posts()) : the_post(); ?>
    <?php
    if (isset($post)){
            $template_location = locate_template('templates/content-page-'.$post->post_name.'.php');
            if (!empty($template_location)){
                get_template_part('templates/content', 'page-'.$post->post_name);
                break;
            }
        }
        get_template_part('templates/content', 'page');
    ?>

<?php endwhile; ?>
