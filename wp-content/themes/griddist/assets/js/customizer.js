/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

 ( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );


	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );




	wp.customize( 'footer_bg_color', function( value ) {
		value.bind( function( to ) {
			$( '#site-footer' ).css( {
				'background-color':to
			});
		} );
	} );


	wp.customize( 'footer_headline_color', function( value ) {
		value.bind( function( to ) {
			$( '#site-footer h3' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'footer_text_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-info, #site-footer .widget, #site-footer .widget li, #site-footer .widget p, #site-footer abbr, #site-footer cite, #site-footer table caption, #site-footer td, #site-footer th' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'footer_link_color', function( value ) {
		value.bind( function( to ) {
			$( '#site-footer .widget a' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'footer_border_color', function( value ) {
		value.bind( function( to ) {
			$( '#site-footer .widget *' ).css( {
				'border-color':to
			});
		} );
	} );



	wp.customize( 'blogfeed_background', function( value ) {
		value.bind( function( to ) {
			$( '.archive-header-desktop .preview-wrapper, .preview-wrapper' ).css( {
				'background':to
			});
		} );
	} );



	wp.customize( 'blogfeed_headline', function( value ) {
		value.bind( function( to ) {
			$( '.archive-header-inner h3, .preview-title' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'blogfeed_text', function( value ) {
		value.bind( function( to ) {
			$( '.archive-header .subheading, .preview-inner p, .post-meta-preview .post-meta' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'blogfeed_button_bg', function( value ) {
		value.bind( function( to ) {
			$( 'button#load-more' ).css( {
				'background':to
			});
		} );
	} );



	wp.customize( 'blogfeed_button_text', function( value ) {
		value.bind( function( to ) {
			$( '.link-pagination a, button#load-more' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'sidebar_tagline_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'sidebar_link_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-nav li, #site-header a' ).css( {
				'color':to
			});
		} );
	} );


	wp.customize( 'sidebar_headline_color', function( value ) {
		value.bind( function( to ) {
			$( '.sidebar-widgets .widget-title' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'sidebar_text_color', function( value ) {
		value.bind( function( to ) {
			$( '#site-header, #site-header .widget, #site-header .widget li, #site-header .widget p, #site-header abbr, #site-header cite, #site-header table caption, #site-header td, #site-header th' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'sidebar_bg_color', function( value ) {
		value.bind( function( to ) {
			$( '#site-header' ).css( {
				'background':to
			});
		} );
	} );



	wp.customize( 'page_background', function( value ) {
		value.bind( function( to ) {
			$( '.error404 .single-container, .page .single-container' ).css( {
				'background':to
			});
		} );
	} );



	wp.customize( 'page_headline', function( value ) {
		value.bind( function( to ) {
			$( '.error404 #site-content h1, .page #site-content h1, .page .entry-content h1, .page .entry-content h2, .page .entry-content h3, .page .entry-content h4, .page .entry-content h5, .page .entry-content h6, .page .entry-content th' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'page_text', function( value ) {
		value.bind( function( to ) {
			$( '.error404 #site-content p, .page .entry-content, .page .entry-content  li, .page .entry-content  p, .page .entry-content  abbr, .page .entry-content  cite, .page .entry-content  table caption, .page .entry-content td' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'page_link', function( value ) {
		value.bind( function( to ) {
			$( '.error404 .go-home, .error404 .entry-content a, .page .entry-content a' ).css( {
				'color':to
			});
		} );
	} );



	wp.customize( 'page_text', function( value ) {
		value.bind( function( to ) {
			$( '.error404 .entry-content blockquote, .page .entry-content blockquote' ).css( {
				'border-color':to
			});
		} );
	} );



	wp.customize( 'posts_background', function( value ) {
		value.bind( function( to ) {
			$( '.single .single-container' ).css( {
				'background':to
			});
		} );
	} );



	wp.customize( 'posts_headline', function( value ) {
		value.bind( function( to ) {
			$( '.single .related-posts-title, .single .single-container th,.single .single-container h1, .single .single-container h2, .single .single-container h3, .single .single-container h4, .single .single-container h5, .single .single-container h6' ).css( {
				'color':to
			});
		} );
	} );
	wp.customize( 'posts_text', function( value ) {
		value.bind( function( to ) {
			$( '.comment-metadata .edit-link::before, .single .comments-wrapper label, .single .entry-content label, .single .comment-form p.logged-in-as, .single .post-meta-single .post-meta, .single .entry-content figcaption, .single .entry-content, .single .entry-content  li, .single .entry-content  p, .single .entry-content  abbr, .single .entry-content  cite, .single .entry-content  table caption, .single .entry-content  td, .single .entry-content th' ).css( {
				'color':to
			});
		} );
	} );
		wp.customize( 'posts_link', function( value ) {
		value.bind( function( to ) {
			$( '.single .entry-content a, .single .comments-wrapper a' ).css( {
				'color':to
			});
		} );
	} );
			wp.customize( 'posts_text', function( value ) {
		value.bind( function( to ) {
			$( '.single .entry-content blockquote' ).css( {
				'color':to
			});
		} );
	} );
	
	
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.the-header-title' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.the-header-title' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.the-header-title' ).css( {
					'color': to
				} );
			}
		} );
	} );
} )( jQuery );
