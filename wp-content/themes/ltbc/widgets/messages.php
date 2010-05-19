<?php
/**
 * Messages List Widget.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 */
class Messages_List_Widget extends WP_Widget {
	
	/**
	 * Widget setup.
	 */
	function Messages_List_Widget() {
		
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'messages-list',
			'description' => __('A list of messages')
		);
		
		/* Widget control settings. */
		$control_ops = array(
			'width' => 300,
			'height' => 350,
			'id_base' => 'messages-list'
		);
		
		/* Create the widget. */
		$this->WP_Widget('messages-list', __('Messages List'), $widget_ops, $control_opts);
	}
	
	/**
	 * Display the widget on the screen.
	 */
	function widget($args, $instance) {
		global $page;
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
		$args = array(
			'post_type' => 'attachment',
			'post_status' => null,
			'post_parent' => 9,
		);
		if ($instance['number']) {
			$args['numberposts'] = $instance['number'];
		}
		$attachments = get_posts($args);
		$autoplay = false;
		if ($instance['full'] === true) {
			$play = $attachments[0];
			if (preg_match("/(\d+)\/?$/", $_SERVER['REQUEST_URI'], $matches)) {
				foreach($attachments as $a) {
					if ($a->ID == $matches[1]) {
						$autoplay = true;
						$play = $a;
						break;
					}
				}
			}
		?>
		<div class="box player">
			<p>Currently Playing: <?PHP echo $play->post_title; ?></p>
			<object type="application/x-shockwave-flash" data="<?PHP bloginfo('template_directory'); ?>/maxi/player_mp3_maxi.swf" width="748" height="20">
				<param name="movie" value="<?PHP bloginfo('template_directory'); ?>/maxi/player_mp3_maxi.swf" />
				<param name="bgcolor" value="#ffffff" />
				<param name="FlashVars" value="mp3=<?php print $play->guid; ?>&amp;width=748<?PHP if ($autoplay) { ?>&amp;autoplay=1<?PHP } else { ?>&amp;autoload=1<?PHP } ?>" />
			</object>
		</div>
		<div class="box">
			<table>
				<tr>
					<th>Title</th>
					<th>Speaker</th>
					<th width="150">Date</th>
					<th width="110"></th>
				</tr>
				<?PHP
				foreach($attachments as $post) :
				?>
				<tr>
					<td><strong><a href="/messages/<?php print $post->ID; ?>"><?php print $post->post_title; ?></a></strong><br /><?php print $post->post_content; ?></td>
					<td><?php print $post->post_excerpt; ?></td>
					<td><?php print date('F jS, Y', strtotime($post->post_date)); ?></td>
					<td><a href="/messages/<?php print $post->ID; ?>">Listen</a> | <a href="<?php print $post->guid; ?>">Download</a></td>
				</tr>
				<?PHP endforeach; ?>
			</table>
		</div>

		<?PHP } else { ?>
			<h2>Latest Messages</h2>
			<ul class="itemlist">
			<?PHP
			foreach($attachments as $post) :
			?>
			<li><strong>&quot;<a href="/messages/<?php print $post->ID; ?>"><?php print $post->post_title; ?></a>&quot;</strong> <?php print date('F jS, Y', strtotime($post->post_date)); ?><br>
			<?php print $post->post_content; ?><br><?php print $post->post_excerpt; ?></li>
			<?PHP endforeach; ?>
			</ul>
		<?php
		}
		echo $after_widget;
	}
	
	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['number'] = $new_instance['number'];
		return $instance;
	}
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array('number' => '5');
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		?>
		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number to Show:'); ?></label>
		<input type="text" name="<?php echo $this->get_field_name('number'); ?>" id="<?php echo $this->get_field_id('number'); ?>" value="<?PHP echo $instacne['number']; ?>" />
		</p>
		<?php
	}
}

/**
 * Register our widget.
 */
register_widget('Messages_List_Widget');