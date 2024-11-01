<?php
/**
 * Theme Stats View Html All Template File
 *
 * @package WordPress
 * @subpackage Theme Stats View
 * @since Theme Stats View 2.00
 * @version 1.00
 */

?>
<div class="themestatsview-all-wrap">
<?php if ( ! $totalonly ) : ?>
	<?php
	foreach ( $stats_arr as $key => $value ) {
		?>
		<div class="themestatsview-all-single-wrap">
			<div>
				<img src="<?php echo esc_url( $value['screenshot_url'] ); ?>" class="themestatsview-simple-icon" />
				<div class="themestatsview-after-icon">
					<div class="themestatsview-bold"><a href="<?php echo esc_url( $value['homepage'] ); ?>" class="themestatsview-astyle"><?php echo esc_html( $value['name'] ); ?></a></div>
					<div class="themestatsview-small"><a title="<?php echo esc_attr( $value['ratings_text'] ); ?>" class="themestatsview-astyle"><?php theme_stats_view_ratings( $value['rating'] ); ?></a></div>
					<div class="themestatsview-small"><?php echo esc_html( $value['active_installs'] ); ?></div>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<?php
	}
	?>
	<div style="clear: both;"></div>
<?php endif; ?>

	<div class="themestatsview-all-graph-wrap">
		<div>
			<?php /* translators: Themes count */ ?>
			<?php echo esc_html( sprintf( __( '%1$d Themes', 'theme-stats-view' ), number_format( $count ) ) ); ?>
		</div>
		<div>
			<?php echo esc_html( number_format( $active_installs ) . __( '+ ', 'theme-stats-view' ) . __( 'active installs', 'theme-stats-view' ) ); ?>
		</div>
		<div>
			<?php echo esc_html( number_format( $downloadeds ) . __( 'Download', 'theme-stats-view' ) ); ?>
		</div>
		<div class="themestatsview-all-reviews-count">
			<?php echo esc_html__( 'Reviews count', 'theme-stats-view' ); ?>
		</div>
		<?php if ( 0 < $full_rate_count ) : ?>
			<?php
			foreach ( $all_ratings as $key => $value ) {
				?>
				<div style="line-height: 1em;">
					<span class="themestatsview-all-reviews-text">
						<?php echo esc_html( $rate_num_text[ $key ] ); ?>
					</span>
					<span class="themestatsview-all-reviews-progress">
						<progress class="paview" value="<?php echo esc_attr( $all_per[ $key ] ); ?>" max="100"></progress>
					</span>
					<span class="themestatsview-all-reviews-text">
						<?php echo esc_html( $all_rate[ $key ] ); ?>
					</span>
				</div>
				<?php
			}
			?>
			<div class="themestatsview-all-reviews-count">
				<?php echo esc_html( __( 'Reviews total', 'theme-stats-view' ) . number_format( $full_rate_count ) ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
