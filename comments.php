<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package marcela
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				//printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'marcela' ),
				//	number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
				printf( _nx( 'Un  commentaire', '%1$s commentaires', get_comments_number(), 'comments title', 'marcela' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h3>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'marcela' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'marcela' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'marcela' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'reply_text' => 'Répondre',
					// 'avatar_size'=> 64
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'marcela' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'marcela' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'marcela' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'marcela' ); ?></p>
	<?php endif; ?>

	<?php
		$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'title_reply'       => __( 'Laisser un commentaire' ),
			'title_reply_to'    => __( 'Laisser un commentaire à %s' ),
			'cancel_reply_link' => __( 'Anuller votre réponse' ),
			'label_submit'      => __( 'Commenter' ),

			'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( '', 'noun' ) .
			  '</label><textarea id="comment" name="comment" placeholder="Commentaire" cols="45" rows="8" aria-required="true">' .
			  '</textarea></p>',

			'must_log_in' => '<p class="must-log-in">' .
			  sprintf(
				__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
				wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
			  ) . '</p>',

			'logged_in_as' => '<p class="logged-in-as">' .
			  sprintf(
			  __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
				admin_url( 'profile.php' ),
				$user_identity,
				wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
			  ) . '</p>',

			'comment_notes_before' => '',

			'comment_notes_after' => '',

			'fields' => apply_filters( 'comment_form_default_fields', array(

			  'author' =>
				'<p class="comment-form-author">' .
				'<label for="author">' . __( '', 'domainreference' ) . '</label> ' .
				( $req ? '<span class="required"></span>' : '' ) .
				'<input id="author" name="author" type="text" placeholder="Nom" value="' . esc_attr( $commenter['comment_author'] ) .
				'" size="30"' . $aria_req . ' /></p>',

			  'email' =>
				'<p class="comment-form-email"><label for="email">' . __( '', 'domainreference' ) . '</label> ' .
				( $req ? '<span class="required"></span>' : '' ) .
				'<input id="email" name="email" type="text" placeholder="Email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				'" size="30"' . $aria_req . ' /></p>'
			  )
			),
		);
	?>

	<?php comment_form( $args ); ?>

</div><!-- #comments -->
