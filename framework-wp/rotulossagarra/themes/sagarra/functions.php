<?php
define('THEMENAME', 'Rotulos Sagarra');

if (is_page_template() || is_attachment() || !is_active_sidebar('')) {

    global $content_width;
    $content_width = 850;
}

// Add support for backgrounds
/* ----------------------------------------------------------------------------------- */
add_custom_background();
/* ----------------------------------------------------------------------------------- */
add_filter('the_content', 'make_clickable');
add_filter('the_excerpt', 'make_clickable');

/* ----------------------------------------------------------------------------------- */
add_editor_style("editor-style.css");

/* ----------------------------------------------------------------------------------- */
add_action('after_setup_theme', 'custom_theme_features');

add_post_type_support('page', 'excerpt');

/* ----------------------------------------------------------------------------------- */
add_theme_support('menus');

/* ----------------------------------------------------------------------------------- */
add_filter('ngettext', 'wps_remove_theme_name');

add_filter('gallery_style', create_function('$css', 'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'));

add_filter('the_content', 'attachment_image_link_remove_filter');

add_filter('use_default_gallery_style', '__return_null');

add_filter('jetpack_enable_open_graph', '__return_false', 99);

defined('JETPACK__API_BASE') or define('JETPACK__API_BASE', 'https://jetpack.wordpress.com/jetpack.');
define('JETPACK__API_VERSION', 1);
remove_action('wp_head', 'jetpack_og_tags');

function unregister_default_sagarra_widgets() {
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Text');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
}

add_action('widgets_init', 'unregister_default_sagarra_widgets', 1);

//WIDGETS : Registra Menus para el tema
/* ----------------------------------------------------------------------------------- */
function sagarra_menus() {
    register_nav_menus(
            array(
                'inicio' => __('Primary Navigation', 'Rotulos Sagarra'),
                'senyaletica' => __('Secondary Navigation', 'Rotulos Sagarra'),
                'externo' => __('Tertiary Menu', 'Rotulos Sagarra'),
                'submenu' => __('Quaternary Menu', 'Rotulos Sagarra'),
                'contacto' => __('Five Menu', 'Rotulos Sagarra'),
                'pie-pagina' => __('Sextiary Menu', 'Rotulos Sagarra')
            )
    );
}

add_action('init', 'sagarra_menus');


remove_filter('get_the_excerpt', 'wp_trim_excerpt');

add_filter('get_the_excerpt', 'sagarra_trim_excerpt');

function sagarra_trim_excerpt($text) {
    $raw_excerpt = $text;
    if ('' == $text) {
        $text = get_the_content('');
        $text = strip_shortcodes($text);
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);
        $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
        $text = strip_tags($text, '<strong><b><em><i><a><code><kbd>');

        $excerpt_length = apply_filters('excerpt_length', 44);

        $excerpt_more = apply_filters('excerpt_more', ' ' . '...');

        $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
        if (count($words) > $excerpt_length) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = force_balance_tags($text);

            $text = $text . $excerpt_more;
        } else {
            $text = implode(' ', $words);
        }
    }
    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

/* ----------------------------------------------------------------------------------- */
/* Fix and remove /category/ */
/* ----------------------------------------------------------------------------------- */

function fix__sagarra_slash($string, $type) {
    global $wp_rewrite;
    if ($wp_rewrite->use_trailing_slashes == false) {
        if ($type != 'single' && $type != 'category')
            return trailingslashit($string);

        if ($type == 'single' && ( strpos($string, '.html/') !== false ))
            return trailingslashit($string);

        if ($type == 'category' && ( strpos($string, 'category') !== false )) {
            $aa_g = str_replace("/category/", "/", $string);
            return trailingslashit($aa_g);
        }
        if ($type == 'category')
            return trailingslashit($string);
    }
    return $string;
}

add_filter('user_trailingslashit', 'fix_sagarra_slash', 55, 2);
/* -----------------------------------------------------------------------------------
 * Clean up language_attributes() used in <html> tag
 *
 * Change lang="en-US" to lang="en"
 * Remove dir="ltr"
  /*----------------------------------------------------------------------------------- */

function sagarra_language_attributes() {
    $attributes = array();
    $output = '';

    if (function_exists('is_rtl')) {
        if (is_rtl() == 'rtl') {
            $attributes[] = 'dir="rtl"';
        }
    }

    $lang = get_bloginfo('language');

    if ($lang && $lang !== 'en-US') {
        $attributes[] = "lang=\"$lang\"";
    } else {
        $attributes[] = 'lang="en"';
    }
    if ($lang && $lang !== 'es-ES') {
        $attributes[] = "lang=\"$lang\"";
    } else {
        $attributes[] = 'lang="es"';
    }
    $output = implode(' ', $attributes);
    $output = apply_filters('roots_language_attributes', $output);

    return $output;
}

add_filter('language_attributes', 'sagarra_language_attributes');

function sagarra_pagination($pages = '', $range = 2) {
    $showitems = ($range * 2) + 1;

    global $paged;
    if (empty($paged))
        $paged = 1;

    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }

    if (1 != $pages) {
        echo "<div class='pagination'>";
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
            echo "<a href='" . get_pagenum_link(1) . "'>&laquo;</a>";
        if ($paged > 1 && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo;</a>";

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<span class='current'>" . $i . "</span>" : "<a href='" . get_pagenum_link($i) . "' class='inactive' >" . $i . "</a>";
            }
        }

        if ($paged < $pages && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($paged + 1) . "'>&rsaquo;</a>";
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
            echo "<a href='" . get_pagenum_link($pages) . "'>&raquo;</a>";
        echo "</div>\n";
    }
}

/*                  Frontend Display Functions                  */
/* ----------------------------------------------------------------------------------- */

function string_limit_words($string, $word_limit) {
    $words = explode(' ', $string, ($word_limit + 1));
    if (count($words) > $word_limit)
        array_pop($words);
    return implode(' ', $words);
}

/* ----------------------------------------------------------------------------------- */
if (!function_exists('sagarra_canonical_url')):

    function sagarra_canonical_url($echo = true) {
        if (is_home() OR is_front_page()) {
            $url = home_url();
        } elseif (is_singular()) {
            global $post;
            $url = get_permalink($post->ID);
        } else {
            global $wp;
            $url = add_query_arg($wp->query_string, '', home_url($wp->request));
        }

        if ($echo == true) {
            echo $url;
        } else {
            return $url;
        }
    }

endif;

/* ----------------------------------------------------------------------------------- */
if (!function_exists('sagarra_mime_types')):

    function sagarra_mime_types($mime_types) {
        $mime_types['ico'] = 'image/x-icon';

        return $mime_types;
    }

endif;

function delfi_allowed_mime_types($mime_types) {
    $mp3_mimes = array('audio/mpeg', 'audio/x-mpeg', 'audio/mp3', 'audio/x-mp3', 'audio/mpeg3', 'audio/x-mpeg3', 'audio/mpg', 'audio/x-mpg', 'audio/x-mpegaudio');
    foreach ($mp3_mimes as $mp3_mime) {
        $mime = $mp3_mime;
        preg_replace("/[^0-9a-zA-Z ]/", "", $mp3_mime);
        $mime_types['mp3|mp3_' . $mp3_mime] = $mime;
    }

    $mime_types['wav'] = 'audio/wav';
    return $mime_types;
}

add_filter('upload_mimes', 'sagarra_mime_types');

add_filter('delfi_allowed_mime_types', 'delfi_allowed_mime_types');

/* ----------------------------------------------------------------------------------- */
if (!function_exists('show_posts_nav')):

    function show_posts_nav() {
        global $wp_query;
        return ($wp_query->max_num_pages > 1);
    }

endif;

/* -----------------------------------------------------------------------------------------------------//
  /* Modify jpeg Quality
  ------------------------------------------------------------------------------------------------------- */
if (!function_exists('sagarra_jpeg_quality')):

    function sagarra_jpeg_quality($quality) {
        return 100;
    }

