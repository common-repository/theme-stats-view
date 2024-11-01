<?php
/**
 * Cli Name:    Theme Stats View refresh
 * Description: Remove all cache and regenerate.
 * Version:     1.02
 * Author:      Katsushi Kawamori
 * Author URI:  https://riverforest-wp.info/
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package tsview_refresh
 */

/*
	Copyright (c) 2024- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
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

/** ==================================================
 * Theme Stats View refresh command
 *
 * @since 1.00
 */
function tsview_refresh_command() {

	do_action( 'tsview_delete_all_cache' );

	$post_ids = get_option( 'tsview_access_ids', array() );
	$remove_ids = array();
	$urls = array();
	if ( ! empty( $post_ids ) ) {
		foreach ( $post_ids as $post_id ) {
			$post = get_post( $post_id );
			if ( ! is_null( $post ) ) {
				$contents = $post->post_content;
				if ( false !== strpos( $contents, '<!-- wp:theme-stats-view' ) ||
						false !== strpos( $contents, '[taview slug=' ) ||
						false !== strpos( $contents, '[tsview slug=' ) ) {
					$urls[] = get_permalink( $post_id );
				} else {
					$remove_ids[] = $post_id;
				}
			} else {
				$remove_ids[] = $post_id;
			}
		}
	}

	if ( ! empty( $remove_ids ) ) {
		$result = array_diff( $post_ids, $remove_ids );
		$result = array_values( $result );
		update_option( 'tsview_access_ids', $result );
	}

	if ( ! empty( $urls ) ) {
		foreach ( $urls as $url ) {
			$response = wp_remote_get(
				$url,
				array(
					'timeout' => 30,
					'redirection' => 0,
					'user-agent' => 'Theme Stats View; ' . $url,
				),
			);
			if ( ( ! is_wp_error( $response ) ) && ( 200 === wp_remote_retrieve_response_code( $response ) ) ) {
				if ( false !== strpos( $response['headers']['content-type'], 'text/html' ) ) {
					$message = sprintf( 'Theme Stats View : %s : refresh.', $url );
					WP_CLI::success( $message );
				}
			} else {
				$message = sprintf( 'Theme Stats View : %s : not refresh.', $url );
				WP_CLI::error( $message );
			}
		}
	}
}
WP_CLI::add_command( 'tsview_refresh', 'tsview_refresh_command' );
