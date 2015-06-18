<?php
/* Template Name: Site-Map
 *
 * Contains  site map, categories and pages
 *
 * @package WordPress
 * @subpackage sagarra
 */
get_header();
?>
<div id="single-sagarra">
    <div id="rotulos">
        <div id="title-sagarra">

        </div>
        <div id="images-sagarra">
            <li>
                <h1><?php the_title(); ?></h1>
            </li>
            <ul  class='sitemap'>
                <?php wp_list_pages(array('exclude' => '', 'title_li' => '',)); ?>
            </ul>

            <ul class="categories">
                <li>
                    <h1>Ultimos Productos</h1>
                </li>
                <?php
                $cats = get_categories('exclude=13,9,8,1');

                foreach ($cats as $cat) {
                    echo "<li><h3>" . $cat->cat_name . "</h3>";
                    echo "<ul>";
                    query_posts('posts_per_page=-1&exclude=8&cat=' . $cat->cat_ID);
                    while (have_posts()) {
                        the_post();
                        $category = get_the_category();
                        if ($category[0]->cat_ID == $cat->cat_ID) {
                            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                        }
                    }
                    echo "</ul>";
                    echo "</li>";
                    foreach (get_post_types(array('public' => true)) as $post_type) {
                        if (in_array($post_type, array('post', 'page', 'attachment')))
                            continue;
                        $pt = get_post_type_object($post_type);
                        echo '<h2>' . $pt->labels->name . '</h2>';
                        echo '<ul>';
                        query_posts('post_type=' . $post_type . '&posts_per_page=-1');
                        while (have_posts()) {
                            the_post();
                            echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                        }
                        echo '</ul>';
                    }
                }
                ?>
            </ul>
        </div>

    </div>

</div>
<?php
wp_reset_query();
?>
</div>
<?php get_footer(); ?>