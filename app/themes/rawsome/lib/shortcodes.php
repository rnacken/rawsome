<?php
/**
 * Add shortcodes
 */

//[button]
function button_shortcode($atts){
    if (isset($atts['text']) && isset($atts['link'])){
        $btn_class = (isset($atts['color']) && strtolower($atts['color'])==='red')? 'btn-red' : '';
        $btn_target = (isset($atts['target']))? $atts['target'] : '_self';
        $result = "<a target='".$btn_target."' href='".$atts['link']."'><button class='btn btn-primary ".$btn_class."'>".$atts['text']."</button></a>";
        return $result;
    }
    return '';
}
add_shortcode('button', 'button_shortcode');


//[quote]
function quote_shortcode($atts) {
    if (isset($atts['text'])) {
        $result = "<blockquote class='quote'>" . $atts['text'];
        if (isset($atts['author'])) {
            $result .= "<small>&mdash;&nbsp;" . $atts['author'] . "</small>";
        }
        $result .= "</blockquote>";
        return $result;
    }
    return '';
}
add_shortcode('quote', 'quote_shortcode');

//[faq]
function faq_shortcode($atts, $post_slug = false) {
    $result = '';
    global $archive_page_id;
    if (isset($archive_page_id) && is_int($archive_page_id)){
        $post_id = $archive_page_id;
    } elseif ($post_slug){
        $post_id = Utils::get_id_by_slug($post_slug);
    } else {    // get current page
        global $post;
        $post_slug = $post->post_name;
        $post_id = $post->ID;
    }
    if (have_rows('faq', $post_id)) {
        $i = 0;

        $result .= '<div class="faq page-element">';
        if (isset($atts['intro'])){
            $result .= '<div class="intro">'.$atts['intro'].'</div>';
        }
        $result .= '<div class="panel-group" id="accordion_' . $post_slug . '">';
        while (have_rows('faq', $post_id)) {
            the_row();
            // display a sub field value
            $question = get_sub_field('question', $post_id);
            $answer = get_sub_field('answer', $post_id);
            if (strlen($question) > 0 && strlen($answer) > 0) {
                $result .= '<div class="panel panel-default">
                    <div class="panel-heading">
                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion_' . $post_slug . '" href="#collapse_'.$post_slug.'_'.$i.'">
                            <span class="accordion-icon"><i class="fa fa-caret-down animated"></i></span>
                            <p class="panel-title">';
                $result .= strip_tags($question);
                $result .= '</p>
                        </a>
                    </div>
                    <div id="collapse_'.$post_slug.'_'.$i.'" class="panel-collapse collapse">
                        <div class="panel-body">
                            <p>';
                $result .= $answer;
                $result .= '</p>
                        </div>
                    </div>
                </div>';
            }
            $i++;
        }
        $result .= '</div><!--.panel-group-->';
        if (isset($atts['outro'])){
            $result .= '<div class="row"><div class="col-sm-6 col-sm-offset-3"><div class="outro">'.$atts['outro'].'</div></div></div>';
        }
        $result .= '</div><!--.faq-->';
    } else {
        // no rows
    }
    return $result;
}
add_shortcode('faq', 'faq_shortcode');


function share_shortcode($atts) {
    global $post;
    if (!$post){
        $post = get_page_by_path('home');
    }
    $post_id = $post->ID;
    if (isset($atts['post_id'])){
        $post_id = intval($atts['post_id']);
        $url = get_permalink($post_id);
    } else {
        $url = get_permalink($post_id);
    }
    $open_graph_title = get_post_meta( $post_id, 'open_graph_title', true );
    $open_graph_description = get_post_meta( $post_id, 'open_graph_description', true );

    $post_title = (isset($open_graph_title) && trim($open_graph_title) !== '')? $open_graph_title : $post->post_title;
    $title = str_replace( '+', '%20', urlencode( $post_title ) ) . ': ' . str_replace( '+', '%20', urlencode( Utils::isset_or($open_graph_description, '')));
    $content = strip_shortcodes( strip_tags( get_the_content() ) );
    if ( strlen( $content ) >= 100 ) {
        $excerpt = substr( $content, 0, 100 ) . '...';
    } else {
        $excerpt = $content;
    }
    $result = '<div class="sharing-buttons">';

    // facebook
    $link = 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($url);
    $result .= '<span class="share-link share-facebook"><a rel="nofollow" title="'.__( 'Share on Facebook', 'templer' ).'" target="_blank" href="'.$link.'" onclick="window.open(\''.$link.'\',\'name\',\'width=600,height=400\')"><i class="fa fa-facebook fa-2x" title="Facebook"></i></a></span>&nbsp;&nbsp;&nbsp;';

    // pinterest
    //$link = "https://twitter.com/intent/tweet?text=$title&amp;url=$url";
    //$result .= '<span class="share-link share-pinterest"><a class="underline" rel="nofollow" title="'.__( 'Share on Pinterest', 'templer' ).'" target="_blank" href="javascript:pinIt();">Pinterest</a></span>&nbsp;';

    // twitter
    $link = "https://twitter.com/intent/tweet?text=$title&amp;url=$url";
    $result .= '<span class="share-link share-facebook"><a rel="nofollow" title="'.__( 'Share on Twitter', 'templer' ).'" target="_blank" href="'.$link.'" onclick="window.open(\''.$link.'\',\'name\',\'width=600,height=400\')"><i class="fa fa-twitter fa-2x" title="Twitter"></i></a></span>&nbsp;&nbsp;&nbsp;';

    // linkedin
    $link = "https://www.linkedin.com/cws/share?mini=true&url=$url&title=$title&summary=$excerpt";
    $result .= '<span class="share-link share-facebook"><a rel="nofollow" title="'.__( 'Share on LinkedIN', 'templer' ).'" target="_blank" href="'.$link.'" onclick="window.open(\''.$link.'\',\'name\',\'width=600,height=400\')"><i class="fa fa-linkedin-square fa-2x" title="LinkedIN"></i></a></span>&nbsp;&nbsp;&nbsp;';

    // email
    $link = "mailto:?subject=".htmlspecialchars($title)."&amp;body=".htmlspecialchars($url);
    $result .= '<span class="share-link share-email"><a rel="nofollow" title="'.__( 'Share with Email', 'templer' ).'" target="_blank" href="'.$link.'"><i class="fa fa-envelope fa-2x" title="Email"></i></a></span>&nbsp;&nbsp;&nbsp;';

    // whatsapp
    $link = "whatsapp://send?text=$url";
    $result .='<span class="share-link share-whatsapp"><a rel="nofollow" title="'.__( 'Share with Whatsapp', 'templer' ).'" target="_blank" href="'.$link.'"><i class="fa fa-whatsapp fa-2x" title="Whatsapp"></i></a></span>';

    $result .= '<div class="stretch"></div></div>';
    return $result;
}
add_shortcode('share', 'share_shortcode');

