<?php
/**
 * @package marcela
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php marcela_posted_on(); ?>
		</div><!-- .entry-meta -->

		<!-- the_post_thumbnail -->
		<?php if ( has_post_thumbnail() ) { ?>
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_post_thumbnail('imgBlog', array('class' => '')); ?>
			</a>
		<?php } ?>
		
	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
