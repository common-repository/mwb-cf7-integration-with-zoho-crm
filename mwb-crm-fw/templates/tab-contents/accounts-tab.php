<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the accounts creation page.
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
<div class="mwb_cf7_integration_account-wrap">

	<!-- Logo section start -->
	<div class="mwb-cf7_integration_logo-wrap">
		<div class="mwb-cf7_integration_logo-crm">
			<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/zoho-logo.png' ); ?>" alt="<?php esc_html_e( 'Zoho', 'mwb-cf7-integration-with-zoho' ); ?>">
		</div>
		<div class="mwb-cf7_integration_logo-contact">
			<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/contact-form.svg' ); ?>" alt="<?php esc_html_e( 'CF7', 'mwb-cf7-integration-with-zoho' ); ?>">
		</div>
	</div>
	<!-- Logo section end -->

	<!--============================================================================================
										Dashboard page start.
	================================================================================================-->

	<!-- Connection status start -->
	<div class="mwb_cf7_integration_crm_connected">
		<ul>
			<li class="mwb-cf7_intergation_conn-row">
				<div class="mwb-cf7-integration__content-wrap">
					<div class="mwb-section__sub-heading__wrap">
						<h3 class="mwb-section__sub-heading">
							<?php echo sprintf( '%s %s', esc_html( $this->crm_title ), esc_html__( 'Connection Status', 'mwb-cf7-integration-with-zoho' ) ); ?>
						</h3>
						<div class="mwb-dashboard__header-text">
							<span class="<?php echo esc_attr( 'is-connected' ); ?>" >
								<?php esc_html_e( 'Connected', 'mwb-cf7-integration-with-zoho' ); ?>
							</span>
						</div>
					</div>

					<div class="mwb-cf7-integration__status-wrap">
						<div class="mwb-cf7-integration__left-col">
							<div class="mwb-cf7-integration-token-notice__wrap">
								<?php if ( ! empty( $params['owner_name'] ) ) : ?>
									<p>
										<?php
										/* translators: %s: owner name */
										printf( esc_html__( 'Owner Name : %s', 'mwb-cf7-integration-with-zoho' ), esc_html( $params['owner_name'] ) );
										?>
									</p>
								<?php endif; ?>
							</div>
							<div class="mwb-cf7-integration-token-notice__wrap">
								<?php if ( ! empty( $params['owner_email'] ) ) : ?>
									<p>
										<?php
										/* translators: %s: owner email */
										printf( esc_html__( 'Owner Email : %s', 'mwb-cf7-integration-with-zoho' ), esc_html( $params['owner_email'] ) );
										?>
									</p>
								<?php endif; ?>
							</div>
							<div class="mwb-cf7-integration-token-notice__wrap">
								<p id="mwb-cf7-token-expiry-notice" >
									<?php if ( $params['expires_in'] > time() ) : ?>
										<?php
										/* translators: %s: time */
										$duration = ceil( ( $params['expires_in'] - time() ) / 60 );
										printf( 'Access token will expire in %s minutes.', esc_html( $duration ) );
										?>
									<?php else : ?>
										<?php esc_html_e( 'Access token has expired.', 'mwb-cf7-integration-with-zoho' ); ?>
									<?php endif; ?>

								</p>
								<p class="mwb-cf7-integration-token_refresh ">
									<img id ="mwb_cf7_integration_refresh_token" src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/refresh.svg' ); ?>" title="<?php esc_html_e( 'Refresh Access Token', 'mwb-cf7-integration-with-zoho' ); ?>">
								</p>
							</div>
						</div>

						<div class="mwb-cf7-integration__right-col">
							<a id="mwb_cf7_integration_reauthorize" href="<?php echo esc_url( wp_nonce_url( admin_url( '?mwb-cf7-integration-perform-reauth=1' ) ) ); ?>" class="mwb-btn mwb-btn--filled">
								<?php esc_html_e( 'Reauthorize', 'mwb-cf7-integration-with-zoho' ); ?>
							</a>
							<a id="mwb_cf7_integration_disconnect" href="javascript:void(0)" class="mwb-btn mwb-btn--filled">
								<?php esc_html_e( 'Disconnect', 'mwb-cf7-integration-with-zoho' ); ?>
							</a>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
	<!-- Connection status end -->

	<!-- About list start -->
	<div class="mwb-dashboard__about">
		<div class="mwb-dashboard__about-list">
			<div class="mwb-content__list-item-text">
				<h2 class="mwb-section__heading"><?php esc_html_e( 'Synced Contact Forms', 'mwb-cf7-integration-with-zoho' ); ?></h2>
				<div class="mwb-dashboard__about-number">
					<span><?php echo esc_html( ! empty( $params['count'] ) ? $params['count'] : '0' ); ?></span>
				</div>
				<div class="mwb-dashboard__about-number-desc">
					<p>

						<i><?php esc_html_e( 'Total number of Contact Form 7 submission successfully synchronized over ZOHO CRM.', 'mwb-cf7-integration-with-zoho' ); ?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=mwb_' . $this->crm_slug . '_cf7&tab=logs' ) ); ?>" target="_blank"><?php esc_html_e( 'View log', 'mwb-cf7-integration-with-zoho' ); ?></a></i>
					</p>
				</div>
			</div>
			<div class="mwb-content__list-item-image">
				<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/deals.svg' ); ?>" alt="<?php esc_html_e( 'Synced Contact Forms', 'mwb-cf7-integration-with-zoho' ); ?>">
			</div>
		</div>

		<?php do_action( 'mwb_zcf7_about_list' ); ?>

	</div>
	<!-- About list end -->

	<!-- Support section start -->
	<div class="mwb-content-wrap">
		<ul class="mwb-about__list">
			<li class="mwb-about__list-item">
				<div class="mwb-about__list-item-text">
					<p><?php esc_html_e( 'Need any help ? Check our documentation.', 'mwb-cf7-integration-with-zoho' ); ?></p>
				</div>
				<div class="mwb-about__list-item-btn">
					<a href="<?php echo esc_url( ! empty( $params['links']['doc'] ) ? $params['links']['doc'] : '' ); ?>" class="mwb-btn mwb-btn--filled"><?php esc_html_e( 'Documentation', 'mwb-cf7-integration-with-zoho' ); ?></a>
				</div>
			</li>
			<li class="mwb-about__list-item">
				<div class="mwb-about__list-item-text">
					<p><?php esc_html_e( 'Facing any issue ? Open a support ticket.', 'mwb-cf7-integration-with-zoho' ); ?></p>
				</div>
				<div class="mwb-about__list-item-btn">
					<a href="<?php echo esc_url( ! empty( $params['links']['ticket'] ) ? $params['links']['ticket'] : '' ); ?>" class="mwb-btn mwb-btn--filled"><?php esc_html_e( 'Support', 'mwb-cf7-integration-with-zoho' ); ?></a>
				</div>
			</li>
			<li class="mwb-about__list-item">
				<div class="mwb-about__list-item-text">
					<p><?php esc_html_e( 'Need personalized solution, contact us !', 'mwb-cf7-integration-with-zoho' ); ?></p>
				</div>
				<div class="mwb-about__list-item-btn">
					<a href="<?php echo esc_url( ! empty( $params['links']['contact'] ) ? $params['links']['contact'] : '' ); ?>" class="mwb-btn mwb-btn--filled"><?php esc_html_e( 'Connect', 'mwb-cf7-integration-with-zoho' ); ?></a>
				</div>
			</li>
		</ul>	
	</div>
	<!-- Support section end -->

</div>

