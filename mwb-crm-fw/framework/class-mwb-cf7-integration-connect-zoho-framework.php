<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Cf7_Integration_With_Zoho
 * @subpackage Mwb_Cf7_Integration_With_Zoho/mwb-crm-fw
 */

if ( ! class_exists( 'Mwb_Cf7_Integration_Zoho_Framework' ) ) {
	wp_die( 'Mwb_Cf7_Integration_Zoho_Framework does not exists.' );
}

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwb_Cf7_Integration_With_Zoho
 * @subpackage Mwb_Cf7_Integration_With_Zoho/mwb-crm-fw
 * @author     makewebbetter <webmaster@makewebbetter.com>
 */
class Mwb_Cf7_Integration_Connect_Zoho_Framework extends Mwb_Cf7_Integration_Zoho_Framework {

	/**
	 *  The instance of this class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $instance    The instance of this class.
	 */
	private static $instance;

	/**
	 * Main Mwb_Cf7_Integration_Connect_Zoho_Framework Instance.
	 *
	 * Ensures only one instance of Mwb_Cf7_Integration_Connect_Zoho_Framework is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Mwb_Cf7_Integration_Connect_Zoho_Framework - Main instance.
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Get current mapping scenerio for current CRM connection.
	 *
	 * @param    mixed $form_id   CF7 Form ID.
	 * @since    1.0.0
	 * @return   array - Current CRM to CF7 mapping.
	 */
	public function getMappingDataset( $form_id = '' ) {

		if ( empty( $form_id ) ) {
			return;
		}

		$obj_type = array(
			'wpcf7',
		);

		$formatted_dataset = array();
		foreach ( $obj_type as $key => $obj ) {
			$formatted_dataset[ $obj ] = $this->getMappingOptions( $form_id );
		}

		$formatted_dataset = $this->parse_labels( $formatted_dataset );
		return $formatted_dataset;
	}

	/**
	 * Get current mapping scenerio for current CRM connection.
	 *
	 * @param    string $id    CF7 form ID.
	 * @since    1.0.0
	 * @return   array         Current CRM to CF7 mapping.
	 */
	public function getMappingOptions( $id = false ) {
		return $this->get_cf7_meta( $id );
	}

	/**
	 * Get available filter options.
	 *
	 * @since    1.0.0
	 * @return   array
	 */
	public function getFilterMappingDataset() {
		return $this->get_avialable_form_filters();
	}

	/**
	 * Create log folder.
	 *
	 * @param     string $path    Name of log folder.
	 * @since     1.0.0
	 * @return    mixed
	 */
	public function create_log_folder( $path ) {

		$basepath = WP_CONTENT_DIR . '/uploads/';
		$fullpath = $basepath . $path;

		if ( ! empty( $fullpath ) ) {

			if ( ! is_dir( $fullpath ) ) {

				$folder = mkdir( $fullpath, 0755, true );

				if ( $folder ) {
					return $fullpath;
				}
			} else {
				return $fullpath;
			}
		}
		return false;
	}

	/**
	 * Get link to data sent over Zoho.
	 *
	 * @param      string $crm_id   An array of data synced over Zoho.
	 * @param      string $object   Crm Object.
	 * @since      1.0.0
	 * @return     string
	 */
	public function get_crm_link( $crm_id = false, $object ) {

		if ( false == $crm_id || empty( $object ) ) { // phpcs:ignore
			return;
		}

		$_domain = get_option( 'mwb-zcf7-domain', 'in' );
		$link    = 'https://crm.zoho.' . $_domain . '/crm/tab/' . $object . '/' . $crm_id;

		return $link;

	}

	/**
	 * Returns count of synced data.
	 *
	 * @since     1.0.0
	 * @return    integer
	 */
	public function get_synced_forms_count() {

		global $wpdb;
		$table_name  = $wpdb->prefix . 'mwb_zcf7_log';
		$col_name    = 'zoho_id';
		$count_query = "SELECT COUNT(*) as `total_count` FROM {$table_name} WHERE {$col_name} != '-'"; // phpcs:ignore
		$count_data  = $wpdb->get_col( $count_query ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
		$total_count = isset( $count_data[0] ) ? $count_data[0] : '0';

		return $total_count;
	}


	/**
	 * Clear n days log.
	 *
	 * @param  int $timestamp  Delete timestamp.
	 * @since  1.0.3
	 * @return void
	 */
	public function clear_n_days_log( $timestamp ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'mwb_zcf7_log';
		$query      = $wpdb->prepare( "DELETE FROM {$table_name} WHERE `time` < %d", $timestamp ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$wpdb->query( $query ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
	}

	// End of class.
}
