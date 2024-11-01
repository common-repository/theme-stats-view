<?php
/**
 * Theme Stats View
 *
 * @package    Theme Stats View
 * @subpackage ThemeStatsView Main Functions
/*
	Copyright (c) 2020- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

$themestatsview = new ThemeStatsView();

/** ==================================================
 * Main Functions
 */
class ThemeStatsView {

	/** ==================================================
	 * Construct
	 *
	 * @since 1.00
	 */
	public function __construct() {

		add_filter( 'block_categories', array( $this, 'theme_stats_view_category' ), 10, 2 );
		add_action( 'init', array( $this, 'tsview_block_init' ) );
		add_action( 'init', array( $this, 'taview_block_init' ) );
		add_action( 'enqueue_block_assets', array( $this, 'load_style' ) );
		add_shortcode( 'tsview', array( $this, 'tsview_shortcode' ) );
		add_shortcode( 'taview', array( $this, 'taview_shortcode' ) );
	}

	/** ==================================================
	 * Original category for block
	 *
	 * @param array  $categories  categories.
	 * @param object $post  post.
	 * @since 1.01
	 */
	public function theme_stats_view_category( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'theme-stats-view',
					'title' => 'Theme Stats View',
					'icon' => 'chart-line',
				),
			)
		);
	}

	/** ==================================================
	 * Attribute block
	 *
	 * @since 1.00
	 */
	public function tsview_block_init() {

		register_block_type(
			plugin_dir_path( __DIR__ ) . 'block/build/tsview-block',
			array(
				'render_callback' => array( $this, 'tsview_shortcode' ),
				'title' => _x( 'Single Theme', 'block title', 'theme-stats-view' ),
				'description' => _x( 'The stats of theme is displayed.', 'block description', 'theme-stats-view' ),
				'keywords' => array(
					_x( 'theme', 'block keyword', 'theme-stats-view' ),
					_x( 'stats', 'block keyword', 'theme-stats-view' ),
				),
			)
		);

		$script_handle = generate_block_asset_handle( 'theme-stats-view/tsview-block', 'editorScript' );
		wp_set_script_translations( $script_handle, 'theme-stats-view' );
	}

	/** ==================================================
	 * Attribute block
	 *
	 * @since 1.01
	 */
	public function taview_block_init() {

		register_block_type(
			plugin_dir_path( __DIR__ ) . 'block/build/taview-block',
			array(
				'render_callback' => array( $this, 'taview_shortcode' ),
				'title' => _x( 'Multi Themes', 'block title', 'theme-stats-view' ),
				'description' => _x( 'The stats of theme is displayed.', 'block description', 'theme-stats-view' ),
				'keywords' => array(
					_x( 'theme', 'block keyword', 'theme-stats-view' ),
					_x( 'stats', 'block keyword', 'theme-stats-view' ),
				),
			)
		);

		$script_handle = generate_block_asset_handle( 'theme-stats-view/taview-block', 'editorScript' );
		wp_set_script_translations( $script_handle, 'theme-stats-view' );
	}

	/** ==================================================
	 * Short code
	 *
	 * @param array  $atts  atts.
	 * @param string $content  content.
	 * @return string $content
	 * @since 1.00
	 */
	public function tsview_shortcode( $atts, $content = null ) {

		$a = shortcode_atts(
			array(
				'slug'  => '',
				'view' => '',
				'link' => '',
				'open' => '',
			),
			$atts
		);

		$this->get_access_url();

		return $this->single_stats( $a, $content = null );
	}

	/** ==================================================
	 * Short code
	 *
	 * @param array  $atts  atts.
	 * @param string $content  content.
	 * @return string $content
	 * @since 1.01
	 */
	public function taview_shortcode( $atts, $content = null ) {

		$a = shortcode_atts(
			array(
				'slug'  => '',
				'link' => '',
				'totalonly' => '',
			),
			$atts
		);

		$this->get_access_url();

		return $this->all_stats( $a, $content = null );
	}

	/** ==================================================
	 * Get access url
	 *
	 * @since 1.13
	 */
	private function get_access_url() {

		$post_id = get_the_ID();
		$post_ids = get_option( 'tsview_access_ids', array() );
		if ( ! in_array( $post_id, $post_ids ) ) {
			$post_ids[] = $post_id;
			update_option( 'tsview_access_ids', $post_ids );
		}
	}

	/** ==================================================
	 * Single stats
	 *
	 * @param array  $a  a.
	 * @param string $content  content.
	 * @return string $content
	 * @since 1.01
	 */
	public function single_stats( $a, $content = null ) {

		$slug = $a['slug'];
		$view = $a['view'];
		$link = $a['link'];
		$open = $a['open'];

		if ( ! empty( $slug ) ) {

			$call_apis = $this->cache( $slug );

			if ( ! empty( $call_apis ) ) {
				if ( is_null( $view ) ) {
					$view = 'normal';
				}
				if ( ! empty( $link ) ) {
					if ( false !== strpos( $link, '%slug%' ) ) {
						$homepage = str_replace( '%slug%', $slug, $link );
					} else {
						$homepage = $link;
					}
				} else {
					$homepage = $call_apis['homepage'];
				}

				$version = $call_apis['version'];
				$author_url = '<a href=' . esc_url( $call_apis['author_url'] ) . '>' . esc_html( $call_apis['author_name'] ) . '</a>';
				$requires_php = $call_apis['requires_php'];
				$requires = $call_apis['requires'];
				$download_link = $call_apis['download_link'];
				$rating = $call_apis['rating'];
				$lastupdated = human_time_diff( strtotime( $call_apis['last_updated'] ), time() ) . __( ' ago', 'theme-stats-view' );
				/* translators: stars */
				$ratings_text = sprintf( __( '%1$s out of %2$d stars', 'theme-stats-view' ), number_format( $call_apis['rating'], 1 ), 5 );

				$num_ratings = null;
				if ( 'simple' <> $view ) {
					$num_ratings = '(' . $call_apis['num_ratings'] . ')';
				}

				$active_installs = null;
				if ( $call_apis['active_installs'] > 10 && $call_apis['active_installs'] < 1000000 ) {
					$active_installs .= number_format( $call_apis['active_installs'] ) . __( '+ ', 'theme-stats-view' ) . __( 'active installs', 'theme-stats-view' );
				} else if ( $call_apis['active_installs'] >= 1000000 ) {
					/* translators: active install */
					$active_installs .= sprintf( __( '%1$d+ million', 'theme-stats-view' ), floor( $call_apis['active_installs'] / 1000000 ) ) . __( 'active installs', 'theme-stats-view' );
				} else {
					$active_installs .= number_format( $call_apis['downloaded'] ) . __( 'Download', 'theme-stats-view' );
				}

				$screenshot_url = null;
				$description = null;
				$short_description = null;
				$name = $call_apis['name'];
				if ( is_array( $call_apis['screenshots'] ) ) {
					$screenshot_url = array_pop( $call_apis['screenshots'] );
				} else {
					$screenshot_url = $call_apis['screenshots'];
				}
				if ( 'normal' == $view ) {
					$description = $call_apis['description'];
				}
				if ( 'normal' == $view || 'card' === $view ) {
					$plus_str = null;
					if ( function_exists( 'mb_substr' ) ) {
						if ( 64 < mb_strlen( $call_apis['description'] ) ) {
							$plus_str = '...';
						}
						$short_description = mb_substr( wp_strip_all_tags( $call_apis['description'], true ), 0, 64 ) . $plus_str;
					} else {
						if ( 64 < strlen( $call_apis['description'] ) ) {
							$plus_str = '...';
						}
						$short_description = substr( wp_strip_all_tags( $call_apis['description'], true ), 0, 64 ) . $plus_str;
					}
				}
				$tags = array();
				$tag_text = null;
				foreach ( $call_apis['tags'] as $key => $value ) {
					$tags[] = $value;
				}
				if ( ! empty( $tags ) ) {
					$tag_text = implode( ',', $tags );
				}

				list( $template_html_file_name, $css_file_name ) = $this->select_template( get_option( 'theme_stats_view_template', 'default' ), $view );

				$template_html_file = apply_filters( 'theme_stats_view_generate_template_html_' . $view . '_file', plugin_dir_path( __DIR__ ) . 'template/' . $template_html_file_name );

				ob_start();
				include $template_html_file;
				$content = ob_get_contents();
				ob_end_clean();
			}
		} elseif ( is_user_logged_in() ) {
			$content .= '<div style="text-align: center;">';
			$content .= '<div><strong><span class="dashicons dashicons-chart-line" style="position: relative; top: 5px;"></span>Theme Stats View</strong></div>';
			/* translators: Input Slug */
			$content .= esc_html( sprintf( __( 'Please input "%1$s".', 'theme-stats-view' ), __( 'Slug' ) ) );
			$content .= '</div>';
		}
		return $content;
	}

	/** ==================================================
	 * All stats
	 *
	 * @param array  $a  a.
	 * @param string $content  content.
	 * @return string $content
	 * @since 1.01
	 */
	public function all_stats( $a, $content = null ) {

		$link = $a['link'];
		$totalonly = $a['totalonly'];

		if ( ! empty( $a['slug'] ) ) {
			$slugs = explode( ',', $a['slug'] );
			sort( $slugs );
			$active_installs = 0;
			$downloadeds = 0;
			$all_ratings = array(
				5 => 0,
				4 => 0,
				3 => 0,
				2 => 0,
				1 => 0,
			);
			$full_rate_count = 0;
			$count = 0;
			$stats_arr = array();
			foreach ( $slugs as $slug ) {
				$call_apis = $this->cache( $slug );
				if ( ! empty( $call_apis ) ) {
					if ( ! $totalonly ) {
						if ( ! empty( $link ) ) {
							if ( false !== strpos( $link, '%slug%' ) ) {
								$stats_arr[ $count ]['homepage'] = str_replace( '%slug%', $slug, $link );
							} else {
								$stats_arr[ $count ]['homepage'] = $link;
							}
						} else {
							$stats_arr[ $count ]['homepage'] = $call_apis['homepage'];
						}
						if ( is_array( $call_apis['screenshots'] ) ) {
							$stats_arr[ $count ]['screenshot_url'] = array_pop( $call_apis['screenshots'] );
						} else {
							$stats_arr[ $count ]['screenshot_url'] = $call_apis['screenshots'];
						}

						$stats_arr[ $count ]['name'] = $call_apis['name'];
						$stats_arr[ $count ]['rating'] = $call_apis['rating'];

						/* translators: stars */
						$stats_arr[ $count ]['ratings_text'] = sprintf( __( '%1$s out of %2$d stars', 'theme-stats-view' ), number_format( $call_apis['rating'], 1 ), 5 );

						if ( $call_apis['active_installs'] > 10 && $call_apis['active_installs'] < 1000000 ) {
							$stats_arr[ $count ]['active_installs'] = number_format( $call_apis['active_installs'] ) . esc_html__( '+ ', 'theme-stats-view' ) . esc_html__( 'active installs', 'theme-stats-view' );
						} else if ( $call_apis['active_installs'] >= 1000000 ) {
							/* translators: active install */
							$stats_arr[ $count ]['active_installs'] = esc_html( sprintf( __( '%1$d+ million', 'theme-stats-view' ), floor( $call_apis['active_installs'] / 1000000 ) ) . __( 'active installs', 'theme-stats-view' ) );
						} else {
							$stats_arr[ $count ]['active_installs'] = number_format( $call_apis['downloaded'] ) . esc_html__( 'Download', 'theme-stats-view' );
						}
					}

					$active_installs += $call_apis['active_installs'];
					$downloadeds += $call_apis['downloaded'];
					foreach ( $call_apis['ratings'] as $rate_no => $rate_count ) {
						$all_ratings[ $rate_no ] += $rate_count;
						$full_rate_count += $rate_count;
					}
					++$count;
				}
			}

			if ( 0 < $full_rate_count ) {
				$rate_num_text = array();
				$all_per = array();
				$all_rate = array();
				foreach ( $all_ratings as $rate_no => $all_rate_count ) {
					$stars = __( 'stars', 'theme-stats-view' );
					if ( 1 == $rate_no ) {
						$stars = __( 'star ', 'theme-stats-view' );
					}
					$rate_num_text[ $rate_no ] = $rate_no . $stars;
					$all_per[ $rate_no ] = round( $all_rate_count / $full_rate_count * 100 );
					$all_rate[ $rate_no ] = number_format( $all_rate_count );
				}
			}

			$view = 'all';
			list( $template_html_file_name, $css_file_name ) = $this->select_template( get_option( 'theme_stats_view_template', 'default' ), $view );

			$template_html_file = apply_filters( 'theme_stats_view_generate_template_html_' . $view . '_file', plugin_dir_path( __DIR__ ) . 'template/' . $template_html_file_name );

			ob_start();
			include $template_html_file;
			$content = ob_get_contents();
			ob_end_clean();
		} elseif ( is_user_logged_in() ) {
			$content .= '<div style="text-align: center;">';
			$content .= '<div><strong><span class="dashicons dashicons-chart-line" style="position: relative; top: 5px;"></span>Theme Stats View</strong></div>';
			/* translators: Input Slugs */
			$content .= esc_html( sprintf( __( 'Please input "%1$s" separated by commas.', 'theme-stats-view' ), __( 'Slug' ) ) );
			$content .= '</div>';
		}
		return $content;
	}

	/** ==================================================
	 * Cache read or create
	 *
	 * @param string $slug  slug.
	 * @return array $call_apis
	 * @since 1.00
	 */
	private function cache( $slug ) {

		$call_apis = array();
		if ( get_transient( 'tsview_datas_' . $slug . '_' . get_locale() ) ) {
			/* Get cache */
			$call_apis = get_transient( 'tsview_datas_' . $slug . '_' . get_locale() );
		} else {
			/* Call API */
			require_once ABSPATH . 'wp-admin/includes/theme.php';
			$call_api = themes_api(
				'theme_information',
				array(
					'slug' => $slug,
					'fields' => array(
						'active_installs' => true,
						'downloaded' => true,
						'screenshot_url' => true,
						'sections' => true,
						'ratings' => true,
					),
				)
			);
			if ( is_wp_error( $call_api ) ) {
				$dummy = 0; /* skip */
			} else {
				$screenshot = $call_api->screenshot_url;
				if ( 0 === strncmp( $screenshot, '//', 2 ) ) {
					if ( is_ssl() ) {
						$screenshot = 'https:' . $screenshot;
					} else {
						$screenshot = 'http:' . $screenshot;
					}
				}
				$call_apis = array(
					'name' => $call_api->name,
					'description' => $call_api->sections['description'],
					'tags' => $call_api->tags,
					'screenshots' => $screenshot,
					'author_name' => $call_api->author['user_nicename'],
					'author_url' => $call_api->author['profile'],
					'version' => $call_api->version,
					'homepage' => $call_api->homepage,
					'requires' => $call_api->requires,
					'requires_php' => $call_api->requires_php,
					'last_updated' => $call_api->last_updated,
					'rating' => 5 * ( $call_api->rating / 100 ),
					'num_ratings' => $call_api->num_ratings,
					'ratings' => $call_api->ratings,
					'downloaded' => $call_api->downloaded,
					'download_link' => $call_api->download_link,
					'active_installs' => $call_api->active_installs,
				);

				/* Set cache */
				set_transient( 'tsview_datas_' . $slug . '_' . get_locale(), $call_apis, 86400 );
			}
		}

		return $call_apis;
	}

	/** ==================================================
	 * Load Style
	 *
	 * @since 1.00
	 */
	public function load_style() {
		list( $template_html_file_name, $css_file_name ) = $this->select_template( get_option( 'theme_stats_view_template', 'default' ), $view = 'normal' );

		$css_url = apply_filters( 'theme_stats_view_css_url', plugin_dir_url( __DIR__ ) . 'template/' . $css_file_name );
		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( 'theme-stats-view', $css_url, array(), '1.00' );
	}

	/** ==================================================
	 * Select Template & CSS
	 *
	 * @param string $slug  slug.
	 * @param string $view  view type.
	 * @return array $template_file_name, $css_file_name  filename.
	 * @since 2.00
	 */
	private function select_template( $slug, $view ) {

		$templates = $this->load_templates();

		$template_html_file_name = $templates['templates'][0]['files'][ 'template_html_' . $view ];
		$css_file_name = $templates['templates'][0]['files']['css'];
		foreach ( $templates as $key => $value ) {
			foreach ( $value as $value2 ) {
				if ( $slug === $value2['slug'] ) {
					if ( ! empty( $value2['files'][ 'template_html_' . $view ] ) ) {
						$template_html_file_name = $value2['files'][ 'template_html_' . $view ];
					}
					if ( ! empty( $value2['files']['css'] ) ) {
						$css_file_name = $value2['files']['css'];
					}
				}
			}
		}

		return array( $template_html_file_name, $css_file_name );
	}

	/** ==================================================
	 * Load Templates
	 *
	 * @return array $templates  templates.
	 * @since 2.00
	 */
	public function load_templates() {

		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
		$wp_filesystem = new WP_Filesystem_Direct( false );

		$json = $wp_filesystem->get_contents( plugin_dir_path( __DIR__ ) . 'template/templates.json' );
		$templates = json_decode( $json, true );

		return $templates;
	}
}
