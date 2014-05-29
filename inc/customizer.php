<?php
/**
 * Kulkuri Theme Customizer
 *
 * @package Kulkuri
 */
 
/**
 * Sets up the theme customizer sections, controls, and settings.
 * 
 * Note! In all settings default 'type' => 'theme_mod' and 'capability' => 'edit_theme_options'. Those can be removed in the code.
 *
 * @since  1.0.0
 * @return void
 */
function kulkuri_customize_register_settings( $wp_customize ) {

	/* === Theme section === */

	/* Add the theme section. */
	$wp_customize->add_section(
		'theme',
		array(
			'title'      => esc_html__( 'Theme', 'kulkuri' ),
			'priority'   => 10
		)
	);
	
	/* === Layout === */
	
	/* Add boxed layout setting. */
	$wp_customize->add_setting(
		'layout_boxed',
		array(
			'default'           => '',
			'sanitize_callback' => 'kulkuri_sanitize_checkbox'
		)
	);
	
	/* Add boxed layout control. */
	$wp_customize->add_control(
		'layout-boxed',
		array(
			'label'    => esc_html__( 'Use boxed layout in all pages.', 'kulkuri' ),
			'section'  => 'theme',
			'settings' => 'layout_boxed',
			'priority' => 1,
			'type'     => 'checkbox'
		)
	);
	
	/* === Front page settings. === */
	
	/* Add the callout link setting. */
	$wp_customize->add_setting(
		'callout_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw'
 		)
 	);
 	
 	/* Add the callout link control. */
 	$wp_customize->add_control(
 		'callout-url',
 		array(
 			'label'    => esc_html__( 'Callout URL', 'kulkuri' ),
 			'section'  => 'theme',
 			'settings' => 'callout_url',
 			'priority' => 3,
 			'type'     => 'text'
 		)
 	);
 	
 	/* Add the callout url text setting. */
 	$wp_customize->add_setting(
 		'callout_url_text',
 		array(
 			'default'           => '',
 			'sanitize_callback' => 'sanitize_text_field'
 		)
 	);
 	
 	/* Add the callout url text control. */
 	$wp_customize->add_control(
 		'callout-url-text',
 		array(
 			'label'    => esc_html__( 'Callout URL text', 'kulkuri' ),
 			'section'  => 'theme',
 			'settings' => 'callout_url_text',
 			'priority' => 4,
			'type'     => 'text'
 		)
	);
	
	/* Loop same setting couple of times. */
	$k = 1;
	
	while( $k < absint( apply_filters( 'kulkuri_how_many_pages', 7 ) ) ) {
	
		/* Add the 'front_page_*' setting. */
		$wp_customize->add_setting(
			'front_page_' . $k,
			array(
				'default'           => 0,
				'sanitize_callback' => 'absint'
			)
		);
	
		/* Add front page control. */
		$wp_customize->add_control(
			'front-page-control-' . $k,
				array(
					/* Translators: %s stands for number. For example Select page 1. */
					'label'    => sprintf( esc_html__( 'Select page %s', 'kulkuri' ), $k ),
					'section'  => 'theme',
					'settings' => 'front_page_' . $k,
					'type'     => 'dropdown-pages',
					'priority' => $k*10
				) 
			);
			
		/* Add the 'background_color' setting. */
		$wp_customize->add_setting(
			'background_color_' . $k,
			array(
				'default'           => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);
	
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'background-color-control-' . $k,
					array(
						'label'     => sprintf( esc_html__( 'Background color %s', 'kulkuri' ), $k ),
						'section'   => 'theme',
						'settings'  => 'background_color_' . $k,
						'priority'  => $k*10+1
				)
			)
		);
		
		/* Add the 'background_image' setting. */
		$wp_customize->add_setting(
			'background_image_' . $k,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw'
			)
		);
	
		/* Add custom logo control. */
		$wp_customize->add_control(
			new KULKURI_Customize_Image_Control(
				$wp_customize, 'background-image-control-' . $k,
					array(
						'label'    => sprintf( esc_html__( 'Background image %s', 'kulkuri' ), $k ),
						'section'  => 'theme',
						'settings'  => 'background_image_' . $k,
						'priority'  => $k*10+2
				) 
			) 
		);
		
		$k++; // Add one before loop ends.
		
	}
	
	/* Add the show latest posts setting. */
	$wp_customize->add_setting(
		'show_latest_posts',
		array(
			'default'           => '',
			'sanitize_callback' => 'kulkuri_sanitize_checkbox'
		)
	);
	
	/* Add the show latest posts control. */
	$wp_customize->add_control(
		'show-latest-posts',
		array(
			'label'    => esc_html__( 'Show latest posts on front page', 'kulkuri' ),
			'section'  => 'theme',
			'settings' => 'show_latest_posts',
			'priority' => 150,
			'type'     => 'checkbox'
		)
	);
	
	/* Show option for testimonial if post type exist. */
	if ( post_type_exists( 'jetpack-testimonial' ) || post_type_exists( 'testimonial' ) ) {
		
		/* Add the show latest testimonials setting. */
		$wp_customize->add_setting(
			'show_latest_testimonials',
			array(
				'default'           => '',
				'sanitize_callback' => 'kulkuri_sanitize_checkbox'
			)
		);
	
		/* Add the show random testimonials control. */
		$wp_customize->add_control(
			'show-latest-testimonials',
			array(
				'label'    => esc_html__( 'Show random testimonials on front page', 'kulkuri' ),
				'section'  => 'theme',
				'settings' => 'show_latest_testimonials',
				'priority' => 170,
				'type'     => 'checkbox'
			)
		);
	}
	
	/* === Logo upload. === */
	
	/* Add the 'logo' setting. */
	$wp_customize->add_setting(
		'logo_upload',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw'
		)
	);
	
	/* Add custom logo control. */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'logo_image',
				array(
					'label'    => esc_html__( 'Upload custom logo.', 'kulkuri' ),
					'section'  => 'theme',
					'settings' => 'logo_upload',
					'priority' => 190,
			) 
		) 
	);

}
add_action( 'customize_register', 'kulkuri_customize_register_settings' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function kulkuri_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'kulkuri_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function kulkuri_customize_preview_js() {
	wp_enqueue_script( 'kulkuri_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'kulkuri_customize_preview_js' );

/**
 * Sanitize the checkbox value.
 *
 * @since 1.0.0
 *
 * @param string $input checkbox.
 * @return string (1 or null).
 */
function kulkuri_sanitize_checkbox( $input ) {

	if ( 1 == $input ) {
		return 1;
	} else {
		return '';
	}

}

if ( class_exists( 'WP_Customize_Image_Control' ) && ! class_exists( 'KULKURI_Customize_Image_Control' ) ) :
/**
 * Class KULKURI_Customize_Image_Control
 *
 * Extend WP_Customize_Image_Control allowing access to uploads made within the same context.
 *
 * @since 1.0.0.
 */
class KULKURI_Customize_Image_Control extends WP_Customize_Image_Control {
	/**
	 * Override the stock tab_uploaded function.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function tab_uploaded() {
		$images = get_posts( array(
			'post_type'  => 'attachment',
			'meta_key'   => '_wp_attachment_context',
			'meta_value' => $this->context,
			'orderby'    => 'none',
			'nopaging'   => true,
		) );

		?><div class="uploaded-target"></div><?php

		if ( empty( $images ) ) {
			return;
		}

		foreach ( (array) $images as $image ) {
			$thumbnail_url = wp_get_attachment_image_src( $image->ID, 'medium' );
			$this->print_tab_image( esc_url_raw( $image->guid ), esc_url_raw( $thumbnail_url[0] ) );
		}
	}
}
endif;
