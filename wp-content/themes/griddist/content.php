<article <?php post_class( 'single-container bg-color-white' ); ?> id="post-<?php the_ID(); ?>">

	<?php if ( has_post_thumbnail() ) : ?>

		<div class="featured-media">

			<?php the_post_thumbnail(); ?>

		</div><!-- .featured-media -->

	<?php endif; ?>

	<div class="post-inner section-inner">

		<header class="post-header">

			<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>

		</header><!-- .post-header -->

		<div class="entry-content">

			<?php the_content(); ?>
			<?php wp_link_pages(); ?>

		</div><!-- .entry-content -->


				<?php

			// If comments are open, or there are at least one comment
			if ( comments_open() || get_comments_number() ) : ?>

				<div class="comments-wrapper">

					<?php comments_template(); ?>

				</div><!-- .comments-wrapper -->

			<?php endif; ?>

		</div><!-- .post-inner -->


</article>
