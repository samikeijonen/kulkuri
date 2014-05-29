<?php
/**
 * Template name: Front Page
 *
 * This is the template that displays the front page.
 *
 * @package Kulkuri
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
			<?php $k = 1;
	
			while ( $k < apply_filters( 'kulkuri_how_many_pages', 7 ) ) : // Begins the loop through found posts from customize settings. 
				
				$kulkuri_page_content = absint( get_theme_mod( 'front_page_' . $k ) );
	
				if ( 0 != $kulkuri_page_content || !empty( $kulkuri_page_content ) ) : // Check if page is selected. ?>
					
					<?php
					/* Get background color. */
					if ( get_theme_mod( 'background_color_' . $k ) ) :
						$kulkuri_section_bg_color = 'background-color: ' . get_theme_mod( 'background_color_' . $k , '#ffffff' ) . ';';
					else :
						$kulkuri_section_bg_color = '';
					endif;	
					
					/* Get background image. */
					if ( get_theme_mod( 'background_image_' . $k ) ) :
						$kulkuri_section_bg_image = 'background-image: url(' . esc_url( get_theme_mod( 'background_image_' . $k ) ) . ');';
					else :
						$kulkuri_section_bg_image = '';
					endif;
					
					/* Get page slug. */
					$kulkuri_page = get_post( $kulkuri_page_content ); 
					$kulkuri_page_slug = $kulkuri_page->post_name;
					
					do_action( 'kulkuri_front_page_before_section_' . $k ); // Add hook where we can filter new stuff. ?>
					
					<section style="<?php echo $kulkuri_section_bg_color . $kulkuri_section_bg_image; ?>" id="<?php echo esc_attr( $kulkuri_page_slug ); ?>" class="kulkuri-section kulkuri-section-<?php echo $k; ?>">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
							<div class="wrapper-inner">
				
								<header class="entry-header">
									<h1 class="entry-title"><?php echo get_the_title( $kulkuri_page_content ); ?></h1>
									
									<?php if ( has_excerpt( $kulkuri_page_content ) ) { ?>
									<div class="entry-summary">
										<?php echo wpautop( get_post_field( 'post_excerpt', $kulkuri_page_content ) ); ?>
									</div><!-- .entry-summary -->
								<?php } ?>
								</header><!-- .entry-header -->
								
								<div class="entry-content">
									<?php echo apply_filters( 'the_content', ( get_post_field( 'post_content', $kulkuri_page_content ) ) );	?>
								</div><!-- .entry-content -->
				
							</div><!-- .wrapper-inner -->
					
						</article><!-- .entry -->
					</section><!-- #slug -->
					
					<?php do_action( 'kulkuri_front_page_after_section_' . $k ); // Add hook where we can filter new stuff. ?>
		
				<?php endif; //End if page is selected. ?>
				
			<?php $k++; // Add one before loop ends. 
	
			endwhile; // End found posts loop.
			
			/* Add latest posts if user wants it. */
			
			if( get_theme_mod( 'show_latest_posts' ) ) :
			
				$kulkuri_post_args = apply_filters( 'kulkuri_front_page_latest_arguments', array(
					'post_type'           => 'post',
					'posts_per_page'      => 3
				) );
			
				$kulkuri_posts = new WP_Query( $kulkuri_post_args );
			
				if ( $kulkuri_posts->have_posts() ) :

					while ( $kulkuri_posts->have_posts() ) : $kulkuri_posts->the_post(); ?>
			
						<section id="<?php the_ID(); ?>" class="kulkuri-section kulkuri-section-blog kulkuri-section-<?php the_ID(); ?>">
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
								<div class="wrapper-inner">
				
									<header class="entry-header">
										<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

									<div class="entry-meta">
										<?php kulkuri_posted_on(); ?>
									</div><!-- .entry-meta -->
									</header><!-- .entry-header -->
								
									<div class="entry-content">
										<?php the_content(); ?>
									</div><!-- .entry-content -->
								
									<footer class="entry-footer">
										<?php kulkuri_post_terms( array( 'taxonomy' => 'category', 'text' => __( 'Posted in %s', 'mina-olen' ) ) ); ?>
										<?php kulkuri_post_terms( array( 'taxonomy' => 'post_tag', 'text' => __( 'Tagged %s', 'mina-olen' ), 'before' => '<br />' ) ); ?>
									</footer><!-- .entry-footer -->
				
								</div><!-- .wrapper-inner -->
					
							</article><!-- .entry -->
						</section><!-- #ID -->
			
					<?php endwhile; // End loop. ?>

				<?php endif; wp_reset_postdata(); // reset query. ?>
				
			<?php endif;; // End show_latest_posts. ?>
			
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
