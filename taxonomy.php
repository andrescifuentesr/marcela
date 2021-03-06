<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package marcela
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site-gallery-grid" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('gallery-page-item clearfix'); ?>>

					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<figure class="effect-grid">
							<?php the_post_thumbnail('imgGalleryGrid', array('class' => 'thumb-gallerie')); ?>
							<figcaption>
								<h3 class="entry-title">
									<?php the_title(); ?>
								</h3>
							</figcaption>
						</figure>
					</a>

				</article><!-- #post-## -->

			<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
