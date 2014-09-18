<?php
/*
Template Name: Templete Column-photo
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site-main--column-photo" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					
					<!-- the_post_thumbnail -->
					<?php if ( has_post_thumbnail() ) { ?>
						<div class="wrap-column-photo">
							<?php the_post_thumbnail('full', array('class' => 'wp-post-image')); ?>
							<?php if( get_field('description_image_boutique') ) { ?>
								<p><?php the_field('description_image_boutique'); ?></p>
							<?php } ?>
						</div>			
					<?php } ?>

					<div class="wrapper-content">

						<div class="entry-content">
							<?php the_content(); ?>
						</div><!-- .entry-content -->

					</div>

				</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
