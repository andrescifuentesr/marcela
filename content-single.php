<?php
/**
 * @package marcela
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- the_post_thumbnail -->
	<?php if ( has_post_thumbnail() ) { ?>
		<?php the_post_thumbnail('full', array('class' => 'thumb-photo')); ?>
	<?php } ?>
		
	<div class="wrap-thumb-column">

		<header class="entry-header">

			<h1 class="entry-title"><?php the_title(); ?></h1>

			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php marcela_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>

				<div class="social-plugin">
					 <?php if( function_exists( do_sociable() ) ){ do_sociable(); } ?>
				</div>
			</div><!-- .entry-content -->

		</header><!-- .entry-header -->

	</div>

</article><!-- #post-## -->
