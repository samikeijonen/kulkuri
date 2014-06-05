<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'not-primary' )  ) { 

	/* Decide which menu to use. */
	if( is_page_template( 'pages/front-page.php' ) ) :
		$kulkuri_menu_args = array (	
			'theme_location'  => 'primary',
			'menu_id'         => 'menu-primary-items',
			'depth'           => 1,
			'menu_class'      => 'menu-items',
			'fallback_cb'     => '',
			//'walker'          => new kulkuri_walker()
		);
	else :
		$kulkuri_menu_args = array (	
			'theme_location'  => 'not-primary',
			'menu_id'         => 'menu-primary-items',
			'depth'           => 1,
			'menu_class'      => 'menu-items',
			'fallback_cb'     => ''
		);
	endif;

	?>
	
	<div id="menu-primary-wrapper" class="menu-primary-wrapper">
		<nav id="menu-primary" class="menu main-navigation nav-collapse" role="navigation">	
			<div class="wrap">
			
				<?php wp_nav_menu( $kulkuri_menu_args ); ?>
		
			</div><!-- .wrap -->
		</nav><!-- #menu-primary -->
	</div><!-- #menu-primary-wrapper -->

<?php } ?>