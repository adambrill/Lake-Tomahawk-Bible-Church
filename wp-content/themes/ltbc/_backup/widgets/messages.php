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
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		$carouselType = (true) ? 'page' : 'item';
		$q = array();
		if ($instance['cat_ID']) {
			array_push($q, 'cat=' . $instance['cat_ID']);
		}
		if ($instance['number']) {
			array_push($q, 'showposts=' . $instance['number']);
		}
		$my_query = new WP_Query(implode('&', $q));
		?>
		<div class="box carousel <?php echo $carouselType; ?>">
			<?php
			if ($carouselType == 'page' && $my_query->post_count) {
				echo '<ul class="jcarousel-control">';
				for ($i=0; $i<$my_query->post_count; $i++) {
					echo '<li><a href="#"><span>' . ($i+1) . '</span></a></li>';
				}
				echo '</ul>';
			}
			?>
			<ul id="carousel">
				<?php
				/*$q = array();
				if ($instance['cat_ID']) {
					array_push($q, 'cat=' . $instance['cat_ID']);
				}
				if ($instance['number']) {
					array_push($q, 'showposts=' . $instance['number']);
				}
				$my_query = new WP_Query(implode('&', $q));*/
				while ($my_query->have_posts()) : $my_query->the_post(); $do_not_duplicate = $post->ID;
				?>
				<li>
					<?php
					if ($carouselType == 'page') {
					?>
						<?php the_content(); ?>
					<?php
					} else {
					?>
					<div class="content">
						<div class="text">
							<h2><a href="javascript:void(0);"><?php the_title(); ?></a></h2>
							<h3><?PHP echo get_post_meta(get_the_ID(), 'user_title', true); ?></h3>
							<div class="moreInfo" style="display:none;">
								<div class="post_box top">
									<div class="headline_area">
										<h1><?php the_title(); ?></h1>
									</div>
									<div class="format_text">
										<?php the_content(); ?>
									</div>
								</div>
							</div>
						</div>
						<?PHP
						$post_image = thesis_post_image_info('image');
						echo $post_image['output'];
						?>
					</div>
					<?php } ?>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>
		
		<script type="text/javascript">
		<?php if ($carouselType == 'page') { ?>
		$(document).ready(function() {
			$('#carousel').jcarousel({
				scroll: 1,
				wrap: 'both',
				buttonNextHTML: '',
				buttonPrevHTML: '',
				initCallback: function(carousel) {
					$('.jcarousel-control a').bind('click', function() {
						$('.jcarousel-control li').removeClass('selected');
						$(this).parent().addClass('selected');
						carousel.scroll($.jcarousel.intval($(this).text()));
						return false;
					});
				},
				itemVisibleInCallback: {
					onAfterAnimation: function(carousel, item, idx, state) {
						/*var h = $('img', item).height();
						$('.jcarousel-item').height(h);*/
						$('.jcarousel-control li').removeClass('selected');
						$('.jcarousel-control a.item_'+idx).parent().addClass('selected');
					}
				}
			});
		});
		<?php } else { ?>
		$(document).ready(function() {
			$('#carousel').jcarousel({
				scroll: 1,
				wrap: 'both'
			});
			var content = $("#content");
			$('#carousel li').click(function() {
				var $this = $(this);
				$('#carousel li').removeClass('selected');
				$this.addClass('selected');
				content.detach();
				//console.log($this.find("div.moreInfo").html());
				$("#carousel_content_wrapper").html($this.find("div.moreInfo").html());
				return false;
			});
		});
		<?php } ?>
		</script>
		<?php
		echo $after_widget;
	}
	
	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
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
		$defaults = array('cat_ID' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$categories = get_categories();
		?>
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
register_widget('Messages_List_Widget');