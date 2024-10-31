<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the header of feeds section.
 *
 * @link       https://makewebbetter.com
 * @since      1.0.0
 *
 * @package    Mwb_Cf7_Integration_With_Zoho
 * @subpackage Mwb_Cf7_Integration_With_Zoho/includes/framework/templates/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="mwb_cf7_integration__feeds-wrap">
	<div class="mwb-cf7_integration_logo-wrap">
		<div class="mwb-sf_cf7__logo-zoho">
			<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/zoho-logo.png' ); ?>" alt="<?php esc_html_e( 'Keap', 'mwb-cf7-integration-with-zoho' ); ?>">
		</div>
		<div class="mwb-cf7_integration_logo-contact">
			<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/contact-form.svg' ); ?>" alt="<?php esc_html_e( 'CF7', 'mwb-cf7-integration-with-zoho' ); ?>">
		</div>
	</div>

