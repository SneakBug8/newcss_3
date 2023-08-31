<?php

/**
 * The functions and definitions.
 *
 * @package    newcss
 * @copyright  Copyright (c) 2020, David Mytton <david@davidmytton.co.uk> (https://davidmytton.blog)
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */

register_rest_field('post', 'views', array(
	'get_callback' => function ($data) {
		return get_post_meta($data['id'], 'views', true);
	},
));

/* No more image width and height for AMP compat */
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

/* No WP caption width for AMP compat */
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
function fixed_img_caption_shortcode($attr, $content = null) {
    // Allow plugins/themes to override the default caption template.
    //$output = apply_filters('img_caption_shortcode', '', $attr, $content);
    //if ( $output != '' ) return $output;
    extract(shortcode_atts(array(
        'id'=> '',
        'align' => 'alignnone',
        'width' => '',
        'caption' => ''), $attr));
    // if ( 1 > (int) $width || empty($caption) )
   // return $content;
    if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align)
    . '">'
    . do_shortcode( $content ) . '</div>';
}

if (!function_exists('newcss_setup')) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	function newcss_setup()
	{

		/**
		 * First, let's set the maximum content width based on the theme's design and stylesheet.
		 * This will limit the width of all uploaded images and embeds.
		 */
		if (!isset($content_width))
			$content_width = 750; /* pixels */

		/**
		 * Add default posts and comments RSS feed links to <head>.
		 */
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/**
		 * Enable support for post thumbnails and featured images.
		 */
		add_theme_support('post-thumbnails');
		set_post_thumbnail_size(750);

		/**
		 * Remove the CSS classes and IDs from the nav menu
		 * https://wordpress.stackexchange.com/a/15725
		 */
		// add_filter( 'nav_menu_item_id', '__return_null', 10, 3 );
		// add_filter( 'nav_menu_css_class', '__return_empty_array', 10, 3 );

		/**
		 * Add support for navigation menu.
		 */
		register_nav_menu('primary', 'Navigation Menu');
		register_nav_menu('left', 'Left Menu');
		register_nav_menu('right', 'Right Menu');

		add_theme_support('post-formats', p2_get_supported_post_formats('post-format'));

		add_rewrite_rule('wiki[/]*', 'index.php?page_id=2498', 'top');
	}
}

add_action('after_setup_theme', 'newcss_setup');

