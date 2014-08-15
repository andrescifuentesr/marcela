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
				<?php the_post_thumbnail('imgBlog', array('class' => '')); ?>
			</a>
		<?php } ?>

	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'marcela' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
