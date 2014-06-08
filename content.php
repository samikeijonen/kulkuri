<?php
/**
 * @package Kulkuri
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
		<?php if ( has_post_thumbnail() ) the_post_thumbnail( 'kulkuri-thumbnail', array( 'class' => 'thumbnail' ) ); ?>
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php kulkuri_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
		<footer class="entry-footer">
			<?php kulkuri_post_terms( array( 'taxonomy' => 'category', 'text' => __( 'Posted in %s', 'mina-olen' ) ) ); ?>
			<?php kulkuri_post_terms( array( 'taxonomy' => 'post_tag', 'text' => __( 'Tagged %s', 'mina-olen' ), 'before' => '<br />' ) ); ?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
	
</article><!-- #post-## -->