endif;

function elimina_ptags_en_images($content) {
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'elimina_ptags_en_images');


/* automatically remove default images links */

function sagarra_imagelink_setup() {
    $image_set = get_option('image_default_link_type');

    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}

add_action('admin_init', 'sagarra_imagelink_setup', 10);
/* ----------------------------------------------------------------------------------- */
/* ADMIN PANEL: Remove Unwanted Admin Menu Items */
/* ----------------------------------------------------------------------------------- */

add_theme_support('menus');

add_filter('the_content', 'filter_ptags_on_images');

function filter_ptags_on_images($content) {
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_action('widgets_init', 'category_sidebars');

function category_sidebars() {
    $categories = get_categories(array('hide_empty' => 0));

    foreach ($categories as $category) {
        if (0 == $category->parent)
            register_sidebar(array(
                'name' => $category->cat_name,
                'id' => $category->category_nicename . '-sidebar',
                'description' => 'Aquesta es la ' . $category->cat_name . ' widgetized area',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
    }
}

/* ----------------------------------------------------------------------------------- */
/* Remove Unwanted Admin Menu Items */
/* ----------------------------------------------------------------------------------- */

function remove_admin_menu_items() {
    $remove_menu_items = array(_('Comments'), _('Tools'), _('Feedback'));
    global $menu;
    end($menu);
    while (prev($menu)) {
        $item = explode(' ', $menu[key($menu)][0]);
        if (in_array($item[0] != NULL ? $item[0] : "", $remove_menu_items)) {
            unset($menu[key($menu)]);
        }
    }
}

add_action('admin_menu', 'remove_admin_menu_items');
add_action('admin_menu', 'remove_menus', 102);

function clean_wp_header() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rel_canonical');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'qtrans_header');
}

add_action('init', 'clean_wp_header');

function wps_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('wp-logo');
    $wp_admin_bar->remove_node('about');
    $wp_admin_bar->remove_node('wporg');
    $wp_admin_bar->remove_node('documentation');
    $wp_admin_bar->remove_node('support-forums');
    $wp_admin_bar->remove_node('feedback');
    $wp_admin_bar->remove_node('view-site');
}

add_action('wp_before_admin_bar_render', 'wps_admin_bar');

function no_autosave() {
    wp_deregister_script('autosave');
}

add_action('wp_print_scripts', 'no_autosave');

function remove_menus() {
    global $submenu;


    remove_menu_page('link-manager.php'); // Links
    remove_menu_page('edit-comments.php'); // Comments

    remove_menu_page('users.php'); // Users

    unset($submenu['themes.php'][5]); // Removes 'Themes'.
    unset($submenu['options-general.php'][15]); // Removes 'Writing'.
    unset($submenu['options-general.php'][25]); // Removes 'Discussion'.
    unset($submenu['tools.php'][5]); // Removes 'Available Tools'.
    unset($submenu['tools.php'][10]); // Removes 'Import'.
    unset($submenu['tools.php'][15]); // Removes 'Export'.

    remove_submenu_page('index.php', 'update-core.php');    //Dashboard->Updates
    remove_submenu_page('themes.php', 'themes.php'); // Appearance-->Themes
    remove_submenu_page('themes.php', 'widgets.php'); // Appearance-->Widgets
    remove_submenu_page('themes.php', 'theme-editor.php'); // Appearance-->Editor

    remove_submenu_page('options-general.php', 'options-general.php?page=viper-jquery-lightbox'); // Settings->General
    remove_submenu_page('options-general.php', 'options-writing.php'); // Settings->writing

    remove_submenu_page('options-general.php', 'options-discussion.php'); // Settings->Discussion

    remove_submenu_page('options-general.php', 'options-privacy.php'); // Settings->Privacy
}

add_action('manage_users_columns', 'remove_user_posts_column');
/* ----------------------------------------------------------------------------------- */
if (!function_exists('remove_user_posts_column')) :

    function remove_user_posts_column($column_headers) {
        unset($column_headers['posts']);
        unset($columns['tags']);
        return $column_headers;
    }

endif;

/* -----------------------------------------------------------------------------------
  DESIGN: Wordpress wp-post-image class remover
  /*----------------------------------------------------------------------------------- */
remove_action('begin_fetch_post_thumbnail_html', '_wp_post_thumbnail_class_filter_add');

/* -----------------------------------------------------------------------------------
 * HEADER: Remove the WordPress version from RSS feeds
  /*----------------------------------------------------------------------------------- */
add_filter('the_generator', '__return_false');

function drop_bad_comments() {
    if (!empty($_POST['comment'])) {
        $post_comment_content = $_POST['comment'];
        $lower_case_comment = strtolower($_POST['comment']);
        $bad_comment_content = array(
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
        if (in_comment_post_like($lower_case_comment, $bad_comment_content)) {
            $comment_box_text = wordwrap(trim($post_comment_content), 80, "\n ", true);
            $txtdrop = fopen('/var/log/httpd/wp_post-logger/nullamatix.com-text-area_dropped.txt', 'a');
            fwrite($txtdrop, " --------------\n [COMMENT] = " . $post_comment_content . "\n --------------\n");
            fwrite($txtdrop, " [SOURCE_IP] = " . $_SERVER['REMOTE_ADDR'] . " @ " . date("F j, Y, g:i a") . "\n");
            fwrite($txtdrop, " [USERAGENT] = " . $_SERVER['HTTP_USER_AGENT'] . "\n");
            fwrite($txtdrop, " [REFERER ] = " . $_SERVER['HTTP_REFERER'] . "\n");
            fwrite($txtdrop, " [FILE_NAME] = " . $_SERVER['SCRIPT_NAME'] . " - [REQ_URI] = " . $_SERVER['REQUEST_URI'] . "\n");
            fwrite($txtdrop, '--------------**********------------------' . "\n");
            header("HTTP/1.1 406 Not Acceptable");
            header("Status: 406 Not Acceptable");
            header("Connection: Close");
            wp_die(__('bang bang.'));
        }
    }
}

add_action('init', 'drop_bad_comments');


/* custom walker that only shows the menuitem's ID's (and active items get active classes), delevering clean menu code (in WordPress > 3.0)
 */

class hermit_walker extends Walker_Nav_Menu {

    function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        $current_indicators = array('current-menu-item', 'menu-item-type-custom', 'menu-item-object-page', 'menu-item-type-post_type', 'current-menu-parent', 'current_page_item', 'current_page_parent');

        $newClasses = array();

        foreach ($classes as $el) {
            //check if it's indicating the current page, otherwise we don't need the class
            if (in_array($el, $current_indicators)) {
                array_push($newClasses, $el);
            }
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($newClasses), $item));
        if ($class_names != '')
            $class_names = ' class="' . esc_attr($class_names) . '"';


        $output .= $indent . '<li id="menu-item-' . $item->ID . '"' . $value . $class_names . '>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .=!empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .=!empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .=!empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        if ($depth != 0) {
            //children stuff, maybe you'd like to store the submenu's somewhere?
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID);
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

}

/* ----------------------------------------------------------------------------------- */
/* Remove link from images and galleries
  /* ----------------------------------------------------------------------------------- */

function attachment_image_link_remove_filter($content) {
    $content = preg_replace(array('{<a[^>]*><img}', '{/></a>}'), array('<img', '/>'), $content);
    return $content;
}

function remove_media_link($form_fields, $post) {

    unset($form_fields['url']);

    return $form_fields;
}

add_filter('attachment_fields_to_edit', 'remove_media_link', 10, 2);

function hasgallery() {
    global $post;
    return (strpos($post->post_content, '[gallery') !== false);
}

add_filter('the_content', 'do_shortcode', 11);


/* ----------------------------------------------------------------------------------- */
/* Add Copyright/ */
/* ----------------------------------------------------------------------------------- */

