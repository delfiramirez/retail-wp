<?php
/* Template Name: Historia
 *
 * Contains history, hand-coded, special libraries
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

        <div id="sagarra-historia">
            <?php
            echo do_shortcode (' [wp-timeline]');
            ?>
        </div>

    </div>

</div>
<?php get_footer (); ?>
