<?php

/**
 * The template for displaying the header.
 *
 * @package    newcss
 * @copyright  Copyright (c) 2020, David Mytton <david@davidmytton.co.uk> (https://davidmytton.blog)
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <script src="/publish/noamp.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <header>
        <a class="screen-reader-text skip-link" href="#content"><?php _e('Skip to content', 'newcss'); ?></a>
        <div class="clearfix site-title-container">
            <span class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>
				<a class="toggle toggleLeftMenu open" on="tap:sidebar1.toggle"> <i class="fa fa-bars"></i>
            </a>
			</span>
        </div>
        
		<div class="clearfix site-description-container">
			<span class="site-description"><?php bloginfo('description'); ?></span>
        </div>
        <div class="buttons clearfix">
            <!-- <?php if (has_nav_menu('left')) : ?>
                <a class="toggle toggleLeftMenu"><i class="fa fa-bars"></i></a>
            <?php endif; ?>
	        <?php if (has_nav_menu('primary')) : ?>
            <a class="toggle" id="toggleMenu">Меню</a>
            <?php endif; ?>
            <a class="toggle" id="toggleDark"><i class="fa fa-adjust"></i></a>
            <span class="social"><a class="social__icon fa fa-twitter" href="https://twitter.com/SneakBug8"></a></span>
            <span class="social"><a class="social__icon fa fa-facebook" href="https://facebook.com/SneakBug8"></a></span>
            <span class="social"><a class="social__icon fa fa-telegram" href="https://t.me/SneakBug8"></a></span> -->
        </div>
        <!-- <nav class="top clearfix">
            <?php if (has_nav_menu('primary')) : ?>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary'
                    )
                ); ?>
            <?php endif; ?>
        </nav>
            -->
        <?php if (has_nav_menu('left')) : ?>
            <nav class="top left-fullwidth clearfix">
            <?php if (function_exists("pll_the_languages")) {
                echo '<ul class="languageswap">';
                pll_the_languages(array('show_flags' => 1, 'show_names' => 0));
                echo "</ul>";
            } ?>

                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'left',
                        'container_class' => 'menu-left'
                    )
                ); ?>

                <div class="flex-right">
                <?php
                get_search_form();
                ?>
                </div>
            </nav>
        <?php endif; ?>
        <!--
	    <?php if (has_nav_menu('right')) : ?>
        <nav class="right">
        <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'right'
                )
            ); ?>
        </nav>
	    <?php endif; ?> -->
    </header>
    <amp-sidebar id="sidebar1" class="menu left" layout="nodisplay" side="left">
        <a class="closeBtn toggleLeftMenu close" on="tap:sidebar1.close"><i class="fa fa-times"></i></a>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'left'
            )
        ); ?>
    </amp-sidebar>