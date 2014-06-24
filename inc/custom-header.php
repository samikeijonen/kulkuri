<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 *
 * @package Kulkuri
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses kulkuri_header_style()
 * @uses kulkuri_admin_header_style()
 * @uses kulkuri_admin_header_image()
 */
function kulkuri_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'kulkuri_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '89c264',
		'width'                  => 1920,
		'height'                 => 600,
		'flex-width'             => true,
		'flex-height'            => true,
		'wp-head-callback'       => 'kulkuri_header_style',
		'admin-head-callback'    => 'kulkuri_admin_header_style',
		'admin-preview-callback' => 'kulkuri_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'kulkuri_custom_header_setup', 15 );

if ( ! function_exists( 'kulkuri_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see kulkuri_custom_header_setup().
 */
function kulkuri_header_style() {

	/* Get header text color. And get out if it's not set. */
	$hex = get_header_textcolor();

	if ( empty( $hex ) ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	
	/* Header image. */
	$header_image = esc_url( get_header_image() );
	
	/* Header image height. */
	$header_height = get_custom_header()->height;
	
	/* Header image height minus 300px. */
	$header_height_smaller = $header_height-absint( apply_filters( 'kulkuri_header_height_smaller', 300 ) );
	
	/* Header image width. */
	$header_width = get_custom_header()->width;
	
	/* When to show header image. */
	$min_width = absint( apply_filters( 'kulkuri_header_bg_show', 1 ) );
	
	/* When to show bigger header image. */
	$min_width_bigger = absint( apply_filters( 'kulkuri_header_bigger', 800 ) );
	
	/* Background arguments. */
	$background_arguments = esc_attr( apply_filters( 'kulkuri_header_bg_arguments', 'no-repeat scroll top' ) );
	
	/* Styles for header. */
	$style = "#masthead, #site-title a, #site-description, body #menu-social li a::before { color: #{$hex}; }";
		
	if ( get_header_image() ) {
		$style .= "@media screen and (min-width: {$min_width}px) { #masthead { background: url({$header_image}) {$background_arguments}; background-size: cover; min-height: {$header_height_smaller}px; } }";
		$style .= "@media screen and (min-width: {$min_width_bigger}px) { #masthead { min-height: {$header_height}px; } }";
	}
	
	echo "\n" . '<style type="text/css" id="custom-header-css">' . trim( $style ) . '</style>' . "\n";
	
}
endif; // kulkuri_header_style

if ( ! function_exists( 'kulkuri_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see kulkuri_custom_header_setup().
 */
function kulkuri_admin_header_style() {

	/* Header image. */
	$header_image = esc_url( get_header_image() );
	
	/* Header image height. */
	$header_height = get_custom_header()->height;

	?>
	
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			background: url(<?php echo $header_image ?>);
			background-size: cover;
			border: none;
			font-size: 1.5em;
			min-height: <?php echo $header_height; ?>px;
			padding-top: 100px;
			text-align: center;
		}
		
		@media screen and (min-width: 800px) {

			.appearance_page_custom-header #headimg h1 {
				font-size: 2.5em;
			}

		}
		
		@media screen and (min-width: 1248px) {

			.appearance_page_custom-header #headimg h1 {
				font-size: 3em;
			}

		}
		
		#headimg h1 {
			text-transform: uppercase;
		}
		#headimg.custom-header-image h1 {
			text-shadow: 2px 2px 8px rgba(0, 0, 0, .8);
		}
		#headimg h1 a {
			text-decoration: none;
		}
		#desc {
			font-size: 1.25em;
			text-transform: none;
		}
		.custom-header-image #desc {
			text-shadow: 2px 2px 5px rgba(0, 0, 0, .8);
		}
	</style>
<?php
}
endif; // kulkuri_admin_header_style

if ( ! function_exists( 'kulkuri_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see kulkuri_custom_header_setup().
 */
function kulkuri_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	
	/* Header image. */
	$header_image = esc_url( get_header_image() );
	
?>
	<div id="headimg" class="headimg<?php if( $header_image ) echo ' custom-header-image'; ?>">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	</div>
<?php
}
endif; // kulkuri_admin_header_image
