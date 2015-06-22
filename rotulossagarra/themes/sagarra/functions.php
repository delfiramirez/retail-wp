<?php

define ('THEMENAME', 'Rotulos Sagarra');

if ( is_page_template () || is_attachment () || !is_active_sidebar ('') )
    {

    global $content_width;
    $content_width = 850;
    }

include 'templates/custom-admin-function.php';
include 'templates/custom-admin-cssLogin.php';

/* -----------------------------------------------------------------------------------
 *
 */

function custom_theme_features ()
    {

    $formats = array ( 'status', 'quote', 'gallery', 'image', 'video', 'audio' );
    add_theme_support ('post-formats', $formats);
    }

/* -----------------------------------------------------------------------------------
 *
 */


add_custom_background ();

/* -----------------------------------------------------------------------------------
 *
 */

add_filter ('the_content', 'make_clickable');
add_filter ('the_excerpt', 'make_clickable');

/* -----------------------------------------------------------------------------------
 *
 */

add_editor_style ("editor-style.css");

/* -----------------------------------------------------------------------------------
 *
 */

add_action ('after_setup_theme', 'custom_theme_features');

add_post_type_support ('page', 'excerpt');

/* -----------------------------------------------------------------------------------
 *
 */

add_theme_support ('menus');

sagarra_action ('begin_fetch_post_thumbnail_html', '_wp_post_thumbnail_class_filter_add');

/* -----------------------------------------------------------------------------------
 *
 */

add_filter ('ngettext', 'wps_sagarra_theme_name');

add_filter ('the_generator', '__return_false');

add_filter ('gallery_style', create_function ('$css', 'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'));

add_filter ('the_content', 'attachment_image_link_sagarra_filter');

add_filter ('use_default_gallery_style', '__return_null');

add_filter ('jetpack_enable_open_graph', '__return_false', 99);

defined ('JETPACK__API_BASE') or define ('JETPACK__API_BASE', 'https://jetpack.wordpress.com/jetpack.');
define ('JETPACK__API_VERSION', 1);

sagarra_action ('wp_head', 'jetpack_og_tags');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_menus ()
    {
    register_nav_menus (
            array (
                'inicio'      => __ ('Primary Navigation', 'Rotulos Sagarra'),
                'senyaletica' => __ ('Secondary Navigation', 'Rotulos Sagarra'),
                'externo'     => __ ('Tertiary Menu', 'Rotulos Sagarra'),
                'submenu'     => __ ('Quaternary Menu', 'Rotulos Sagarra'),
                'contacto'    => __ ('Five Menu', 'Rotulos Sagarra'),
                'pie-pagina'  => __ ('Sextiary Menu', 'Rotulos Sagarra')
            )
    );
    }

add_action ('init', 'sagarra_menus');

/* -----------------------------------------------------------------------------------
 *
 */


sagarra_filter ('the_content', 'wpautop');

add_filter ('the_content', 'wpautop', 10);
add_filter ('the_content', 'make_clickable');

/* -----------------------------------------------------------------------------------
 *
 * //MEDIA
 */



add_theme_support ('post-thumbnails', array ( 'post', 'page' ));

add_image_size ('admin-thumb', 150, 150, true);
add_image_size ('sagarra-thumb', 360, 240, true);
add_image_size ('article-thumb', 360, 210, true);
add_image_size ('timeline-thumb', 200, 200, true);
add_image_size ('gal-thumb', 432, 432, 1); // Sagarra Style
add_image_size ('retina', 768, 9999, true);

/* -----------------------------------------------------------------------------------
 *
 */

if ( !function_exists ('delfi_sagarra_imge_size') ):

    function delfi_sagarra_image_size ()
        {

        if ( has_post_thumbnail () )
            {
            $image_src = wp_get_attachment_image_src (get_post_thumbnail_id (), 'full');
            echo '<img src="' . $image_src[ 0 ] . '" width="100%"  />';
            }
        return this;
        }

endif;

add_image_size ('resp-large', 720, 9999, true);
add_image_size ('resp-medium', 9999, 9999, true);
add_image_size ('resp-small', 320, 9999, true);

/* -----------------------------------------------------------------------------------
 *
 */

if ( !function_exists ('sagarra_jpeg_quality') ):

    function sagarra_jpeg_quality ($quality)
        {
        return 100;
        }

endif;

/* -----------------------------------------------------------------------------------
 *
 */

function attachment_image_link_sagarra_filter ($content)
    {
    $content = preg_replace (array ( '{<a[^>]*><img}', '{/></a>}' ), array ( '<img', '/>' ), $content);
    return $content;
    }

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_media_link ($form_fields, $post)
    {

    unset ($form_fields[ 'url' ]);

    return $form_fields;
    }

add_filter ('attachment_fields_to_edit', 'sagarra_media_link', 10, 2);

/* -----------------------------------------------------------------------------------
 *
 */

function hasgallery ()
    {
    global $post;
    return (strpos ($post->post_content, '[gallery') !== false);
    }

add_filter ('the_content', 'do_shortcode', 11);

/* -----------------------------------------------------------------------------------
 *
 */

