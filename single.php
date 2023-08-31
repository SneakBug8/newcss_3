<?php
/**
 * The template for displaying a single posts.
 *
 * @package    newcss
 * @copyright  Copyright (c) 2020, David Mytton <david@davidmytton.co.uk> (https://davidmytton.blog)
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

get_header(); ?>
    <main id="content">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'entry' ); ?>

        <?php wp_link_pages(); ?>

        <?php endwhile; ?>

        <?php if ( is_single()) : ?>
            <?php if ( is_active_sidebar( 'post-1' ) ) : ?>
                <?php dynamic_sidebar( 'post-1' ); ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>
        <?php endif; ?>
    </main>
<?php get_footer(); ?>