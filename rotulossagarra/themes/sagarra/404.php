<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Sagarra
 *
 */
get_header();
?>
<div id="front-sagarra">

    <header class="page-header">
        <h1 class="page-title">
<?php _e("<!--:en-->Request Not Found<!--:--><!--:es-->P&aacute;gina no encontrada<!--:--><!--:ca-->P&aacute;gina no trobada<!--:-->"); ?>
        </h1>
    </header>


    <div class="page-content">
        <h2>
<?php _e("<!--:en-->Request Not Found<!--:--><!--:es-->P&aacute;gina no encontrada<!--:--><!--:ca-->P&aacute;gina no trobada<!--:-->"); ?>
        </h2>
        <p>
<?php _e("<!--:en-->Please use the links to navigate the site<!--:--><!--:es-->Por favor utilice los enlaces para regresar<!--:--><!--:ca-->Si us plau, feu servir els menus per a navegar<!--:-->"); ?>
        </p>
    </div>

</div>

<?php get_footer(); ?>