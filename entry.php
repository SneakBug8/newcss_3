<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php p2_title(); ?>
    <small>
        <p><?php _e('Published', 'newcss'); ?>
            <time><?php the_date(); ?></time><?php if (get_the_modified_date() > get_the_date()) : ?>
                (<?php _e('updated', 'newcss'); ?>: <time><?php the_modified_date(); ?></time>)<?php endif; ?>
                <?php _e('in', 'newcss'); ?> <?php the_category(', '); ?>. <?php if (has_tag()) : ?>
                    <?php the_tags(); ?>.<?php endif; ?>
        </p>
    </small>
    <?php
    if (has_post_thumbnail()) {
        if ( /*is_home() ||*/is_single()) {
            the_post_thumbnail('post-thumbnail', ['alt' => esc_attr(get_the_title())]);
        }
        else {
            ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_post_thumbnail(); ?>
        </a>
        <?php
        }
    }
    ?>
    <section>
        <?php if ( /*is_home() ||*/is_single()) {
            p2_content(); ?>

            <?php /* _e('Any questions left?', 'newcss') ?>
            <a href="https://forms.gle/XyQqjVpQwJEJNh4z8">
                <?php _e('Ask me!', 'newcss') ?>
            </a>
			*/ ?>

            <div class="views-counter" id="<?php the_ID(); ?>">
                <?php if (function_exists('the_views')) {
                    the_views();
                } ?>
            </div><?php
                } else {
                    the_excerpt();
                } ?>

        <?php if (is_single()) { ?>
            <?php /* <aside>
                <?php
                if (!is_page()) : ?>
                    <a class="post-avatar">
                        <?php echo get_avatar(get_the_author_meta('user_email'), 48); ?>
                    </a>
                <?php endif; ?>
                <h3><?php _e('About the author', 'newcss'); ?> <?php the_author_meta('display_name') ?></h3>
                <p><?php the_author_meta('description'); ?></p>
            </aside> */ ?>

            <div class="next-prev-links clearfix">
                <span class="prev-link"><?php previous_post_link(); ?></span>
                <span class="next-link"><?php next_post_link(); ?></span>
            </div>
        <?php } ?>
    </section>
</article>