function newcss_css()
{
	wp_enqueue_style('newcss-dist', get_template_directory_uri() . '/assets/css/new.css', array(), '1.1.3', 'all');
	wp_enqueue_style('bootstrap-grid', get_template_directory_uri() . '/assets/css/bootstrap-grid.min.css', array(), '5.1', 'all');

	wp_enqueue_style('custom', get_template_directory_uri() . '/custom.css', array(), '1.1.3', 'all');

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style('fontawesome', 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css', array(), '5.15.3', 'all');

	wp_enqueue_style('newcss-customised', get_stylesheet_uri(), array(), '1.0.2', 'all');

	wp_enqueue_script(
		'jquery',
		get_template_directory_uri() . '/assets/jquery-3.6.0.min.js',
		array(),
		'20210507'
	);

	if (is_singular())
		wp_enqueue_script('comment-reply');
}

add_action('wp_enqueue_scripts', 'newcss_css');

function p2_get_post_format($post_id = null)
{
	if (is_null($post_id)) {
		global $post;
		$post_id = $post->ID;
	}

	if (empty($post_id))
		return '';

	// 1- try to get post format, first
	$post_format = get_post_format($post_id);

	// 2- try back compat category, next
	if (false === $post_format)
		$post_format = p2_get_the_category($post_id);

	// Check against accepted values
	if (empty($post_format) || !in_array($post_format, p2_get_supported_post_formats()))
		$post_format = 'standard';

	return $post_format;
}

function p2_get_supported_post_formats($type = 'all')
{
	$post_formats = array('link', 'quote', 'status');

	switch ($type) {
		case 'post-format':
			break;
		case 'category':
			$post_formats[] = 'post';
			break;
		case 'all':
		default:
			array_push($post_formats, 'post', 'standard');
			break;
	}

	return apply_filters('p2_get_supported_post_formats', $post_formats);
}

function p2_title($before = '<h2>', $after = '</h2>')
{
	if (is_home() || is_archive() || is_search()) { ?>
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php
	} else {
	?>
		<h1><?php the_title(); ?></h1>
	<?php
	}
}

function p2_content()
{
	if (is_home() || is_archive() || is_search()) {
		$content = get_the_content();
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		$content = preg_replace(
			array(
				"/<(.*?)h6(.*?)>(.*?)<\/h6>/",
				"/<(.*?)h5(.*?)>(.*?)<\/h5>/",
				"/<(.*?)h4(.*?)>(.*?)<\/h4>/",
				"/<(.*?)h3(.*?)>(.*?)<\/h3>/",
				"/<(.*?)h2(.*?)>(.*?)<\/h2>/",
				"/<(.*?)h1(.*?)>(.*?)<\/h1>/",
			),
			array(
				"<$1b$2>$3</b>",
				"<$1h6$2>$3</h6>",
				"<$1h5$2>$3</h5>",
				"<$1h4$2>$3</h4>",
				"<$1h3$2>$3</h3>",
				"<$1h2$2>$3</h2>",
			),
			$content
		);
		echo $content;
	} else {
		the_content();
	}
}

function mypostviews()
{
	?><div id="postviews_lscwp"></div><?php
										//do_shortcode( '[spp-current-post]');
									}

									function the_views2()
									{
										?>
	<!-- Views counter start -->
	<div class="views-counter">Просмотров: <span id="counter-<?php the_ID(); ?>"></span></div>
	<script>
		"use strict";

		function isElementInViewport(el) {
			if (!el) {
				return false;
			}
			var rect = el.getBoundingClientRect();

			return (
				rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /* or $(window).height() */
				rect.right <= (window.innerWidth || document.documentElement.clientWidth) /* or $(window).width() */
			);
		}

		function defer(method) {
			if (window.jQuery) {
				method();
			} else {
				setTimeout(function() {
					defer(method)
				}, 50);
			}
		}

		defer(function() {
			jQuery(window).ready(function() {
				jQuery.ajax("https://sneakbug8.com/publish/postviewcounter/get.php?id=<?php the_ID(); ?>&skip=true")
					.done(function(msg) {
						jQuery("#counter-<?php the_ID(); ?>").text(msg);
					});
			});
		});

		function checkElem<?php the_ID(); ?>() {
			defer(function() {
				jQuery(window).ready(function() {
					if (isElementInViewport(jQuery('#post-<?php the_ID(); ?>').get(0))) {
						if (!alreadyviewed<?php the_ID(); ?>) {
							jQuery.ajax("https://sneakbug8.com/publish/postviewcounter/index.php?id=<?php the_ID(); ?>")
								.done(function(msg) {
									console.log("#counter-<?php the_ID(); ?> : " + msg);
									jQuery("#counter-<?php the_ID(); ?>").text(msg);
									localStorage.setItem("SB8post<?php the_ID(); ?>", true);
								});
						}
					}
				});
			});
		}

		var alreadyviewed<?php the_ID(); ?> = localStorage.getItem("SB8post<?php the_ID(); ?>");
		checkElem<?php the_ID(); ?>();
	</script>
	</div>
	<!-- Views counter end -->
<?php
									}


									function p2_register_sidebar()
									{
										register_sidebar(
											array(
												'id' => 'header-1',
												'name' => esc_html__('Header area', 'newcss'),
												'description' => esc_html__('Header area', 'newcss'),
												'before_widget' => '<aside id="%1$s" class="widget %2$s">',
												'after_widget' => '</aside>',
												'before_title' => '<h3 class="widget-title">',
												'after_title' => '</h3>'
											)
										);

										register_sidebar(
											array(
												'id' => 'post-1',
												'name' => esc_html__('After post area', 'newcss'),
												'description' => esc_html__('After post area', 'newcss'),
												'before_widget' => '<aside id="%1$s" class="widget %2$s">',
												'after_widget' => '</aside>',
												'before_title' => '<h3 class="widget-title">',
												'after_title' => '</h3>'
											)
										);

										register_sidebar(
											array(
												'id' => 'post-2',
												'name' => esc_html__('Middle post area', 'newcss'),
												'description' => esc_html__('Middle post area', 'newcss'),
												'before_widget' => '<aside id="%1$s" class="widget %2$s">',
												'after_widget' => '</aside>',
												'before_title' => '<h3 class="widget-title">',
												'after_title' => '</h3>'
											)
										);
									}
									add_action('widgets_init', 'p2_register_sidebar');

									add_filter('widget_title', 'remove_widget_title');
									function remove_widget_title($widget_title)
									{
										if (substr($widget_title, 0, 1) == '!')
											return;
										else
											return ($widget_title);
									}
?>