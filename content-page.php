<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package marcela
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- the_post_thumbnail -->
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="thumb-bio">
			<?php the_post_thumbnail('full', array('class' => '')); ?>
		</div>
	<?php } ?>

	<div class="wrap-bio">

		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->

	</div><!-- .wrap-bio -->

</article><!-- #post-## -->
