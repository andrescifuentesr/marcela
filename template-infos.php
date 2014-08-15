<?php
/*
Template Name: Template Expos et Infos
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				$args = array(
					'post_type' 		=> 'infos', 	//Costum type recipe
					'order'				=> 'DESC',		// List in descending order
					'orderby'      		=> 'id',		// List them by ID
					'posts_per_page'	=>  -1, 		// Show all
				);
				$queryRecipe = new WP_Query($args);
			?>
			<?php while ($queryRecipe->have_posts()) : $queryRecipe->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<!-- the_post_thumbnail -->
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail('full', array('class' => 'thumb-infos')); } ?>

					<div class="wrap-infos">

						<header class="entry-header">
							<h1 class="entry-title"><?php the_title(); ?></h1>
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
