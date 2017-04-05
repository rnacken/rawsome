<?php 

namespace Knack\Rawsome\Mce;
/**
 * 
 * @param type $html
 * @param type $id
 * @param type $caption
 * @param type $title
 * @param type $align
 * @param type $url
 * @return string
 * Insert an image with the figure tag around it
 */
function html5_insert_image($html, $id, $caption, $title, $align, $url) {
    if (!$url){
        if ($id){
            $img = get_post($id);
            $caption = $img->post_excerpt;
            $title = $img->post_title;
            $url = $img->guid;
        }
    }
    $html5 = "<figure id='post-$id media-$id' class='align-$align'>";
    $html5 .= "<img src='$url' alt='$title' />";
    if ($caption) {
      $html5 .= "<figcaption>$caption</figcaption>";
    }
    $html5 .= "</figure>";
    return $html5;
}
add_filter( 'image_send_to_editor', __NAMESPACE__ . '\\html5_insert_image', 10, 6 );


/**
 * 
 * @param type $in
 * @return string
 * prevent styles with copy/pasting
 */
function my_format_TinyMCE( $in ) {
	$in['remove_linebreaks'] = false;
	$in['gecko_spellcheck'] = false;
	$in['keep_styles'] = false;
	$in['accessibility_focus'] = true;
	$in['tabfocus_elements'] = 'major-publishing-actions';
	$in['media_strict'] = false;
	$in['paste_remove_styles'] = true;
	$in['paste_remove_spans'] = true;
	$in['paste_strip_class_attributes'] = 'none';
	$in['paste_text_use_dialog'] = false;       // v3
        $in['paste_text_sticky'] = true;            // v3
	$in['paste_text_sticky_default'] = true;    // v3
        $in['paste_as_text'] = true;                // v4
	$in['wpeditimage_disable_captions'] = true;
        $in['plugins'] = 'tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs';
        //$in['content_css'] = get_template_directory_uri() . "/editor-style.css";
	$in['wpautop'] = true;
	$in['apply_source_formatting'] = false;
        $in['block_formats'] = "Paragraph=p; Heading 3=h3; Heading 4=h4";
	$in['toolbar1'] = 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,wp_fullscreen,wp_adv ';
	$in['toolbar2'] = 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help ';
	$in['toolbar3'] = '';
	$in['toolbar4'] = '';
	return $in;
}
add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\\my_format_TinyMCE' );