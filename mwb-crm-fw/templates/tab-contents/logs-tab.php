<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the Zoho logs listing aspects of the plugin.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Cf7_Integration_With_Zoho
 * @subpackage Mwb_Cf7_Integration_With_Zoho/admin/partials/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="mwb-cf7-integration__logs-wrap" id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-logs" ajax_url="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">
	<div class="mwb-cf7_integration_logo-wrap">
		<div class="mwb-cf7_integration_logo-crm">
			<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/zoho-logo.png' ); ?>" alt="<?php esc_html_e( 'ZOHO', 'mwb-cf7-integration-with-zoho' ); ?>">
		</div>
		<div class="mwb-cf7_integration_logo-contact">
			<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/contact-form.svg' ); ?>" alt="<?php esc_html_e( 'CF7', 'mwb-cf7-integration-with-zoho' ); ?>">
		</div>
		<?php if ( $params['log_enable'] ) : ?>
				<ul class="mwb-logs__settings-list">
					<li class="mwb-logs__settings-list-item">
						<a id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-clear-log" href="javascript:void(0)" class="mwb-logs__setting-link">
							<?php esc_html_e( 'Clear Log', 'mwb-cf7-integration-with-zoho' ); ?>	
						</a>
					</li>
					<li class="mwb-logs__settings-list-item">
						<a id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-download-log" href="javascript:void(0)"  class="mwb-logs__setting-link">
							<?php esc_html_e( 'Download', 'mwb-cf7-integration-with-zoho' ); ?>	
						</a>
					</li>
				</ul>
		<?php endif; ?>
	</div>
	<div>
		<div>
			<?php if ( $params['log_enable'] ) : ?>
			<div class="mwb-cf7-integration__logs-table-wrap">
				<table id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-table" class="display mwb-cf7-integration__logs-table dt-responsive nowrap" style="width: 100%;">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Expand', 'mwb-cf7-integration-with-zoho' ); ?></th>
							<th><?php esc_html_e( 'Feed', 'mwb-cf7-integration-with-zoho' ); ?></th>
							<th><?php esc_html_e( 'Feed ID', 'mwb-cf7-integration-with-zoho' ); ?></th>
							<th>
								<?php
								/* translators: %s: CRM name. */
								printf( esc_html__( '%s Object', 'mwb-cf7-integration-with-zoho' ), esc_html( $this->crm_title ) );
								?>
							</th>
							<th>
								<?php
								/* translators: %s: CRM name. */
								printf( esc_html__( '%s ID', 'mwb-cf7-integration-with-zoho' ), esc_html( $this->crm_title ) );
								?>
							</th>
							<th><?php esc_html_e( 'Event', 'mwb-cf7-integration-with-zoho' ); ?></th>
							<th><?php esc_html_e( 'Timestamp', 'mwb-cf7-integration-with-zoho' ); ?></th>
							<th class=""><?php esc_html_e( 'Request', 'mwb-cf7-integration-with-zoho' ); ?></th>
							<th class=""><?php esc_html_e( 'Response', 'mwb-cf7-integration-with-zoho' ); ?></th>
						</tr>
					</thead>
				</table>
			</div>
			<?php else : ?>
				<div class="mwb-content-wrap">
					<?php esc_html_e( 'Please enable the logs from ', 'mwb-cf7-integration-with-zoho' ); ?><a href="<?php echo esc_url( 'admin.php?page=mwb_' . $this->crm_slug . '_cf7_page&tab=settings' ); ?>" target="_blank"><?php esc_html_e( 'Settings tab', 'mwb-cf7-integration-with-zoho' ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php
// $crm_class = Mwb_Cf7_Integration_Keap_Api::get_instance();
// $states = $crm_class->get_state( 'IN', 'UP' );
// echo '<pre>'; print_r( $states ); echo '</pre>';