<?php

/* ---------------------------------------------------------------------------------------------
   THEME SETUP
   --------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'griddist_setup' ) ) :

	function griddist_setup() {

		// Automatic feed
		add_theme_support( 'automatic-feed-links' );

		// Custom background color
		add_theme_support( 'custom-background' );

		// Set content-width
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 520;
		}

		// Post thumbnails
		add_theme_support( 'post-thumbnails' );

		// Set post thumbnail size
		set_post_thumbnail_size( 1870, 9999 );

		// Add image sizes
		add_image_size( 'griddist_preview_image_low_resolution', 400, 9999, false );
		add_image_size( 'griddist_preview_image_high_resolution', 800, 9999, false );

		// Custom logo
		add_theme_support( 'custom-logo', array(
			'height'      => 200,
			'width'       => 600,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		// Title tag
		add_theme_support( 'title-tag' );

		// Add nav menu
		register_nav_menu( 'primary-menu', __( 'Primary Menu', 'griddist' ) );
		register_nav_menu( 'mobile-menu', __( 'Mobile Menu', 'griddist' ) );
		register_nav_menu( 'social', __( 'Social Menu', 'griddist' ) );

		// HTML5 semantic markup
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'caption' ) );

		// Make the theme translation ready
		load_theme_textdomain( 'griddist', get_template_directory() . '/languages' );

	}
	add_action( 'after_setup_theme', 'griddist_setup' );

endif;

/* ---------------------------------------------------------------------------------------------
   ENQUEUE STYLES
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_load_style' ) ) :

	function griddist_load_style() {
		if ( ! is_admin() ) :

			wp_register_style( 'griddist-fontawesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.css' );

			$dependencies = array( 'griddist-fontawesome' );

			wp_enqueue_style( 'griddist-style', get_template_directory_uri() . '/style.css', $dependencies, wp_get_theme()->get( 'Version' ) );
		endif;
	}
	add_action( 'wp_enqueue_scripts', 'griddist_load_style' );

endif;



/* ---------------------------------------------------------------------------------------------
   ENQUEUE SCRIPTS
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_enqueue_scripts' ) ) :

	function griddist_enqueue_scripts() {

		wp_enqueue_script( 'griddist_construct', get_template_directory_uri() . '/assets/js/construct.js', array( 'jquery', 'imagesloaded', 'masonry' ), wp_get_theme()->get( 'Version' ), true );

		if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		$ajax_url = admin_url( 'admin-ajax.php' );

		// AJAX Load More
		wp_localize_script( 'griddist_construct', 'griddist_ajax_load_more', array(
			'ajaxurl'   => esc_url( $ajax_url ),
		) );

	}
	add_action( 'wp_enqueue_scripts', 'griddist_enqueue_scripts' );

endif;

/* ---------------------------------------------------------------------------------------------
   EXCERPTS
   --------------------------------------------------------------------------------------------- */


function griddist_excerpt_more( $more ) {
    if ( is_admin() ) {
        return $more;
    }
    return '...';
}
add_filter( 'excerpt_more', 'griddist_excerpt_more' );

function griddist_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'griddist_custom_excerpt_length', 999 );

/* ---------------------------------------------------------------------------------------------
   GET FONTS
   --------------------------------------------------------------------------------------------- */
function griddist_load_google_fonts() {
	wp_enqueue_style( 'griddist-google-fonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,900|Merriweather:700i' ); 
}
add_action( 'wp_enqueue_scripts', 'griddist_load_google_fonts' ); 




