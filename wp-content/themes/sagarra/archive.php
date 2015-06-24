<?php
/**
 * Archive Template
 *
 * Contains  content , #includes
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage sagarra
 */
?>
<?php get_header (); ?>

<?php if ( have_posts () ) : while ( have_posts () ) : the_post (); ?>

        <div id="single-sagarra" <?php post_class (); ?>>

            <div id="content-sagarra">

                <a href="<?php the_permalink (); ?>">
                    <h1>
                        <?php the_title (); ?>
                    </h1>
                </a>
            </div>

            <div id="images-sagarra">
                <?php
                $images = & get_children (array (
                            'post_parent'    => $post->ID,
                            'post_type'      => 'attachment',
                            'post_mime_type' => 'image'
                ));

                if ( empty ($images) )
                    {

                    }
                else
                    {
                    foreach ( $images as $attachment_id => $attachment )
                        {
                        echo wp_get_attachment_image ($attachment_id, 'thumbnail');
                        }
                    }
                ?>
            </div>
            <div class="clear"></div>
                    <?php if ( $wp_query->max_num_pages > 1 ) : ?>
                <div class="navigation">
                    <div class="nav-previous">

            <?php next_posts_link (); ?>

                    </div>

                    <div class="nav-next">

                <?php previous_posts_link (); ?>

                    </div>

                </div>
                <?php
            endif;
            ?>
            <?php
        endwhile;

    endif;
    ?>
</div>

<?php get_footer (); ?>
