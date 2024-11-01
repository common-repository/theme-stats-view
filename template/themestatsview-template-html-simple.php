<?php
/**
 * Theme Stats View Html Simple Template File
 *
 * @package WordPress
 * @subpackage Theme Stats View
 * @since Theme Stats View 2.00
 * @version 1.00
 */

?>

<div class="themestatsview-simple-wrap">
	<div>
		<img src="<?php echo esc_url( $screenshot_url ); ?>" class="themestatsview-simple-icon" />
		<div class="themestatsview-after-icon">
			<div class="themestatsview-bold"><a href="<?php echo esc_url( $homepage ); ?>" class="themestatsview-astyle"><?php echo esc_html( $name ); ?></a></div>
			<div class="themestatsview-small"><a title="<?php echo esc_attr( $ratings_text ); ?>" class="themestatsview-astyle"><?php theme_stats_view_ratings( $rating ); ?></a></div>
			<div class="themestatsview-small"><?php echo esc_html( $active_installs ); ?></div>
		</div>
	</div>
	<div style="clear: both;"></div>
</div>