function show_all_thumbs ()
    {
    global $post;
    $post   = get_post ($post);
    $images = & get_children ('post_type=attachment&post_mime_type=image&output=ARRAY_N&orderby=menu_order&order=ASC&post_parent=' . $post->post_parent);
    if ( $images )
        {
        foreach ( $images as $imageID => $imagePost )
            {

            unset ($the_b_img);
            $the_b_img = wp_get_attachment_image ($imageID, 'thumbnail', false);
            $thumblist .= '<a href="' . get_attachment_link ($imageID) . '">' . $the_b_img . '</a>';
            }
        }
    return $thumblist;
    }

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_filter_HTML5_video ($output, $data, $url)
    {

    $return = '<div class="video">' . $output . '</div>';
    return $return;
    }

add_filter ('oembed_dataparse', 'sagarra_filter_HTML5_video', 90, 3);

/* -----------------------------------------------------------------------------------
 *
 */

function delfi_allowed_mime_types ($mime_types)
    {
    $mp3_mimes = array ( 'audio/mpeg', 'audio/x-mpeg', 'audio/mp3', 'audio/x-mp3', 'audio/mpeg3', 'audio/x-mpeg3', 'audio/mpg', 'audio/x-mpg', 'audio/x-mpegaudio' );
    foreach ( $mp3_mimes as $mp3_mime )
        {
        $mime                                 = $mp3_mime;
        preg_replace ("/[^0-9a-zA-Z ]/", "", $mp3_mime);
        $mime_types[ 'mp3|mp3_' . $mp3_mime ] = $mime;
        }

    $mime_types[ 'wav' ] = 'audio/wav';
    return $mime_types;
    }

add_filter ('upload_mimes', 'sagarra_mime_types');

add_filter ('delfi_allowed_mime_types', 'delfi_allowed_mime_types');

/* -----------------------------------------------------------------------------------
 *
 */

