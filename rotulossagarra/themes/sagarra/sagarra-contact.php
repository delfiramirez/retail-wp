<?php
/*
  Template Name: Contact
 *
 * Contains  gmap`, addres, bg-location
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

                <div id="contact-sagarra" class="contact-sagarra-rotulos">
                    <h1 class="page-title"><?php the_title(); ?></h1>


                    <h2 itemscope itemtype="http://schema.org/Organization">
                        <span itemprop="name"><?php _e("<!--:en-->Rotulos Sagarra, Inc.<!--:--><!--:es-->R&oacute;tulos Sagarra, SA.<!--:--><!--:ca-->R&egrave;tols Sagarra, SA.<!--:-->"); ?> </span>
                    </h2>

                    <h3><?php _e("<!--:en-->We are attending you at<!--:--><!--:es--> Estamos a su disposición en<!--:--><!--:ca-->Estem a ala seua disposició a<!--:-->"); ?></h3>

                    <address itemscope itemtype="http://schema.org/PostalAddress"> <span itemprop="streetAddress">Parlament, 55</span>
                        <span itemprop="addressLocality">Barcelona</span>
                        <span itemprop="postalCode">08018</span>
                        <p>T <a href="tel:+34934410033" itemprop="telephone"> 93 441 00 33</a>
                        <p>T <a href="tel:+34934418002" itemprop="telephone">93 441 80 02</a>
                        <p>F <a href="tel:+34934428801">93 442 88 01</a>
                        <hr>
                        <p>Mail <a href="mailto:<?php echo antispambot('comercial@rotulossagarra.com') ?>"  itemprop="email"><?php _e("<!--:en-->Client Customer<!--:--><!--:es-->Departamento Comercial<!--:--><!--:ca-->Departament Comercial<!--:-->"); ?></a>
                        <p>Mail <a href="mailto:<?php echo antispambot('dibujo@rotulossagarra.com') ?>"  itemprop="email"><?php _e("<!--:en--> Design Department Rótulos Sagarra<!--:--><!--:es-->Departamento Diseño Rótulos Sagarra<!--:--><!--:ca-->Departament DIsseny Rètols Sagarra<!--:-->"); ?></a>
                        <p>Mail <a href="mailto:<?php echo antispambot('info@rotulossagarra.com') ?>"  itemprop="email"><?php _e("<!--:en-->Administrative Dept.<!--:--><!--:es-->Departamento Administrativo<!--:--><!--:ca-->Departament Administratiu<!--:-->"); ?></a>
                    </address>

                </div>
            </div>
            <?php
        endwhile;
    endif;
    wp_reset_query();
    ?>

</div>

<?php get_footer(); ?>
