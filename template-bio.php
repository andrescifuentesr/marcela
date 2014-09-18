<?php
/*
Template Name: Bio
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site-main--thumb-column site-main--bio" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<h2><?php the_field('nom_bio'); ?></h2>

						<!-- the_post_thumbnail -->
						<?php if ( has_post_thumbnail() ) { ?>
							<?php the_post_thumbnail('full', array('class' => 'thumb-photo')); ?>
						<?php } ?>

						<div class="wrap-thumb-column">
							<header class="entry-header">
								<h1 class="entry-title"><?php the_field('phrase_bio'); ?></h1>
							</header><!-- .entry-header -->
						
							<div class="entry-content">
								<h3><?php the_title(); ?></h3>
								<?php the_content(); ?>
							</div><!-- .entry-content -->
						
							<a href="<?php the_field('pdf_bio'); ?>" class="bt-bio" target="_blank">Télécharger le Pdf</a>

						</div>

				</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
