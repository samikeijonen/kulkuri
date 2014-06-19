<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'not-primary' )  ) : 

	/* Decide which menu to use. */
	if( is_page_template( 'pages/front-page.php' ) ) :
		$kulkuri_location = 'primary';
	else :
		$kulkuri_location = 'not-primary';
	endif;

	?>
	
	<div id="menu-primary-wrapper" class="menu-primary-wrapper">
		<nav id="menu-primary" class="menu main-navigation nav-collapse" role="navigation">	
			<div class="wrap">
			
				<?php
				wp_nav_menu( array (	
						'theme_location'  => $kulkuri_location,
						'menu_id'         => 'menu-primary-items',
						'depth'           => 1,
						'menu_class'      => 'menu-items',
						'fallback_cb'     => ''
				) );
				?>
		
			</div><!-- .wrap -->
		</nav><!-- #menu-primary -->
	</div><!-- #menu-primary-wrapper -->

<?php endif; // End check for menu. ?>