/* ---------------------------------------------------------------------------------------------
   POST CLASSES
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_post_classes' ) ) :

	function griddist_post_classes( $classes ) {

		global $post;

		// Class indicating presence/lack of post thumbnail
		$classes[] = ( has_post_thumbnail() ? 'has-thumbnail' : 'missing-thumbnail' );

		return $classes;
	}
	add_action( 'post_class', 'griddist_post_classes' );

endif;


/* ---------------------------------------------------------------------------------------------
   BODY CLASSES
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_body_classes' ) ) :

	function griddist_body_classes( $classes ) {

		global $post;

		// Determine type of infinite scroll
		$pagination_type = get_theme_mod( 'griddist_pagination_type' ) ? get_theme_mod( 'griddist_pagination_type' ) : 'button';
		switch ( $pagination_type ) {
			case 'button' :
				$classes[] = 'pagination-type-button';
				break;
			case 'scroll' :
				$classes[] = 'pagination-type-scroll';
				break;
			case 'links' :
				$classes[] = 'pagination-type-links';
				break;
		}

		// Check for post thumbnail
		if ( is_singular() && has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		} elseif ( is_singular() ) {
			$classes[] = 'missing-post-thumbnail';
		}

		// Check whether we're in the customizer preview
		if ( is_customize_preview() ) {
			$classes[] = 'customizer-preview';
		}

		// Slim page template class names (class = name - file suffix)
		if ( is_page_template() ) {
			$classes[] = preg_replace( '/\\.[^.\\s]{3,4}$/', '', get_page_template_slug( $post->ID ) );
		}

		return $classes;

	}
	add_action( 'body_class', 'griddist_body_classes' );

endif;


/* ---------------------------------------------------------------------------------------------
   ADD HTML CLASS IF THERE'S JAVASCRIPT
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_has_js' ) ) :

	function griddist_has_js() {
		?>
		<script>document.documentElement.className = document.documentElement.className.replace( 'no-js', 'js' );</script>
		<?php
	}
	add_action( 'wp_head', 'griddist_has_js' );

endif;


/* ---------------------------------------------------------------------------------------------
   CUSTOM LOGO OUTPUT
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_custom_logo' ) ) :

	function griddist_custom_logo() {

		// Get the logo
		$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

		if ( $logo ) {

			// For clarity
			$logo_url = esc_url( $logo[0] );
			$logo_width = esc_attr( $logo[1] );
			$logo_height = esc_attr( $logo[2] );

			// If the retina logo setting is active, reduce the width/height by half
			if ( get_theme_mod( 'griddist_retina_logo' ) ) {
				$logo_width = floor( $logo_width / 2 );
				$logo_height = floor( $logo_height / 2 );
			}

			?>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" class="custom-logo-link">
				<img src="<?php echo esc_url( $logo_url ); ?>" width="<?php echo esc_attr( $logo_width ); ?>" height="<?php echo esc_attr( $logo_height ); ?>" />
			</a>

			<?php
		}

	}

endif;

/* ---------------------------------------------------------------------------------------------
   OUTPUT POST META
   If it's a single post, output the post meta values specified in the Customizer settings.

   @param	$post_id int		The ID of the post for which the post meta should be output
   @param	$location string	Which post meta location to output – single or preview
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_the_post_meta' ) ) :

	function griddist_the_post_meta( $post_id = null, $location = 'single' ) {

		echo griddist_get_post_meta( $post_id, $location );

	}

endif;


/* ---------------------------------------------------------------------------------------------
   GET THE POST META
   If the provided ID is for a single post, return the post meta values specified in the Customizer settings.

   @param	$post_id int		The ID of the post for which the post meta should be output
   @param	$location string	Which post meta location to output – single or preview
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_get_post_meta' ) ) :

	function griddist_get_post_meta( $post_id = null, $location = 'single' ) {

		// Require post ID
		if ( ! $post_id ) {
			return;
		}

		// Check that the post type should be able to output post meta
		$allowed_post_types = apply_filters( 'griddist_allowed_post_types_for_meta_output', array( 'post' ) );
		if ( ! in_array( get_post_type( $post_id ), $allowed_post_types ) ) {
			return;
		}

		$post_meta_wrapper_classes = '';
		$post_meta_classes = '';

		// Get the post meta settings for the location specified
		if ( 'preview' === $location ) {
			$post_meta = get_theme_mod( 'griddist_post_meta_preview' );

			$post_meta_wrapper_classes = ' post-meta-preview';

			// Empty = use default
			if ( ! $post_meta ) {
				$post_meta = array(
					'post-date',
					'comments',
				);
			}
		} else {
			$post_meta = get_theme_mod( 'griddist_post_meta_single' );

			$post_meta_wrapper_classes = ' post-meta-single';
			$post_meta_classes = ' stack-mobile';

			// Empty = use default
			if ( ! $post_meta ) {
				$post_meta = array(
					'post-date',
					'categories',
				);
			}
		}

		// If the post meta setting has the value 'empty', it's explicitly empty and the default post meta shouldn't be output
		if ( $post_meta && ! in_array( 'empty', $post_meta ) ) :

			ob_start();

			setup_postdata( $post_id );

			?>

			<div class="post-meta-wrapper<?php echo $post_meta_wrapper_classes; ?>">

				<ul class="post-meta<?php echo $post_meta_classes; ?>">

					<?php

					// Post date
					if ( in_array( 'post-date', $post_meta ) ) : ?>
						<li class="post-date">
							<a class="meta-wrapper" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<span class="screen-reader-text"><?php _e( 'Post date', 'griddist' ); ?></span>
								<div class="meta-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/calendar.svg" /></div>
								<span class="meta-content"><?php the_time( get_option( 'date_format' ) ); ?></span>
							</a>
						</li>
					<?php endif;

					// Author
					if ( in_array( 'author', $post_meta ) ) : ?>
						<li class="post-author">
							<span class="screen-reader-text"><?php _e( 'Posted by', 'griddist' ); ?></span>
							<a class="meta-wrapper" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
								<div class="meta-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/user.svg" /></div>
								<span class="meta-content"><?php the_author_meta( 'nickname' ); ?></span>
							</a>
						</li>
						<?php
					endif;

					// Categories
					if ( in_array( 'categories', $post_meta ) ) : ?>
						<li class="post-categories meta-wrapper">
							<div class="meta-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/folder.svg" /></div>
							<span class="screen-reader-text"><?php _e( 'Posted in', 'griddist' ); ?></span>
							<span class="meta-content"><?php the_category( ', ' ); ?></span>
						</li>
						<?php
					endif;

					// Tags
					if ( in_array( 'tags', $post_meta ) && has_tag() ) : ?>
						<li class="post-tags meta-wrapper">
							<div class="meta-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/tag.svg" /></div>
							<span class="screen-reader-text"><?php _e( 'Tagged with', 'griddist' ); ?></span>
							<span class="meta-content"><?php the_tags( '', ', ', '' ); ?></span>
						</li>
						<?php
					endif;

					// Comments link
					if ( in_array( 'comments', $post_meta ) && comments_open() ) : ?>
						<li class="post-comment-link">
							<a class="meta-wrapper" href="<?php echo esc_url( get_comments_link( $post_id ) ); ?>">
								<span class="screen-reader-text"><?php _e( 'Comments', 'griddist' ); ?></span>
								<div class="meta-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/comment.svg" /></div>
								<span class="meta-content"><?php echo get_comments_number(); ?></span>
							</a>
						</li>
						<?php
					endif;

					// Sticky
					if ( in_array( 'sticky', $post_meta ) && is_sticky() ) : ?>
						<li class="post-sticky meta-wrapper">
							<div class="meta-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/bookmark.svg" /></div>
							<span class="meta-content"><?php _e( 'Sticky post', 'griddist' ); ?></span>
						</li>
					<?php endif;

					// Edit link
					if ( in_array( 'edit-link', $post_meta ) && current_user_can( 'edit_post', get_the_ID() ) ) : ?>
						<li class="edit-post">
							
							<?php
							// Make sure we display something in the customizer, as edit_post_link() doesn't output anything there
							if ( is_customize_preview() ) { ?>
								<div class="meta-wrapper">
									<div class="meta-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/edit.svg" /></div>
									<span class="meta-content"><?php _e( 'Edit', 'griddist' ); ?></span>
								</div>
								<?php
							} else {
								echo '<a href="' . esc_url( get_edit_post_link() ) . '" class="meta-wrapper"><div class="meta-icon">';
								echo '<img src="' . get_template_directory_uri() . '/assets/images/icons/edit.svg' . '" />';
								echo '</div>';
								echo '<span class="meta-content">' . __( 'Edit', 'griddist' ) . '</span>';
								echo '</a>';
							}
							?>

						</li>
					<?php endif; ?>

				</ul><!-- .post-meta -->

			</div><!-- .post-meta-wrapper -->

			<?php

			// Get the contents of the buffer
			$post_meta_contents = ob_get_clean();

			wp_reset_postdata();

			// And return them
			return $post_meta_contents;

		endif;

		// If we've reached this point, there's nothing to return, so let's return nothing
		return;

	}

endif;


 
/* ---------------------------------------------------------------------------------------------
   REGISTER WIDGET AREAS
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_widget_areas' ) ) :

	function griddist_widget_areas() {

		register_sidebar( array(
			'name' 			=> __( 'Sidebar', 'griddist' ),
			'id' 			=> 'sidebar',
			'description' 	=> __( 'Widgets in this area will be shown below the main menu.', 'griddist' ),
			'before_title' 	=> '<h3 class="widget-title">',
			'after_title' 	=> '</h3>',
			'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
			'after_widget' 	=> '</div><div class="clear"></div></div>',
		) );

		register_sidebar( array(
			'name' 			=> __( 'Footer #1', 'griddist' ),
			'id' 			=> 'footer-one',
			'description' 	=> __( 'Widgets in this area will be shown in the first footer column.', 'griddist' ),
			'before_title' 	=> '<h3 class="widget-title">',
			'after_title' 	=> '</h3>',
			'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
			'after_widget' 	=> '</div><div class="clear"></div></div>',
		) );

		register_sidebar( array(
			'name' 			=> __( 'Footer #2', 'griddist' ),
			'id' 			=> 'footer-two',
			'description' 	=> __( 'Widgets in this area will be shown in the second footer column.', 'griddist' ),
			'before_title' 	=> '<h3 class="widget-title">',
			'after_title' 	=> '</h3>',
			'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
			'after_widget' 	=> '</div><div class="clear"></div></div>',
		) );

		register_sidebar( array(
			'name' 			=> __( 'Footer #3', 'griddist' ),
			'id' 			=> 'footer-three',
			'description' 	=> __( 'Widgets in this area will be shown in the third footer column.', 'griddist' ),
			'before_title' 	=> '<h3 class="widget-title">',
			'after_title' 	=> '</h3>',
			'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
			'after_widget' 	=> '</div><div class="clear"></div></div>',
		) );

	}
	add_action( 'widgets_init', 'griddist_widget_areas' );

endif;


/* ---------------------------------------------------------------------------------------------
   REMOVE ARCHIVE PREFIXES
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_remove_archive_title_prefix' ) ) :

	function griddist_remove_archive_title_prefix( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_year() ) {
			$title = get_the_date( 'Y' );
		} elseif ( is_month() ) {
			$title = get_the_date( 'F Y' );
		} elseif ( is_day() ) {
			$title = get_the_date( get_option( 'date_format' ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Asides', 'post format archive title', 'griddist' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title', 'griddist' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title', 'griddist' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title', 'griddist' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title', 'griddist' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title', 'griddist' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title', 'griddist' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title', 'griddist' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title', 'griddist' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		} elseif ( is_search() ) {
			$title = '&ldquo;' . get_search_query() . '&rdquo;';
		} else {
			$title = __( 'Archives', 'griddist' );
		} // End if().
		return $title;
	}
	add_filter( 'get_the_archive_title', 'griddist_remove_archive_title_prefix' );

endif;


/* ---------------------------------------------------------------------------------------------
   GET ARCHIVE PREFIX
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_get_archive_title_prefix' ) ) :

	function griddist_get_archive_title_prefix() {
		if ( is_category() ) {
			$title_prefix = __( 'Category', 'griddist' );
		} elseif ( is_tag() ) {
			$title_prefix = __( 'Tag', 'griddist' );
		} elseif ( is_author() ) {
			$title_prefix = __( 'Author', 'griddist' );
		} elseif ( is_year() ) {
			$title_prefix = __( 'Year', 'griddist' );
		} elseif ( is_month() ) {
			$title_prefix = __( 'Month', 'griddist' );
		} elseif ( is_day() ) {
			$title_prefix = __( 'Day', 'griddist' );
		} elseif ( is_tax() ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			$title_prefix = $tax->labels->singular_name;
		} elseif ( is_search() ) {
			$title_prefix = __( 'Search Results', 'griddist' );
		} else {
			$title_prefix = __( 'Archives', 'griddist' );
		}
		return $title_prefix;
	}

endif;


/* ---------------------------------------------------------------------------------------------
   GET FALLBACK IMAGE
   --------------------------------------------------------------------------------------------- */


