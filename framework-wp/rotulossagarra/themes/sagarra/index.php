<?php
/**
 * Template Name: Inicio
 *
 * Contains  content , #includes
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage sagarra
 */
get_header();
?>

<div id="home-sagarra">
    <?php $attachments = new Attachments('attachments'); ?>

    <div class="sagarra">

        <?php if ($attachments->exist()) : ?>
            <div class="gallery">

                <?php while ($attachments->get()) : ?>
                    <dl>
                        <dt>
                        <?php echo $attachments->image('article-thumb'); ?>
                        </dt>
                    </dl>

                    <?php
                endwhile;
                ?>

                <dl>
                    <?php
                    global $post;
                    $args = array('numberposts' => 1,
                        'category__not_in' => array(8, 6)
                    );

                    $myposts = get_posts($args);
                    foreach ($myposts as $post) : setup_postdata($post);
                        ?>
                        <dt class="bannerUltimos">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php if (qtrans_getLanguage() == 'es'): ?>
                                <a href="<?php echo get_permalink(1928); ?>">
                                    <img class="nuevosProductos" src="http://rotulossagarra.com/static/images/last-projects/cast.png" alt="<?php ?>" />
                                <?php endif; ?>
                                <?php if (qtrans_getLanguage() == 'en'): ?>
                                    <a href="<?php echo get_permalink(1928); ?>">
                                        <img class="nuevosProductos" src="http://rotulossagarra.com/static/images/last-projects/eng.png" alt="<?php ?>" />
                                    <?php endif; ?>
                                    <?php if (qtrans_getLanguage() == 'ca'): ?>
                                        <a href="<?php echo get_permalink(1928); ?>">
                                            <img class="nuevosProductos" src="http://rotulossagarra.com/static/images/last-projects/cat.png" alt="<?php ?>" />
                                        <?php endif; ?>

                                        <?php echo get_the_post_thumbnail($post_id, 'article-thumb'); ?>
                                    </a>
                                <?php endif; ?>
                                </dt>
                                <?php
                            endforeach;
                            wp_reset_postdata();
                            ?>
                            </dl>
                            </div>
                        <?php endif; ?>
                        </div>
                        </div>
                        <?php get_footer(); ?>