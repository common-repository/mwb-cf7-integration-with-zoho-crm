<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the select object section of feeds.
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

$objects = isset( $params['objects'] ) ? $params['objects'] : array();

if ( ! is_array( $objects ) ) {
	echo esc_html( $objects );
	return;
}

?>
<div class="mwb-feeds__content  mwb-content-wrap  mwb-feed__select-object">
	<a class="mwb-feeds__header-link active">
		<?php
		printf(
			/* translators: %s:crm name */
			esc_html__( 'Select %s Object', 'mwb-cf7-integration-with-zoho' ),
			esc_html( $this->crm_title )
		);
		?>
	</a>

	<div class="mwb-feeds__meta-box-main-wrapper">
		<div class="mwb-feeds__meta-box-wrap">
			<div class="mwb-form-wrapper">
				<select name="crm_object" id="mwb-feeds-<?php echo esc_attr( $this->crm_slug ); ?>-object" class="mwb-form__dropdown">
					<option value="-1"><?php esc_html_e( 'Select Object', 'mwb-cf7-integration-with-zoho' ); ?></option>
					<?php if ( ! empty( $objects ) && is_array( $objects ) ) : ?>
						<?php foreach ( $objects as $key => $modules ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $params['selected_object'] ); ?> > <?php echo esc_html( $modules ); ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</div>
			<div class="mwb-form-wrapper">
				<a id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-refresh-object" class="button refresh-object">
					<span class="mwb-cf7-refresh-object ">
						<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/refresh.svg' ); ?>">
					</span>
					<?php esc_html_e( 'Refresh Objects', 'mwb-cf7-integration-with-zoho' ); ?>
				</a>
				<a id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-refresh-fields" class="button refresh-fields">
					<span class="mwb-cf7-refresh-fields ">
						<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/refresh.svg' ); ?>">
					</span>
					<?php esc_html_e( 'Refresh Fields', 'mwb-cf7-integration-with-zoho' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