function delfin_copyright() {
    global $wpdb;
    $copyright_dates = $wpdb->get_results("
SELECT
YEAR(min(post_date_gmt)) AS firstdate,
YEAR(max(post_date_gmt)) AS lastdate
FROM
$wpdb->posts
WHERE
post_status = 'publish'
");
    $output = '';
    if ($copyright_dates) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
        if ($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
            $copyright .= '-' . $copyright_dates[0]->lastdate;
        }
        $output = $copyright;
    }
    return $output;
}

/* -----------------------------------------------------------------------------------
 * Encode an email address to display on the website
 * http://www.paulund.co.uk/encode-email-with-php
 */

function encode_email_address($email) {
    $output = '';
    for ($i = 0; $i < strlen($email); $i++) {
        $output .= '&#' . ord($email[$i]) . ';';
    }
    return $output;
}

/* ----------------------------------------------------------------------------------- */
/* PAGES: History timeline function. Convert date to string
  /*----------------------------------------------------------------------------------- */

function stringToDate($string, $option) {
    $separator = "-";
    if (substr($option, 0, 1) == "Y") {
        if (strlen($option) > 1) {
            list($y, $m, $d) = explode($separator, $string);
        } else {
            $d = 1;
            $m = 1;
            $y = $string;
        }
    }
    if (substr($option, 0, 1) == "d")
        list($d, $m, $y) = explode($separator, $string);
    if (substr($option, 0, 1) == "m") {
        $d = 1;
        list($m, $y) = explode($separator, $string);
    }

    $date = new DateTime($y . '-' . $m . '-' . $d);
    return $date;
}

/* -----------------------------------------------------------------------------------
 * FORM SEARCH: Replacing the default WordPress search form with an HTML5 version
 *
  /*----------------------------------------------------------------------------------- */

function html5_search_form($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '" >
    <label class="assistive-text" for="s">' . __('Search for:') . '</label>
    <input type="search" placeholder="' . __("Enter term...") . '" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="Search" />
    </form>';

    return $form;
}

add_filter('get_search_form', 'html5_search_form');


add_action('template_redirect', 'redirect_single_post');

function redirect_single_post() {
    if (is_search()) {
        global $wp_query;
        if ($wp_query->post_count == 1) {
            wp_redirect(get_permalink($wp_query->posts['0']->ID));
        }
    }
}

/* ----------------------------------------------------------------------------------- */

/**
 * // Miniaturas de imagen en el panel de administracion
 *
  /*----------------------------------------------------------------------------------- */
add_theme_support('post-thumbnails', array('post', 'page'));

add_image_size('admin-thumb', 150, 150, true);
add_image_size('sagarra-thumb', 360, 240, true);
add_image_size('article-thumb', 360, 210, true);
add_image_size('timeline-thumb', 200, 200, true);
add_image_size('gal-thumb', 432, 432, 1); // Sagarra Style
add_image_size('retina', 768, 9999, true);


if (!function_exists('delfi_remove_imge_size')):

    function delfi_remove_image_size() {

        if (has_post_thumbnail()) {
            $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
            echo '<img src="' . $image_src[0] . '" width="100%"  />';
        }
        return this;
    }

endif;
/* ----------------------------------------------------------------------------------- */
add_image_size('resp-large', 720, 9999, true);
add_image_size('resp-medium', 9999, 9999, true);
add_image_size('resp-small', 320, 9999, true);

/* ----------------------------------------------------------------------------------- */
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
add_filter('manage_pages_columns', 'posts_columns', 5);
add_action('manage_pages_custom_column', 'posts_custom_columns', 5, 2);

function posts_columns($defaults) {
    $defaults['wps_post_thumbs'] = __('Thumbs');
    return $defaults;
}

function posts_custom_columns($column_name, $id) {
    if ($column_name === 'wps_post_thumbs') {
        echo the_post_thumbnail('admin-thumb');
    }
}

/* ----------------------------------------------------------------------------------- */

function sagarra_login_head() {
    remove_action('login_head', 'wp_shake_js', 12);
}

add_action('login_head', 'sagarra_login_head');

/* ----------------------------------------------------------------------------------- */
add_filter('login_errors', create_function('$a', "return null;"));

function the_breadcrumb() {
    if (!is_home()) {
        echo '<a href="';
        echo get_option('home');
        echo '">';
        bloginfo('name');
        echo "</a> Â» ";
    } elseif (is_page()) {
        echo the_title();
    }
}

/* ----------------------------------------------------------------------------------- */

function enable_more_buttons($buttons) {
    $buttons[] = 'styleselect';
    $buttons[] = 'hr';
    return $buttons;
}

add_filter("mce_buttons_3", "enable_more_buttons");

/* ----------------------------------------------------------------------------------- */

function remove_upgrade_sagarra() {
    echo '<style type="text/css">
           .update-nag {display: none}
         </style>';
}

add_action('admin_head', 'remove_upgrade_sagarra');

// Remove non-validating rel attributes from category links

/* ----------------------------------------------------------------------------------- */

function delfi_fix_link_category($c) {
    return preg_replace('/category tag/', 'tag', $c);
}

add_filter('the_category', 'delfi_fix_link_category');

// Add a proper thousands delimiter to category post counts
/* ----------------------------------------------------------------------------------- */
function delim($c) {
    return preg_replace('/(\d)(\d{3})\b/', '\1,\2', $c); // Hat tip to @myfonts for the regex tweaks
}

add_filter('wp_list_categories', 'delim');

// Remove class and ID attributes from list elements
/* ----------------------------------------------------------------------------------- */
if (!function_exists('delfi_list')):

    function delfi_list($c) {
        $c_ = preg_replace('/ class=[\"\'].+?[\"\']/', '', $c);
        return preg_replace('/ id=[\"\'].+?[\"\']/', '', $c_);
    }

endif;

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
  /*----------------------------------------------------------------------------------- */
function roots_nice_search_redirect() {
    global $wp_rewrite;
    if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
        return;
    }

    $search_base = $wp_rewrite->search_base;
    if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
        wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
        exit();
    }
}

if (current_theme_supports('nice-search')) {
    add_action('template_redirect', 'roots_nice_search_redirect');
}

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
  /*----------------------------------------------------------------------------------- */
function roots_request_filter($query_vars) {
    if (isset($_GET['s']) && empty($_GET['s'])) {
        $query_vars['s'] = ' ';
    }

    return $query_vars;
}

add_filter('request', 'roots_request_filter');

/* ----------------------------------------------------------------------------------- */

//Deletes all CSS classes and id's, except for those listed in the array below
//Deletes all CSS classes and id's, except for those listed in the array below
function sagarra_nav_menu($var) {
    return is_array($var) ? array_intersect($var, array(
                'current_page_item',
                'first',
                'last',
                'vertical',
                'horizontal'
                    )
            ) : '';
}

add_filter('nav_menu_css_class', 'sagarra_nav_menu');
add_filter('nav_menu_item_id', 'sagarra_nav_menu');
add_filter('page_css_class', 'sagarra_nav_menu');

//Replaces "current-menu-item" with "active"
function current_to_active($text) {
    $replace = array(
        'current_page_item' => 'active',
        'current_page_parent' => 'active',
        'current_page_ancestor' => 'active',
    );
    $text = str_replace(array_keys($replace), $replace, $text);
    return $text;
}

add_filter('wp_nav_menu', 'current_to_active');

function strip_empty_classes($menu) {
    $menu = preg_replace('/ class=""| class="sub-menu"/', '', $menu);
    return $menu;
}

add_filter('wp_nav_menu', 'strip_empty_classes');

function nav_class_filter($var) {
    return is_array($var) ? array_intersect($var, array('current-menu-item')) : '';
}

add_filter('nav_menu_css_class', 'nav_class_filter', 100, 1);

// Add page slug as nav IDs
function nav_id_filter($id, $item) {
    return 'nav-' . cleanname($item->title);
}

add_filter('nav_menu_item_id', 'nav_id_filter', 10, 2);

