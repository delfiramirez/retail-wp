<?php
/*
  Template Name: Proyectos Sagarra
 *
 * Contains  Posts

 *
 * @package WordPress
 * @subpackage sagarra
 */
get_header ();
?>

<div id="single-sagarra">


    <div id="rotulos">

        <div id="content-sagarra">


            <h1 class="page-title">
                <?php the_title (); ?>
            </h1>


        </div>

        <div class="principal">
            <?php
            $recentPosts = new WP_Query();
            $recentPosts->query ('showposts=5&cat=-8');
            ?>
            <?php while ( $recentPosts->have_posts () ) : $recentPosts->the_post (); ?>
                <div id="project-sagarra">

                    <h3>
                        <a href="<?php the_permalink () ?>" rel="bookmark">

                            <?php the_title (); ?>

                        </a>
                    </h3>

                    <hr>

                    <a class ="alignright">

                        <?php echo get_the_post_thumbnail ($post_id, 'sagarra-thumb'); ?>
                    </a>

                    <?php
                    global $more;
                    $more = 0;
                    ?>
                    <p>
                        <?php the_content (__ ('<!--:en-->Continue reading <!--:--><!--:es-->Ver proyecto<!--:--><!--:ca-->Veure projecte<!--:-->' . '  ' . '<span class="meta-nav">&rarr;</span>')); ?>
                    </p>


                </div>
            <?php endwhile; ?>

            <hr>

        </div>

    </div>
    <?php get_footer (); ?>