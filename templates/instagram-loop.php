<?php defined( 'ABSPATH' ) || exit; ?>

<?php
/**
 * READ BEFORE EDITING!
 *
 * Do not edit templates in the plugin folder, since all your changes will be
 * lost after the plugin update. Read the following article to learn how to
 * change this template or create a custom one:
 *
 * https://getshortcodes.com/docs/posts/#built-in-templates
 */
?>

<ul class="su-posts su-posts-list-loop clearfix">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
        /*if ( !has_post_thumbnail( ) ) {
            continue;
        }*/
?>

<div class="circle" id="su-post-<?php the_ID(); ?>">
<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

<div class="img" <?php if ( has_post_thumbnail( ) ) { ?>
    style="background-image:url('<?php the_post_thumbnail_url("small") ?>');"
    <?php } ?>
    >
</a>

</div>
<span class="eXle2"><?php the_title(); ?></span>

</div>

<?php
	}
}
// Posts not found
else {
?>
<li><?php _e( 'Posts not found', 'shortcodes-ultimate' ) ?></li>
<?php
}
?>
</ul>
