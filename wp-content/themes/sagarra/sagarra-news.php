<?php
/*
  Template Name: Noticias
 *
 * Contains  ajax streaming posts
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage sagarra
 */
get_header ();
query_posts ('category_name=noticias&showposts=-1')
?>


<?php if ( have_posts () ) : while ( have_posts () ) : the_post (); ?>

        <div id="single-sagarra" <?php post_class (); ?>>

            <div class="sagarra-post">

                <div id="content-sagarra">

                    <h1>
                        <?php the_title (); ?>
                    </h1>

                    <?php the_content (); ?>

                </div>

                <div id="images-sagarra">

                    <?php
                    $args        = array (
                        'order'          => 'random',
                        'post_type'      => 'attachment',
                        'post_parent'    => $post->ID,
                        'post_mime_type' => 'image',
                        'post_status'    => null,
                        'numberposts'    => -1,
                    );
                    $attachments = get_posts ($args);
                    if ( $attachments )
                        {
                        foreach ( $attachments as $attachment )
                            {

                            echo wp_get_attachment_link ($attachment->ID, 'resp-medium', false, false);
                            }
                        }
                    ?>

                </div>

                <div class="clear"></div>

            </div>

            <p class="sagarra-category">
                <?php the_tags (); ?>
            </p>

            <?php if ( show_posts_nav () ) : ?>

                <div class="post-navigation">
                    <div class="previous-post">
                        <?php previous_post_link ('%link'); ?>
                    </div>
                    <div class="next-post">
                        <?php next_post_link ('%link'); ?>
                    </div>
                </div>

            <?php endif; ?>
            <?php rewind_posts (); ?>

        </div>

        <?php
    endwhile;
endif;
?>
</div>
<?php get_footer (); ?>