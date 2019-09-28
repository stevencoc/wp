<article <?php post_class( 'preview preview-' . get_post_type() . ' do-spot' ); ?> id="post-<?php the_ID(); ?>">

	<div class="preview-wrapper">

		<?php

		$fallback_image_url = griddist_get_fallback_image_url();

		if ( has_post_thumbnail() || $fallback_image_url ) : ?>

		<a href="<?php the_permalink(); ?>" class="preview-image">

			<?php
			if ( has_post_thumbnail() ) {
				$image_size = griddist_get_preview_image_size();
				the_post_thumbnail( $image_size );
			}
			?>

		</a>

	<?php endif; ?>

	<div class="preview-inner">

		<h3 class="preview-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
		<p><?php the_excerpt(); ?></p>
	</div><!-- .preview-inner -->

</div><!-- .preview-wrapper -->

</article>
