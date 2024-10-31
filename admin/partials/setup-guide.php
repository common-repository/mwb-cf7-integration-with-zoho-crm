<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.3
 *
 * @package    Mwb_Cf7_Integration_With_Zoho_Crm
 * @subpackage Mwb_Cf7_Integration_With_Zoho_Crm/setup
 */

?>
<div class="mwb-crm-setup-content-wrap">
	<div class="mwb-crm-setup-list-wrap">
		<ul class="mwb-crm-setup-list">
			<?php if ( 'yes' == $custom_app ) : // phpcs:ignore ?>
				<li>
					<a href="https://accounts.zoho.com/developerconsole"><?php esc_html_e( 'Go', 'mwb-cf7-integration-with-zoho' ); ?></a>
					<?php esc_html_e( ' to your developer account.', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'Select client type as Server based', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'Enter client name ( For eg. "Demo" or "My app" )', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'Fill up mandatory informations like "CLinet Name" on the Client details tab', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
				<li>
					<?php
					echo wp_kses(
						sprintf(
						/* translators: Feed object name */
							__( 'Enter  <strong> %s </strong> as Redirect URL.', 'mwb-cf7-integration-with-zoho' ),
							$params['callback_url']
						),
						$params['allowed_html']
					);
					?>
				</li>
				<li>
					<?php esc_html_e( 'New app will be created and its its credentials will be displayed on Client Secret tab.', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'Copy "Client ID" and "Client secret" from there and enter it in Authentication form.', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
			<?php else : ?>
				<li>
					<?php esc_html_e( 'Click on authorize button.', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'It will redirect you to ZOHO login panel.', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'After successful login, it will redirect you to consent page, where it will ask your permissions to access the data.', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
				<li>
					<?php esc_html_e( 'Click on allow, it should redirect back to your plugin admin page and your connection part is done.', 'mwb-cf7-integration-with-zoho' ); ?>
				</li>
			<?php endif; ?>
			<li>
			<?php
			echo wp_kses(
				sprintf(
				/* translators: Feed object name */
					__( 'Still facing issue! Please check detailed app setup <a href="%s" target="_blank"  >documentation</a>.', 'mwb-cf7-integration-with-zoho' ),
					$params['setup_guide_url']
				),
				$params['allowed_html']
			);
			?>
			</li>
		</ul>
		<?php if ( 'yes' == $custom_app ) : // phpcs:ignore ?>
			<div class="mwb_cf7_integration_popupimg">
				<img style="width: 100%;" src="<?php echo esc_url( $params['api_key_image'] ); ?>">
			</div>
		<?php endif; ?>
	</div>
</div>
