<?php 

function psp_comment_template( $comment_template ) {
     global $post;
     if ( !( is_singular() && ( have_comments() || 'open' == $post->comment_status ) ) ) {
        return;
     }
     if($post->post_type == 'psp_projects'){ // assuming there is a post type called business
        return dirname(__FILE__) . '/templates/comments.php';
     }
}

add_filter( "comments_template", "psp_comment_template" );


function project_status_comment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		
<?php if ($comment->comment_approved == '0') : ?>
		<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
		<br />
<?php endif; ?>
		
		<div class="comment-text">
			<?php comment_text() ?>
			
				<div class="reply">
				<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			
			<div class="comment-date">
				<?php
					/* translators: 1: date, 2: time */
					printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?> <?php edit_comment_link(__('(Edit)'),'  ','' );
				?>
			</div>
		</div>
		<span class="psp-bubble"></span>
		
		<div class="comment-author vcard">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
		</div>

	
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
        } ?>