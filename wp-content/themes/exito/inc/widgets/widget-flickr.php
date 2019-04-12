<?php

/**
 * Widget Name: Flickr
 */

class exito_widget_flickr extends WP_Widget {

	public function __construct() {

		parent::__construct(
				'flickr_widget',
				esc_html__('Evatheme Flickr', 'exito'),
				array('description' => esc_html__('List of your works from the flickr.', 'exito'),)
		);
	}

	public function widget( $args, $instance ) {
		extract($args, EXTR_SKIP);

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$unique_id = rand(0, 300);
		
		wp_enqueue_script('exito_jflickrfeed', get_template_directory_uri() . '/assets/js/jflickrfeed.min.js', array('jquery'), false, true);

		echo $before_widget;

		if ($title !== '') {
			echo $before_title . $title . $after_title;
		}

		?>

		<ul id="cs_flickr_feed_<?php echo esc_html( $unique_id ); ?>" class="flickr-feed clearfix"></ul>

		<script type="text/javascript">
			jQuery(window).load(function () {
				setTimeout(function () {
					jQuery('#cs_flickr_feed_<?php echo esc_html( $unique_id ); ?>').jflickrfeed({
						limit: <?php echo $instance['imagescount'] ?>,
						qstrings: { id: '<?php echo $instance['username'] ?>' },
						itemTemplate: '<li><a data-group="flickr" target="_blank" href="{{image_b}}"><img src="{{image_q}}" alt="{{title}}" /></a></li>'
					});
				}, 300);
			});
		</script>

		<?php echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = esc_attr($new_instance['title']);
		$instance['username'] = esc_attr($new_instance['username']);
		$instance['imagescount'] = absint($new_instance['imagescount']);
		return $instance;
	}

	public function form( $instance ) {
		$defaults = array(
			'title' => 'Photo Stream',
			'username' => '108038684@N04',
			'imagescount' => '8',
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title', 'exito') ?>:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php esc_html_e('Flickr ID', 'exito') ?>:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $instance['username']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('imagescount'); ?>"><?php esc_html_e('Number of images', 'exito') ?>:</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('imagescount'); ?>" name="<?php echo $this->get_field_name('imagescount'); ?>" value="<?php echo $instance['imagescount']; ?>" />
		</p>

	<?php
	}
}

function flickr_register_widgets() { register_widget( 'exito_widget_flickr' ); } 
add_action( 'widgets_init', 'flickr_register_widgets' );

?>