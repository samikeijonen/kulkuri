<?php
/**
 * Kulkuri functions and definitions
 *
 * @package Kulkuri
 */
 
/**
 * The current version of the theme.
 */
define( 'KULKURI_VERSION', '1.0.0' );

if ( ! function_exists( 'kulkuri_is_wpcom' ) ) :
/**
 * Whether or not the current environment is WordPress.com.
 *
 * @since  1.0.0.
 *
 * @return bool Whether or not the current environment is WordPress.com.
 */
function kulkuri_is_wpcom() {
	return ( defined( 'IS_WPCOM' ) && true === IS_WPCOM );
}
endif;

/**
 * The suffix to use for scripts.
 */
if ( ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) || kulkuri_is_wpcom() ) {
	define( 'KULKURI_SUFFIX', '' );
} else {
	define( 'KULKURI_SUFFIX', '.min' );
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

if ( ! function_exists( 'kulkuri_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kulkuri_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Kulkuri, use a find and replace
	 * to change 'kulkuri' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'kulkuri', get_template_directory() . '/languages' );

	/* Add default posts and comments RSS feed links to head. */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/* This theme uses wp_nav_menu() in 3 locations. */
	register_nav_menus( array(
		'primary'     => __( 'Front Page Menu', 'kulkuri' ),
		'not-primary' => __( 'Not Front Page Menu', 'kulkuri' ),
		'social'      => __( 'Social Menu', 'kulkuri' )
	) );

	/* Enable support for HTML5 markup. */
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	) );
	
	/* Enable infinite scroll. */
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'main',
		'footer'         => 'home',
		'footer_widgets' => 'subsidiary'
	) );
	
	/* Add Editor styles. */
	add_editor_style( kulkuri_get_editor_styles() );
	
	/* Add excerpt support for pages. */
	add_post_type_support( 'page', 'excerpt' );
	
}
endif; // kulkuri_setup
add_action( 'after_setup_theme', 'kulkuri_setup' );

/**
 *  Adds custom image sizes for thumbnail images.
 * 
 * @since 1.0.0
 */
