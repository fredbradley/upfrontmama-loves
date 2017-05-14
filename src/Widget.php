<?php

namespace UpfrontMama\Loves;

use WP_Query;

class Widget extends \WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname' => 'upfront-mama-loves',
			'description' => 'Upfront Mama Loves Widget'
		);
		parent::__construct('upfront-mama-loves', 'Upfront Mama Loves', $widget_ops);
	}

	function widget($args, $instance) {

		$a = shortcode_atts(
			array(
				"post_type" => "upfrontmamaloves",
				"posts_per_page"=>5
			),
			$instance
		);

		$post_args = [
			"post_type" => $a['post_type'],
			"posts_per_page" => $a['posts_per_page'],
		];

		if (
			(isset($instance['include_terms']) && !empty($instance['include_terms'])) || 
			(isset($instance['exclude_terms']) && !empty($instance['exclude_terms']))
			) {
			$post_args['tax_query'] = [
				"relation" => "OR",
				[
				"taxonomy" => 'love-categories',
				'field' => 'slug',
				'terms' => explode(",", $instance['include_terms'])
				],
				[
				"taxonomy" => 'love-categories',
				'field' => 'slug',
				'terms' => explode(",", $instance['exclude_terms']),
				'operator' => 'NOT IN'
				],
			];
		}

		$query = new WP_Query($post_args);

		if ($query->post_count < 1) {
			echo '<!-- HIDE BECAUSE THERE IS NO POSTS TO DISPLAY -->';
			return false;
		}
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
		echo '<div class="upfront-mama-loves-list">';
		echo '<ul id="pipdig-widget-popular-posts">';
		
		while($query->have_posts()): $query->the_post();
		?>
			<li>			
				<a href="<?php echo get_post_meta(get_the_ID(), 'ufm_loves_url', true); ?>">
					<?php
						$thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'pipdig-mosaic' );
						?>
					<div class="p3_cover_me" style="background-image:url(<?php echo $thumbnail; ?>)">
							<?php the_post_thumbnail( 'pipdig-mosaic', ["class"=>"p3_invisible"]); ?>
					</div>
					<h4><?php the_title(); ?></h4>
				</a>
			</li>
		<?php endwhile;
			
			wp_reset_postdata();
			echo "</ul>";
			echo "</div>";


		echo $args['after_widget'];
	}

	function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['posts_per_page'] = (!empty($new_instance['posts_per_page'])) ? strip_tags($new_instance['posts_per_page']):'';
		$instance['include_terms'] = (!empty($new_instance['include_terms'])) ? strip_tags($new_instance['include_terms']):'';
		$instance['exclude_terms'] = (!empty($new_instance['exclude_terms'])) ? strip_tags($new_instance['exclude_terms']):'';

		return $instance;
	}

	function form($instance) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Recent Posts', 'upfront-mama' );
		$posts_per_page = ! empty( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : 5;
		$include_terms = ! empty( $instance['include_terms'] ) ? $instance['include_terms'] : '';
		$exclude_terms = ! empty( $instance['exclude_terms'] ) ? $instance['exclude_terms'] : '';

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_per_page' ) ); ?>"><?php _e( esc_attr( '# Posts to show:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'posts_per_page' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_per_page' ) ); ?>" type="number" placeholder="5" value="<?php echo esc_attr( $posts_per_page ); ?>">
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'include_terms' ) ); ?>"><?php _e( esc_attr( 'Included Term Slugs:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'include_terms' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'include_terms' ) ); ?>" type="text" value="<?php echo esc_attr( $include_terms ); ?>">
			<small>Comma separated list of slugs to look for</small>
		</p>
	 	<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_terms' ) ); ?>"><?php _e( esc_attr( 'Excluded Term Slugs:' ) ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'exclude_terms' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude_terms' ) ); ?>" type="text" value="<?php echo esc_attr( $exclude_terms ); ?>">
			<small>Comma separated list of slugs to look for</small>
		</p>
		<?php
	}


}


