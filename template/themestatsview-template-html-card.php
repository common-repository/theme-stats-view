<?php
/**
 * Theme Stats View Html Card Template File
 *
 * @package WordPress
 * @subpackage Theme Stats View
 * @since Theme Stats View 2.00
 * @version 1.00
 */

?>

<div class="themestatsview-card-wrap">
	<div>
		<img src="<?php echo esc_url( $screenshot_url ); ?>" class="themestatsview-card-icon" />
		<div class="themestatsview-after-icon">
			<div class="themestatsview-bold"><a href="<?php echo esc_url( $homepage ); ?>" class="themestatsview-astyle"><?php echo esc_html( $name ); ?></a></div>
			<div class="themestatsview-small"><?php echo esc_html( $short_description ); ?></div>
			<div class="themestatsview-small"><?php echo esc_html__( 'Author', 'theme-stats-view' ); ?>: <?php echo wp_kses_post( $author_url ); ?></div>
			<div style="clear: both;"></div>
		</div>
	</div>
	<div style="clear: both;"></div>

	<div class="themestatsview-small">
		<span class="themestatsview-card-left"><a title="<?php echo esc_attr( $ratings_text ); ?>" class="themestatsview-astyle"><?php theme_stats_view_ratings( $rating ); ?></a><?php echo esc_html( $num_ratings ); ?></span>
		<span class="themestatsview-card-right"><?php echo esc_html__( 'Last Updated', 'theme-stats-view' ); ?>: <?php echo esc_html( $lastupdated ); ?></span>
	</div>
	<div class="themestatsview-small">
		<span class="themestatsview-card-left"><?php echo esc_html( $active_installs ); ?></span>
		<span class="themestatsview-card-right"><?php echo esc_html__( 'PHP', 'theme-stats-view' ); ?>: <?php echo esc_html( $requires_php ); ?></span>
	</div>
	<div class="themestatsview-small">
		<span class="themestatsview-card-left"><?php echo esc_html__( 'Download', 'theme-stats-view' ); ?>: <a href="<?php echo esc_url( $download_link ); ?>" class="dashicons dashicons-download themestatsview-download"></a></span>
		<span class="themestatsview-card-right"><?php echo esc_html__( 'WordPress', 'theme-stats-view' ); ?>: <?php echo esc_html( $requires ); ?></span>
	</div>
</div>
