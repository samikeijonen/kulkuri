<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Kulkuri
 */
?>
		
		</div><!-- .wrap -->
	</div><!-- #content -->
	
	<?php get_sidebar( 'subsidiary' ); // Loads the sidebar-subsidiary.php template. ?>

</div><!-- #home -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="site-info">
		<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'kulkuri' ) ); ?>" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'kulkuri' ); ?>"><?php printf( __( 'Proudly powered by %s', 'kulkuri' ), 'WordPress' ); ?></a>
		<span class="sep"> <?php esc_attr_e( '&middot;', 'kulkuri' ); ?></span>
		<?php printf( __( 'Theme: %1$s by %2$s.', 'kulkuri' ), 'kulkuri', '<a href="https://foxland.fi" rel="designer">Foxnet Themes</a>' ); ?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
