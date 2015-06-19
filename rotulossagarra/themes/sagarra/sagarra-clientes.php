<?php
/**
* Template Name: Clientes
 *
 * Contains  clent icons
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

                <div id="c-sagarra">

                    <img class="clients-sagarra" src ="http://rotulosagarra.com/static/images/clientes.jpg" alt="clientes Sagarra" />

                </div>

                <?php
            endwhile;
        endif;
        ?>

    </div>

</div>

<?php get_footer(); ?>
