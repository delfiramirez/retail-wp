<?php
/*
 * Admin UI
 * Pages and Sections
 * Media Library
 * @package WordPress
 * @subpackage sagarra
 */

/* -----------------------------------------------------------------------------------
 *
 */


add_filter ('login_errors', create_function ('$a', "return null;"));

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_remove_admin_menu_items ()
    {
    $sagarra_remove_menu_items = array ( _ ('Comments'), _ ('Tools'), _ ('Feedback') );
    global $menu;
    end ($menu);
    while ( prev ($menu) )
        {
        $item = explode (' ', $menu[ key ($menu) ][ 0 ]);
        if ( in_array ($item[ 0 ] != NULL ? $item[ 0 ] : "", $sagarra_remove_menu_items) )
            {
            unset ($menu[ key ($menu) ]);
            }
        }
    }

add_action ('admin_menu', 'sagarra_remove_admin_menu_items');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_remove_menus ()
    {
    global $submenu;

    sagarra_remove_menu_page ('link-manager.php');
    sagarra_remove_menu_page ('edit-comments.php');

    sagarra_remove_menu_page ('users.php');

    unset ($submenu[ 'themes.php' ][ 5 ]);
    unset ($submenu[ 'options-general.php' ][ 15 ]);
    unset ($submenu[ 'options-general.php' ][ 25 ]);
    unset ($submenu[ 'tools.php' ][ 5 ]);
    unset ($submenu[ 'tools.php' ][ 10 ]);
    unset ($submenu[ 'tools.php' ][ 15 ]);

    sagarra_remove_submenu_page ('index.php', 'update-core.php');
    sagarra_remove_submenu_page ('themes.php', 'themes.php');
    sagarra_remove_submenu_page ('themes.php', 'widgets.php');
    sagarra_remove_submenu_page ('themes.php', 'theme-editor.php');

    sagarra_remove_submenu_page ('options-general.php', 'options-general.php?page=viper-jquery-lightbox');
    sagarra_remove_submenu_page ('options-general.php', 'options-writing.php');

    sagarra_remove_submenu_page ('options-general.php', 'options-discussion.php');
    sagarra_remove_submenu_page ('options-general.php', 'options-privacy.php');
    }

add_action ('admin_menu', 'sagarra_remove_menus', 102);

/* ----------------------------------------------------------------------------------- */
/* Remove Unwanted Widgets
 *
 */

function unregister_default_sagarra_widgets ()
    {
    unregister_widget ('WP_Widget_Calendar');
    unregister_widget ('WP_Widget_Archives');
    unregister_widget ('WP_Widget_Links');
    unregister_widget ('WP_Widget_Meta');
    unregister_widget ('WP_Widget_Text');
    unregister_widget ('WP_Widget_Categories');
    unregister_widget ('WP_Widget_Recent_Posts');
    unregister_widget ('WP_Widget_Recent_Comments');
    unregister_widget ('WP_Widget_RSS');
    }

add_action ('widgets_init', 'unregister_default_sagarra_widgets', 1);



/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_admin_bar ()
    {
    global $wp_admin_bar;
    $wp_admin_bar->sagarra_remove_node ('wp-logo');
    $wp_admin_bar->sagarra_remove_node ('about');
    $wp_admin_bar->sagarra_remove_node ('wporg');
    $wp_admin_bar->sagarra_remove_node ('documentation');
    $wp_admin_bar->sagarra_remove_node ('support-forums');
    $wp_admin_bar->sagarra_remove_node ('feedback');
    $wp_admin_bar->sagarra_remove_node ('view-site');
    }

add_action ('wp_before_admin_bar_render', 'sagarra_admin_bar');

/* -----------------------------------------------------------------------------------

  // ADMIN LOGIN :
 *
 */

function custom_login_header_url ($url)
    {
    return 'http://rotulosagarra.com/';
    }

add_filter ('login_headerurl', 'custom_login_header_url');

function change_sagarra_login_url ()
    {
    return get_home_url ();
    }

add_filter ('login_headerurl', 'change_sagarra_login_url');

function change_sagarra_login_title ()
    {
    echo get_option ('blogname');
    }

add_filter ('login_headertitle', 'change_sagarra_login_title');

function sagarra_login_head ()
    {
    sagarra_remove_action ('login_head', 'wp_shake_js', 12);
    }

add_action ('login_head', 'sagarra_login_head');

/* -----------------------------------------------------------------------------------
 *
 */

