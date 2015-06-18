<?php
/**
 * Template name: Contact Mobile
 *
 * Contains  form
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage sagarra
 */
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div id="single-sagarra">

            <div id="title-sagarra">
                <h1><?php the_title(); ?></h1>
            </div>

            <div id="content-sagarra">

                <h2 itemscope itemtype="http://schema.org/Organization">
                    <span itemprop="name"><?php _e("<!--:en-->Rotulos Sagarra, Inc.<!--:--><!--:es-->R&oacute;tulos Sagarra, SA.<!--:--><!--:ca-->R&egrave;tols Sagarra, SA.<!--:-->"); ?> </span>
                </h2>
                <h3><?php _e("<!--:en-->We are attending you at<!--:--><!--:es--> Estamos a su disposición en<!--:--><!--:ca-->Estem a ala seua disposició a<!--:-->"); ?></h3>
                <address itemscope itemtype="http://schema.org/PostalAddress"> <span itemprop="streetAddress">Parlament, 55</span>
                    <span itemprop="addressLocality">Barcelona</span>  <span itemprop="postalCode">08018</span>
                    <br>T <a href="tel:+34934410033" itemprop="telephone"> 93 441 00 33</a>
                    <br>T <a href="tel:+34934418002" itemprop="telephone">93 441 80 02</a>
                    <br>F <a href="tel:+34934428801">93 442 88 01</a>
                    <hr>Mail <a href="mailto:<?php echo antispambot('comercial@rotulossagarra.com') ?>"  itemprop="email"><?php _e("<!--:en-->Client Customer<!--:--><!--:es-->Departamento Comercial<!--:--><!--:ca-->Departament Comercial<!--:-->"); ?></a>
                    <br>Mail <a href="mailto:<?php echo antispambot('dibujo@rotulossagarra.com') ?>"  itemprop="email"><?php _e("<!--:en--> Design Department Rótulos Sagarra<!--:--><!--:es-->Departamento Diseño Rótulos Sagarra<!--:--><!--:ca-->Departament DIsseny Rètols Sagarra<!--:-->"); ?></a>
                    <br>Mail <a href="mailto:<?php echo antispambot('info@rotulossagarra.com') ?>"  itemprop="email"><?php _e("<!--:en-->Administrative Dept.<!--:--><!--:es-->Departamento Administrativo<!--:--><!--:ca-->Departament Administratiu<!--:-->"); ?></a>
                </address>
            </div>

            <div id="images-sagarra">

                <?php echo do_shortcode("[contact-form to='comercial@rotulossagarra.com' subject='Contact'][contact-field label='Name' type='name' required='1'/][contact-field label='Email' type='email' required='1'/][contact-field label='Comment' type='textarea' required='1'/][/contact-form]"); ?>

            </div>
            <?php
        endwhile;
    endif;
    wp_reset_query();
    ?>
</div>
<?php get_footer(); ?>
