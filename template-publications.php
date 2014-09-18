<?php
/*
Template Name: Template Publications
*/

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main site-gallery-grid site-gallery-pub" role="main">

			<?php
				$args = array(
					'post_type' 		=> 'publication', 	//Costum type reportages
					'order'				=> 'DESC',		// List in descending order
					'orderby'      		=> 'id',		// List them by ID
					'posts_per_page'	=>  -1, 		// Show all
				);
				$queryPublications = new WP_Query($args);
			?>
			<?php while ($queryPublications->have_posts()) : $queryPublications->the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class('gallery-page-item gallery-page-item--pub clearfix'); ?>>
				<?php
					$args = array(
						'post_parent'    	=> 		$post->ID,			// For the current post
						'post_type'      	=> 		'attachment',		// Get all post attachments
						'post_mime_type' 	=> 		'image',			// Only grab images
						'order'		 		=> 		'ASC',			// List in ascending order
						'orderby'        	=> 		'menu_order',			// List them in their menu order
						'numberposts'    	=> 		-1, 			// Show all attachments
						'post_status'    	=> 		null,			// For any post status
					);
				 
					// Retrieve the items that match our query; in this case, images attached to the current post.
					$attachments = get_posts($args); ?>
				 
				<?php // If any images are attached to the current post, do the following: ?>
				<?php if ($attachments) {	?>
					<div class="">
						<?php 	
							// Now we loop through all of the images that we found
							foreach ($attachments as $attachment) { 
							//Set the parameters for the image we are about to display.
							$default_attr = array(
								'alt' => trim( $attachment->post_content )
							);

							$title = $attachment->post_title;
							$caption = $attachment->post_excerpt;
							$content = $attachment->post_content;

							$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'full'); 
						?>
							<div class="">
								<a href="<?php echo $image_attributes[0]; ?>" rel="group" data-imagelightbox="f">
									<?php echo wp_get_attachment_image($attachment->ID, 'imgPub', false, $default_attr); ?>
								</a>
							</div>
							<a href="<?php echo $image_attributes[0]; ?>" rel="group" class="block-text">
								<h3 class="entry-title"><?php the_title(); ?></h3>
								<?php the_content(); ?>
							</a>
									
						<?php } // End of foreach Loop?>
					</div>
				<?php } //End of if loop ?>

				</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
