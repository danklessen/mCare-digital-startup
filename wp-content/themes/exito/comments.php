<?php
global $exito_options;

function exito_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'exito_move_comment_field_to_bottom' );
?>

<div id="comments">
	
	<?php
	
		if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
			die ('Please do not load this page directly. Thanks!');
	
		if ( post_password_required() ) { ?>
			<?php echo '<div class="comments_pass_note">' . esc_html__('This post is password protected. Enter the password to view comments.', 'exito') . '</div></div>'; ?>
		<?php
			return;
		}
	?>
	
	<?php if ( have_comments() ) : ?>
		
		<div class="commentlist_wrap">
			<h4 class="comments_title"><?php echo esc_html__('Comments','exito'); ?> <span class="theme_color"><?php echo get_comments_number(); ?></span></h4>
			<?php $exito_custom_divider = $exito_options['custom_divider']['url']; ?>
			<?php $exito_custom_divider_width = isset( $exito_options['custom_divider_width'] ) ? $exito_options['custom_divider_width'] : '48'; ?>
			<div class="divider_active">
				<?php if( isset( $exito_custom_divider ) && !empty( $exito_custom_divider ) ){ ?>
					<img src="<?php echo esc_url( $exito_custom_divider ); ?>" alt="" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;" />
				<?php } else { ?>
					<span class="bg_primary" style="width:<?php echo esc_attr( $exito_custom_divider_width ); ?>px !important;"></span>
				<?php } ?>
			</div>
		
			<div class="navigation">
				<div class="next-posts"><?php previous_comments_link() ?></div>
				<div class="prev-posts"><?php next_comments_link() ?></div>
			</div>
		
			<ol class="commentlist clearfix">
				<?php wp_list_comments(array('callback' => 'exito_comment' )); ?>
			</ol>
		
			<div class="navigation">
				<div class="next-posts"><?php previous_comments_link() ?></div>
				<?php paginate_comments_links(); ?> 
				<div class="prev-posts"><?php next_comments_link() ?></div>
			</div>
		</div>
		
	 <?php else : // this is displayed if there are no comments so far ?>
	
		<?php if ( comments_open() ) : ?>
			<!-- If comments are open, but there are no comments. -->
	
		 <?php else : // comments are closed ?>
			<p class="hidden"><?php esc_html_e('Comments are closed.', 'exito'); ?></p>
	
		<?php endif; ?>
		
	<?php endif; ?>
		
		
<?php if ( comments_open() ) : ?>

	<?php
	
		$comment_form = array(
            'fields' => apply_filters('comment_form_default_fields', array(
                'author' => '<div class="respond-inputs clearfix"><div class="author_wrap"><input type="text" placeholder="' . esc_html__('Name *', 'exito') . '" title="' . esc_html__('Name *', 'exito') . '" id="author" name="author" class="form_field"></div>',
                'email' => '<div class="email_wrap"><input type="text" placeholder="' . esc_html__('Email *', 'exito') . '" title="' . esc_html__('Email *', 'exito') . '" id="email" name="email" class="form_field"></div>',
                'url' => '<div class="url_wrap"><input type="text" placeholder="' . esc_html__('Web site', 'exito') . '" title="' . esc_html__('Web site', 'exito') . '" id="web" name="url" class="form_field"></div></div>'
            )),
            'comment_field' => '<textarea name="comment" cols="45" rows="5" placeholder="' . esc_html__('Comment', 'exito') . '" id="comment-message" class="form_field"></textarea>',
            'comment_form_before' => '',
            'comment_form_after' => '',
            'must_log_in' => esc_html__('You must be logged in to post a comment.', 'exito'),
            'title_reply' => esc_html__('Leave a Comment!', 'exito'),
            'label_submit' => esc_html__('Add a Comment', 'exito'),
            'logged_in_as' => '<p class="logged-in-as">' . esc_html__('Logged in as', 'exito') . ' <a href="' . admin_url('profile.php') . '">' . $user_identity . '</a>. <a href="' . wp_logout_url(apply_filters('the_permalink', get_permalink())) . '">' . esc_html__('Log out?', 'exito') . '</a></p>',
        );
        comment_form($comment_form, $post->ID);
		
	?>


<?php endif; // if you delete this the sky will fall on your head ?>

</div>