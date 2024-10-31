<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Cf7_Integration_With_Zoho
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Get settings data.
$settings = get_option( 'mwb_zcf7_setting', false );

if ( ! empty( $settings ) && is_array( $settings ) ) {
	if ( isset( $settings['data_delete'] ) && 'yes' == $settings['data_delete'] ) { // phpcs:ignore

		// Delete all feeds.
		$args = array(
			'post_type'      => 'mwb_zoho_feeds',
			'posts_per_page' => -1,
		);

		$all_feeds = get_posts( $args );

		if ( ! empty( $all_feeds ) && is_array( $all_feeds ) ) {
			foreach ( $all_feeds as $feed ) {
				$post_meta = get_post_meta( $feed->ID );
				if ( ! empty( $post_meta ) && is_array( $post_meta ) ) {
					foreach ( $post_meta as $key => $value ) {
						delete_post_meta( $feed->ID, $key );
					}
				}
				wp_delete_post( $feed->ID, true );
			}
		}
		unregister_post_type( 'mwb_zoho_feeds' );

		// Drop logs table.
		global $wpdb;
		$table_name = $wpdb->prefix . 'mwb_zcf7_log';

		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		// Delete options at last.
		$options = array(
			'mwb-zcf7-client-id',
			'mwb-zcf7-secret-id',
			'mwb-zcf7-domain',
			'mwb-zcf7-own-app',
			'mwb_zcf7_admin_notice',
			'mwb_zcf7_admin_feed_notice',
			'mwb-zcf7-authorised',
			'mwb_zcf7_setting',
			'onboarding-data-sent',
			'onboarding-data-skipped',
			'mwb_zcf7_zoho_token_data',
			'mwb_is_crm_active',
			'mwb-zcf7-user-info',
			'mwb_zcf7_auth_nonce_data',
			'mwb_zcf7_synced_forms_count',
		);

		foreach ( $options as $option ) {
			if ( get_option( $option ) ) {
				delete_option( $option );
			}
		}

		$forms = get_posts(
			array(
				'post_type'   => 'wpcf7_contact_form',
				'numberposts' => -1,
			)
		);

		foreach ( $forms as $key => $form ) {
			if ( get_option( 'mwb_cf7_submit_form_' . $form->ID . '_count' ) ) {
				delete_option( 'mwb_cf7_submit_form_' . $form->ID . '_count' ); // delete dynamic options.
			}
		}

		// unscedule cron.
		wp_unschedule_event( time(), 'mwb_zcf7_clear_log' );

		// Delete transients.
		if ( ! empty( get_transient_keys_with_prefix( 'mwb_zcf7' ) ) ) {
			foreach ( get_transient_keys_with_prefix( 'mwb_zcf7' ) as $key ) {
				delete_transient( $key );
			}
		}
	}
}


/**
 * Gets all transient keys in the database with a specific prefix.
 *
 * Note that this doesn't work for sites that use a persistent object
 * cache, since in that case, transients are stored in memory.
 *
 * @param  string $prefix Prefix to search for.
 * @return array          Transient keys with prefix, or empty array on error.
 */
function get_transient_keys_with_prefix( $prefix ) {
	global $wpdb;

	$prefix = $wpdb->esc_like( '_transient_' . $prefix );
	$sql    = "SELECT `option_name` FROM $wpdb->options WHERE `option_name` LIKE '%s'";
	$keys   = $wpdb->get_results( $wpdb->prepare( $sql, $prefix . '%' ), ARRAY_A ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

	if ( is_wp_error( $keys ) ) {
		print( esc_html( $keys ) );
	}

	return array_map(
		function( $key ) {
			// Remove '_transient_' from the option name.
			return ltrim( $key['option_name'], '_transient_' );
		},
		$keys
	);
}
