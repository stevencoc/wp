<?php 

/* ---------------------------------------------------------------------------------------------
   	CUSTOM CUSTOMIZER CONTROLS
   	--------------------------------------------------------------------------------------------- */


   	if ( class_exists( 'WP_Customize_Control' ) ) :

   		if ( ! class_exists( 'griddist_Customize_Control_Checkbox_Multiple' ) ) :

		// Custom Customizer control that outputs a specified number of checkboxes
		// Based on a solution by Justin Tadlock: http://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
   			class griddist_Customize_Control_Checkbox_Multiple extends WP_Customize_Control {

   				public $type = 'checkbox-multiple';

   				public function render_content() {

   					if ( empty( $this->choices ) ) :
   						return;
   					endif;

   					if ( ! empty( $this->label ) ) : ?>
   					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
   					<?php endif;

   					if ( ! empty( $this->description ) ) : ?>
   					<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
   					<?php endif;

   					$multi_values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

   					<ul>
   						<?php foreach ( $this->choices as $value => $label ) : ?>

   						<li>
   							<label>
   								<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> />
   								<?php echo esc_html( $label ); ?>
   							</label>
   						</li>

   					<?php endforeach; ?>
   				</ul>

   				<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
   				<?php
   			}
   		}

   		endif;

   		endif;


/* ---------------------------------------------------------------------------------------------
   CUSTOMIZER SETTINGS
   --------------------------------------------------------------------------------------------- */


   if ( ! class_exists( 'griddist_Customize' ) ) :

   	class griddist_Customize {

   		public static function griddist_register( $wp_customize ) {
   			$wp_customize->get_section('colors')->title = __( 'Background Color', 'griddist' );




				/* ------------------------------------
			 * Sidebar Settings
			 * ------------------------------------ */



				$wp_customize->add_section( 'sidebar_settings', array(
					'title'      => __('Sidebar Settings','griddist'),
					'priority'   => 2,
					'capability' => 'edit_theme_options',
					) );

				$wp_customize->add_setting( 'sidebar_bg_color', array(
					'default'           => '#fff',
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
					) );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_bg_color', array(
					'label'       => __( 'Background Color', 'griddist' ),
					'section'     => 'sidebar_settings',
					'priority'   => 1,
					'settings'    => 'sidebar_bg_color',
					) ) );


				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_textcolor', array(
					'label'       => __( 'Site Title Color', 'griddist' ),
					'section'     => 'sidebar_settings',
					'priority'   => 1,
					'settings'    => 'header_textcolor',
					) ) );




				$wp_customize->add_setting( 'sidebar_tagline_color', array(
					'default'           => '#afafaf',
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
					) );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_tagline_color', array(
					'label'       => __( 'Site Tagline Color', 'griddist' ),
					'section'     => 'sidebar_settings',
					'priority'   => 1,
					'settings'    => 'sidebar_tagline_color',
					) ) );

				$wp_customize->add_setting( 'sidebar_link_color', array(
					'default'           => '#888888',
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
					) );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_link_color', array(
					'label'       => __( 'Link Color', 'griddist' ),
					'section'     => 'sidebar_settings',
					'priority'   => 1,
					'settings'    => 'sidebar_link_color',
					) ) );

				$wp_customize->add_setting( 'sidebar_headline_color', array(
					'default'           => '#333',
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
					) );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_headline_color', array(
					'label'       => __( 'Headline Color', 'griddist' ),
					'section'     => 'sidebar_settings',
					'priority'   => 1,
					'settings'    => 'sidebar_headline_color',
					) ) );

				$wp_customize->add_setting( 'sidebar_text_color', array(
					'default'           => '#4B555F',
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
					) );
				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar_text_color', array(
					'label'       => __( 'Text Color', 'griddist' ),
					'section'     => 'sidebar_settings',
					'priority'   => 1,
					'settings'    => 'sidebar_text_color',
					) ) );

			}

		// Initiate the customize controls js
			public static function griddist_customize_controls() {
				wp_enqueue_script( 'griddist-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.js', array( 'jquery', 'customize-controls' ), '', true );
			}

		}

	// Setup the Theme Customizer settings and controls
		add_action( 'customize_register', array( 'griddist_Customize', 'griddist_register' ) );

		endif;



		if(! function_exists('griddist_customizer_input' ) ):
			function griddist_customizer_input(){
				?>

				<style type="text/css">

				.site-description{ color: <?php echo esc_attr(get_theme_mod( 'sidebar_tagline_color')); ?>; }
				.site-nav li{ color: <?php echo esc_attr(get_theme_mod( 'sidebar_link_color')); ?>; }
				.sidebar-widgets .widget-title{ color: <?php echo esc_attr(get_theme_mod( 'sidebar_headline_color')); ?>; }
				#site-header, #site-header .widget, #site-header .widget li, #site-header .widget p, #site-header abbr, #site-header cite, #site-header table caption, #site-header td, #site-header th{ color: <?php echo esc_attr(get_theme_mod( 'sidebar_text_color')); ?>; }
				#site-header{ background: <?php echo esc_attr(get_theme_mod( 'sidebar_bg_color')); ?>; }

				</style>
				<?php }
				add_action( 'wp_head', 'griddist_customizer_input' );
				endif;


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function griddist_customize_preview_js() {
	wp_enqueue_script( 'griddist-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'griddist_customize_preview_js' );
