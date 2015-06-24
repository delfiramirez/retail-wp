<?php
/**
 * Category Page
 *
 * Contains  content , #includes
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage sagarra
 */
get_header ();
?>


<div id="single-sagarra">

    <div id="content-sagarra">

        <h1>
            <?php the_title (); ?>
        </h1>

        <p>
            <?php the_content (); ?>
        </p>

        <div id="breadcrumbs">
            <?php the_breadcrumb (); ?>
        </div>
    </div>

    <div id="images-sagarra">
        <?php if ( have_posts () ) : while ( have_posts () ) : the_post (); ?>
                <ul class="categories">
                    <?php
                    $cats = get_categories ('exclude=13,9,8,1');
                    foreach ( $cats as $cat )
                        {
                        echo "<li>" . "<h3>" . $cat->cat_name . "</h3>";
                        echo "<ul>";
                        query_posts ('posts_per_page=-1&exclude=8&cat=' . $cat->cat_ID);
                        while ( have_posts () )
                            {
                            the_post ();
                            $category = get_the_category ();
                            if ( $category[ 0 ]->cat_ID == $cat->cat_ID )
                                {
                                echo '<li><a href="' . get_permalink () . '">' . get_the_title () . '</a></li>';
                                }
                            }
                        echo "</ul>";
                        echo "</li>";
                        foreach ( get_post_types (array ( 'public' => true )) as $post_type )
                            {
                            if ( in_array ($post_type, array ( 'post', 'page', 'attachment' )) )
                                continue;
                            $pt = get_post_type_object ($post_type);
                            echo '<h2>' . $pt->labels->name . '</h2>';
                            echo '<ul>';
                            query_posts ('post_type=' . $post_type . '&posts_per_page=-1');
                            while ( have_posts () )
                                {
                                the_post ();
                                echo '<li><a href="' . get_permalink () . '">' . get_the_title () . '</a></li>';
                                }
                            echo '</ul>';
                            }
                        }
                    ?>
                </ul>
            </div>
            <?php
        endwhile;
    endif;
    wp_reset_query ();
    ?>
    <div class="clear"></div>
</div>
<?php get_footer (); ?>
