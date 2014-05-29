<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Kulkuri
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="home" class="hfeed site">

	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'kulkuri' ); ?></a>
	
	<?php get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php template. ?>

	<header id="masthead" class="site-header" role="banner">
		<?php if ( display_header_text() ) : // If user chooses to display header text. ?>
			<div class="site-branding">
			
			<?php if ( get_theme_mod( 'logo_upload') ) { // Use logo if is set. Else use bloginfo name. ?>	
				<h1 id="site-title">
					<a href="<?php echo esc_url( home_url() ); ?>" rel="home">
						<img class="kulkuri-logo logo" src="<?php echo esc_url( get_theme_mod( 'logo_upload' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
					</a>
				</h1>
				<?php } else { ?>
				<h1 id="site-title" class="site-title logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php } ?>
				
				<h2 id="site-description" class="site-description"><?php bloginfo( 'description' ); ?></h2>
				
				<?php kulkuri_callout_output(); // Callout text and link on front page template.
				
				get_template_part( 'menu', 'social' ); // Loads the menu-social.php template. ?>
				
			</div>
		<?php endif; // End check for header text. ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="wrap">
