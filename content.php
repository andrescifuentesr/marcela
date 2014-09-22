<?php
/**
 * @package marcela
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<!-- the_post_thumbnail -->
	<?php if ( has_post_thumbnail() ) { ?>
		<a href="<?php the_permalink(); ?>" rel="bookmark">
			<?php the_post_thumbnail('full', array('class' => 'thumb-photo')); ?>
		</a>
	<?php } ?>

	<div class="wrap-thumb-column">

		<header class="entry-header">

			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php marcela_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>

			<div class="entry-content">
				<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'marcela' ) ); ?>
			</div><!-- .entry-content -->

		</header><!-- .entry-header -->

	</div>

</article><!-- #post-## -->
