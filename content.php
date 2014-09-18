<?php
/**
 * @package marcela
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php marcela_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<!-- the_post_thumbnail -->
		<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php the_permalink(); ?>" rel="bookmark">

				<?php //different sizes ?>
				<?php $large_image_urlLarge = wp_get_attachment_image_src( get_post_thumbnail_id(), 'imgBlogLarge' ); ?>
				<?php $large_image_urlMedium = wp_get_attachment_image_src( get_post_thumbnail_id(), 'imgBlogMedium' ); ?>
				<?php $large_image_urlSmall = wp_get_attachment_image_src( get_post_thumbnail_id(), 'imgBlogSmall' ); ?>
				
				<?php //title == alt ?>
				<?php $title = get_post(get_post_thumbnail_id())->post_title; //The Title ?>

				<picture>
					<!--[if IE 9]><video style="display: none;"><![endif]-->
					<source srcset="<?php echo $large_image_urlLarge[0];?>" media="(min-width: 912px)">
					<source srcset="<?php echo $large_image_urlMedium[0];?>" media="(min-width: 400px)">
					<source srcset="<?php echo $large_image_urlSmall[0];?>">
					<!--[if IE 9]></video><![endif]-->
					<img srcset="<?php echo $large_image_urlLarge[0];?>" alt="<?php echo $title; ?>">
				</picture>

				<?php //the_post_thumbnail('imgBlog', array('class' => '')); ?>
			</a>
		<?php } ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'marcela' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