function elimina_ptags_en_images ($content)
    {
    return preg_replace ('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    }

add_filter ('the_content', 'elimina_ptags_en_images');

/* -----------------------------------------------------------------------------------
 *
 */

function image_alt_tag ($content)
    {
    global $post;
    preg_match_all ('/<img (.*?)\/>/', $content, $images);
    if ( !is_null ($images) )
        {
        foreach ( $images[ 1 ] as $index => $value )
            {
            if ( !preg_match ('/alt=/', $value) )
                {
                $new_img = str_replace ('<img', '<img alt="' . get_the_title () . '"', $images[ 0 ][ $index ]);
                $content = str_replace ($images[ 0 ][ $index ], $new_img, $content);
                }
            }
        }
    return $content;
    }

add_filter ('the_content', 'image_alt_tag', 99999);

/* -----------------------------------------------------------------------------------
 *
 */

function clean_wp_header ()
    {
    sagarra_action ('wp_head', 'wp_generator');
    sagarra_action ('wp_head', 'rel_canonical');
    sagarra_action ('wp_head', 'rsd_link');
    sagarra_action ('wp_head', 'feed_links', 2);
    sagarra_action ('wp_head', 'feed_links_extra', 3);
    sagarra_action ('wp_head', 'wlwmanifest_link');
    sagarra_action ('wp_head', 'wp_shortlink_wp_head', 10, 0);
    sagarra_action ('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    sagarra_action ('wp_head', 'qtrans_header');
    }

add_action ('init', 'clean_wp_header');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_trim_excerpt ($text)
    {
    $raw_excerpt = $text;
    if ( '' == $text )
        {
        $text = get_the_content ('');
        $text = strip_shortcodes ($text);
        $text = apply_filters ('the_content', $text);
        $text = str_replace (']]>', ']]&gt;', $text);
        $text = preg_replace ('@<script[^>]*?>.*?</script>@si', '', $text);
        $text = strip_tags ($text, '<strong><b><em><i><a><code><kbd>');

        $excerpt_length = apply_filters ('excerpt_length', 44);

        $excerpt_more = apply_filters ('excerpt_more', ' ' . '...');

        $words = preg_split ("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
        if ( count ($words) > $excerpt_length )
            {
            array_pop ($words);
            $text = implode (' ', $words);
            $text = force_balance_tags ($text);

            $text = $text . $excerpt_more;
            }
        else
            {
            $text = implode (' ', $words);
            }
        }
    return apply_filters ('wp_trim_excerpt', $text, $raw_excerpt);
    }

sagarra_filter ('get_the_excerpt', 'wp_trim_excerpt');

add_filter ('get_the_excerpt', 'sagarra_trim_excerpt');

/* -----------------------------------------------------------------------------------
 *
 */

function fix__sagarra_slash ($string, $type)
    {
    global $wp_rewrite;
    if ( $wp_rewrite->use_trailing_slashes == false )
        {
        if ( $type != 'single' && $type != 'category' )
            return trailingslashit ($string);

        if ( $type == 'single' && ( strpos ($string, '.html/') !== false ) )
            return trailingslashit ($string);

        if ( $type == 'category' && ( strpos ($string, 'category') !== false ) )
            {
            $aa_g = str_replace ("/category/", "/", $string);
            return trailingslashit ($aa_g);
            }
        if ( $type == 'category' )
            return trailingslashit ($string);
        }
    return $string;
    }

add_filter ('user_trailingslashit', 'fix_sagarra_slash', 55, 2);

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_IEhtml5_shim ()
    {
    global $is_IE;
    if ( $is_IE )
        echo '<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->';
    }

add_action ('wp_footer', 'sagarra_IEhtml5_shim');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_pagination ($pages = '', $range = 2)
    {
    $showitems = ($range * 2) + 1;

    global $paged;
    if ( empty ($paged) )
        $paged = 1;

    if ( $pages == '' )
        {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if ( !$pages )
            {
            $pages = 1;
            }
        }

    if ( 1 != $pages )
        {
        echo "<div class='pagination'>";
        if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages )
            echo "<a href='" . get_pagenum_link (1) . "'>&laquo;</a>";
        if ( $paged > 1 && $showitems < $pages )
            echo "<a href='" . get_pagenum_link ($paged - 1) . "'>&lsaquo;</a>";

        for ( $i = 1; $i <= $pages; $i++ )
            {
            if ( 1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
                {
                echo ($paged == $i) ? "<span class='current'>" . $i . "</span>" : "<a href='" . get_pagenum_link ($i) . "' class='inactive' >" . $i . "</a>";
                }
            }

        if ( $paged < $pages && $showitems < $pages )
            echo "<a href='" . get_pagenum_link ($paged + 1) . "'>&rsaquo;</a>";
        if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages )
            echo "<a href='" . get_pagenum_link ($pages) . "'>&raquo;</a>";
        echo "</div>\n";
        }
    }

/* -----------------------------------------------------------------------------------
 *
 */

function string_limit_words ($string, $word_limit)
    {
    $words = explode (' ', $string, ($word_limit + 1));
    if ( count ($words) > $word_limit )
        array_pop ($words);
    return implode (' ', $words);
    }

if ( !function_exists ('sagarra_canonical_url') ):

    function sagarra_canonical_url ($echo = true)
        {
        if ( is_home () OR is_front_page () )
            {
            $url = home_url ();
            }
        elseif ( is_singular () )
            {
            global $post;
            $url = get_permalink ($post->ID);
            }
        else
            {
            global $wp;
            $url = add_query_arg ($wp->query_string, '', home_url ($wp->request));
            }

        if ( $echo == true )
            {
            echo $url;
            }
        else
            {
            return $url;
            }
        }

endif;

if ( !function_exists ('sagarra_mime_types') ):

    function sagarra_mime_types ($mime_types)
        {
        $mime_types[ 'ico' ] = 'image/x-icon';

        return $mime_types;
        }

endif;

if ( !function_exists ('show_posts_nav') ):

    function show_posts_nav ()
        {
        global $wp_query;
        return ($wp_query->max_num_pages > 1);
        }

endif;

function delfi_fix_link_category ($c)
    {
    return preg_replace ('/category tag/', 'tag', $c);
    }

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_no_autosave ()
    {
    wp_deregister_script ('autosave');
    }

add_action ('wp_print_scripts', 'sagarra_no_autosave');


/* -----------------------------------------------------------------------------------
 * SEO
 *
 *
 */

function seo_slugs ($slug)
    {
    if ( $slug )
        return $slug;
    global $wpdb;
    $seo_slug       = strtolower (stripslashes ($_POST[ 'post_title' ]));
    $seo_slug       = preg_replace ('/&.+?;/', '', $seo_slug);
    $seo_slug       = preg_replace ("/[^a-zA-Z0-9 \']/", "", $seo_slug);
    $seo_slug_array = array_diff (split (" ", $seo_slug), seo_slugs_stop_words ());
    $seo_slug       = join ("-", $seo_slug_array);
    return $seo_slug;
    }

add_filter ('name_save_pre', 'seo_slugs', 0);

function seo_slugs_stop_words ()
    {
    return array ( "a", "able", "about", "above", "abroad", "according", "accordingly", "across", "actually", "adj", "after", "afterwards", "again", "against", "ago", "ahead", "ain't", "all", "allow", "allows", "almost", "alone", "along", "alongside", "already", "also", "although", "always", "am", "amid", "amidst", "among", "amongst", "an", "and", "another", "any", "anybody", "anyhow", "anyone", "anything", "anyway", "anyways", "anywhere", "apart", "appear", "appreciate", "appropriate", "are", "aren't", "around", "as", "a's", "aside", "ask", "asking", "associated", "at", "available", "away", "awfully", "b", "back", "backward", "backwards", "be", "became", "because", "become", "becomes", "becoming", "been", "before", "beforehand", "begin", "behind", "being", "believe", "below", "beside", "besides", "best", "better", "between", "beyond", "both", "brief", "but", "by", "c", "came", "can", "cannot", "cant", "can't", "caption", "cause", "causes", "certain", "certainly", "changes", "clearly", "c'mon", "co", "co.", "com", "come", "comes", "concerning", "consequently", "consider", "considering", "contain", "containing", "contains", "corresponding", "could", "couldn't", "course", "c's", "currently", "d", "dare", "daren't", "definitely", "described", "despite", "did", "didn't", "different", "directly", "do", "does", "doesn't", "doing", "done", "don't", "down", "downwards", "during", "e", "each", "edu", "eg", "eight", "eighty", "either", "else", "elsewhere", "end", "ending", "enough", "entirely", "especially", "et", "etc", "even", "ever", "evermore", "every", "everybody", "everyone", "everything", "everywhere", "ex", "exactly", "example", "except", "f", "fairly", "far", "farther", "few", "fewer", "fifth", "first", "five", "followed", "following", "follows", "for", "forever", "former", "formerly", "forth", "forward", "found", "four", "from", "further", "furthermore", "g", "get", "gets", "getting", "given", "gives", "go", "goes", "going", "gone", "got", "gotten", "greetings", "h", "had", "hadn't", "half", "happens", "hardly", "has", "hasn't", "have", "haven't", "having", "he", "he'd", "he'll", "hello", "help", "hence", "her", "here", "hereafter", "hereby", "herein", "here's", "hereupon", "hers", "herself", "he's", "hi", "him", "himself", "his", "hither", "hopefully", "how", "howbeit", "however", "hundred", "i", "i'd", "ie", "if", "ignored", "i'll", "i'm", "immediate", "in", "inasmuch", "inc", "inc.", "indeed", "indicate", "indicated", "indicates", "inner", "inside", "insofar", "instead", "into", "inward", "is", "isn't", "it", "it'd", "it'll", "its", "it's", "itself", "i've", "j", "just", "k", "keep", "keeps", "kept", "know", "known", "knows", "l", "last", "lately", "later", "latter", "latterly", "least", "less", "lest", "let", "let's", "like", "liked", "likely", "likewise", "little", "look", "looking", "looks", "low", "lower", "ltd", "m", "made", "mainly", "make", "makes", "many", "may", "maybe", "mayn't", "me", "mean", "meantime", "meanwhile", "merely", "might", "mightn't", "mine", "minus", "miss", "more", "moreover", "most", "mostly", "mr", "mrs", "much", "must", "mustn't", "my", "myself", "n", "name", "namely", "nd", "near", "nearly", "necessary", "need", "needn't", "needs", "neither", "never", "neverf", "neverless", "nevertheless", "new", "next", "nine", "ninety", "no", "nobody", "non", "none", "nonetheless", "noone", "no-one", "nor", "normally", "not", "nothing", "notwithstanding", "novel", "now", "nowhere", "o", "obviously", "of", "off", "often", "oh", "ok", "okay", "old", "on", "once", "one", "ones", "one's", "only", "onto", "opposite", "or", "other", "others", "otherwise", "ought", "oughtn't", "our", "ours", "ourselves", "out", "outside", "over", "overall", "own", "p", "particular", "particularly", "past", "per", "perhaps", "placed", "please", "plus", "possible", "presumably", "probably", "provided", "provides", "q", "que", "quite", "qv", "r", "rather", "rd", "re", "really", "reasonably", "recent", "recently", "regarding", "regardless", "regards", "relatively", "respectively", "right", "round", "s", "said", "same", "saw", "say", "saying", "says", "second", "secondly", "see", "seeing", "seem", "seemed", "seeming", "seems", "seen", "self", "selves", "sensible", "sent", "serious", "seriously", "seven", "several", "shall", "shan't", "she", "she'd", "she'll", "she's", "should", "shouldn't", "since", "six", "so", "some", "somebody", "someday", "somehow", "someone", "something", "sometime", "sometimes", "somewhat", "somewhere", "soon", "sorry", "specified", "specify", "specifying", "still", "sub", "such", "sup", "sure", "t", "take", "taken", "taking", "tell", "tends", "th", "than", "thank", "thanks", "thanx", "that", "that'll", "thats", "that's", "that've", "the", "their", "theirs", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "there'd", "therefore", "therein", "there'll", "there're", "theres", "there's", "thereupon", "there've", "these", "they", "they'd", "they'll", "they're", "they've", "thing", "things", "think", "third", "thirty", "this", "thorough", "thoroughly", "those", "though", "three", "through", "throughout", "thru", "thus", "till", "to", "together", "too", "took", "toward", "towards", "tried", "tries", "truly", "try", "trying", "t's", "twice", "two", "u", "un", "under", "underneath", "undoing", "unfortunately", "unless", "unlike", "unlikely", "until", "unto", "up", "upon", "upwards", "us", "use", "used", "useful", "uses", "using", "usually", "v", "value", "various", "versus", "very", "via", "viz", "vs", "w", "want", "wants", "was", "wasn't", "way", "we", "we'd", "welcome", "well", "we'll", "went", "were", "we're", "weren't", "we've", "what", "whatever", "what'll", "what's", "what've", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "where's", "whereupon", "wherever", "whether", "which", "whichever", "while", "whilst", "whither", "who", "who'd", "whoever", "whole", "who'll", "whom", "whomever", "who's", "whose", "why", "will", "willing", "wish", "with", "within", "without", "wonder", "won't", "would", "wouldn't", "x", "y", "yes", "yet", "you", "you'd", "you'll", "your", "you're", "yours", "yourself", "yourselves", "you've", "z", "zero" );
    }

function drop_bad_comments ()
    {
    if ( !empty ($_POST[ 'comment' ]) )
        {
        $post_comment_content = $_POST[ 'comment' ];
        $lower_case_comment   = strtolower ($_POST[ 'comment' ]);
        $bad_comment_content  = array (
            'viagra',
            'hydrocodone',
            'hair loss',
            '[url=http',
            '[link=http',
            'xanax',
            'tramadol',
            'russian girls',
            'russian brides',
            'lorazepam',
            'adderall',
            'dexadrine',
            'no prescription',
            'oxycontin',
            'without a prescription',
            'sex pics',
            'family incest',
            'online casinos',
            'online dating',
            'cialis',
            'best forex',
            'amoxicillin'
        );
        if ( in_comment_post_like ($lower_case_comment, $bad_comment_content) )
            {
            $comment_box_text = wordwrap (trim ($post_comment_content), 80, "\n ", true);
            $txtdrop          = fopen ('/var/log/httpd/wp_post-logger/nullamatix.com-text-area_dropped.txt', 'a');
            fwrite ($txtdrop, " --------------\n [COMMENT] = " . $post_comment_content . "\n --------------\n");
            fwrite ($txtdrop, " [SOURCE_IP] = " . $_SERVER[ 'REMOTE_ADDR' ] . " @ " . date ("F j, Y, g:i a") . "\n");
            fwrite ($txtdrop, " [USERAGENT] = " . $_SERVER[ 'HTTP_USER_AGENT' ] . "\n");
            fwrite ($txtdrop, " [REFERER ] = " . $_SERVER[ 'HTTP_REFERER' ] . "\n");
            fwrite ($txtdrop, " [FILE_NAME] = " . $_SERVER[ 'SCRIPT_NAME' ] . " - [REQ_URI] = " . $_SERVER[ 'REQUEST_URI' ] . "\n");
            fwrite ($txtdrop, '--------------**********------------------' . "\n");
            header ("HTTP/1.1 406 Not Acceptable");
            header ("Status: 406 Not Acceptable");
            header ("Connection: Close");
            wp_die (__ ('bang bang.'));
            }
        }
    }

add_action ('init', 'drop_bad_comments');

/* -----------------------------------------------------------------------------------

 * http://www.paulund.co.uk/encode-email-with-php

 */

function encode_email_address ($email)
    {
    $output = '';
    for ( $i = 0; $i < strlen ($email); $i++ )
        {
        $output .= '&#' . ord ($email[ $i ]) . ';';
        }
    return $output;
    }

/* ----------------------------------------------------------------------------------- */
/* PAGES:
 *
 */

function stringToDate ($string, $option)
    {
    $separator = "-";
    if ( substr ($option, 0, 1) == "Y" )
        {
        if ( strlen ($option) > 1 )
            {
            list($y, $m, $d) = explode ($separator, $string);
            }
        else
            {
            $d = 1;
            $m = 1;
            $y = $string;
            }
        }
    if ( substr ($option, 0, 1) == "d" )
        list($d, $m, $y) = explode ($separator, $string);
    if ( substr ($option, 0, 1) == "m" )
        {
        $d = 1;
        list($m, $y) = explode ($separator, $string);
        }

    $date = new DateTime ($y . '-' . $m . '-' . $d);
    return $date;
    }

/* -----------------------------------------------------------------------------------
 * FORM
  /
 *
 */

function sagarra_style_search_form ($form)
    {
    $form = '<form method="get" id="searchform" action="' . get_option ('home') . '/" >
            <label for="s">' . __ ('') . '</label>
            <div>';
    if ( is_search () )
        {
        $form .='<input type="text" value="' . attribute_escape (apply_filters ('the_search_query', get_search_query ())) . '" name="s" id="s" />';
        }
    else
        {
        $form .='<input type="text" value="Search Site" name="s" id="s"  onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;"/>';
        }
    $form .= '<input type="submit" id="searchsubmit" value="' . attribute_escape (__ ('Go')) . '" />
            </div>
            </form>';
    return $form;
    }

add_filter ('get_search_form', 'sagarra_style_search_form');

/* -----------------------------------------------------------------------------------
 *
 */

function html5_search_form ($form)
    {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url ('/') . '" >
    <label class="assistive-text" for="s">' . __ ('Search for:') . '</label>
    <input type="search" placeholder="' . __ ("Enter term...") . '" value="' . get_search_query () . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="Search" />
    </form>';

    return $form;
    }

add_filter ('get_search_form', 'html5_search_form');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_nice_search_redirect ()
    {
    global $wp_rewrite;
    if ( !isset ($wp_rewrite) || !is_object ($wp_rewrite) || !$wp_rewrite->using_permalinks () )
        {
        return;
        }

    $search_base = $wp_rewrite->search_base;
    if ( is_search () && !is_admin () && strpos ($_SERVER[ 'REQUEST_URI' ], "/{$search_base}/") === false )
        {
        wp_redirect (home_url ("/{$search_base}/" . urlencode (get_query_var ('s'))));
        exit ();
        }
    }

if ( current_theme_supports ('nice-search') )
    {
    add_action ('template_redirect', 'sagarra_nice_search_redirect');
    }

/* -----------------------------------------------------------------------------------
 *

 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330

 */

function sagarra_request_filter ($query_vars)
    {
    if ( isset ($_GET[ 's' ]) && empty ($_GET[ 's' ]) )
        {
        $query_vars[ 's' ] = ' ';
        }

    return $query_vars;
    }

add_filter ('request', 'sagarra_request_filter');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_breadcrumb ()
    {
    if ( !is_home () )
        {
        echo '<a href="';
        echo get_option ('home');
        echo '">';
        bloginfo ('name');
        echo "</a> Â» ";
        }
    elseif ( is_page () )
        {
        echo the_title ();
        }
    }

/* -----------------------------------------------------------------------------------
 *
 */

if ( !function_exists ('delfi_list') ):

    function delfi_list ($c)
        {
        $c_ = preg_replace ('/ class=[\"\'].+?[\"\']/', '', $c);
        return preg_replace ('/ id=[\"\'].+?[\"\']/', '', $c_);
        }

endif;

/* -----------------------------------------------------------------------------------
 *
 * NAVIGATION
 */

function sagarra_nav_menu ($var)
    {
    return is_array ($var) ? array_intersect ($var, array (
                'current_page_item',
                'first',
                'last',
                'vertical',
                'horizontal'
                    )
            ) : '';
    }

add_filter ('nav_menu_css_class', 'sagarra_nav_menu');
add_filter ('nav_menu_item_id', 'sagarra_nav_menu');
add_filter ('page_css_class', 'sagarra_nav_menu');



/* -----------------------------------------------------------------------------------
 *
 */

function strip_empty_classes ($menu)
    {
    $menu = preg_replace ('/ class=""| class="sub-menu"/', '', $menu);
    return $menu;
    }

add_filter ('wp_nav_menu', 'strip_empty_classes');

/* -----------------------------------------------------------------------------------
 *
 */

function nav_class_filter ($var)
    {
    return is_array ($var) ? array_intersect ($var, array ( 'current-menu-item' )) : '';
    }

add_filter ('nav_menu_css_class', 'nav_class_filter', 100, 1);

function nav_id_filter ($id, $item)
    {
    return 'nav-' . cleanname ($item->title);
    }

add_filter ('nav_menu_item_id', 'nav_id_filter', 10, 2);

/* -----------------------------------------------------------------------------------
 *
 */

function delfi_link_current_to_active ($text)
    {
    $replace = array (
        'current_page_item'     => 'active',
        'current_page_parent'   => 'active',
        'current_page_ancestor' => 'active',
    );
    $text    = str_replace (array_keys ($replace), $replace, $text);
    return $text;
    }

add_filter ('wp_nav_menu', 'delfi_link_current_to_active');


/* -----------------------------------------------------------------------------------
 *
 */

class hermit_walker extends Walker_Nav_Menu
    {

    function start_el (&$output, $item, $depth, $args)
        {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat ("\t", $depth) : '';

        $class_names = $value       = '';

        $classes = empty ($item->classes) ? array () : (array) $item->classes;

        $current_indicators = array ( 'current-menu-item', 'menu-item-type-custom', 'menu-item-object-page', 'menu-item-type-post_type', 'current-menu-parent', 'current_page_item', 'current_page_parent' );

        $newClasses = array ();

        foreach ( $classes as $el )
            {

            if ( in_array ($el, $current_indicators) )
                {
                array_push ($newClasses, $el);
                }
            }

        $class_names = join (' ', apply_filters ('nav_menu_css_class', array_filter ($newClasses), $item));
        if ( $class_names != '' )
            $class_names = ' class="' . esc_attr ($class_names) . '"';


        $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

        $attributes = !empty ($item->attr_title) ? ' title="' . esc_attr ($item->attr_title) . '"' : '';
        $attributes .=!empty ($item->target) ? ' target="' . esc_attr ($item->target) . '"' : '';
        $attributes .=!empty ($item->xfn) ? ' rel="' . esc_attr ($item->xfn) . '"' : '';
        $attributes .=!empty ($item->url) ? ' href="' . esc_attr ($item->url) . '"' : '';

        if ( $depth != 0 )
            {

            }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters ('the_title', $item->title, $item->ID);
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters ('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

    }

/* -----------------------------------------------------------------------------------
 *
 */

function cleanname ($v)
    {
    $v = preg_replace ('/[^a-zA-Z0-9s]/', '', $v);
    $v = str_replace (' ', '-', $v);
    $v = strtolower ($v);
    return $v;
    }

/* -----------------------------------------------------------------------------------
 *
 */

function rt_post_join ($join, $isc, $ec)
    {
    global $wpdb;

    $join = " INNER JOIN $wpdb->postmeta AS pm ON pm.post_id = p.ID";
    return $join;
    }

function rt_prev_post_where ($w)
    {
    global $wpdb, $post;

    $prd = get_post_meta ($post->ID, 'release_date', true);
    $w   = $wpdb->prepare (" WHERE pm.meta_key = 'release_date' AND pm.meta_value < '$prd' AND p.post_type = 'products' AND p.post_status = 'publish'");
    return $w;
    }

function rt_next_post_where ($w)
    {
    global $wpdb, $post;

    $prd = get_post_meta ($post->ID, 'release_date', true);
    $w   = $wpdb->prepare (" WHERE pm.meta_key = 'release_date' AND pm.meta_value > '$prd' AND p.post_type = 'products' AND p.post_status = 'publish'");
    return $w;
    }

function rt_prev_post_sort ($o)
    {
    $o = "ORDER BY pm.meta_value DESC LIMIT 1";
    return $o;
    }

function rt_next_post_sort ($o)
    {
    $o = "ORDER BY pm.meta_value ASC LIMIT 1";
    return $o;
    }

/* -----------------------------------------------------------------------------------
 *
 */

if ( !function_exists ('get_pagination_links') ):

    function get_pagination_links ()
        {
        global $wp_query;
        $big = 999999999;
        echo paginate_links (array (
            'base'      => str_replace ($big, '%#%', esc_url (get_pagenum_link ($big))),
            'format'    => '?paged=%#%',
            'current'   => max (1, get_query_var ('paged')),
            'prev_text' => __ ('Â«'),
            'next_text' => __ ('Â»'),
            'total'     => $wp_query->max_num_pages
        ));
        }

endif;

/* -----------------------------------------------------------------------------------
 *
 */

function redirect_single_post ()
    {
    if ( is_search () )
        {
        global $wp_query;
        if ( $wp_query->post_count == 1 )
            {
            wp_redirect (get_permalink ($wp_query->posts[ '0' ]->ID));
            }
        }
    }

add_action ('template_redirect', 'redirect_single_post');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_args_prevnext_add ($args)
    {
    global $page, $numpages, $more, $pagenow;

    if ( !$args[ 'next_or_number' ] == 'next_and_number' )
        return $args;

    $args[ 'next_or_number' ] = 'number';
    if ( !$more )
        return $args;

    if ( $page - 1 )
        $args[ 'before' ] .= _wp_link_page ($page - 1)
                . $args[ 'link_before' ] . $args[ 'previouspagelink' ] . $args[ 'link_after' ] . '</a>';

    if ( $page < $numpages )
        $args[ 'after' ] = _wp_link_page ($page + 1)
                . $args[ 'link_before' ] . $args[ 'nextpagelink' ] . $args[ 'link_after' ] . '</a>'
                . $args[ 'after' ];

    return $args;
    }

add_filter ('sagarra_args', 'sagarra_args_prevnext_add');

/* -----------------------------------------------------------------------------------
 *
 */

function delfi_formatter ($content)
    {

    $bad_content  = array ( '<p></div></p>', '<p><div class="full', '_width"></p>', '</div></p>', '<p><ul', '</ul></p>', '<p><div', '<p><block', 'quote></p>', '<p><hr /></p>', '<p><table>', '<td></p>', '<p></td>', '</table></p>', '<p></div>', 'nosidebar"></p>', '<p><p>', '<p><a', '</a></p>', '-half"></p>', '-third"></p>', '-fourth"></p>', '<p><p', '</p></p>', 'child"></p>', '<p></p>', '-fifth"></p>', '-sixth"></p>', 'last"></p>', 'fix" /></p>', '<p><hr', '<p><li', '"centered"></p>', '</li></p>', '<div></p>', '<p></ul>', '<p><img', ' /></p>', '"nop"></p>', 'tures"></p>', '"left"></p>', '<p><h1 class="center">', 'centered"></p>' );
    $good_content = array ( '</div>', '<div class="full', '_width">', '</div>', '<ul', '</ul>', '<div', '<block', 'quote>', '<hr />', '<table>', '<td>', '</td>', '</table>', '</div>', 'nosidebar">', '<p>', '<a', '</a>', '-half">', '-third">', '-fourth">', '<p', '</p>', 'child">', '', '-fifth">', '-sixth">', 'last">', 'fix" />', '<hr', '<li', '"centered">', '</li>', '<div>', '</ul>', '<img', ' />', '"nop">', 'tures">', '"left">', '<h1 class="center">', 'centered">' );

    $new_content = str_replace ($bad_content, $good_content, $content);
    return $new_content;
    }

add_filter ('the_content', 'delfi_formatter', 11);

/* -----------------------------------------------------------------------------------
 *
 */

function delfi_request_filter ($query_vars)
    {
    if ( isset ($_GET[ 's' ]) && empty ($_GET[ 's' ]) )
        {
        $query_vars[ 's' ] = " ";
        }
    return $query_vars;
    }

add_filter ('request', 'delfi_request_filter');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_excerpt ($limit)
    {
    $excerpt = explode (' ', get_the_excerpt (), $limit);
    if ( count ($excerpt) >= $limit )
        {
        array_pop ($excerpt);
        $excerpt = implode (" ", $excerpt) . '...';
        }
    else
        {
        $excerpt = implode (" ", $excerpt);
        }
    $excerpt = preg_replace ('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt;
    }

function sagarra_content ($limit)
    {
    $content = explode (' ', get_the_content (), $limit);
    if ( count ($content) >= $limit )
        {
        array_pop ($content);
        $content = implode (" ", $content) . '...';
        }
    else
        {
        $content = implode (" ", $content);
        }
    $content = preg_replace ('/\[.+\]/', '', $content);
    $content = apply_filters ('the_content', $content);
    $content = str_replace (']]>', ']]&gt;', $content);
    return $content;
    }

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_thumbnail_dimensions ($html)
    {
    $html = preg_replace ('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
    }

add_filter ('post_thumbnail_html', 'sagarra_thumbnail_dimensions', 10);
add_filter ('image_send_to_editor', 'sagarra_thumbnail_dimensions', 10);

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_more_jump_link ($link)
    {
    $offset = strpos ($link, '#more-');
    if ( $offset )
        {
        $end = strpos ($link, '"', $offset);
        }
    if ( $end )
        {
        $link = substr_replace ($link, '', $offset, $end - $offset);
        }
    return $link;
    }

add_filter ('the_content_more_link', 'sagarra_more_jump_link');

/* -----------------------------------------------------------------------------------
 *
 */

function disablePostCommentsFeedLink ($for_comments)
    {
    return;
    }

add_filter ('post_comments_feed_link', 'disablePostCommentsFeedLink');

/* -----------------------------------------------------------------------------------
 *
 */

function cuatro_ultimos ($query)
    {
    if ( $query->is_home () && $query->is_main_query () )
        {
        $query->set ('posts_per_page', '14');
        }
    }

add_action ('pre_get_posts', 'cuatro_ultimos');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_category_id_class ($classes)
    {
    global $post;
    foreach ( (get_the_category ($post->ID) ) as $category )
        $classes [] = 'cat-' . $category->cat_ID . '-id';
    return $classes;
    }

add_filter ('post_class', 'sagarra_category_id_class');
add_filter ('body_class', 'sagarra_category_id_class');



/* -----------------------------------------------------------------------------------
 *
 */

function bm_displayArchives ()
    {
    global $month, $wpdb, $wp_version;

    $sql = 'SELECT
            DISTINCT YEAR(post_date) AS year,
            MONTH(post_date) AS month,
            count(ID) as posts
        FROM ' . $wpdb->posts . '
        WHERE post_status="publish"
            AND post_type="post"
            AND post_password=""
        GROUP BY YEAR(post_date),
            MONTH(post_date)
        ORDER BY post_date DESC';

    $archiveSummary = $wpdb->get_results ($sql);
    if ( $archiveSummary )
        {
        foreach ( $archiveSummary as $date )
            {
            unset ($bmWp);
            $bmWp = new WP_Query ('year=' . $date->year . '&monthnum=' . zeroise ($date->month, 2) . '&posts_per_page=-1' . '&cat=-126,-127,-225,-10' . '&paged=' . $paged);

            if ( $bmWp->have_posts () )
                {
                $url  = get_month_link ($date->year, $date->month);
                $text = $month[ zeroise ($date->month, 2) ] . ' ' . $date->year;

                echo get_archives_link ($url, $text, '', '<div class="sitemap"><h5>', '</h5>');
                echo '<ul>';
                while ( $bmWp->have_posts () )
                    {
                    $bmWp->the_post ();
                    echo '<li>&spades; <a href=" ' . get_permalink ($bmWp->post) . '" title="' . wp_specialchars ($text, 1) . '">' . wptexturize ($bmWp->post->post_title) . '</a></li>';
                    }
                echo '</ul></div>';
                }
            }
        }
    }

/* -----------------------------------------------------------------------------------
  LANGUAGES
 *
 */

function sagarra_language_attributes ()
    {
    $attributes = array ();
    $output     = '';

    if ( function_exists ('is_rtl') )
        {
        if ( is_rtl () == 'rtl' )
            {
            $attributes[] = 'dir="rtl"';
            }
        }

    $lang = get_bloginfo ('language');

    if ( $lang && $lang !== 'en-US' )
        {
        $attributes[] = "lang=\"$lang\"";
        }
    else
        {
        $attributes[] = 'lang="en"';
        }
    if ( $lang && $lang !== 'es-ES' )
        {
        $attributes[] = "lang=\"$lang\"";
        }
    else
        {
        $attributes[] = 'lang="es"';
        }
    $output = implode (' ', $attributes);
    $output = apply_filters ('sagarra_language_attributes', $output);

    return $output;
    }

add_filter ('language_attributes', 'sagarra_language_attributes');


/* -----------------------------------------------------------------------------------
  Qtranslate
 *
 */

add_filter ('month_link', 'qtrans_convertURL');
add_filter ('page_link', 'qtrans_convertURL');
add_filter ('post_link', 'qtrans_convertURL');
add_filter ('post_type_link', 'qtrans_convertURL');
add_filter ('year_link', 'qtrans_convertURL');
add_filter ('category_feed_link', 'qtrans_convertURL');
add_filter ('category_link', 'qtrans_convertURL');

add_filter ('wp_nav_menu_items', 'qtrans_in_nav_function');

function qtrans_in_nav_function ($nav)
    {

    $url      = get_bloginfo ('url');
    $url_preg = preg_replace ('/\//', '\/', $url);

    $qtrans_url = qtrans_convertURL ($url);

    $nav = preg_replace ('/(' . $url_preg . ')(\/id)/', $url, $nav);
    $nav = preg_replace ('/(' . $url_preg . ')/', $qtrans_url, $nav);

    return $nav;
    }

function exclude_post_categories ($excl = '')
    {
    $categories = get_the_category ($post->ID);
    if ( !empty ($categories) )
        {
        $exclude = $excl;
        $exclude = explode (",", $exclude);
        foreach ( $categories as $cat )
            {
            $html = '';
            if ( !in_array ($cat->cat_ID, $exclude) )
                {
                $html .= '<a href="' . get_category_link ($cat->cat_ID) . '" ';
                $html .= 'title="' . $cat->cat_name . '">' . $cat->cat_name . '</a>';
                echo $html;
                }
            }
        }
    }

//Amnesia de WP para las categorias : Comprobar si genera errores !!!
/* -----------------------------------------------------------------------------------
 *
 */


function cure_wp_amnesia_on_query_string ($query_string)
    {
    if ( !is_admin () )
        {
        if ( isset ($query_string[ 'category_name' ]) )
            {
            switch ( $query_string[ 'category_name' ] )
                {
                case 'noticias':
                    $query_string[ 'posts_per_page' ] = 8;
                    break;

                case 'senaletica':
                    $query_string[ 'posts_per_page' ] = 12;
                    $query_string[ 'orderby' ]        = 'name';
                    $query_string[ 'order' ]          = 'asc';
                    break;
                case 'plafones':
                    $query_string[ 'posts_per_page' ] = 12;

                    break;
                }
            }
        if ( isset ($query_string[ 's' ]) )
            {
            $query_string[ 'posts_per_page' ] = 5;
            }
        }
    return $query_string;
    }

add_filter ('request', 'cure_wp_amnesia_on_query_string');
?>
