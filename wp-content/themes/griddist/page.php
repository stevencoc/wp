<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bloggist
 */

 get_header(); ?>

<main id="site-content">

	<?php

	if ( have_posts() ) :

		while ( have_posts() ) : the_post();

			get_template_part( 'content', get_post_type() );

			// Display related posts
			get_template_part( 'inc/related-posts' );

		endwhile;

	endif;

	?>

</main><!-- #site-content -->

<?php get_footer(); ?>