function cleanname($v) {
    $v = preg_replace('/[^a-zA-Z0-9s]/', '', $v);
    $v = str_replace(' ', '-', $v);
    $v = strtolower($v);
    return $v;
}

/* ----------------------------------------------------------------------------------- */

//Replaces "current-menu-item" with "active"
/* ----------------------------------------------------------------------------------- */
function delfi_link_current_to_active($text) {
    $replace = array(
        'current_page_item' => 'active',
        'current_page_parent' => 'active',
        'current_page_ancestor' => 'active',
    );
    $text = str_replace(array_keys($replace), $replace, $text);
    return $text;
}

add_filter('wp_nav_menu', 'delfi_link_current_to_active');
/* ----------------------------------------------------------------------------------- */



/* ----------------------------------------------------------------------------------- */

function rt_post_join($join, $isc, $ec) {
    global $wpdb;

    $join = " INNER JOIN $wpdb->postmeta AS pm ON pm.post_id = p.ID";
    return $join;
}

function rt_prev_post_where($w) {
    global $wpdb, $post;

    $prd = get_post_meta($post->ID, 'release_date', true);
    $w = $wpdb->prepare(" WHERE pm.meta_key = 'release_date' AND pm.meta_value < '$prd' AND p.post_type = 'products' AND p.post_status = 'publish'");
    return $w;
}

function rt_next_post_where($w) {
    global $wpdb, $post;

    $prd = get_post_meta($post->ID, 'release_date', true);
    $w = $wpdb->prepare(" WHERE pm.meta_key = 'release_date' AND pm.meta_value > '$prd' AND p.post_type = 'products' AND p.post_status = 'publish'");
    return $w;
}

function rt_prev_post_sort($o) {
    $o = "ORDER BY pm.meta_value DESC LIMIT 1";
    return $o;
}

function rt_next_post_sort($o) {
    $o = "ORDER BY pm.meta_value ASC LIMIT 1";
    return $o;
}

/* -----------------------------------------------------------------------------------------------------//
  //ADMIN PANEL: Re-attach images
  ------------------------------------------------------------------------------------------------------- */
add_filter("manage_upload_columns", 'upload_columns');
add_action("manage_media_custom_column", 'media_custom_columns', 0, 2);

function upload_columns($columns) {

    unset($columns['parent']);
    $columns['better_parent'] = "Parent";

    return $columns;
}

function media_custom_columns($column_name, $id) {

    $post = get_post($id);

    if ($column_name != 'better_parent')
        return;

    if ($post->post_parent > 0) {
        if (get_post($post->post_parent)) {
            $title = _draft_or_post_title($post->post_parent);
        }
        ?>
        <strong><a href="<?php echo get_edit_post_link($post->post_parent); ?>"><?php echo $title ?></a></strong>, <?php echo get_the_time(__("Y/m/d")); ?>
        <br />
        <a class="hide-if-no-js" onclick="findPosts.open('media[]', '<?php echo $post->ID ?>');
                return false;" href="#the-list"><?php _e('Re-Attach'); ?></a></td>

        <?php
    } else {
        ?>
        <?php _e('(Unattached)'); ?><br />
        <a class="hide-if-no-js" onclick="findPosts.open('media[]', '<?php echo $post->ID ?>');
                return false;" href="#the-list"><?php _e('Attach'); ?></a>
           <?php
       }
   }

   /* -----------------------------------------------------------------------------------------------------//
     Custom Search Widget
     ------------------------------------------------------------------------------------------------------- */

   function style_search_form($form) {
       $form = '<form method="get" id="searchform" action="' . get_option('home') . '/" >
            <label for="s">' . __('') . '</label>
            <div>';
       if (is_search()) {
           $form .='<input type="text" value="' . attribute_escape(apply_filters('the_search_query', get_search_query())) . '" name="s" id="s" />';
       } else {
           $form .='<input type="text" value="Search Site" name="s" id="s"  onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;"/>';
       }
       $form .= '<input type="submit" id="searchsubmit" value="' . attribute_escape(__('Go')) . '" />
            </div>
            </form>';
       return $form;
   }

   add_filter('get_search_form', 'style_search_form');

   /* ----------------------------------------------------------------------------------- */
   /* 	Pagination Function
     /*----------------------------------------------------------------------------------- */
   if (!function_exists('get_pagination_links')):

       function get_pagination_links() {
           global $wp_query;
           $big = 999999999;
           echo paginate_links(array(
               'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
               'format' => '?paged=%#%',
               'current' => max(1, get_query_var('paged')),
               'prev_text' => __('Â«'),
               'next_text' => __('Â»'),
               'total' => $wp_query->max_num_pages
           ));
       }

   endif;

   /* ----------------------------------------------------------------------------------- */
   /* 	Custom Page Links
     /*----------------------------------------------------------------------------------- */

   function wp_link_pages_args_prevnext_add($args) {
       global $page, $numpages, $more, $pagenow;

       if (!$args['next_or_number'] == 'next_and_number')
           return $args;

       $args['next_or_number'] = 'number';
       if (!$more)
           return $args;

       if ($page - 1)
           $args['before'] .= _wp_link_page($page - 1)
                   . $args['link_before'] . $args['previouspagelink'] . $args['link_after'] . '</a>';

       if ($page < $numpages) // There is a next page
           $args['after'] = _wp_link_page($page + 1)
                   . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>'
                   . $args['after'];

       return $args;
   }

   add_filter('wp_link_pages_args', 'wp_link_pages_args_prevnext_add');


   /* ---------------------------------
     Deal with WP empty paragraphcs
     /*----------------------------------------------------------------------------------- */

   function delfi_formatter($content) {

       $bad_content = array('<p></div></p>', '<p><div class="full', '_width"></p>', '</div></p>', '<p><ul', '</ul></p>', '<p><div', '<p><block', 'quote></p>', '<p><hr /></p>', '<p><table>', '<td></p>', '<p></td>', '</table></p>', '<p></div>', 'nosidebar"></p>', '<p><p>', '<p><a', '</a></p>', '-half"></p>', '-third"></p>', '-fourth"></p>', '<p><p', '</p></p>', 'child"></p>', '<p></p>', '-fifth"></p>', '-sixth"></p>', 'last"></p>', 'fix" /></p>', '<p><hr', '<p><li', '"centered"></p>', '</li></p>', '<div></p>', '<p></ul>', '<p><img', ' /></p>', '"nop"></p>', 'tures"></p>', '"left"></p>', '<p><h1 class="center">', 'centered"></p>');
       $good_content = array('</div>', '<div class="full', '_width">', '</div>', '<ul', '</ul>', '<div', '<block', 'quote>', '<hr />', '<table>', '<td>', '</td>', '</table>', '</div>', 'nosidebar">', '<p>', '<a', '</a>', '-half">', '-third">', '-fourth">', '<p', '</p>', 'child">', '', '-fifth">', '-sixth">', 'last">', 'fix" />', '<hr', '<li', '"centered">', '</li>', '<div>', '</ul>', '<img', ' />', '"nop">', 'tures">', '"left">', '<h1 class="center">', 'centered">');

       $new_content = str_replace($bad_content, $good_content, $content);
       return $new_content;
   }

   remove_filter('the_content', 'wpautop');
   add_filter('the_content', 'wpautop', 10);
   add_filter('the_content', 'delfi_formatter', 11);

   /* ---------------------------------
     Fix empty search issue
     /*----------------------------------------------------------------------------------- */

   function delfi_request_filter($query_vars) {
       if (isset($_GET['s']) && empty($_GET['s'])) {
           $query_vars['s'] = " ";
       }
       return $query_vars;
   }

   add_filter('request', 'delfi_request_filter');


   /* ----------------------------------------------------------------------------------- */

