<?php
/**
 * The template for displaying a list of posts for any page that does not have a template defined.
 *
 * @package    newcss
 * @copyright  Copyright (c) 2020, David Mytton <david@davidmytton.co.uk> (https://davidmytton.blog)
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

get_header(); ?>
    <main id="content">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'entry' ); ?>

        <?php endwhile; ?>

        <div class="navigation clearfix">
			<p class="nav-older"><?php next_posts_link( __( '&larr; Older posts', 'newcss' ) ); ?></p>
			<p class="nav-newer"><?php previous_posts_link( __( 'Newer posts &rarr;', 'newcss' ) ); ?></p>
		</div>
        <?php else: ?>

        <p><?php _e( 'No posts found.', 'newcss' ); ?></p>

        <?php endif; ?>
    </main>
<?php get_footer(); ?>