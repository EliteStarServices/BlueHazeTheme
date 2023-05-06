<?php

// This file was adapted from 'widget.php', originally part of the QuadLayers WP Menu Icons plugin (https://quadlayers.com)

if ( ! class_exists( 'BH_Widget' ) ) {

	class BH_Widget {

		protected static $instance;

		public function __construct() {
			if ( is_admin() ) {
				add_action( 'wp_network_dashboard_setup', array( $this, 'add_dashboard_widget' ), -10 );
				add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard_widget' ), -10 );
			}
		}

		public function add_dashboard_widget() {
			wp_add_dashboard_widget(
				'elitestar-dashboard-overview',
				__( 'Elite Star News', 'blue-haze' ),
				array( $this, 'display_dashboard_widget' )
			);
		}

		public function display_dashboard_widget() {
			$posts = $this->get_feed();

			?>
		<div>
			<div>
				<div style="margin-top: 11px;float: left;">
					<b><?php esc_html_e( 'I hope you are finding our Blue Haze theme beneficial!', 'blue-haze' ); ?></b><br>
					<?php esc_html_e( 'Elite Star has been working with WordPress for over 15 years.', 'blue-haze' ); ?><br>
					<?php esc_html_e( 'Follow the news to learn more about our products & projects.', 'blue-haze' ); ?>
				</div>
							</div>
			<div style="clear: both;"></div>
		</div>
		<div style="margin: 16px -12px 0; padding: 12px 12px 0;border-top: 1px solid #eee;">
			<ul>
				<?php if ( is_array( $posts ) ) { ?>
					<?php
					foreach ( $posts  as $post ) {

						$link = $post['link'];
						while ( stristr( $link, 'http' ) !== $link ) {
							$link = substr( $link, 1 );
						}

//						$link  = esc_url( strip_tags( $link . '?utm_source=bh_dashboard' ) );
						$link  = esc_url( strip_tags( $link ) );
						$title = esc_html( trim( strip_tags( $post['title'] ) ) );

						if ( empty( $title ) ) {
							$title = __( 'Untitled', 'blue-haze' );
						}

						$excerpt = esc_attr( wp_trim_words( $post['excerpt'], 18, '...' ) );
						$summary = '<p class="rssSummary">• ' . $excerpt . '</p>';
						$date    = $post['date'];
						if ( $date ) {
							$date = '<span class="rss-date"><small>' . date_i18n( get_option( 'date_format' ), $date ) . '</small></span>';
						}

						printf( __( '<li><strong><a href="%1$s">%2$s</a></strong><br>%3$s%4$s</li>', 'blue-haze' ), $link, $title, $date, $summary );
					}
					?>
					<?php
				} else {
					printf( __( '<li>%s</li>', 'blue-haze' ), $posts );
				}
				?>
			</ul>
		</div>
		<div style="display: flex; justify-content: space-between;align-items: center;margin: 16px -12px 0;padding: 12px 12px 0; border-top: 1px solid #eee;">
			<?php esc_html_e( 'Please visit our website.', 'blue-haze' ); ?>
			<a class="button-primary" href="<?php printf( 'https://elite-star-services.com', 'blue-haze' ); ?>"><?php esc_html_e( 'Elite Star Services', 'blue-haze' ); ?></a>
		</div>
			<?php
		}

		public function get_feed() {

			$posts = get_transient( 'elitestar_news_feed' );

			if ( false === $posts ) {

				$response = wp_remote_get( 'https://elite-star-services.com/wp-json/wp/v2/posts?categories=1&per_page=1' );

				if ( is_wp_error( $response ) || ! isset( $response['body'] ) ) {
					return 'An error has occurred, which probably means the feed is down. Try again later';
				}

				$posts_array = json_decode( wp_remote_retrieve_body( $response ), true );

				if ( ! is_array( $posts_array ) ) {
					return 'An error has occurred, which probably means the feed is down. Try again later';
				}

				$posts = array();

				foreach ( $posts_array as $post ) {
					$posts[] = array(
						'link'    => $post['link'],
						'title'   => $post['title']['rendered'],
						'excerpt' => $post['excerpt']['rendered'],
						'date'    => strtotime( $post['date'], time() ),
					);
				}

				set_transient( 'elitestar_news_feed', $posts, DAY_IN_SECONDS );
			}

			return $posts;
		}

		public static function instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}

	BH_Widget::instance();

}
