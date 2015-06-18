<?php
/**
 * Footer Template
 *
 * Contains footer content and widgets of menu_subnavigation, #includes
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage sagarra
 */
?>

</div>

</div>

<footer role="contentinfo">

    <div id ="footer-container">

        <div id="dividir">
            <?php
            wp_nav_menu(array('container_class' => 'menu-inicio',
                'theme_location' => 'inicio'));
            ?>
        </div>
        <div class="site-info">
            <?php wp_nav_menu(array('theme_location' => 'externo')); ?>
            <?php if (function_exists('qts_language_menu')) qts_language_menu('text'); ?>
            <?php wp_nav_menu(array('theme_location' => 'pie-pagina')); ?>
        </div>
    </div>
</footer>
<script type="text/javascript">
    Cufon.replace('#menu-submenu li, #menu-contacto li,h3, h4, h5,.categories h3');
    fontFamily : "DIN"
    fontWeight: "bold"
</script>
<script src="http://segonquart.net/sagarra/src/js/scroll.js?<?php echo date('Y-m-d H:i:s'); ?>"></script>
<!--
<script src="http://segonquart.net/sagarra/src/js/scripts-sagarra2.js?<? /* php echo date('Y-m-d H:i:s'); */ ?>"></script>
//-->

<script src="http://segonquart.net/sagarra/src/js/libs/retina.js"></script>

<!--[if lte IE 6]>
<style type="text/css">
.fixMe {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true',src='http://static.rotulossagarra.com/images/last-projects/cast.png');padding-top:150px}
</style>
<![endif]-->
<!--[if lte IE 7]>
 <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <script type="text/javascript" src="http://segonquart.net/sagarra/src/js/libs/unitpngfix.js"></script>
<![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if IE 8]>
<style type="text/css">
img {
max-width: none !important
}
</style>
<![endif]-->
<!--[if IE]>

<style type="text/css" media="screen">

@font-face{

font-family:'cartogothic_stdbold';
    src: url('http://static.rotulossagarra.com/fonts/headers/CartoGothicStd-Bold-webfont.eot');
    src: url('http://static.rotulossagarra.com/fonts/headers/CartoGothicStd-Bold-webfont.eot?#iefix') format('embedded-opentype'),

}
</style>
<![endif]-->
<?php wp_footer(); ?>
</body>
</html>