if ( ! function_exists( 'griddist_get_fallback_image_url' ) ) :

	function griddist_get_fallback_image_url() {

		$disable_fallback_image = get_theme_mod( 'griddist_disable_fallback_image' );

		if ( $disable_fallback_image ) {
			return '';
		}

		$fallback_image_id = get_theme_mod( 'griddist_fallback_image' );

		if ( $fallback_image_id ) {
			$fallback_image = wp_get_attachment_image_src( $fallback_image_id, 'full' );
		}

		$fallback_image_url = isset( $fallback_image ) ? esc_url( $fallback_image[0] ) : get_template_directory_uri() . '/assets/images/default-fallback-image.png';

		return $fallback_image_url;

	}

endif;

/* ---------------------------------------------------------------------------------------------
   GET THE IMAGE SIZE OF PREVIEWS
   --------------------------------------------------------------------------------------------- */

if ( ! function_exists( 'griddist_get_preview_image_size' ) ) :

	function griddist_get_preview_image_size() {

		// Check if low-resolution images are activated in the customizer
		$low_res_images = get_theme_mod( 'griddist_activate_low_resolution_images' );

		// If they are, we're using the low resolution image size
		if ( $low_res_images ) {
			return 'griddist_preview_image_low_resolution';

		// If not, we're using the high resolution image size
		} else {
			return 'griddist_preview_image_high_resolution';
		}

	}

