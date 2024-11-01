<?php
/**
 * Theme Stats View
 *
 * @package    Theme Stats View
 * @subpackage ThemeStatsViewAdmin Management screen
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

$themestatsviewadmin = new ThemeStatsViewAdmin();

/** ==================================================
 * Management screen
 */
class ThemeStatsViewAdmin {

	/** ==================================================
	 * Construct
	 *
	 * @since 1.00
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'plugin_menu' ) );
		add_filter( 'plugin_action_links', array( $this, 'settings_link' ), 10, 2 );

		/* Original hook */
		add_action( 'tsview_delete_all_cache', array( $this, 'delete_all_cache' ) );
	}

	/** ==================================================
	 * Add a "Settings" link to the plugins page
	 *
	 * @param  array  $links  links array.
	 * @param  string $file   file.
	 * @return array  $links  links array.
	 * @since 1.00
	 */
	public function settings_link( $links, $file ) {
		static $this_plugin;
		if ( empty( $this_plugin ) ) {
			$this_plugin = 'theme-stats-view/themestatsview.php';
		}
		if ( $file == $this_plugin ) {
			$links[] = '<a href="' . admin_url( 'options-general.php?page=ThemeStatsView' ) . '">' . __( 'Settings' ) . '</a>';
		}
		return $links;
	}

	/** ==================================================
	 * Settings page
	 *
	 * @since 1.00
	 */
	public function plugin_menu() {
		add_options_page( 'ThemeStatsView Options', 'Theme Stats View', 'manage_options', 'ThemeStatsView', array( $this, 'plugin_options' ) );
	}

	/** ==================================================
	 * Settings page
	 *
	 * @since 1.00
	 */
	public function plugin_options() {

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
		}

		$this->options_updated();

		$scriptname = admin_url( 'options-general.php?page=ThemeStatsView' );

		?>
		<div class="wrap">
			<h2>Theme Stats View</h2>

			<details>
			<summary><strong><?php esc_html_e( 'Various links of this plugin', 'theme-stats-view' ); ?></strong></summary>
			<?php $this->credit(); ?>
			</details>

			<h3><?php esc_html_e( 'How to use', 'theme-stats-view' ); ?></h3>
			<div style="margin: 0px 10px;"><?php esc_html_e( 'Please add new Page. Please insert a block or write a shortcode.', 'theme-stats-view' ); ?></div>

			<div style="margin: 0px 10px;">
				<h3><?php esc_html_e( 'Example of short code', 'theme-stats-view' ); ?></h3>

				<div style="margin: 0px 20px;"><strong><?php esc_html_e( 'Single Theme', 'theme-stats-view' ); ?></strong></div>
				<div style="margin: 5px 20px;"><code>[tsview slug="twentytwenty"]</code></div>
				<div style="margin: 5px 20px;"><code>[tsview slug="twentytwenty" view="simple" link="https://test.com/%slug%/"]</code></div>

				<div style="margin: 0px 40px;"><strong><?php esc_html_e( 'Description of each attribute', 'theme-stats-view' ); ?></strong></div>

				<ul style="list-style-type: disc; margin: 0px 60px;">
				<li><code>slug</code> <?php esc_html_e( 'Specifies the theme slug.', 'theme-stats-view' ); ?></li>
				<li><code>view</code> <?php echo esc_html( __( 'View style. Choose normal(Standard display), card(Card display) or simple(Simple display).', 'theme-stats-view' ) . ' ' . __( 'Default' ) ); ?>: <code>view="normal"</code></li>
				<li><code>link</code> <?php echo esc_html( __( 'You can specify the link destination of the theme name. If not specified, this is the theme homepage link. Can insert a slug tag in the URL of the link.', 'theme-stats-view' ) . ' ' . __( 'Default' ) ); ?>: <code>link=null</code> <?php esc_html_e( 'Tag' ); ?>: <code>%slug%</code></li>
				<li><code>open</code> <?php echo esc_html( __( 'Description style for normal view. Select true(View Description) or false(Hide Description).', 'theme-stats-view' ) . ' ' . __( 'Default' ) ); ?>: <code>open=false</code></li>
				</ul>

				<div style="margin: 0px 20px;"><strong><?php esc_html_e( 'Multi Themes', 'theme-stats-view' ); ?></strong></div>
				<div style="margin: 5px 20px;"><code>[taview slug="twentytwenty,twentynineteen,twentyseventeen"]</code></div>
				<div style="margin: 5px 20px;"><code>[taview slug="twentytwenty,twentynineteen,twentyseventeen" link="https://test.com/%slug%/"]</code></div>

				<div style="margin: 0px 40px;"><strong><?php esc_html_e( 'Description of each attribute', 'theme-stats-view' ); ?></strong></div>

				<ul style="list-style-type: disc; margin: 0px 60px;">
				<li><code>slug</code> <?php esc_html_e( 'Specify the slugs of multiple themes separated by a comma.', 'theme-stats-view' ); ?></li>
				<li><code>link</code> <?php echo esc_html( __( 'You can specify the link destination of the theme name. If not specified, this is the theme homepage link. Can insert a slug tag in the URL of the link.', 'theme-stats-view' ) . ' ' . __( 'Default' ) ); ?>: <code>link=null</code> <?php esc_html_e( 'Tag' ); ?>: <code>%slug%</code></li>
				<li><code>totalonly</code> <?php echo esc_html( __( 'Total graph only. Select true(View Total only) or false(View Full).', 'theme-stats-view' ) . ' ' . __( 'Default' ) ); ?>: <code>totalonly=false</code></li>
				</ul>

				<h3><?php esc_html_e( 'It will create a cache in one-day intervals for speedup. Please delete the cache if you want to display the most recent data.', 'theme-stats-view' ); ?></h3>

				<form style="padding:10px;" method="post" action="<?php echo esc_url( $scriptname ); ?>" />
					<?php wp_nonce_field( 'tsv_settings', 'themestatsview_settings' ); ?>
					<?php submit_button( __( 'Remove Cache', 'theme-stats-view' ), 'large', 'tsview_clear_cache', false ); ?>
				</form>

				<h3><?php esc_html_e( 'Can delete and regenerate the cache with the following WP-CLI command. It would be beneficial to register it with the server\'s cron.', 'theme-stats-view' ); ?></h3>
				<div style="margin: 0px 20px;"><strong>WP-CLI</strong></div>
				<div style="margin: 5px 20px;"><code>wp tsview_refresh</code></div>

				<h3><?php esc_html_e( 'Can specify your own output html template and its CSS using filter hooks, see the files in the template directory of plugin.', 'theme-stats-view' ); ?></h3>
				<div style="margin: 0px 20px;"><strong>HTML</strong></div>
				<div style="margin: 5px 20px;">
					<div style="line-height: 2em;"><code>theme_stats_view_generate_template_html_normal_file</code></div>
					<div style="line-height: 2em;"><code>theme_stats_view_generate_template_html_card_file</code></div>
					<div style="line-height: 2em;"><code>theme_stats_view_generate_template_html_simple_file</code></div>
					<div style="line-height: 2em;"><code>theme_stats_view_generate_template_html_all_file</code></div>
				</div>
				<div style="margin: 0px 20px;"><strong>CSS</strong></div>
				<div style="margin: 5px 20px;">
					<code>theme_stats_view_css_url</code>
				</div>

			</div>
		</div>
		<?php
	}

	/** ==================================================
	 * Credit
	 *
	 * @since 1.00
	 */
	private function credit() {

		$plugin_name    = null;
		$plugin_ver_num = null;
		$plugin_path    = plugin_dir_path( __DIR__ );
		$plugin_dir     = untrailingslashit( wp_normalize_path( $plugin_path ) );
		$slugs          = explode( '/', $plugin_dir );
		$slug           = end( $slugs );
		$files          = scandir( $plugin_dir );
		foreach ( $files as $file ) {
			if ( '.' === $file || '..' === $file || is_dir( $plugin_path . $file ) ) {
				continue;
			} else {
				$exts = explode( '.', $file );
				$ext  = strtolower( end( $exts ) );
				if ( 'php' === $ext ) {
					$plugin_datas = get_file_data(
						$plugin_path . $file,
						array(
							'name'    => 'Plugin Name',
							'version' => 'Version',
						)
					);
					if ( array_key_exists( 'name', $plugin_datas ) && ! empty( $plugin_datas['name'] ) && array_key_exists( 'version', $plugin_datas ) && ! empty( $plugin_datas['version'] ) ) {
						$plugin_name    = $plugin_datas['name'];
						$plugin_ver_num = $plugin_datas['version'];
						break;
					}
				}
			}
		}
		$plugin_version = __( 'Version:' ) . ' ' . $plugin_ver_num;
		/* translators: FAQ Link & Slug */
		$faq       = sprintf( __( 'https://wordpress.org/plugins/%s/faq', 'theme-stats-view' ), $slug );
		$support   = 'https://wordpress.org/support/plugin/' . $slug;
		$review    = 'https://wordpress.org/support/view/plugin-reviews/' . $slug;
		$translate = 'https://translate.wordpress.org/projects/wp-plugins/' . $slug;
		$facebook  = 'https://www.facebook.com/katsushikawamori/';
		$twitter   = 'https://twitter.com/dodesyo312';
		$youtube   = 'https://www.youtube.com/channel/UC5zTLeyROkvZm86OgNRcb_w';
		$donate    = __( 'https://shop.riverforest-wp.info/donate/', 'theme-stats-view' );

		?>
		<span style="font-weight: bold;">
		<div>
		<?php echo esc_html( $plugin_version ); ?> | 
		<a style="text-decoration: none;" href="<?php echo esc_url( $faq ); ?>" target="_blank" rel="noopener noreferrer">FAQ</a> | <a style="text-decoration: none;" href="<?php echo esc_url( $support ); ?>" target="_blank" rel="noopener noreferrer">Support Forums</a> | <a style="text-decoration: none;" href="<?php echo esc_url( $review ); ?>" target="_blank" rel="noopener noreferrer">Reviews</a>
		</div>
		<div>
		<a style="text-decoration: none;" href="<?php echo esc_url( $translate ); ?>" target="_blank" rel="noopener noreferrer">
		<?php
		/* translators: Plugin translation link */
		echo esc_html( sprintf( __( 'Translations for %s' ), $plugin_name ) );
		?>
		</a> | <a style="text-decoration: none;" href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-facebook"></span></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-twitter"></span></a> | <a style="text-decoration: none;" href="<?php echo esc_url( $youtube ); ?>" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-video-alt3"></span></a>
		</div>
		</span>

		<div style="width: 250px; height: 180px; margin: 5px; padding: 5px; border: #CCC 2px solid;">
		<h3><?php esc_html_e( 'Please make a donation if you like my work or would like to further the development of this plugin.', 'theme-stats-view' ); ?></h3>
		<div style="text-align: right; margin: 5px; padding: 5px;"><span style="padding: 3px; color: #ffffff; background-color: #008000">Plugin Author</span> <span style="font-weight: bold;">Katsushi Kawamori</span></div>
		<button type="button" style="margin: 5px; padding: 5px;" onclick="window.open('<?php echo esc_url( $donate ); ?>')"><?php esc_html_e( 'Donate to this plugin &#187;' ); ?></button>
		</div>

		<?php
	}

	/** ==================================================
	 * Update wp_options table.
	 *
	 * @since 1.00
	 */
	private function options_updated() {

		if ( isset( $_POST['tsview_clear_cache'] ) && ! empty( $_POST['tsview_clear_cache'] ) ) {
			if ( check_admin_referer( 'tsv_settings', 'themestatsview_settings' ) ) {
				$del_cache_count = $this->delete_all_cache();
				if ( 0 < $del_cache_count ) {
					echo '<div class="notice notice-success is-dismissible"><ul><li>' . esc_html__( 'Removed the cache.', 'theme-stats-view' ) . '</li></ul></div>';
				} else {
					echo '<div class="notice notice-error is-dismissible"><ul><li>' . esc_html__( 'No Cache', 'theme-stats-view' ) . '</li></ul></div>';
				}
			}
		}
	}

	/** ==================================================
	 * Delete all cache
	 *
	 * @return int $del_cache_count(int)
	 * @since 1.00
	 */
	public function delete_all_cache() {

		global $wpdb;
		$search_transients = '%tsview_datas_%';
		$del_transients = $wpdb->get_results(
			$wpdb->prepare(
				"
				SELECT	option_name
				FROM	$wpdb->options
				WHERE	option_name LIKE %s
				",
				$search_transients
			)
		);

		$del_cache_count = 0;
		foreach ( $del_transients as $del_transient ) {
			$transient = str_replace( '_transient_', '', $del_transient->option_name );
			$value_del_cache = get_transient( $transient );
			if ( false <> $value_del_cache ) {
				delete_transient( $transient );
				++$del_cache_count;
			}
		}

		return $del_cache_count;
	}
}