function kulkuri_add_image_sizes() {

	add_image_size( 'kulkuri-thumbnail', 980, 551, true );

}
add_action( 'init', 'kulkuri_add_image_sizes' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function kulkuri_widgets_init() {
	
	$sidebar_subsidiary_args = array(
		'id'            => 'subsidiary',
		'name'          => _x( 'Subsidiary', 'sidebar', 'kulkuri' ),
		'description'   => __( 'A sidebar located in the footer of the site.', 'kulkuri' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	);
	
	/* Register sidebars. */
	register_sidebar( $sidebar_subsidiary_args );
	
}
add_action( 'widgets_init', 'kulkuri_widgets_init' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
function kulkuri_scripts() {

	/* Enqueue styles. */
	wp_enqueue_style( 'kulkuri-style', get_stylesheet_uri(), array(), KULKURI_VERSION );
		
	/* Enqueue responsive fixed navigation. */
	wp_enqueue_script( 'kulkuri-navigation', trailingslashit( get_template_directory_uri() ) . 'js/fixed-nav/responsive-nav' . KULKURI_SUFFIX . '.js', array(), KULKURI_VERSION, false );
	
	/* Enqueue responsive navigation settings for other than front page. */
	if( ! is_page_template( 'pages/front-page.php' ) ) {
		wp_enqueue_script( 'kulkuri-navigation-settings', trailingslashit( get_template_directory_uri() ) . 'js/fixed-nav/responsive-nav-settings' . KULKURI_SUFFIX . '.js', array( 'kulkuri-navigation' ), KULKURI_VERSION, true );
		
		wp_localize_script( 'kulkuri-navigation-settings', 'kulkuri_script_vars_2', array(
		'menu_2' => __( 'Menu', 'kulkuri' )
			)
		);
	}
	
	/* And all the files we need with responsive fixed navigation. */
	if( is_page_template( 'pages/front-page.php' ) ) {
		wp_enqueue_script( 'kulkuri-navigation-fastclick', trailingslashit( get_template_directory_uri() ) . 'js/fixed-nav/fastclick' . KULKURI_SUFFIX . '.js', array( 'kulkuri-navigation' ), KULKURI_VERSION, true );
		wp_enqueue_script( 'kulkuri-navigation-scroll', trailingslashit( get_template_directory_uri() ) . 'js/fixed-nav/scroll' . KULKURI_SUFFIX . '.js', array( 'kulkuri-navigation' ), KULKURI_VERSION, true );
		wp_enqueue_script( 'kulkuri-navigation-fixed', trailingslashit( get_template_directory_uri() ) . 'js/fixed-nav/fixed-responsive-nav' . KULKURI_SUFFIX . '.js', array( 'kulkuri-navigation', 'kulkuri-navigation-fastclick', 'kulkuri-navigation-scroll' ), KULKURI_VERSION, true );
	
		/* Menu label text for both files. */
		wp_localize_script( 'kulkuri-navigation-fixed', 'kulkuri_script_vars_1', array(
		'menu_1' => __( 'Menu', 'kulkuri' )
			) 
		);
	}
	
	/* Enqueue Fitvids. */
	wp_enqueue_script( 'kulkuri-fitvids', trailingslashit( get_template_directory_uri() ) . 'js/fitvids/fitvids' . KULKURI_SUFFIX . '.js', array( 'jquery' ), KULKURI_VERSION, false );
	
	/* Fitvids settings. */
	wp_enqueue_script( 'kulkuri-fitvids-settings', trailingslashit( get_template_directory_uri() ) . 'js/fitvids/settings' . KULKURI_SUFFIX . '.js', array( 'kulkuri-fitvids' ), KULKURI_VERSION, true );
		
	/* Enqueue skip link fix. */
	wp_enqueue_script( 'kulkuri-skip-link-focus-fix', trailingslashit( get_template_directory_uri() ) . 'js/skip-link-focus-fix' . KULKURI_SUFFIX . '.js', array(), KULKURI_VERSION, true );
	
	/* Enqueue fonts. */
	wp_enqueue_style( 'kulkuri-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' );
	
	/* Add Genericons font, used in the main stylesheet. */
	wp_enqueue_style( 'genericons', trailingslashit( get_template_directory_uri() ) . 'fonts/genericons/genericons' . KULKURI_SUFFIX . '.css', array(), '3.0.3' );
	
	/* Enqueue comment reply. */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kulkuri_scripts' );

/**
 * Filter menu href attributes for page scrolling in primary menu.
 *
 * @since 1.0.0
 * @return array $atts
 */
function kulkuri_nav_menu_link_attributes( $atts, $item, $args ) {
	
	if( 'post_type' == $item->type && 'page' == $item->object && 'primary' == $args->theme_location ) {
		$kulkuri_page_slug = get_post( $item->object_id );
		$atts['href'] = '#' . $kulkuri_page_slug->post_name;
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'kulkuri_nav_menu_link_attributes', 100, 3 );

/**
 * Add data-scroll to primary menu anchor so that scroll is working.
 *
 * @since 1.0.0
 * @return string modified menu
 */
function kulkuri_menu_data_scroll( $menu, $args ) {
	if( 'primary' == $args->theme_location ) {
		$menu = str_replace( 'href=', 'data-scroll href=', $menu );
	}
	return $menu;
}
add_filter( 'wp_nav_menu_items','kulkuri_menu_data_scroll', 10, 2 );

/**
 * Counts widgets number in subsidiary sidebar and ads css class (.sidebar-subsidiary-$number) to body_class.
 * Used to increase / decrease widget size according to number of widgets.
 * Example:   if there's one widget in subsidiary sidebar - widget width is 100%, if two widgets, 50% each...
 * @author    Sinisa Nikolic
 * @copyright Copyright (c) 2012
 * @link      http://themehybrid.com/themes/sukelius-magazine
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since     1.0.0
 */
function kulkuri_subsidiary_classes( $classes ) {
    
	if ( is_active_sidebar( 'subsidiary' ) ) {
		
		$the_sidebars = wp_get_sidebars_widgets();
		$num = count( $the_sidebars['subsidiary'] );
		$classes[] = 'sidebar-subsidiary-' . $num;
		
    }
    
    return $classes;
	
}
add_filter( 'body_class', 'kulkuri_subsidiary_classes' );

/**
 * Add boxed-layout class and header image class.
 *
 * @since     1.0.0
 */
function kulkuri_extra_layout_classes( $classes ) {
    
	/* Add 'boxed-layout' if boxed layout is chosen in theme customizer. */
	if ( get_theme_mod( 'layout_boxed' ) ) {
		$classes[] = 'boxed-layout';	
    }
	
	/* Add the '.custom-header-image' class if the user is using a custom header image. */
	if ( get_header_image() ) {
		$classes[] = 'custom-header-image';
	}
    
    return $classes;
	
}
add_filter( 'body_class', 'kulkuri_extra_layout_classes' );

/*
 * Use link for all post thumbnail.
 *
 * @since  1.0.0
 * @return html.
 */
function kulkuri_post_image_html( $html, $post_id, $post_image_id ) {

	$html = '<a href="' . esc_url( get_permalink( $post_id ) ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
	return $html;

}
add_filter( 'post_thumbnail_html', 'kulkuri_post_image_html', 10, 3 );

/*
 * Add Footer info.
 *
 * @since  1.0.0
 * @return html.
 */
function kulkuri_footer_info() { ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'kulkuri' ) ); ?>" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'kulkuri' ); ?>"><?php printf( __( 'Proudly powered by %s', 'kulkuri' ), 'WordPress' ); ?></a>
			<span class="sep"> <?php esc_attr_e( '&middot;', 'kulkuri' ); ?></span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'kulkuri' ), 'kulkuri', '<a href="https://foxnet-themes.fi" rel="designer">Foxnet Themes</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon --> <?php
	
}
add_action( 'wp_footer', 'kulkuri_footer_info' );

/**
 * Callback function for adding editor styles. Use along with the add_editor_style() function.
 *
 * @author  Justin Tadlock, justintadlock.com
 * @link    http://themehybrid.com/themes/stargazer
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since   1.0.0
 * @return  array
 */
function kulkuri_get_editor_styles() {

	/* Set up an array for the styles. */
	$editor_styles = array();
	
	/* Add Genericons styles. */
	$editor_styles[] = 'fonts/genericons/genericons.css';

	/* Add the theme's editor styles. */
	$editor_styles[] = trailingslashit( get_template_directory_uri() ) . 'css/editor-style.css';

	/* If a child theme, add its editor styles. Note: WP checks whether the file exists before using it. */
	if ( is_child_theme() && file_exists( trailingslashit( get_stylesheet_directory() ) . 'css/editor-style.css' ) ) {
		$editor_styles[] = trailingslashit( get_stylesheet_directory_uri() ) . 'css/editor-style.css';
	}

	/* Add the locale stylesheet. */
	$editor_styles[] = get_locale_stylesheet_uri();

	/* Return the styles. */
	return $editor_styles;
}

/**
* Callout text and link in front page template.
*
* @since  1.0.0
*/
function kulkuri_callout_output() {

	/* Output callout link and text on front page template. */
	if ( get_theme_mod( 'callout_url' ) && get_theme_mod( 'callout_url_text' ) ) {
		echo '<div id="kulkuri-callout-url"><a class="kulkuri-callout-button" href="' . esc_url( get_theme_mod( 'callout_url' ) ) . '">' . esc_textarea( get_theme_mod( 'callout_url_text' ) ) . '</a></div>';
	}
	
}

/**
 * Get all posts id from wanted menu.
 *
 * @author  Tom McFarlin, http://tommcfarlin.com/
 * @link    http://tommcfarlin.com/tabbed-navigation-in-wordpress
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @since   1.0.0
*/
function kulkuri_get_posts_for_menu( $menu_name ) {

	/* Read all of the navigation menu locations */
	$locations = get_nav_menu_locations();

	/* Grab the specific menu identified by the specified menu name. */
	$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	$menu_items = wp_get_nav_menu_items( $menu->term_id );

	/* Grab all of the post IDs that are represented in this menu. */
	$post_ids = array();
	
	foreach( $menu_items as $post ) {
		$post_ids[] = $post->object_id;
	}

	return $post_ids;

}

/**
 * Flush out the transients used in front page WP Queries.
 *
 * @since   1.0.0
 */
function kulkuri_transient_flusher() {
	delete_transient( 'kulkuri_section_query' );
	delete_transient( 'kulkuri_posts' );
}
add_action( 'wp_update_nav_menu', 'kulkuri_transient_flusher' );
add_action( 'save_post', 'kulkuri_transient_flusher' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Implement the Custom Background feature.
 */
require get_template_directory() . '/inc/custom-background.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Theme updater.
 */
if ( is_admin() && !kulkuri_is_wpcom() ) {
	require get_template_directory() . '/admin/functions-admin.php';
}
