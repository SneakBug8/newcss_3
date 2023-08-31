<?php /* Template Name: WikiPage */ ?>

<?php get_header(); ?>
    <main id="content">
        <section>
		<?php
        $base = $_SERVER['DOCUMENT_ROOT'];
        // load dependencies
       	require_once($base.'/wiki/wordpress.php');
         ?>
        </section>
    </main>
<?php get_footer(); ?>