endif;


if ( ! function_exists( 'griddist_add_gutenberg_features' ) ) :

	function griddist_add_gutenberg_features() {

		/* Gutenberg Feature Opt-Ins --------------------------------------- */

		add_theme_support( 'align-wide' );

		/* Gutenberg Palette --------------------------------------- */

		add_theme_support( 'editor-color-palette', array(
			array(
				'name' 	=> _x( 'Black', 'Name of the black color in the Gutenberg palette', 'griddist' ),
				'slug' 	=> 'black',
				'color' => '#232D37',
			),
			array(
				'name' 	=> _x( 'Darkest gray', 'Name of the darkest gray color in the Gutenberg palette', 'griddist' ),
				'slug' 	=> 'darkest-gray',
				'color' => '#4B555F',
			),
			array(
				'name' 	=> _x( 'Darker Gray', 'Name of the darker gray color in the Gutenberg palette', 'griddist' ),
				'slug' 	=> 'darker-gray',
				'color' => '#69737D',
			),
			array(
				'name' 	=> _x( 'Gray', 'Name of the gray color in the Gutenberg palette', 'griddist' ),
				'slug' 	=> 'gray',
				'color' => '#9BA5AF',
			),
			array(
				'name' 	=> _x( 'Light gray', 'Name of the light gray color in the Gutenberg palette', 'griddist' ),
				'slug' 	=> 'light-gray',
				'color' => '#DCDFE2',
			),
			array(
				'name' 	=> _x( 'Lightest gray', 'Name of the lightest gray color in the Gutenberg palette', 'griddist' ),
				'slug' 	=> 'lightest-gray',
				'color' => '#E6E9EC',
			),
			array(
				'name' 	=> _x( 'White', 'Name of the white color in the Gutenberg palette', 'griddist' ),
				'slug' 	=> 'white',
				'color' => '#FFF',
			),
		) );

		/* Gutenberg Font Sizes --------------------------------------- */

		add_theme_support( 'editor-font-sizes', array(
			array(
				'name' 		=> _x( 'Small', 'Name of the small font size in Gutenberg', 'griddist' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the Gutenberg editor.', 'griddist' ),
				'size' 		=> 16,
				'slug' 		=> 'small',
			),
			array(
				'name' 		=> _x( 'Regular', 'Name of the regular font size in Gutenberg', 'griddist' ),
				'shortName' => _x( 'M', 'Short name of the regular font size in the Gutenberg editor.', 'griddist' ),
				'size' 		=> 19,
				'slug' 		=> 'regular',
			),
			array(
				'name' 		=> _x( 'Large', 'Name of the large font size in Gutenberg', 'griddist' ),
				'shortName' => _x( 'L', 'Short name of the large font size in the Gutenberg editor.', 'griddist' ),
				'size' 		=> 24,
				'slug' 		=> 'large',
			),
			array(
				'name' 		=> _x( 'Larger', 'Name of the larger font size in Gutenberg', 'griddist' ),
				'shortName' => _x( 'XL', 'Short name of the larger font size in the Gutenberg editor.', 'griddist' ),
				'size' 		=> 32,
				'slug' 		=> 'larger',
			),
		) );

	}
	add_action( 'after_setup_theme', 'griddist_add_gutenberg_features' );

endif;


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Header
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Extra PHP.
 */
require get_template_directory() . '/inc/extra.php';




/**
 * Justintadlock customizer button https://github.com/justintadlock/trt-customizer-pro
 */
require_once( trailingslashit( get_template_directory() ) . 'justinadlock-customizer-button/class-customize.php' );


/**
 * Compare page CSS
 */

function griddist_comparepage_css($hook) {
  if ( 'appearance_page_griddist-info' != $hook ) {
    return;
  }
  wp_enqueue_style( 'griddist-custom-style', get_template_directory_uri() . '/css/compare.css' );
}
add_action( 'admin_enqueue_scripts', 'griddist_comparepage_css' );

/**
 * Compare page content
 */

add_action('admin_menu', 'griddist_themepage');
function griddist_themepage(){
  $theme_info = add_theme_page( __('Griddist Info','griddist'), __('Griddist Info','griddist'), 'manage_options', 'griddist-info.php', 'griddist_info_page' );
}

function griddist_info_page() {
  $user = wp_get_current_user();
  ?>
  <div class="wrap about-wrap griddist-add-css">
    <div>
      <h1>
        <?php echo __('Welcome to Griddist!','griddist'); ?>
      </h1>

      <div class="feature-section three-col">
        <div class="col">
          <div class="widgets-holder-wrap">
            <h3><?php echo __("Contact Support", "griddist"); ?></h3>
            <p><?php echo __("Getting started with a new theme can be difficult, if you have issues with Griddist then throw us an email.", "griddist"); ?></p>
            <p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/help-contact/', 'griddist'); ?>" class="button button-primary">
              <?php echo __("Contact Support", "griddist"); ?>
            </a></p>
          </div>
        </div>
        <div class="col">
          <div class="widgets-holder-wrap">
            <h3><?php echo __("Review Griddist", "griddist"); ?></h3>
            <p><?php echo __("Nothing motivates us more than feedback, are you are enjoying Griddist? We would love to hear what you think!", "griddist"); ?></p>
            <p><a target="blank" href="<?php echo esc_url('https://wordpress.org/support/theme/griddist/reviews/?filter=5', 'griddist'); ?>" class="button button-primary">
              <?php echo __("Submit A Review", "griddist"); ?>
            </a></p>
          </div>
        </div>
        <div class="col">
          <div class="widgets-holder-wrap">
            <h3><?php echo __("Premium Edition", "griddist"); ?></h3>
            <p><?php echo __("If you enjoy Griddist and want to take your website to the next step, then check out our premium edition here.", "griddist"); ?></p>
            <p><a target="blank" href="<?php echo esc_url('https://superbthemes.com/griddist/', 'griddist'); ?>" class="button button-primary">
              <?php echo __("Read More", "griddist"); ?>
            </a></p>
          </div>
        </div>
      </div>
    </div>
    <hr>

    <h2><?php echo __("Free Vs Premium","griddist"); ?></h2>
    <div class="griddist-button-container">
      <a target="blank" href="<?php echo esc_url('https://superbthemes.com/griddist/', 'griddist'); ?>" class="button button-primary">
        <?php echo __("Read Full Description", "griddist"); ?>
      </a>
      <a target="blank" href="<?php echo esc_url('https://superbthemes.com/demo/griddist/', 'griddist'); ?>" class="button button-primary">
        <?php echo __("View Theme Demo", "griddist"); ?>
      </a>
    </div>


    <table class="wp-list-table widefat">
      <thead>
        <tr>
          <th><strong><?php echo __("Theme Feature", "griddist"); ?></strong></th>
          <th><strong><?php echo __("Basic Version", "griddist"); ?></strong></th>
          <th><strong><?php echo __("Premium Version", "griddist"); ?></strong></th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td><?php echo __("Custom Background Color	  ", "griddist"); ?></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Navigation Site Title & Tagline ", "griddist"); ?></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Site Title Logo Color", "griddist"); ?></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Logo	", "griddist"); ?></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Sidebar Colors", "griddist"); ?></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Header Image", "griddist"); ?></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("3 Footer Widgets", "griddist"); ?></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Sidebar Widgets", "griddist"); ?></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Premium Support", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Easy Google Fonts", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Fully SEO Optimized", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>

        <tr>
          <td><?php echo __("Only Show Header Image On Front Page	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Extended Recent Posts	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Reveal Buttons	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Reveal Buttons	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Disable Related Posts	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Show Author, Categories, Comments, Edit link & date on Post Feed	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Show Author, Categories, Comments, Edit link & date on Posts	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Footer Copyright Text	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Retina Logo	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Posts Colors	  ", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Sidebar Colors	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Blog Feed Colors	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Page Colors	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Footer Colors	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr>
        <tr>
          <td><?php echo __("Custom Post & Page Colors	", "griddist"); ?></td>
          <td><span class="cross"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/cross.png' ); ?>" alt="<?php echo __("No", "griddist"); ?>" /></span></td>
          <td><span class="checkmark"><img height="24" width="24" src="<?php echo esc_url( get_template_directory_uri() . '/icons/check.png' ); ?>" alt="<?php echo __("Yes", "griddist"); ?>" /></span></td>
        </tr> 
      </tbody>
    </table>

  </div>
  <?php
}