//WIDGETS : Registro de barra lateral
   /* ----------------------------------------------------------------------------------- */
   function delfi_widgets_init() {
       if (function_exists('register_sidebar'))
           register_sidebar(array(
               'name' => 'Footer Widgets Esquerra',
               'id' => 'left-footer',
               'before_widget' => '',
               'after_widget' => '',
               'before_title' => '<h3 class="sagarra-title">',
               'after_title' => '</h3>'
           ));

       if (function_exists('register_sidebar'))
           register_sidebar(array(
               'name' => 'Footer Widgets Centre',
               'id' => 'center-footer',
               'before_widget' => '',
               'after_widget' => '',
               'before_title' => '<h3 class="sagarra-title">',
               'after_title' => '</h3>'
           ));

       if (function_exists('register_sidebar'))
           register_sidebar(array(
               'name' => 'Footer Widgets Dreta',
               'id' => 'right-footer',
               'before_widget' => '',
               'after_widget' => '',
               'before_title' => '<h3 class="sagarra-title">',
               'after_title' => '</h3>'
           ));
   }

   add_action('init', 'delfi_widgets_init');

   /* ----------------------------------------------------------------------------------- */


   /* ----------------------------------------------------------------------------------- */

// Register Theme Features
   /* ----------------------------------------------------------------------------------- */
   function custom_theme_features() {

       // Add theme support for Post Formats
       $formats = array('status', 'quote', 'gallery', 'image', 'video', 'audio');
       add_theme_support('post-formats', $formats);
   }

   /* ----------------------------------------------------------------------------------- */

   function excerpt($limit) {
       $excerpt = explode(' ', get_the_excerpt(), $limit);
       if (count($excerpt) >= $limit) {
           array_pop($excerpt);
           $excerpt = implode(" ", $excerpt) . '...';
       } else {
           $excerpt = implode(" ", $excerpt);
       }
       $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
       return $excerpt;
   }

   /* ----------------------------------------------------------------------------------- */

   function content($limit) {
       $content = explode(' ', get_the_content(), $limit);
       if (count($content) >= $limit) {
           array_pop($content);
           $content = implode(" ", $content) . '...';
       } else {
           $content = implode(" ", $content);
       }
       $content = preg_replace('/\[.+\]/', '', $content);
       $content = apply_filters('the_content', $content);
       $content = str_replace(']]>', ']]&gt;', $content);
       return $content;
   }

   /* ------------------------------------------------------------------------------------
     Strip inline width and height attributes from WP generated images
     /*----------------------------------------------------------------------------------- */

   function remove_thumbnail_dimensions($html) {
       $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
       return $html;
   }

   add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
   add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);


   /* -----------------------------------------------------------------------------------
    * Segonquart Custom Template
    *
     /*----------------------------------------------------------------------------------- */

   add_filter('the_content', 'make_clickable');
   /* ----------------------------------------------------------------------------------- */

   function modify_footer_admin() {
       echo 'Website designed and developed by <a href="http://segonquart.net">Delfi Ramirez - Segonquart Studio</a>.';
   }

   add_filter('admin_footer_text', 'modify_footer_admin');

   function custom_post_columns($defaults) {
       unset($defaults['comments']);
       return $defaults;
   }

   add_filter('manage_posts_columns', 'custom_post_columns');

   function custom_pages_columns($defaults) {
       unset($defaults['comments']);
       unset($defaults['date']);

       return $defaults;
   }

   function remove_more_jump_link($link) {
       $offset = strpos($link, '#more-');
       if ($offset) {
           $end = strpos($link, '"', $offset);
       }
       if ($end) {
           $link = substr_replace($link, '', $offset, $end - $offset);
       }
       return $link;
   }

   add_filter('the_content_more_link', 'remove_more_jump_link');

   function admin_color_scheme() {
       global $_wp_admin_css_colors;
       $_wp_admin_css_colors = 0;
   }

   add_action('admin_head', 'admin_color_scheme');

   /* ----------------------------------------------------------------------------------- */

   function add_remove_contactmethods($contactmethods) {
       $contactmethods['twitter'] = 'Twitter';
       $contactmethods['facebook'] = 'Facebook';
       $contactmethods['linkedin'] = 'Linked In';
       // this will remove existing contact fields
       unset($contactmethods['aim']);
       unset($contactmethods['yim']);
       unset($contactmethods['jabber']);
       return $contactmethods;
   }

   add_filter('user_contactmethods', 'add_remove_contactmethods', 10, 1);

   /* ----------------------------------------------------------------------------------- */

   function posts_columns_attachment_count($defaults) {
       $defaults['wps_post_attachments'] = __('Images');
       return $defaults;
   }

   function posts_custom_columns_attachment_count($column_name, $id) {
       if ($column_name === 'wps_post_attachments') {
           $attachments = get_children(array('post_parent' => $id));
           $count = count($attachments);
           if ($count != 0) {
               echo $count;
           }
       }
   }

   /* ----------------------------------------------------------------------------------- */

   function remove_recent_comments_style() {
       global $wp_widget_factory;
       remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
   }

   add_action('widgets_init', 'remove_recent_comments_style');

   function remove_comments() {
       global $wp_admin_bar;
       $wp_admin_bar->remove_menu('comments');
   }

   add_action('wp_before_admin_bar_render', 'remove_comments');
   /* ----------------------------------------------------------------------------------- */

   function wps_recent_posts_dw() {
       ?>
    <ol>
        <?php
        global $post;
        $args = array('numberposts' => 5);
        $myposts = get_posts($args);
        foreach ($myposts as $post) : setup_postdata($post);
            ?>
            <li> (<? the_date('Y / n / d'); ?>) <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endforeach; ?>
    </ol>
    <?php
}

function add_wps_recent_posts_dw() {
    wp_add_dashboard_widget('wps_recent_posts_dw', __('Recent Posts'), 'wps_recent_posts_dw');
}

add_action('wp_dashboard_setup', 'add_wps_recent_posts_dw');

/* ----------------------------------------------------------------------------------- */

function remove_default_post_screen_metaboxes() {
    remove_meta_box('authordiv', 'post', 'normal');
}

add_action('admin_menu', 'remove_default_post_screen_metaboxes');
/* ----------------------------------------------------------------------------------- */

function single_screen_columns($columns) {
    $columns['dashboard'] = 1;
    return $columns;
}

add_filter('screen_layout_columns', 'single_screen_columns');

function single_screen_dashboard() {
    return 1;
}

add_filter('get_user_option_screen_layout_dashboard', 'single_screen_dashboard');

// disable comment feeds for individual posts
/* ----------------------------------------------------------------------------------- */
function disablePostCommentsFeedLink($for_comments) {
    return;
}

add_filter('post_comments_feed_link', 'disablePostCommentsFeedLink');

/* ----------------------------------------------------------------------------------- */

// Call Googles HTML5 Shim, but only for users on old versions of IE
/* ----------------------------------------------------------------------------------- */


function sagarra_IEhtml5_shim() {
    global $is_IE;
    if ($is_IE)
        echo '<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->';
}

add_action('wp_footer', 'sagarra_IEhtml5_shim');


/* ----------------------------------------------------------------------------------- */

// ADMIN: Cambia Post por Article
/* ----------------------------------------------------------------------------------- */


function change_post_to_article($translated) {
    $translated = str_ireplace('Post', 'Article', $translated);  // ireplace is PHP5 only
    return $translated;
}

if (!function_exists('wps_remove_theme_name')) {

    function wps_remove_theme_name($translated) {
        $translated = str_ireplace('Theme <span class="b">%1$s</span> with', '', $translated);
        return $translated;
    }

}
global $user_ID;
if ($user_ID) {
    if (!current_user_can('administrator')) {
        if (strlen($_SERVER['REQUEST_URI']) > 255 ||
                stripos($_SERVER['REQUEST_URI'], "eval(") ||
                stripos($_SERVER['REQUEST_URI'], "CONCAT") ||
                stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
                stripos($_SERVER['REQUEST_URI'], "base64")) {
            @header("HTTP/1.1 414 Request-URI Too Long");
            @header("Status: 414 Request-URI Too Long");
            @header("Connection: Close");
            @exit;
        }
    }
}

