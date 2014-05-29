<?php if ( is_active_sidebar( 'subsidiary' ) ) { ?>

	<aside id="sidebar-subsidiary" class="sidebar" role="complementary">
		
		<div class="wrap">
			<div class="wrap-inside">
			
				<?php dynamic_sidebar( 'subsidiary' ); ?>
		
			</div><!-- .wrap-inside -->	
		</div><!-- .div -->

	</aside><!-- #sidebar-subsidiary .sidebar -->

<?php } ?>