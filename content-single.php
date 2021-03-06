<?php
/**
 * @package Kulkuri
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php kulkuri_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'kulkuri' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php kulkuri_post_terms( array( 'taxonomy' => 'category', 'text' => __( 'Posted in %s', 'kulkuri' ) ) ); ?>
		<?php kulkuri_post_terms( array( 'taxonomy' => 'post_tag', 'text' => __( 'Tagged %s', 'kulkuri' ), 'before' => '<br />' ) ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
