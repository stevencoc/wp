<?php 



/* ---------------------------------------------------------------------------------------------
	AJAX LOAD MORE
	Called in construct.js when the user has clicked the load more button
--------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_ajax_load_more' ) ) :

	function griddist_ajax_load_more() {

		$query_args = json_decode( wp_unslash( $_POST['json_data'] ), true );

		$ajax_query = new WP_Query( $query_args );

		// Determine which preview to use based on the post_type
		$post_type = $ajax_query->get( 'post_type' );

		// Default to the "post" post type for previews
		if ( is_array( $post_type ) ) {
			$post_type = 'post';
		}

		if ( $ajax_query->have_posts() ) :

			while ( $ajax_query->have_posts() ) : $ajax_query->the_post();

				get_template_part( 'inc/post-feed', $post_type );

			endwhile;

		endif;

		die();
	}
	add_action( 'wp_ajax_nopriv_griddist_ajax_load_more', 'griddist_ajax_load_more' );
	add_action( 'wp_ajax_griddist_ajax_load_more', 'griddist_ajax_load_more' );

endif;

/* ---------------------------------------------------------------------------------------------
   OUTPUT LOADING INDICATOR
------------------------------------------------------------------------------------------------ */


if ( ! function_exists( 'griddist_loading_indicator' ) ) :

	function griddist_loading_indicator() {

		echo '<div class="loader"></div>';

	}

endif;


 ?>