/* ----------------------------------------------------------------------------------- */
// ADMIN LOGIN : @desc update logo URL to point towards DI
/* ----------------------------------------------------------------------------------- */
add_filter('login_headerurl', 'custom_login_header_url');

function custom_login_header_url($url) {
    return 'http://rotulosagarra.com/';
}

/* ----------------------------------------------------------------------------------- */

// ADMIN LOGIN:  Personalizacion del panel de acceso
/* ----------------------------------------------------------------------------------- */

function elimina_lostpassword_text($text) {
    if ($text == 'Lost your password?') {
        $text = '';
    }
    return $text;
}

add_filter('gettext', 'elimina_lostpassword_text');

function elimina_volver_text($text) {
    if ($text == 'Â«Back to Rotulos Sagarra') {
        $text = '';
    }
    return $text;
}

add_filter('gettext', 'elimina_volver_text');
/* ----------------------------------------------------------------------------------- */

// ADMIN LOGIN:  Login con usuario
/* ----------------------------------------------------------------------------------- */
function login_con_email($username) {
    $user = get_user_by_email($username);
    if (!empty($user->user_login))
        $username = $user->user_login;
    return $username;
}

add_action('wp_authenticate', 'login_con_email');

/* ----------------------------------------------------------------------------------- */

// ADMIN LOGIN:  Personalizacion CSS
/* ----------------------------------------------------------------------------------- */

function login_enqueue_scripts() {

    echo '

			<div class="background-cover"></div>

			<style type="text/css" media="screen">
.background-cover {
	background: url(http://rotulosagarra.com/static/images/bg.jpg) no-repeat center center fixed;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	position: fixed;
	top: 0;
	left: 0;
	z-index: 10;
	overflow: hidden;
	width: 100%;
	height: 100%;
	opacity:.8;
}

#login {
	z-index: 9999;
	position: relative;
}

.login form {
	width: 300px;
	background:#111;
	margin: 0 auto;
	position: relative;
	z-index: 5;
	border-radius: 5px;
	background: #fff;
	border: 1px solid #fff;
	box-shadow: 0px 1px 5px rgba(0,0,0,0.5);
	-moz-box-shadow: 0px 1px 5px rgba(0,0,0,0.5);
	-webkit-box-shadow: 0px 1px 5px rgba(0,0,0,0.5);
}



.login form.header span {
	font-size: 13px;
	line-height: 16px;
	color: #678889;
	font-weight: 400;
	text-shadow: 1px 1px 0 rgba(256,256,256,1.0);
}

.login-form .content {
	padding: 0;
	position: relative;
	z-index: 1;
}

.login form  .input {
	width: 188px !important;
	padding: 15px 25px;
	font-weight: 400;
	font-size: 14px;
	color: #9d9e9e;
	text-shadow: 1px 1px 0 rgba(256,256,256,1.0);
	border: 1px solid #fff;
	border-radius: 5px;
	box-shadow: inset 0 1px 3px rgba(0,0,0,0.50);
	-moz-box-shadow: inset 0 1px 3px rgba(0,0,0,0.50);
	-webkit-box-shadow: inset 0 1px 3px rgba(0,0,0,0.50);
}
.login form  .input:hover {

	color: #414848;
}

.login form  .input:focus {
	background: #fdfdfd;
	color: #414848;
	box-shadow: inset 0 1px 2px rgba(0,0,0,0.25);
	-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.25);
	-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.25);
}

input {
	outline: none;
}
.login form .header h1 {

}
a{
padding:0;
margin:0;

}
.login h1 a {
	background: url("http://static.rotulossagarra.com/images/sagarra-logo.png") no-repeat top left !important;
	width: 274px;
	height: 3px;
	display: block;
	margin-bottom: 10px;
	text-align: center;
	margin-top: 15px;
}

.wp-core-ui .button-primary {
	float:right;
	padding: 11px 25px;
	font-weight: 300;
	font-size: 18px;
	color: #fff;
	text-shadow: 0px 1px 0 rgba(0,0,0,0.25);
	border-radius:5px;
	background: #F15A29;
	border: 1px solid #fff;
	cursor: pointer;

	box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
	-moz-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
	-webkit-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
}

.button:active, .submit input:active, .button-secondary:active {
	display: block;
	float: right;
	padding: 10px;
	margin-right: 20px;

	background: none;
	border: none;
	cursor: pointer;

	font-weight: 300;
	font-size: 18px;
	color: #414848;
	text-shadow: 0px 1px 0 rgba(256,256,256,0.5);
}

.login #nav a, .login #backtoblog a {
	color: #fff !important;
	text-shadow: none !important;
}

.login #nav a:hover, .login #backtoblog a:hover {
	color: #96C800 !important;
	text-shadow: none !important;
}

.login #nav, .login #backtoblog {
	text-shadow: none !important;
}

/* Second input field */

.login form  .input .password,.login form  .input .pass-icon {
	margin-top: 25px;
}

.error-password {
	top: 73px;
}

.user-icon, .pass-icon, .error-login, .error-password {
	width: 46px;
	height: 47px;
	display: block;
	position: absolute;
	left: 0px;
	padding-right: 2px;
	z-index: -3;
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-bottomleft: 5px;
	-webkit-border-top-left-radius: 5px;
	-webkit-border-bottom-left-radius: 5px;
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
}

.user-icon {
	top: 0;
	background: #171717 url(images/user-icon.png) no-repeat center;
}

.pass-icon {
	top: 48px;
	background: #171717 url(images/pass-icon.png) no-repeat center;
}

/* Animation */

.input, .user-icon, .pass-icon, .button, .register {
	transition: all 0.5s;
	-moz-transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-o-transition: all 0.5s;
	-ms-transition: all 0.5s;
}

.login form .footer {
	padding: 20px 30px 30px;
	overflow: auto;
}

/* Login button */

.login form .footer .button {
		float:right;
	padding: 11px 25px;
	font-weight: 300;
	font-size: 18px;
	color: #fff;
	text-shadow: 0px 1px 0 rgba(0,0,0,0.25);
	border-radius:5px;
	background: #F15A29;
	border: 1px solid #fff;
	cursor: pointer;

	box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
	-moz-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
	-webkit-box-shadow: inset 0 0 2px rgba(256,256,256,0.75);
}

.login form .footer .button:hover {
	background: #171717;
	border: 1px solid rgba(256,256,256,0.75);
	box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
	-moz-box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
	-webkit-box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
}

.login form .footer .button:focus {
	position: relative;
	bottom: -1px;
	background: #56c2e1;
	box-shadow: inset 0 1px 6px rgba(256,256,256,0.75);
	-moz-box-shadow: inset 0 1px 6px rgba(256,256,256,0.75);
	-webkit-box-shadow: inset 0 1px 6px rgba(256,256,256,0.75);
}

/* Register button */

.login form .footer .register {
	display: block;
	float: right;
	padding: 10px;
	margin-right: 20px;
	background: none;
	border: none;
	cursor: pointer;
	font-weight: 300;
	font-size: 18px;
	color: #414848;
	text-shadow: 0px 1px 0 rgba(256,256,256,0.5);
}

#login-form .footer .register:hover {
	color: #3f9db8;
}

#login-form .footer .register:focus {
	position: relative;
	bottom: -1px;
}

.company {
	margin-bottom: 45px;
	min-width: 600px;
}

.company a {
	width: 100%;
	max-width: 600px;
}

.company a img {
	left: 50%;
	position: relative;
}

.inputs {
	background: #FFFFFF;
	padding: 0 30px 15px;
}

.error-login, .error-password {
	background: url("images/error.png") no-repeat scroll center center #171717;
	left: -49px;
}

.company {
	margin-bottom: 20px;
}


				</style>

		';
}