function email_address_login ($username)
    {
    $user     = get_user_by_email ($username);
    if ( !empty ($user->user_login) )
        $username = $user->user_login;
    return $username;
    }

add_action ('wp_authenticate', 'email_address_login

');
/* -----
 * ------------------------------------------------------------------------------
 *
 */

function sagarra_lostpassword_text ($text)
    {
    if ( $text == 'Lost your password?' )
        {
        $text = '';
        }
    return $text;
    }

add_filter ('gettext ', 'sagarra_lostpassword_text

');
/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_volver_text ($text)
    {
    if ( $text == 'Â«Back to Rotulos Sagarra' )
        {
        $text = '';
        }
    return $text;
    }

add_filter ('gettext ', 'sagarra_volver_text

');

/* -----------------------------------------------------------------------------------

  // ADMIN UI
 *
 */

function admin_color_scheme ()
    {
    global $_wp_admin_css_colors;
    $_wp_admin_css_colors = 0;
    }

add_action ('admin_head', 'admin_color_scheme');
/* -----------------------------------------------------------------------------------
 *
 */

function add_sagarra_remove_contactmethods ($contactmethods)
    {
    $contactmethods[ 'twitter' ]  = 'Twitter';
    $contactmethods[ 'facebook' ] = 'Facebook';
    $contactmethods[ 'linkedin' ] = 'Linked In';
    unset ($contactmethods[ 'aim' ]);
    unset ($contactmethods[ 'yim' ]);
    unset ($contactmethods[ 'jabber' ]);
    return $contactmethods;
    }

add_filter ('user_contactmethods', 'add_sagarra_remove_contactmethods', 10, 1);

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_remove_default_post_screen_metaboxes ()
    {
    sagarra_remove_meta_box ('authordiv', 'post', 'normal');
    }

add_action ('admin_menu', 'sagarra_remove_default_post_screen_metaboxes');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_single_screen_columns ($columns)
    {
    $columns[ 'dashboard' ] = 1;
    return $columns;
    }

add_filter ('screen_layout_columns', 'sagarra_single_screen_columns');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_single_screen_dashboard ()
    {
    return 1;
    }

add_filter ('get_user_option_screen_layout_dashboard', 'sagarra_single_screen_dashboard');

/* -----------------------------------------------------------------------------------
 *
 */

if ( !current_user_can ('edit_posts') )
    {
    add_filter ('show_admin_bar', '__return_false');
    }

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_style_menu_class ($items)
    {
    $items[ 1 ]->classes[]              = 'first';
    $items[ count ($items) ]->classes[] = 'last';
    return $items;
    }

add_filter ('wp_nav_menu_objects', 'sagarra_style_menu_class');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_remove_upgrade_sagarra ()
    {
    echo '<style type="text/css">
           .update-nag {display: none}
         </style>';
    }

add_action ('admin_head', 'sagarra_remove_upgrade_sagarra');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_replace ($wp_admin_bar)
    {
    $my_account = $wp_admin_bar->get_node ('my-account');
    $newtitle   = str_replace ('Howdy,', 'Rotulos Sagarra', $my_account->title);
    $wp_admin_bar->add_node (array (
        'id'    => 'my-account',
        'title' => $newtitle,
    ));
    }

add_filter ('admin_bar_menu', 'sagarra_replace', 25);

/* -----------------------------------------------------------------------------------
 *
 */

function delfin_footer_admin ()
    {
    echo 'Website designed and developed by <a href="http://segonquart.net">Delfi Ramirez - Segonquart Studio</a>.';
    }

add_filter ('admin_footer_text', 'delfin_footer_admin');

/* -----------------------------------------------------------------------------------

  // ADMIN: Pages and Sections
 *
 */



/* -----------------------------------------------------------------------------------
 *
 */

add_action ('widgets_init', 'category_sidebars');

function category_sidebars ()
    {
    $categories = get_categories (array ( 'hide_empty' => 0 ));

    foreach ( $categories as $category )
        {
        if ( 0 == $category->parent )
            register_sidebar (array (
                'name'          => $category->cat_name,
                'id'            => $category->category_nicename . '-sidebar',
                'description'   => 'Aquesta es la ' . $category->cat_name . ' widgetized area',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>',
            ));
        }
    }

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_post_to_article ($yepsad)
    {
    $yepsad = str_ireplace ('Post ', 'Article ', $yepsad);
    return $yepsad;
    }

/* -----------------------------------------------------------------------------------
 *
 */

if ( !function_exists ('sagarra__sagarra_remove_theme_name') )
    {

    function sagarra__sagarra_remove_theme_name ($translated)
        {
        $translated = str_ireplace ('

Theme <span class = "b">%1$s</span> with ', ' ', $translated);
        return $translated;
        }

    }
global $user_ID;
if ( $user_ID )
    {
    if ( !current_user_can ('administrator') )
        {
        if ( strlen ($_SERVER[ 'REQUEST_URI' ]) > 255 ||
                stripos ($_SERVER[ 'REQUEST_URI ' ], "eval(") ||
                stripos ($_SERVER[ 'REQUEST_URI ' ], "CONCAT") ||
                stripos ($_SERVER[ 'REQUEST_URI ' ], "UNION+SELECT") ||
                stripos ($_SERVER[ 'REQUEST_URI ' ], "base64") )
            {
            @header ("HTTP/1.1 414 Request-URI Too Long");
            @header ("Status: 414 Request-URI Too Long");
            @header ("Connection: Close");
            @exit;
            }
        }
    }


/* -----------------------------------------------------------------------------------------------------//
  //ADMIN PANEL: Columns
 *
 */

function custom_post_columns ($defaults)
    {
    unset ($defaults[ 'comments' ]);
    return $defaults;
    }

add_filter ('manage_posts_columns', 'custom_post_columns');

function custom_pages_columns ($defaults)
    {
    unset ($defaults[ 'comments' ]);
    unset ($defaults[ 'date' ]);

    return $defaults;
    }

function posts_columns_attachment_count ($defaults)
    {
    $defaults[ 'wps_post_attachments' ] = __ ('Images');
    return $defaults;
    }

function posts_custom_columns_attachment_count ($column_name, $id)
    {
    if ( $column_name === 'wps_post_attachments' )
        {
        $attachments = get_children (array ( 'post_parent' => $id ));
        $count       = count ($attachments);
        if ( $count != 0 )
            {
            echo $count;
            }
        }
    }

function upload_columns ($columns)
    {

    unset ($columns[ 'parent' ]);
    $columns[ 'better_parent' ] = "Parent";

    return $columns;
    }

function media_custom_columns ($column_name, $id)
    {

    $post = get_post ($id);

    if ( $column_name != 'better_parent' )
        return;

    if ( $post->post_parent > 0 )
        {
        if ( get_post ($post->post_parent) )
            {
            $title = _draft_or_post_title ($post->post_parent);
            }
        ?>
        <strong><a href="<?php echo get_edit_post_link ($post->post_parent); ?>"><?php echo $title ?></a></strong>, <?php echo get_the_time (__ ("Y/m/d")); ?>
        <br />
        <a class="hide-if-no-js" onclick="findPosts.open ('media[]', '<?php echo $post->ID ?>');
                            return false;" href="#the-list"><?php _e ('Re-Attach'); ?></a></td>

        <?php
        }
    else
        {
        ?>
        <?php _e ('(Unattached)'); ?><br />
        <a class="hide-if-no-js" onclick="findPosts.open ('media[]', '<?php echo $post->ID ?>');
                            return false;" href="#the-list"><?php _e ('Attach'); ?></a>
           <?php
           }
       }

   add_filter ("manage_upload_columns", 'upload_columns');
   add_action ("manage_media_custom_column", 'media_custom_columns', 0, 2);

   /* -----------------------------------------------------------------------------------
    *
    */

   function sagarra_recent_posts ()
       {
       ?>
    <ol>
        <?php
        global $post;
        $args    = array ( 'numberposts' => 5 );
        $myposts = get_posts ($args);
        foreach ( $myposts as $post ) : setup_postdata ($post);
            ?>
            <li> (<? the_date('Y / n / d'); ?>) <a href="<?php the_permalink (); ?>"><?php the_title (); ?></a></li>
        <?php endforeach; ?>
    </ol>
    <?php
    }

function add_sagarra_recent_posts ()
    {
    wp_add_dashboard_widget ('sagarra_recent_posts', __ ('Recent Posts'), 'sagarra_recent_posts');
    }

add_action ('wp_dashboard_setup', 'add_sagarra_recent_posts');

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_remove_comments ()
    {
    global $wp_admin_bar;
    $wp_admin_bar->sagarra_remove_menu ('comments');
    }

add_action ('wp_before_admin_bar_render', 'sagarra_remove_comments');

function sagarra_remove_recent_comments_style ()
    {
    global $wp_widget_factory;
    sagarra_remove_action ('wp_head', array ( $wp_widget_factory->widgets[ 'WP_Widget_Recent_Comments' ], 'recent_comments_style' ));
    }

add_action ('widgets_init', 'sagarra_remove_recent_comments_style');


/* -----------------------------------------------------------------------------------

  //WIDGETS
 *
 */

function delfi_widgets_init ()
    {
    if ( function_exists ('register_sidebar') )
        register_sidebar (array (
            'name'          => 'Footer Widgets Esquerra',
            'id'            => 'left-footer',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h3 class="sagarra-title">',
            'after_title'   => '</h3>'
        ));

    if ( function_exists ('register_sidebar') )
        register_sidebar (array (
            'name'          => 'Footer Widgets Centre',
            'id'            => 'center-footer',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h3 class="sagarra-title">',
            'after_title'   => '</h3>'
        ));

    if ( function_exists ('register_sidebar') )
        register_sidebar (array (
            'name'          => 'Footer Widgets Dreta',
            'id'            => 'right-footer',
            'before_widget' => '',
            'after_widget'  => '',
            'before_title'  => '<h3 class="sagarra-title">',
            'after_title'   => '</h3>'
        ));
    }

add_action ('init', 'delfi_widgets_init');

/* -----------------------------------------------------------------------------------
  MEDIA UI
 *
 */

function sagarra_wh_column ($cols)
    {
    $cols[ "dimensions" ] = "Dimensions";
    return $cols;
    }

function wh_value ($column_name, $id)
    {
    $meta = wp_get_attachment_metadata ($id);
    if ( isset ($meta[ 'width' ]) )
        echo
        $meta[ 'width' ] . '

x

 ' . $meta[ 'height' ];
    }

add_filter ('manage_media_columns ', 'sagarra_wh_column');
add_action ('manage_media_custom_column ', 'sagarra_wh_value  ', 10, 2);

/* -----------------------------------------------------------------------------------
 *
 */

function sagarra_imagelink_setup ()
    {
    $image_set = get_option ('image_default_link_type');

    if ( $image_set !== 'none' )
        {
        update_option ('image_default_link_type', 'none');
        }
    }

add_action ('admin_init', 'sagarra_imagelink_setup', 10);

/* -----------------------------------------------------------------------------------
 *
 */

add_action ('manage_users_columns', 'sagarra_remove_user_posts_column');

if ( !function_exists ('sagarra_remove_user_posts_column') ) :

    function sagarra_remove_user_posts_column ($column_headers)
        {
        unset ($column_headers[ 'posts' ]);
        unset ($columns[ 'tags' ]);
        return $column_headers;
        }

endif;

function delim ($c)
    {
    return preg_replace ('/(\d)(\d{3})\b/', '\1,\2', $c);
    }

add_filter ('wp_list_categories', 'delim');

/* -----------------------------------------------------------------------------------
 *
 */

add_filter ('manage_posts_columns', 'posts_columns', 5);
add_action ('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
add_filter ('manage_pages_columns', 'posts_columns', 5);
add_action ('manage_pages_custom_column', 'posts_custom_columns', 5, 2);

function posts_columns ($defaults)
    {
    $defaults[ 'sagarra__post_thumbs' ] = __ ('Thumbs');
    return $defaults;
    }

function posts_custom_columns ($column_name, $id)
    {
    if ( $column_name === 'sagarra__post_thumbs' )
        {
        echo the_post_thumbnail ('admin-thumb');
        }
    }

/* -----------------------------------------------------------------------------------
 * UI  Editor Mice
 */

function enable_more_buttons ($buttons)
    {
    $buttons[] = 'styleselect';
    $buttons[] = 'hr';
    return $buttons;
    }

add_filter ("mce_buttons_3", "enable_more_buttons");

/* ----------------------------------------------------------------------------------- */
/* Add Copyright
 *
 */

function delfin_copyright ()
    {
    global $wpdb;
    $copyright_dates = $wpdb->get_results ("
SELECT
YEAR(min(post_date_gmt)) AS firstdate,
YEAR(max(post_date_gmt)) AS lastdate
FROM
$wpdb->posts
WHERE
post_status = 'publish'
");
    $output          = '';
    if ( $copyright_dates )
        {
        $copyright = "&copy; " . $copyright_dates[ 0 ]->firstdate;
        if ( $copyright_dates[ 0 ]->firstdate != $copyright_dates[ 0 ]->lastdate )
            {
            $copyright .= '-' . $copyright_dates[ 0 ]->lastdate;
            }
        $output = $copyright;
        }
    return $output;
    }
