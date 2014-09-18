<?php
/*
Template Name: Template Slider
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
			
			<?php
				$args2 = array(
					'post_type' 	=> 'page',		//type / Only the first 20
					'page_id'   	=> '30',			// For the home ID					
					'order'			=> 'DESC',		// List in ascending order
					'orderby'       => 'id'			// List them in their menu order
				);
				
				$carouselHome = new WP_Query($args2);
			?>

			<?php /* Start the Loop */ ?>
			<?php while ($carouselHome->have_posts()) : $carouselHome->the_post(); ?>

				<div class="flexslider-wrapper loading">

					<div class="spinner">
						<div class="bounce1"></div>
						<div class="bounce2"></div>
						<div class="bounce3"></div>
					</div>

					<div class="flexslider">
						<ul class="slides">
							<?php
								$args = array(
									'post_parent'    	=> $post->ID,			// For the current post
									'post_type'      	=> 'attachment',		// Get all post attachments
									'post_mime_type'	=> 'image',			// Only grab images
									'order'				=> 'ASC',			// List in ascending order
									'orderby'       	=> 'rand',			// List them in their menu order
									'numberposts'   	=> 1, 			// Show all attachments
									'post_status'   	=> null,			// For any post status
								);
							 
								// Retrieve the items that match our query; in this case, images attached to the current post.
								$attachments = get_posts($args); 
							?>
							<?php foreach ($attachments as $attachment) { ?>
								<li>
									<?php echo wp_get_attachment_image($attachment->ID, 'full', false, $default_attr); ?>
								</li>
							<?php } // End of foreach Loop?>						
						</ul>
					</div>
				</div>

			<?php endwhile; ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
