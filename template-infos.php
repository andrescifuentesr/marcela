<?php
/*
Template Name: Template Expos et Infos
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site-main--thumb-column" role="main">

			<?php
				$args = array(
					'post_type' 		=> 'infos', 	//Costum type recipe
					'order'				=> 'DESC',		// List in descending order
					'orderby'      		=> 'id',		// List them by ID
					'posts_per_page'	=>  -1, 		// Show all
				);
				$queryInfos = new WP_Query($args);
			?>
			<?php while ($queryInfos->have_posts()) : $queryInfos->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

					<!-- the_post_thumbnail -->
					<?php if ( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail('full', array('class' => 'thumb-photo')); ?>
					<?php } ?>

					<div class="wrap-thumb-column">

						<header class="entry-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</header><!-- .entry-header -->

						<div class="entry-content">
							<?php the_content(); ?>

							<div class="social-plugin">
								 <?php if( function_exists( do_sociable() ) ){ do_sociable(); } ?>
							</div>
						</div><!-- .entry-content -->

					</div>

				</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
