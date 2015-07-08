<?php
if ( substr_count ($_SERVER[ 'HTTP_ACCEPT_ENCODING' ], 'gzip') )
    {
    ob_start ("ob_gzhandler");
    }
else
    {
    ob_start ();
    }
?>
<!doctype html>

<!--[if IE 7]><html class="ie ie7" <?php language_attributes (); ?>><![endif]-->
<!--[if IE 8]><html class="ie ie8" <?php language_attributes (); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!--><html <?php language_attributes (); ?>><!--<![endif]-->
    <head>

        <base href="http://rotulossagarra.com">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, height=device-height" />
        <title><?php wp_title (''); ?> | Rotulos Sagarra - Barcelona</title>
        <?php
        if ( is_single () || is_page () || is_home () )
            {
            ?>
            <meta name="googlebot" content="index,noarchive,follow,noodp" />
            <meta name="robots" content="all,index,follow" />
            <meta name="msnbot" content="all,index,follow" />
            <?php
            }
        else
            {
            ?>
            <meta name="googlebot" content="noindex,noarchive,follow,noodp" />
            <meta name="robots" content="noindex,follow" />
            <meta name="msnbot" content="noindex,follow" />
            <?php
            }
        ?>
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="360">
        <meta name="apple-mobile-web-app-capable" content="yes">

        <link rel="P3Pv1" href="http://rotulossagarra.com/public/P3P/public.xml">

        <link rel="apple-touch-startup-image" href="http://static.rotulossagarra.com/images/sagarra-startup.png">
        <link rel="apple-touch-icon" href="http://static.rotulossagarra.com/images/sagarra-touch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="72x72" href="http://static.rotulossagarra.com/images/sagarra-touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="114x114" href="http://static.rotulossagarra.com/images/sagarra-touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="144x144" href="http://static.rotulosagarra.com/images/sagarra-touch-icon-ipad-retina.png">
        <!--[if lte IE 8]><link rel="stylesheet" href="http://segonquart.net/sagarra/src/css/ie/ie.css"><![endif]-->
        <!--[if lte IE 7]><link rel="stylesheet" href="http://segonquart.net/sagarra/src/css/ie/ie.css?<?php echo date ('Y-m-d H:i:s'); ?>"><![endif]-->
        <!--[if lte IE 7]>
        <script src="http://segonquart.net/sagarra/src/js/lib/modernizr.custom.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <![endif]-->
        <!-- [if lt IE 9]><script src="http://segonquart.net/sagarra/src/js/html5.js" type="text/javascript"></script><![endif]-->
        <link rel="stylesheet"
              type="text/css"
              media="all"
              href="http://segonquart.net/sagarra/src/css/style.css?<?php echo date ('Y-m-d H:i:s'); ?>"/>


        <?php if ( qtrans_getLanguage () == 'en' ): ?>
            <?php echo '
          <style>
              #aniversari{
              background: url("http://static.rotulossagarra.com/images/100/eng.png") center left no-repeat;
              }
          </style>';
            ?>
        <?php endif; ?>

        <?php if ( qtrans_getLanguage () == 'ca' ): ?>
            <?php echo '<style>
                  #aniversari{
                  background: url("http://static.rotulossagarra.com/images/100/cat.png") center left no-repeat;
                  }
              </style>';
            ?>
        <?php endif; ?>

        <style type="text/css">

            @font-face
            {
                font-family: 'cartogothic_stdbold';
                src: url('/static/fonts/headers/CartoGothicStd-Bold-webfont.eot');
                src: local('☺'),
                    url('http://static.rotulossagarra.com/fonts/headers/CartoGothicStd-Bold-webfont.eot?#iefix') format('embedded-opentype'),
                    url('http://static.rotulossagarra.com/fonts/headers/CartoGothicStd-Bold-webfont.woff') format('woff'),
                    url('http://static.rotulossagarra.com/fonts/headers/CartoGothicStd-Bold-webfont.ttf') format('truetype'),
                    url('http://static.rotulossagarra.com/fonts/headers/CartoGothicStd-Bold-webfont.svg#cartogothic_stdbold') format('svg');
                font-weight: normal;
                font-style: normal;
            }
        </style>

        <script  src="http://static.rotulosagarra.com/cufon/cufon-yui.js"></script>
        <script src="http://static.rotulosagarra.com/cufon/DIN_500.font.js"></script>
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

        <?php
        if ( is_page_template ('sagarra-clientes.php') )
            {
            echo '<script>
                alert (location.hostname);
                function preloader(){
                if (document.images) {
                    img1 = new Image();
                    img1.src = "http://static.rotulosagarra.com/images/clientes.jpg";
                }
                }

                function addLoadEvent(func) {
                        var oldonload = window.onload;
                        if (typeof window.onload != "function")) {
                                window.onload = func;
                        } else {
                                window.onload = function() {
                                        if (oldonload) {
                                                oldonload();
                                        }
                                        func();
                                }
                        }
                }
                addLoadEvent(preloader);

                    </script>';
            }
        ?>

        <?php wp_head (); ?>

        <?php flush (); ?>

    </head>
    <body>

        <script type="text/javascript">Cufon.now ();</script>

        <div id="main" class="site wrapper">

            <div class="top-sagarra">

                <header role="banner">

                    <div class="sagarra-logo">
                        <h1>
                            <a href="<?php echo qtrans_convertURL (home_url ('/')); ?>">SAGARRA</a>
                        </h1>
                    </div>
                    <div id="aniversari" class="fixMe">
                        <?php
                        bloginfo ('description');
                        ?>
                    </div>
                    <?php wp_nav_menu (array ( 'container_class' => 'contactar', 'theme_location' => 'contacto' )); ?>

                </header>
            </div>
