<?php
/**
 * Theme Stats View Html Normal Template File
 *
 * @package WordPress
 * @subpackage Theme Stats View
 * @since Theme Stats View 2.00
 * @version 1.00
 */

?>

<div class="themestatsview-normal-wrap">
	<div>
		<?php if ( ! empty( $screenshot_url ) ) : ?>
			<img src="<?php echo esc_url( $screenshot_url ); ?>" class="themestatsview-banner" />
		<?php endif; ?>
		<img src="<?php echo esc_url( $screenshot_url ); ?>" class="themestatsview-normal-icon" />
		<div class="themestatsview-after-icon">
			<div class="themestatsview-bold"><a href="<?php echo esc_url( $homepage ); ?>" class="themestatsview-astyle"><?php echo esc_html( $name ); ?></a></div>
			<div><a title="<?php echo esc_attr( $ratings_text ); ?>" class="themestatsview-astyle"><?php theme_stats_view_ratings( $rating ); ?></a><?php echo esc_html( $num_ratings ); ?></div>
			<div><?php echo esc_html__( 'Version', 'theme-stats-view' ) . esc_html( $version ); ?></div>
		</div>
	</div>
	<div style="clear: both;"></div>

	<div><?php echo esc_html( $active_installs ); ?></div>
	<div><?php echo esc_html( $short_description ); ?></div>
	<details open class="themestatsview-details">
	<summary class="themestatsview-summary"><?php echo esc_html__( 'Specification', 'theme-stats-view' ); ?></summary>
	<?php if ( wp_is_mobile() ) : ?>
		<details class="themestatsview-mobile-details">
		<summary class="themestatsview-summary"><?php echo esc_html__( 'Date' ); ?></summary>
			<span class="themestatsview-mobile-indent">
				<div><?php echo esc_html__( 'Author', 'theme-stats-view' ); ?>: <?php echo wp_kses_post( $author_url ); ?></div>
				<div><?php echo esc_html__( 'Last Updated', 'theme-stats-view' ); ?>: <?php echo esc_html( $lastupdated ); ?></div>
			</span>
		</details>
		<details class="themestatsview-mobile-details">
		<summary class="themestatsview-summary"><?php echo esc_html__( 'Compatible version', 'theme-stats-view' ); ?></summary>
			<span class="themestatsview-mobile-indent">
				<div><span class="themestatsview-bold"><?php echo esc_html__( 'PHP', 'theme-stats-view' ); ?>: </span><?php echo esc_html( $requires_php ); ?></div>
				<div><span class="themestatsview-bold"><?php echo esc_html__( 'WordPress', 'theme-stats-view' ); ?>: </span><?php echo esc_html( $requires ); ?></div>
			</span>
		</details>
		<details class="themestatsview-mobile-details">
		<summary class="themestatsview-summary"><?php echo esc_html__( 'Links' ); ?></summary>
			<span class="themestatsview-mobile-indent">
				<div><span class="themestatsview-bold">WordPress : </span><a href="<?php echo esc_url( $homepage ); ?>" class="dashicons dashicons-wordpress themestatsview-download"></a></div>
				<div><span class="themestatsview-bold"><?php echo esc_html__( 'Download', 'theme-stats-view' ); ?>: </span><a href="<?php echo esc_url( $download_link ); ?>" class="dashicons dashicons-download themestatsview-download"></a></div>
			</span>
		</details>
	<?php else : ?>
		<table class="themestatsview-table">
			<tr class="themestatsview-tr1">
				<th class="themestatsview-th"><?php echo esc_html__( 'Date' ); ?></th>
				<th class="themestatsview-th"><?php echo esc_html__( 'Compatible version', 'theme-stats-view' ); ?></th>
				<th class="themestatsview-th"><?php echo esc_html__( 'Links' ); ?></th>
			</tr>
			<tr class="themestatsview-tr2">
				<td class="themestatsview-td">
					<div><span class="themestatsview-bold"><?php echo esc_html__( 'Author', 'theme-stats-view' ); ?>: </span><?php echo wp_kses_post( $author_url ); ?></div>
					<div><span class="themestatsview-bold"><?php echo esc_html__( 'Last Updated', 'theme-stats-view' ); ?>: </span><?php echo esc_html( $lastupdated ); ?></div>
				</td>
				<td class="themestatsview-td">
					<div><span class="themestatsview-bold"><?php echo esc_html__( 'PHP', 'theme-stats-view' ); ?>: </span><?php echo esc_html( $requires_php ); ?></div>
					<div><span class="themestatsview-bold"><?php echo esc_html__( 'WordPress', 'theme-stats-view' ); ?>: </span><?php echo esc_html( $requires ); ?></div>
				</td>
				<td class="themestatsview-td">
					<div><span class="themestatsview-bold">WordPress : </span><a href="<?php echo esc_url( $homepage ); ?>" class="dashicons dashicons-wordpress themestatsview-download"></a></div>
					<div><span class="themestatsview-bold"><?php echo esc_html__( 'Download', 'theme-stats-view' ); ?>: </span><a href="<?php echo esc_url( $download_link ); ?>" class="dashicons dashicons-download themestatsview-download"></a></div>
				</td>
			</tr>
		</table>
	<?php endif; ?>
	</details>

	<?php if ( 'true' === $open || $open ) : ?>
		<details open class="themestatsview-details">
	<?php else : ?>
		<details class="themestatsview-details">
	<?php endif; ?>
	<summary class="themestatsview-summary"><?php echo esc_html__( 'Description', 'theme-stats-view' ); ?></summary>
		<div class="themestatsview-normal-desc"><?php echo wp_kses_post( $description ); ?></div>
	</details>

	<?php if ( 'true' === $open || $open ) : ?>
		<details open class="themestatsview-details">
	<?php else : ?>
		<details class="themestatsview-details">
	<?php endif; ?>
	<summary class="themestatsview-summary"><?php echo esc_html__( 'Tags', 'theme-stats-view' ); ?></summary>
		<div class="themestatsview-normal-desc"><?php echo esc_html( $tag_text ); ?></div>
	</details>

</div>
