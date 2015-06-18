<?php

function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('cat', '18,11');
    }
    return $query;
}

add_filter('pre_get_posts', 'SearchFilter');

get_header();
?>
<div id="single-sagarra">

    <div id="content-sagarra">
        <h1>
            <?php the_title(); ?>
        </h1>
    </div>

    <div id="images-sagarra">
        <h2>
            <?php _e("<!--:en-->Search Results<!--:--><!--:es-->Resultado de la Busqueda<!--:--><!--:ca-->Resultat de la vostra cerca<!--:-->"); ?>
        </h2>

        <ul>

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <li>
                        <a class="article-aside" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>

            <?php else : ?>
                <h3>
                    <?php echo _e("<!--:en-->Noresults<!--:--><!--:es-->Sin resultado<!--:--><!--:ca-->No hem trobat la seva consulta<!--:-->"); ?>
                </h3>
            <?php endif; ?>

        </ul>

        <div>
            <?php
            global $wp_query;
            $big = 999999999;
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                'format' => '?paged=%#%',
                'total' => $wp_query->max_num_pages,
                'current' => max(1, get_query_var('paged')),
                'show_all' => False,
                'end_size' => 1,
                'mid_size' => 2,
                'prev_next' => True,
                'prev_text' => __('<!--[if lte IE 8]><span id="iebtn-prev">&laquo; </span><![endif]--><!--[if gt IE 8]><!--><button>&laquo; </button><!--<![endif]-->'),
                'next_text' => __('<!--[if lte IE 8]><span id="iebtn-nxt"> &raquo;</span><![endif]--><!--[if gt IE 8]><!--><button> &raquo;</button><!--<![endif]-->'),
                'type' => 'plain',
                'add_args' => False,
                'add_fragment' => ''));
            ?>
        </div>

        </section>

    </div>

</div>

<?php get_footer(); ?>
