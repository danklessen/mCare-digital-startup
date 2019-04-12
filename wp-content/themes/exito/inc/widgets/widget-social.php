<?php

/**
 * Widget Name: Social Links
 */

class exito_widget_sociallinks extends WP_Widget {

    public function __construct() {

		parent::__construct(
				'sociallinks_widget', // Base ID
				'Evatheme Social Links', // Name
				array('description' => esc_html__('Displays your social profile.', 'exito'),) // Args
		);
	}

    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
            if ($title){echo $before_title . $title . $after_title;}
			
			$exito_widget_social_links = array(
				'facebook' => array(
					'name' => 'facebook_username',
					'link' => '*',
				),
				'flickr' => array(
					'name' => 'flickr_username',
					'link' => '*'
				),
				'google-plus' => array(
					'name' => 'googleplus_username',
					'link' => '*'
				),
				'twitter' => array(
					'name' => 'twitter_username',
					'link' => '*',
				),
				'instagram' => array(
					'name' => 'instagram_username',
					'link' => '*',
				),
				'pinterest' => array(
					'name' => 'pinterest_username',
					'link' => '*',
				),
				'skype' => array(
					'name' => 'skype_username',
					'link' => 'skype:*'
				),
				'youtube' => array(
					'name' => 'youtube_username',
					'link' => '*',
				),
				'dribbble' => array(
					'name' => 'dribbble_username',
					'link' => '*',
				),
				'linkedin' => array(
					'name' => 'linkedin_username',
					'link' => '*'
				),
				'rss' => array(
					'name' => 'rss_username',
					'link' => '*'
				)
			);
			
            echo '<div class="social_links_wrap clearfix">';
            foreach ($exito_widget_social_links as $key => $social) {
                if(!empty($instance[$social['name']])){
                    echo '<a class="social_link ' . $key . '" href="' . str_replace('*',$instance[$social['name']],$social['link']) . '" target="_blank" title="' . $key . '"><i class="fa fa-' . $key . '"></i><i class="fa fa-' . $key . '"></i></a>';
                }
            }
            echo '</div>';
        echo $after_widget;
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance = $new_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    public function form($instance) {
		
		$exito_widget_social_links = array(
			'facebook' => array(
				'name' => 'facebook_username',
				'link' => '*',
			),
			'flickr' => array(
				'name' => 'flickr_username',
				'link' => '*'
			),
			'google-plus' => array(
				'name' => 'googleplus_username',
				'link' => '*'
			),
			'twitter' => array(
				'name' => 'twitter_username',
				'link' => '*',
			),
			'instagram' => array(
				'name' => 'instagram_username',
				'link' => '*',
			),
			'pinterest' => array(
				'name' => 'pinterest_username',
				'link' => '*',
			),
			'skype' => array(
				'name' => 'skype_username',
				'link' => 'skype:*'
			),
			'youtube' => array(
				'name' => 'youtube_username',
				'link' => '*',
			),
			'dribbble' => array(
				'name' => 'dribbble_username',
				'link' => '*',
			),
			'linkedin' => array(
				'name' => 'linkedin_username',
				'link' => '*'
			),
			'rss' => array(
				'name' => 'rss_username',
				'link' => '*'
			)
		);
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'exito'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo isset($instance['title']) ? $instance['title'] : ''; ?>"  />
        </p>
		<?php
        foreach ($exito_widget_social_links as $key => $social) { ?>
            <p>
                <label for="<?php echo $this->get_field_id($social['name']); ?>"><?php echo $key; if($key==='linkedin'){echo ' URL';} ?>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id($social['name']); ?>" type="text" name="<?php echo $this->get_field_name($social['name']); ?>" value="<?php echo isset($instance[$social['name']]) ? $instance[$social['name']] : ''; ?>"  />
            </p><?php
        }
    }
}

add_action('widgets_init', create_function('', 'return register_widget("exito_widget_sociallinks");'));
?>
