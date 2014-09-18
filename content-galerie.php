<?php
/**
 * @package marcela
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
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
					
			<!-- Slideshow 2 -->
			<div class="gallery-full">
				<?php 	
					// Now we loop through all of the images that we found
					foreach ($attachments as $attachment) { 
					//Set the parameters for the image we are about to display.
					$default_attr = array(
						'alt' => trim(strip_tags( $attachment->post_content )),
					);
					$image_attributes = wp_get_attachment_image_src( $attachment->ID, 'full'); 
				?>
				<div class="gallery-item">
					<a href="<?php echo $image_attributes[0]; ?>" rel="group" data-imagelightbox="f">
						<?php echo wp_get_attachment_image($attachment->ID, 'imgGallery', false, $default_attr); ?>
					</a>
				</div>
				<?php } // End of foreach Loop?>
			</div>									
		<?php } //End of if loop ?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
