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
		
		<?php
		
		/* Get page IDs from child pages. */
		$kulkuri_page_child_ids = kulkuri_get_child_page_ids( get_queried_object_id() );
			
		/* Check that we have IDs. */
		if ( ! empty( $kulkuri_page_child_ids ) ) :
			
			$kulkuri_section_args = apply_filters( 'kulkuri_front_page_section_arguments', array(
				'post_type'   => array( 'page' ),
				'post__in'    => $kulkuri_page_child_ids,
				'post_status' => 'publish',
				'orderby'     => 'post__in',
				'order'       => 'asc'
			) );
			
			/* Set transient (24h) for faster loading. Delete transient on hook 'save_post' in functions.php file. */
			if( false === ( $kulkuri_section_query = get_transient( 'kulkuri_section_query' ) ) ) {
				$kulkuri_section_query = new WP_Query( $kulkuri_section_args );
				set_transient( 'kulkuri_section_query', $kulkuri_section_query, 60*60*24 );
			}
			
			if ( $kulkuri_section_query->have_posts() ) :
			
				$k=1;

				while ( $kulkuri_section_query->have_posts() ) : $kulkuri_section_query->the_post();
		
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
					$kulkuri_page = get_post( get_the_ID() ); 
					$kulkuri_page_slug = $kulkuri_page->post_name;
					
					do_action( 'kulkuri_front_page_before_section_' . $k ); // Add hook where we can filter new stuff. ?>
					
					<section style="<?php echo $kulkuri_section_bg_color . $kulkuri_section_bg_image; ?>" id="<?php echo esc_attr( $kulkuri_page_slug ); ?>" class="kulkuri-section kulkuri-section-<?php echo $k; ?>">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
							<div class="wrapper-inner">
				
								<header class="entry-header">
									<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
								</header><!-- .entry-header -->
								
								<div class="entry-content">
									<?php the_content(); ?>
								</div><!-- .entry-content -->
				
							</div><!-- .wrapper-inner -->
					
						</article><!-- .entry -->
					</section><!-- #slug -->
					
					<?php do_action( 'kulkuri_front_page_after_section_' . $k ); // Add hook where we can filter new stuff. ?>
		
					<?php $k++; // Add one before loop ends. ?>
					
				<?php endwhile; //End loop. ?>
				
			<?php endif; wp_reset_postdata(); // reset query. ?>
			
		<?php endif; // End check for post IDs.
			
		/* Add latest posts if user wants it. */
			
		if( get_theme_mod( 'show_latest_posts' ) ) :
			
			$kulkuri_post_args = apply_filters( 'kulkuri_front_page_latest_arguments', array(
				'post_type'           => 'post',
				'posts_per_page'      => 3
			) );
				
			/* Set transient (24h) for faster loading. Delete transient on hook 'save_post' in functions.php file. */
			if( false === ( $kulkuri_posts = get_transient( 'kulkuri_posts' ) ) ) {
				$kulkuri_posts = new WP_Query( $kulkuri_post_args );
				set_transient( 'kulkuri_posts', $kulkuri_posts, 60*60*24 );
			}
			
			if ( $kulkuri_posts->have_posts() ) :

				while ( $kulkuri_posts->have_posts() ) : $kulkuri_posts->the_post(); ?>
			
					<section id="<?php the_ID(); ?>" class="kulkuri-section kulkuri-section-blog kulkuri-section-blog-<?php the_ID(); ?>">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
							<div class="wrapper-inner">
				
								<header class="entry-header">
									<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

									<div class="entry-meta">
										<?php kulkuri_posted_on(); ?>
									</div><!-- .entry-meta -->
								</header><!-- .entry-header -->
								
								<div class="entry-content">
									<?php the_content(); ?>
								</div><!-- .entry-content -->
								
								<footer class="entry-footer">
									<?php kulkuri_post_terms( array( 'taxonomy' => 'category', 'text' => __( 'Posted in %s', 'kulkuri' ) ) ); ?>
									<?php kulkuri_post_terms( array( 'taxonomy' => 'post_tag', 'text' => __( 'Tagged %s', 'kulkuri' ), 'before' => '<br />' ) ); ?>
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
