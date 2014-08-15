<?php
/*
Template Name: Bio
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site-main--bio" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">

						<div class="wrap-bio clearfix">
							<!-- the_post_thumbnail -->
							<?php if ( has_post_thumbnail() ) { ?>
								<?php the_post_thumbnail('full', array('class' => 'wp-post-image--bio')); ?>
							<?php } ?>

							<?php the_content(); ?>
						</div>

						<div class="wrap-bio">
							<h4><?php _e( 'Realisations Photographiques', 'marcela' ); ?></h4>						
							<p><?php the_field('realisations_photographiques'); ?></p>
						</div>
						
						<div class="wrap-bio">
							<h4><?php _e( 'Quelques reconnaissances et expos', 'marcela' ); ?></h4>
							<p><?php the_field('reconnaissances'); ?></p>
						</div>

						<div class="wrap-bio">
							<h4><?php _e( 'Formation', 'marcela' ); ?></h4>
							<p><?php the_field('formation'); ?></p>
						</div>

					</div><!-- .entry-content -->

				</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
