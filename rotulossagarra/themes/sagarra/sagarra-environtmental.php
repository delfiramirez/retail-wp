<?php
/**
 * Template Name: Senaletica
 * Contains  external gallery, links, etc.
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage sagarra
 */
get_header ();
?>

<?php if ( have_posts () ) : while ( have_posts () ) : the_post (); ?>

        <div id="single-sagarra">

            <div id="rotulos">

                <div id="title-sagarra">

                    <h1 class="page-title">
                        <?php the_title (); ?>
                    </h1>

                </div>

                <div id="content-sagarra">

                    <?php the_content (); ?>

                </div>

                <div class="images-sagarra">

                    <div class="senaletica">

                        <dt>

                        <?php
                        $senaleticaPosts = new WP_Query();
                        $senaleticaPosts->query ('showposts=4&cat=-8');
                        ?>

                        <?php while ( $senaleticaPosts->have_posts () ) : $senaleticaPosts->the_post (); ?>

                            <dl>

                                <a href="<?php the_permalink () ?>" rel="bookmark">
                                    <?php echo get_the_post_thumbnail ($post_id, 'sagarra-thumb'); ?>
                                </a>


                            </dl>

                        <?php endwhile; ?>

                        </dt>

                        <br>

                        <?php wp_nav_menu (array ( 'theme_location' => 'senyaletica' )); ?>
                    </div>

                </div>

                <?php
            endwhile;
        endif;
        wp_reset_query ();
        ?>
    </div>

</div>

<?php get_footer (); ?>
