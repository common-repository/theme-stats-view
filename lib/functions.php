<?php
/**
 * Functions file for Theme Stats View
 *
 * @package Theme Stats View
 */

/** ==================================================
 * Rating 5 stars
 *
 * @param float $score  score.
 * @since 2.00
 */
function theme_stats_view_ratings( $score ) {

	?>
	<span class="themestatsview-stars">
		<?php if ( 0 <= $score && 0.25 > $score ) : ?>
			<span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span>
		<?php elseif ( 0.25 <= $score && 0.75 > $score ) : ?>
			<span class="dashicons dashicons-star-half"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span>
		<?php elseif ( 0.75 <= $score && 1.25 > $score ) : ?>
			<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span>
		<?php elseif ( 1.25 <= $score && 1.75 > $score ) : ?>
			<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-half"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span>
		<?php elseif ( 1.75 <= $score && 2.25 > $score ) : ?>
			<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span>
		<?php elseif ( 2.25 <= $score && 2.75 > $score ) : ?>
			<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-half"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span>
		<?php elseif ( 2.75 <= $score && 3.25 > $score ) : ?>
			<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-empty"></span><span class="dashicons dashicons-star-empty"></span>
		<?php elseif ( 3.25 <= $score && 3.75 > $score ) : ?>
			<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-half"></span><span class="dashicons dashicons-star-empty"></span>
		<?php elseif ( 3.75 <= $score && 4.25 > $score ) : ?>
			<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-empty"></span>
		<?php elseif ( 4.25 <= $score && 4.75 > $score ) : ?>
			<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-half"></span>
		<?php elseif ( 4.75 <= $score ) : ?>
			<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span>
		<?php endif; ?>
	</span>
	<?php
}
