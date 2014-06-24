
	<div id="menu-primary-wrapper" class="menu-primary-wrapper">
	
		<button id="nav-toggle" class="nav-toggle"><?php _e( 'Menu', 'kulkuri' ); ?></button>
		
		<nav id="menu-primary" class="menu main-navigation nav-collapse" role="navigation" aria-label="<?php _e( 'Primary Menu', 'kulkuri' ); ?>">	
			<div class="wrap">
			<?php
				if( is_page_template( 'pages/front-page.php' ) ) :
					$kulkuri_pages = get_pages( apply_filters( 'kulkuri_front_page_menu_args',
						array (
							'child_of'    => get_queried_object_id(),
							'sort_column' => 'menu_order'
						)
					) ); ?>
					
					<ul id="menu-primary-items" class="menu-items">
						<li><a data-scroll href="#home"><?php _e( 'Home', 'kulkuri' ); ?></a></li>
						<?php foreach( $kulkuri_pages as $page ) : ?>
							<li id="menu-item-<?php echo absint( $page->ID ); ?>" class="menu-item"><a data-scroll href="#<?php echo esc_attr( $page->post_name ); ?>"><?php echo esc_attr( $page->post_title ); ?></a></li>
						<?php endforeach; ?>
					</ul>
					
					<?php
				else :
					wp_nav_menu( array (	
						'theme_location' => 'primary',
						'menu_id'        => 'menu-primary-items',
						'depth'          => 1,
						'menu_class'     => 'menu-items',
						'fallback_cb'    => ''
					) );
				endif;
			?>
		
			</div><!-- .wrap -->
		</nav><!-- #menu-primary -->
	</div><!-- #menu-primary-wrapper -->