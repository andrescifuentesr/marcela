<?php
/*
Template Name: Template Reportages
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site-main--thumb-column" role="main">

			<?php
				$args = array(
					'post_type' 		=> 'reportage', 	//Costum type reportages
					'order'				=> 'DESC',		// List in descending order
					'orderby'      		=> 'id',		// List them by ID
					'posts_per_page'	=>  -1, 		// Show all
				);
				$queryReportages = new WP_Query($args);
			?>
			<?php while ($queryReportages->have_posts()) : $queryReportages->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

					<!-- the_post_thumbnail -->
					<?php if ( has_post_thumbnail() ) { ?>
						<a href="<?php the_permalink(); ?>" rel="bookmark">
							<?php the_post_thumbnail('full', array('class' => 'thumb-photo')); ?>
						</a>
					<?php } ?>

					<div class="wrap-thumb-column">

						<header class="entry-header">
							<h1 class="entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h1>
						</header><!-- .entry-header -->						

						<div class="entry-content">
							<?php the_content(); ?>
						</div><!-- .entry-content -->

					</div>

				</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
