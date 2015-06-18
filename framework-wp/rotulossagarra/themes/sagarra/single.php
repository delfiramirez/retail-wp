<?php
/**
 * Single Page
 *
 * Contains  content , #includes
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage sagarra
 */
get_header();
?>
<div id="single-sagarra">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div id="rotulos">
                <div id="title-sagarra">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </div>
                <div id="content-sagarra">
                    <?php the_content(); ?>
                </div>

                <div id="images-sagarra">

                    <?php
                    echo do_shortcode('[gallery type="rectangular" ignore_gallery_link_urls=”true” orderby="rand" link="none"]');
                    ?>

                </div>
            </div>
            <?php
        endwhile;
    endif;
    wp_reset_query();
    ?>
</div>
<?php get_footer(); ?>