add_action('login_enqueue_scripts', 'login_enqueue_scripts');

/* -----------------------------------------------------------------------------------
 * // Funcion  que limita a 14 el numero de articulos por pagina.
 *
  /*----------------------------------------------------------------------------------- */

function cuatro_ultimos($query) {
    if ($query->is_home() && $query->is_main_query()) {
        $query->set('posts_per_page', '14');
    }
}

add_action('pre_get_posts', 'cuatro_ultimos');

add_filter('login_errors', create_function('$a', "return null;"));
/* -----------------------------------------------------------------------------------
  // ADMIN: no more jumping for read more link
  /*----------------------------------------------------------------------------------- */

// category id in body and post class
/* ----------------------------------------------------------------------------------- */
function category_id_class($classes) {
    global $post;
    foreach ((get_the_category($post->ID)) as $category)
        $classes [] = 'cat-' . $category->cat_ID . '-id';
    return $classes;
}

add_filter('post_class', 'category_id_class');
add_filter('body_class', 'category_id_class');

// show admin bar only for admins and editors
/* ----------------------------------------------------------------------------------- */
if (!current_user_can('edit_posts')) {
    add_filter('show_admin_bar', '__return_false');
}

function style_sagarra_menu_class($items) {
    $items[1]->classes[] = 'first';
    $items[count($items)]->classes[] = 'last';
    return $items;
}

add_filter('wp_nav_menu_objects', 'style_sagarra_menu_class');


/* -----------------------------------------------------------------------------------
 * Autor del site en G+
 *
  /*----------------------------------------------------------------------------------- */
add_action('wp_head', 'google_web_author');

function google_web_author() {
    echo '<link rel="author" href="https://plus.google.com/+DelfiRamirez" />';
}

/* ----------------------------------------------------------------------------------- */

// ADMIN LOGIN:  Cambiar el link de web en pagina de registro
/* ----------------------------------------------------------------------------------- */
function change_sagarra_login_url() {
    return get_home_url();
}

add_filter('login_headerurl', 'change_sagarra_login_url');
/* ----------------------------------------------------------------------------------- */

// ADMIN LOGIN:  Cambiar el atributo de web en pagina de registro
/* ----------------------------------------------------------------------------------- */

function change_sagarra_login_title() {
    echo get_option('blogname');
}

add_filter('login_headertitle', 'change_sagarra_login_title');

/* ----------------------------------------------------------------------------------- */

// ADMIN LOGIN:  Permite acceder mediante el uso de email
/* ----------------------------------------------------------------------------------- */

function email_address_login($username) {
    $user = get_user_by_email($username);
    if (!empty($user->user_login))
        $username = $user->user_login;
    return $username;
}

add_action('wp_authenticate', 'email_address_login');


/* ----------------------------------------------------------------------------------- */


/* -----------------------------------------------------------------------------------
 * Archive para Optimizacion SEO eliminando palabras del SLUG del POST
  /*----------------------------------------------------------------------------------- */

function seo_slugs($slug) {
    if ($slug)
        return $slug;
    global $wpdb;
    $seo_slug = strtolower(stripslashes($_POST['post_title']));
    $seo_slug = preg_replace('/&.+?;/', '', $seo_slug);
    $seo_slug = preg_replace("/[^a-zA-Z0-9 \']/", "", $seo_slug);
    $seo_slug_array = array_diff(split(" ", $seo_slug), seo_slugs_stop_words());
    $seo_slug = join("-", $seo_slug_array);
    return $seo_slug;
}

add_filter('name_save_pre', 'seo_slugs', 0);

function seo_slugs_stop_words() {
    return array("a", "able", "about", "above", "abroad", "according", "accordingly", "across", "actually", "adj", "after", "afterwards", "again", "against", "ago", "ahead", "ain't", "all", "allow", "allows", "almost", "alone", "along", "alongside", "already", "also", "although", "always", "am", "amid", "amidst", "among", "amongst", "an", "and", "another", "any", "anybody", "anyhow", "anyone", "anything", "anyway", "anyways", "anywhere", "apart", "appear", "appreciate", "appropriate", "are", "aren't", "around", "as", "a's", "aside", "ask", "asking", "associated", "at", "available", "away", "awfully", "b", "back", "backward", "backwards", "be", "became", "because", "become", "becomes", "becoming", "been", "before", "beforehand", "begin", "behind", "being", "believe", "below", "beside", "besides", "best", "better", "between", "beyond", "both", "brief", "but", "by", "c", "came", "can", "cannot", "cant", "can't", "caption", "cause", "causes", "certain", "certainly", "changes", "clearly", "c'mon", "co", "co.", "com", "come", "comes", "concerning", "consequently", "consider", "considering", "contain", "containing", "contains", "corresponding", "could", "couldn't", "course", "c's", "currently", "d", "dare", "daren't", "definitely", "described", "despite", "did", "didn't", "different", "directly", "do", "does", "doesn't", "doing", "done", "don't", "down", "downwards", "during", "e", "each", "edu", "eg", "eight", "eighty", "either", "else", "elsewhere", "end", "ending", "enough", "entirely", "especially", "et", "etc", "even", "ever", "evermore", "every", "everybody", "everyone", "everything", "everywhere", "ex", "exactly", "example", "except", "f", "fairly", "far", "farther", "few", "fewer", "fifth", "first", "five", "followed", "following", "follows", "for", "forever", "former", "formerly", "forth", "forward", "found", "four", "from", "further", "furthermore", "g", "get", "gets", "getting", "given", "gives", "go", "goes", "going", "gone", "got", "gotten", "greetings", "h", "had", "hadn't", "half", "happens", "hardly", "has", "hasn't", "have", "haven't", "having", "he", "he'd", "he'll", "hello", "help", "hence", "her", "here", "hereafter", "hereby", "herein", "here's", "hereupon", "hers", "herself", "he's", "hi", "him", "himself", "his", "hither", "hopefully", "how", "howbeit", "however", "hundred", "i", "i'd", "ie", "if", "ignored", "i'll", "i'm", "immediate", "in", "inasmuch", "inc", "inc.", "indeed", "indicate", "indicated", "indicates", "inner", "inside", "insofar", "instead", "into", "inward", "is", "isn't", "it", "it'd", "it'll", "its", "it's", "itself", "i've", "j", "just", "k", "keep", "keeps", "kept", "know", "known", "knows", "l", "last", "lately", "later", "latter", "latterly", "least", "less", "lest", "let", "let's", "like", "liked", "likely", "likewise", "little", "look", "looking", "looks", "low", "lower", "ltd", "m", "made", "mainly", "make", "makes", "many", "may", "maybe", "mayn't", "me", "mean", "meantime", "meanwhile", "merely", "might", "mightn't", "mine", "minus", "miss", "more", "moreover", "most", "mostly", "mr", "mrs", "much", "must", "mustn't", "my", "myself", "n", "name", "namely", "nd", "near", "nearly", "necessary", "need", "needn't", "needs", "neither", "never", "neverf", "neverless", "nevertheless", "new", "next", "nine", "ninety", "no", "nobody", "non", "none", "nonetheless", "noone", "no-one", "nor", "normally", "not", "nothing", "notwithstanding", "novel", "now", "nowhere", "o", "obviously", "of", "off", "often", "oh", "ok", "okay", "old", "on", "once", "one", "ones", "one's", "only", "onto", "opposite", "or", "other", "others", "otherwise", "ought", "oughtn't", "our", "ours", "ourselves", "out", "outside", "over", "overall", "own", "p", "particular", "particularly", "past", "per", "perhaps", "placed", "please", "plus", "possible", "presumably", "probably", "provided", "provides", "q", "que", "quite", "qv", "r", "rather", "rd", "re", "really", "reasonably", "recent", "recently", "regarding", "regardless", "regards", "relatively", "respectively", "right", "round", "s", "said", "same", "saw", "say", "saying", "says", "second", "secondly", "see", "seeing", "seem", "seemed", "seeming", "seems", "seen", "self", "selves", "sensible", "sent", "serious", "seriously", "seven", "several", "shall", "shan't", "she", "she'd", "she'll", "she's", "should", "shouldn't", "since", "six", "so", "some", "somebody", "someday", "somehow", "someone", "something", "sometime", "sometimes", "somewhat", "somewhere", "soon", "sorry", "specified", "specify", "specifying", "still", "sub", "such", "sup", "sure", "t", "take", "taken", "taking", "tell", "tends", "th", "than", "thank", "thanks", "thanx", "that", "that'll", "thats", "that's", "that've", "the", "their", "theirs", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "there'd", "therefore", "therein", "there'll", "there're", "theres", "there's", "thereupon", "there've", "these", "they", "they'd", "they'll", "they're", "they've", "thing", "things", "think", "third", "thirty", "this", "thorough", "thoroughly", "those", "though", "three", "through", "throughout", "thru", "thus", "till", "to", "together", "too", "took", "toward", "towards", "tried", "tries", "truly", "try", "trying", "t's", "twice", "two", "u", "un", "under", "underneath", "undoing", "unfortunately", "unless", "unlike", "unlikely", "until", "unto", "up", "upon", "upwards", "us", "use", "used", "useful", "uses", "using", "usually", "v", "value", "various", "versus", "very", "via", "viz", "vs", "w", "want", "wants", "was", "wasn't", "way", "we", "we'd", "welcome", "well", "we'll", "went", "were", "we're", "weren't", "we've", "what", "whatever", "what'll", "what's", "what've", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "where's", "whereupon", "wherever", "whether", "which", "whichever", "while", "whilst", "whither", "who", "who'd", "whoever", "whole", "who'll", "whom", "whomever", "who's", "whose", "why", "will", "willing", "wish", "with", "within", "without", "wonder", "won't", "would", "wouldn't", "x", "y", "yes", "yet", "you", "you'd", "you'll", "your", "you're", "yours", "yourself", "yourselves", "you've", "z", "zero");
}

