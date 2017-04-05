<?php
//use Knack\Rawsome\Setup;
use Knack\Rawsome\Wrapper;
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
    <!--[if lt IE 9]>
    <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your
        browser</a> to improve your experience.', 'rawsome'); ?>
    </div>
    <![endif]-->
    <div class="wrap">
        <div class="page-container">
            <?php
            do_action('get_header');
            get_template_part('templates/header');
            ?>
            <div class="container-fluid">
                <div class="content row">
                    <main class="main">
                        <?php include Wrapper\template_path(); ?>
                    </main><!-- /.main -->
                </div><!-- /.content -->
            </div><!-- /.wrap -->

            <?php
            do_action('get_footer');
            get_template_part('templates/footer');
            wp_footer();
            ?>
        </div>
    </div>

    <script>
        window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
        ga('create','UA-XXXXXXX-1','auto');ga('send','pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>
</html>
