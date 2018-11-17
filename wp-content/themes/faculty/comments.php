<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','faculty'); ?></p>
	<?php
		return;
	}
?>



<?php if ( have_comments() ) : ?>
	<h3 class="title" id="comments"><?php	printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number() ,'faculty'),
									number_format_i18n( get_comments_number() ), '&#8220;' . get_the_title() . '&#8221;' ); ?></h3>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments("callback=fac_comment");?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.','faculty'); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

<div id="respond">
	<?php 
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$arg = array(
		'comment_notes_after' => '',
		'fields' => apply_filters( 'comment_form_default_fields', array(
						'author' =>
					      	'<div class="row">'.
								'<div class="col-md-6">'.
									'<label for="author">'. __('Name','faculty'). ' <small>'. ( $req ? __('(required)','faculty') : '') .'</small></label>'.
									'<input class="form-control" type="text" name="author" id="author" value="'. esc_attr( $commenter['comment_author'] ) .'" size="22" tabindex="1"'. $aria_req .'/>'.
								'</div>'.
							'</div>',

					    'email' =>

					    	'<div class="row">'.
								'<div class="col-md-6">'.
									'<label for="email">'. __('Email','faculty'). ' <small>'. ( $req ? __('(required)','faculty') : '') .'</small></label>'.
									'<input class="form-control" type="text" name="email" id="email" value="'. esc_attr( $commenter['comment_author_email'] ) .'" size="22" tabindex="1"'. $aria_req .'/>'.
								'</div>'.
							'</div>',

					    'url' =>

					    	'<div class="row">'.
								'<div class="col-md-6">'.
									'<label for="url">'. __('Website','faculty').'</label>'.
									'<input class="form-control" type="text" name="url" id="url" value="'. esc_attr( $commenter['comment_author_url'] ) .'" size="22" tabindex="1"'. $aria_req .'/>'.
								'</div>'.
							'</div>'
					))
	); ?>
	<?php comment_form($arg); ?>

</div>

<?php endif;?>