/* -----------------------------------------------------------------------------------
 * Archive que permite mostrar el contenido MENSUAL en el SITEMAP
  /*----------------------------------------------------------------------------------- */

function bm_displayArchives() {
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

    $archiveSummary = $wpdb->get_results($sql);
    if ($archiveSummary) {
        foreach ($archiveSummary as $date) {
            unset($bmWp);
            $bmWp = new WP_Query('year=' . $date->year . '&monthnum=' . zeroise($date->month, 2) . '&posts_per_page=-1' . '&cat=-126,-127,-225,-10' . '&paged=' . $paged);

            if ($bmWp->have_posts()) {
                $url = get_month_link($date->year, $date->month);
                $text = $month[zeroise($date->month, 2)] . ' ' . $date->year;

                echo get_archives_link($url, $text, '', '<div class="sitemap"><h5>', '</h5>');
                echo '<ul>';
                while ($bmWp->have_posts()) {
                    $bmWp->the_post();
                    echo '<li>&spades; <a href=" ' . get_permalink($bmWp->post) . '" title="' . wp_specialchars($text, 1) . '">' . wptexturize($bmWp->post->post_title) . '</a></li>';
                }
                echo '</ul></div>';
            }
        }
    }
}

function sagarra_filter($output, $data, $url) {

    $return = '<div class="video">' . $output . '</div>';
    return $return;
}

add_filter('oembed_dataparse', 'sagarra_filter', 90, 3);

function image_alt_tag($content) {
    global $post;
    preg_match_all('/<img (.*?)\/>/', $content, $images);
    if (!is_null($images)) {
        foreach ($images[1] as $index => $value) {
            if (!preg_match('/alt=/', $value)) {
                $new_img = str_replace('<img', '<img alt="' . get_the_title() . '"', $images[0][$index]);
                $content = str_replace($images[0][$index], $new_img, $content);
            }
        }
    }
    return $content;
}

add_filter('the_content', 'image_alt_tag', 99999);

function exclude_post_categories($excl = '') {
    $categories = get_the_category($post->ID);
    if (!empty($categories)) {
        $exclude = $excl;
        $exclude = explode(",", $exclude);
        foreach ($categories as $cat) {
            $html = '';
            if (!in_array($cat->cat_ID, $exclude)) {
                $html .= '<a href="' . get_category_link($cat->cat_ID) . '" ';
                $html .= 'title="' . $cat->cat_name . '">' . $cat->cat_name . '</a>';
                echo $html;
            }
        }
    }
}

function show_all_thumbs() {
    global $post;
    $post = get_post($post);
    $images = & get_children('post_type=attachment&post_mime_type=image&output=ARRAY_N&orderby=menu_order&order=ASC&post_parent=' . $post->post_parent);
    if ($images) {
        foreach ($images as $imageID => $imagePost) {

            unset($the_b_img);
            $the_b_img = wp_get_attachment_image($imageID, 'thumbnail', false);
            $thumblist .= '<a href="' . get_attachment_link($imageID) . '">' . $the_b_img . '</a>';
        }
    }
    return $thumblist;
}

function howdy_replace($wp_admin_bar) {
    $my_account = $wp_admin_bar->get_node('my-account');
    $newtitle = str_replace('Howdy,', 'Rotulos Sagarra', $my_account->title);
    $wp_admin_bar->add_node(array(
        'id' => 'my-account',
        'title' => $newtitle,
    ));
}

add_filter('admin_bar_menu', 'howdy_replace', 25);
/* -----------------------------------------------------------------------------------
 * // Permite utilizar funciones del plugin Qtranslate
  /*----------------------------------------------------------------------------------- */

add_filter('month_link', 'qtrans_convertURL');
add_filter('page_link', 'qtrans_convertURL');
add_filter('post_link', 'qtrans_convertURL');
add_filter('post_type_link', 'qtrans_convertURL');
add_filter('year_link', 'qtrans_convertURL');
add_filter('category_feed_link', 'qtrans_convertURL');
add_filter('category_link', 'qtrans_convertURL');

add_filter('wp_nav_menu_items', 'qtrans_in_nav_function');

function qtrans_in_nav_function($nav) {

    $url = get_bloginfo('url');
    $url_preg = preg_replace('/\//', '\/', $url);

    $qtrans_url = qtrans_convertURL($url);

    $nav = preg_replace('/(' . $url_preg . ')(\/id)/', $url, $nav);
    $nav = preg_replace('/(' . $url_preg . ')/', $qtrans_url, $nav);

    return $nav;
}

//Amnesia de WP para las categorias : Comprobar si genera errores !!!
/* ----------------------------------------------------------------------------------- */
function cure_wp_amnesia_on_query_string($query_string) {
    if (!is_admin()) {
        if (isset($query_string['category_name'])) {
            switch ($query_string['category_name']) {
                case 'noticias':
                    $query_string['posts_per_page'] = 8;
                    break;

                case 'senaletica':
                    $query_string['posts_per_page'] = 12;
                    $query_string['orderby'] = 'name';
                    $query_string['order'] = 'asc';
                    break;
                case 'plafones':
                    $query_string['posts_per_page'] = 12;
                    //default:
                    break;
            }
        }
        if (isset($query_string['s'])) {//case SEARCH
            $query_string['posts_per_page'] = 5;
        }
    }
    return $query_string;
}

add_filter('request', 'cure_wp_amnesia_on_query_string');

/* -----------------------------------------------------------------------------------
  //Add media library column with image width and height
  /*----------------------------------------------------------------------------------- */

function wh_column($cols) {
    $cols["dimensions"] = "Dimensions";
    return $cols;
}

function wh_value($column_name, $id) {
    $meta = wp_get_attachment_metadata($id);
    if (isset($meta['width']))
        echo $meta['width'] . ' x ' . $meta['height'];
}

add_filter('manage_media_columns', 'wh_column');
add_action('manage_media_custom_column', 'wh_value', 10, 2);
?>