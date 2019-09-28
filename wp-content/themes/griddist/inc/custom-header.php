<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package griddist
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses griddist_header_style()
 */
function griddist_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'griddist_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'flex-height'            => true,
		'default-image'			=> '',
		'wp-head-callback'       => 'griddist_header_style',
		) ) );
}
add_action( 'after_setup_theme', 'griddist_custom_header_setup' );

if ( ! function_exists( 'griddist_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see griddist_custom_header_setup().
	 */
function griddist_header_style() {
	$header_text_color = get_header_textcolor();
	$header_image = get_header_image();
		if ( empty( $header_image ) && $header_text_color == get_theme_support( 'custom-header', 'default-text-color' ) ){
			return;
		}
		?>
		<style type="text/css">
		.site-title a {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
		<?php if ( ! display_header_text() ) : ?>
		.site-title, .site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
			display:none;
		}
		<?php endif; ?>

		<?php header_image(); ?>"
		<?php
		if ( ! display_header_text() ) :
			?>
		.site-title, .site-description{
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
			display:none;
		}
		<?php
		else :
			?>
		<?php endif; ?>
		</style>
		<?php
	}
	endif;
