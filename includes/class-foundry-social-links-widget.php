<?php
/**
 * Social Network Links Widget Class
 *
 * @package Foundry Social Networks Links
 * @category Core
 * @author Performance Foundry
 */

/**
 * Create Widget extending WP_Widget Class
 */
class Foundry_Social_Links_Widget extends WP_Widget {

	/**
	 * Available social networks
	 *
	 * @var array
	 */
	public $social_networks = array();
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		parent::__construct(
			'foundry_social_links',
			__( 'Foundry Social Networks Links', 'foundry-social-links' ),
			array( 'description' => __( 'Adds social networks icons and links', 'foundry-social-links' ) )
		);

	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args .
	 * @param array $instance .
	 */
	public function widget( $args, $instance ) {

		$display_name = false;

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', esc_html( $instance['title'] ) ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( isset( $instance['display_name'] ) && $instance['display_name'] ) {
			$display_name = true;
		}

		foundry_SL()->front_end->the_social_networks( $display_name );

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options.
	 */
	public function form( $instance ) {

		$title      = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		$is_checked = ( isset( $instance['display_name'] ) && $instance['display_name'] ) ? 'checked="checked"' : '';
		?>

		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'foundry-social-links' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'display_name' ) ); ?>"><?php esc_html_e( 'Display Social Network Names:', 'foundry-social-links' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'display_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'display_name' ) ); ?>" type="checkbox" value="true" <?php echo esc_html( $is_checked ); ?>">
		</p>

		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options.
	 * @param array $old_instance The previous options.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';

		$instance['display_name'] = ( isset( $new_instance['display_name'] ) ) ? true : false;

		return $instance;

	}
}

/**
 * Register Widget
 */
function register_foundry_social_links() {
	register_widget( 'Foundry_Social_Links_Widget' );
}
add_action( 'widgets_init', 'register_foundry_social_links' );
