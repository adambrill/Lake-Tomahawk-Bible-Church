<?php
/**
 * HoloThesis RecentPosts Widget.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 */
class RecentCategoryPosts_Widget extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function RecentCategoryPosts_Widget() {
		
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'recentCategoryPosts',
			'description' => __('A listing of recent posts from a certain category')
		);
		
		/* Widget control settings. */
		$control_ops = array(
			'width' => 300,
			'height' => 350,
			'id_base' => 'example-widget'
		);
		
		/* Create the widget. */
		$this->WP_Widget('recentCategoryPosts', __('Recent Category Posts'), $widget_ops, $control_opts);
		
	}
	
	/**
	 * Display the widget on the screen.
	 */
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
 
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$number = empty($instance['number']) ? 10 : $instance['number'];
		$show_images = $instance['show_images'];
		
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		?>
		<div class="box recentPosts">
			<h3 id="photos"><?php echo $text; ?></h3>
			<ul>
				<?php
				
				// Featured Headlines Loop
				/*global $options;
				foreach ($options as $value) {
					if (get_settings($value['id']) === FALSE) {
						$$value['id'] = $value['std'];
					} else {
						$$value['id'] = get_settings($value['id']); 
					}
				}
				$cat = $ts_featured_headlines_id;*/
				if ($instance['cat_ID']) {
					$cat = $instance['cat_ID'];
				}
				$my_query = new WP_Query("cat=$cat&showposts=$number");
				while ($my_query->have_posts()) : $my_query->the_post(); 
				?>
				<li class="clearfix">
					<div class="item">
						<h4><a href="<?PHP the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<?php
						if ($show_images) {
							$attachments = get_children(array(
								'post_parent' => get_the_id(),
								'post_status' => 'inherit',
								'post_type' => 'attachment',
								'post_mime_type' => 'image',
								'order' => 'ASC',
								'orderby' => 'menu_order ID',
								'numberposts' => 1
							));
							foreach($attachments as $key => $attachment) {
							?>
								<p><a href="<?PHP the_permalink(); ?>"><?php print wp_get_attachment_image($key, "medium"); ?></a></p>
							<?PHP
							}
						}
						?>
						<?PHP the_excerpt(); ?>
					</div>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php
		echo $after_widget;
	}
	
	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
		$instance['show_images'] = $new_instance['show_images'];
		$instance['cat_ID'] = (int) $new_instance['cat_ID'];
 
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Recent Posts'), 'number' => '5', 'show_images' => true );
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$categories = get_categories();
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of items:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo attribute_escape($instance['number']); ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_images'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Show images?'); ?></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('cat_ID'); ?>"><?php _e('Category:'); ?></label>
		<select name="<?php echo $this->get_field_name('cat_ID'); ?>" id="<?php echo $this->get_field_id('cat_ID'); ?>">
			<option value="">All</option>
			<?PHP foreach ($categories as $cat) { ?>
			<option value="<?PHP echo $cat->cat_ID; ?>"<?php selected( $instance['cat_ID'], $cat->cat_ID ); ?>><?PHP echo $cat->name; ?></option>
			<?PHP } ?>
		</select>
		</p>
		<?php
	}
}

/**
 * Register our widget.
 */
register_widget('RecentCategoryPosts_Widget');