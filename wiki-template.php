<?php /* Template Name: WikiPage */ ?>

<?php get_header(); ?>

<?php if ( is_page() ) : ?>

    <?php if (has_post_parent()):
        $parentid = wp_get_post_parent_id(); ?>
<aside>
    <h3><a href="<?php the_permalink($parentid); ?>">
    <?php echo isset($parentid) ? get_the_title($parentid) : get_the_title(); ?></a></h3>
                <?php echo do_shortcode("[su_subpages p='" . $parentid . "']"); ?>
</aside>
<?php endif; ?>
<?php endif; ?>

<main id="content">
        <section>

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'entry' ); ?>

        <?php wp_link_pages(); ?>

        <?php if ( is_single() ) {
			the_post_navigation( array(
				'prev_text' 	=> '<span class="arrow" aria-hidden="true">&larr;</span><span class="screen-reader-text">' . __( 'Previous post:', 'chaplin' ) . '</span><span class="post-title">%title</span>',
				'next_text' 	=> '<span class="arrow" aria-hidden="true">&rarr;</span><span class="screen-reader-text">' . __( 'Next post:', 'chaplin' ) . '</span><span class="post-title">%title</span>',
				'in_same_term' 	=> true,
			) );
		}
        ?>

        <?php endwhile; ?>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>
        <?php endif; ?>

        </section>

		<?php
        /* $base = $_SERVER['DOCUMENT_ROOT'];
        // load dependencies
       	require_once($base.'/wiki/wordpress.php');
        */
         ?>
    </main>
<?php get_footer(); ?>