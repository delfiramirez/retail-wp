<?php
/**
 * Template Name: Texto Informativo
 *
 * Contains  content , #includes
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
                    <h1 class="page-title"><?php the_title (); ?></h1>
                </div>

                <div id="images-sagarra">

                    <?php
                    the_content ();
                    ?>

                </div>
                <?php
            endwhile;
        endif;
        wp_reset_query ();
        ?>
    </div>

</div>
</div>
<?php get_footer (); ?>