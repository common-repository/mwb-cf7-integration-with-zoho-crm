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
<?php if ( '1' !== get_option( 'mwb_is_crm_active', false ) ) : ?>
	<section class="mwb-intro">
		<div class="mwb-content-wrap">
			<div class="mwb-intro__header">
				<h2 class="mwb-section__heading">
					<?php echo sprintf( 'Getting started with CF7 and %s', esc_html( $this->crm_title ) ); ?>
				</h2>
			</div>
			<div class="mwb-intro__body mwb-intro__content">
				<p>
				<?php
				echo sprintf(
					/* translators: %1$s: CRM name, %2$s: CRM name, %3$s: CRM modules, %4$s: CRM name  */
					esc_html__( 'With this CF7 %1$s Integration you can easily sync all your CF7 Form Submissions data over %2$s CRM. It will create %3$s over %4$s CRM, based on your CF7 Form Feed data.', 'mwb-cf7-integration-with-zoho' ),
					esc_html( $this->crm_title ),
					esc_html( $this->crm_title ),
					esc_html__( 'Leads, Contacts, Quotes etc.', 'mwb-cf7-integration-with-zoho' ),
					esc_html( $this->crm_title )
				);
				?>
				</p>
				<ul class="mwb-intro__list">
					<li class="mwb-intro__list-item">
						<?php
						echo sprintf(
							/* translators: %s: CRM name */
							esc_html__( 'Connect your %s CRM account with CF7.', 'mwb-cf7-integration-with-zoho' ),
							esc_html( $this->crm_title )
						);
						?>
					</li>
					<li class="mwb-intro__list-item">
						<?php
						echo sprintf(
							/* translators: %s: CRM name */
							esc_html__( 'Sync your data over %s CRM.', 'mwb-cf7-integration-with-zoho' ),
							esc_html( $this->crm_title )
						);
						?>
					</li>
				</ul>
				<div class="mwb-intro__button">
					<a href="javascript:void(0)" class="mwb-btn mwb-btn--filled" id="mwb-showauth-form">
						<?php esc_html_e( 'Connect your Account.', 'mwb-cf7-integrate-with-keap' ); ?>
					</a>
				</div>
			</div> 
		</div>
	</section>

	<!--============================================================================================
											Authorization form start.
	================================================================================================-->

	<div class="mwb_cf7_integration_account-wrap row-hide" id="mwb-cf7-auth_wrap">
		<!-- Logo section start -->
		<div class="mwb-cf7_integration_logo-wrap">
			<div class="mwb-cf7_integration_logo-crm">
				<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/zoho-logo.png' ); ?>" alt="<?php esc_html_e( 'ZOHO', 'mwb-cf7-integration-with-zoho' ); ?>">
			</div>
			<div class="mwb-cf7_integration_logo-contact">
				<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/contact-form.svg' ); ?>" alt="<?php esc_html_e( 'CF7', 'mwb-cf7-integration-with-zoho' ); ?>">
			</div>
		</div>
		<!-- Logo section end -->

		<!-- Login form start -->
		<form method="post" id="mwb_cf7_integration_account_form">

			<div class="mwb_cf7_integration_table_wrapper">
				<div class="mwb_cf7_integration_account_setup">
					<h2>
						<?php esc_html_e( 'Enter your api credentials here', 'mwb-cf7-integration-with-zoho' ); ?>
					</h2>
				</div>

				<table class="mwb_cf7_integration_table">
					<tbody>

						<!-- Own app start -->
						<tr>
							<th>
								<label>
									<?php esc_html_e( 'Use own app', 'mwb-cf7-integration-with-zoho' ); ?>
								</label>

								<td>
									<input type="checkbox" name="mwb_account[own_app]" id="mwb-zcf7-own-app" value="yes" <?php checked( 'yes', $params['own_app'] ); ?> >
								</td>
							</th>
						</tr>
						<!-- Own app end -->

						<!-- Zoho Domain start -->
						<tr>
							<th>
								<label><?php esc_html_e( 'ZOHO Domain', 'mwb-cf7-integration-with-zoho' ); ?></label>
							</th>

							<td>
								<select name="mwb_account[domain]" id="mwb-zcf7-domain" >
									<option value="in" <?php selected( 'in', $params['domain'] ); ?> ><?php esc_html_e( '.in', 'mwb-cf7-integration-with-zoho' ); ?></option>
									<option value="com.cn" <?php selected( 'com.cn', $params['domain'] ); ?> ><?php esc_html_e( '.com.cn', 'mwb-cf7-integration-with-zoho' ); ?></option>
									<option value="com.au" <?php selected( 'com.au', $params['domain'] ); ?> ><?php esc_html_e( '.com.au', 'mwb-cf7-integration-with-zoho' ); ?></option>
									<option value="eu" <?php selected( 'eu', $params['domain'] ); ?> ><?php esc_html_e( '.eu', 'mwb-cf7-integration-with-zoho' ); ?></option>
									<option value="com" <?php selected( 'com', $params['domain'] ); ?> ><?php esc_html_e( '.com', 'mwb-cf7-integration-with-zoho' ); ?></option>
								</select>
							</td>
						</tr>
						<!-- Zoho domain end -->

						<!-- App ID start  -->
						<tr class="mwb-api-fields">
							<th>							
								<label><?php esc_html_e( 'Client ID', 'mwb-cf7-integration-with-zoho' ); ?></label>
							</th>

							<td>
								<div class="mwb-cf7-integration__secure-field">
									<input type="password"  name="mwb_account[app_id]" id="mwb-zcf7-client-id" value="<?php echo esc_html( $params['client_id'] ); ?>" required>
									<div class="mwb-cf7-integration__trailing-icon">
										<span class="dashicons dashicons-visibility mwb-toggle-view"></span>
									</div>
								</div>
							</td>
						</tr>
						<!-- App ID end -->

						<!-- Secret Key start -->
						<tr class="mwb-api-fields">
							<th>
								<label><?php esc_html_e( 'Secret key', 'mwb-cf7-integration-with-zoho' ); ?></label>
							</th>

							<td>
								<div class="mwb-cf7-integration__secure-field">
									<input type="password" name="mwb_account[secret_key]" id="mwb-zcf7-secret-id" value="<?php echo esc_html( $params['client_secret'] ); ?>" required>
									<div class="mwb-cf7-integration__trailing-icon">
										<span class="dashicons dashicons-visibility mwb-toggle-view"></span>
									</div>
								</div>
							</td>
						</tr>
						<!-- Secret Key End -->

						<!-- Redirect url start -->
						<tr class="mwb-api-fields">
							<th>
								<label><?php esc_html_e( 'Redirect URL', 'mwb-cf7-integration-with-zoho' ); ?></label>
							</th>

							<td>
								<input type="url" name="mwb_account[redirect_url]" value="<?php echo esc_html( rtrim( admin_url(), '/' ) ); ?>" readonly>
							</td>
						</tr>
						<!-- Redirect url end -->

						<!-- Save & connect account start -->
						<tr>
							<th>
							</th>
							<td>
								<a href="<?php echo esc_url( wp_nonce_url( admin_url( '?mwb-cf7-integration-perform-auth=1' ) ) ); ?>" class="mwb-btn mwb-btn--filled mwb_cf7_integration_submit_account" id="mwb-<?php echo esc_attr( $this->crm_slug ); ?>-cf7-authorize-button" ><?php esc_html_e( 'Authorize', 'mwb-cf7-integration-with-zoho' ); ?></a>
							</td>
						</tr>
						<!-- Save & connect account end -->
					</tbody>
				</table>
			</div>
		</form>
		<!-- Login form end -->

		<!-- Info section start -->
		<div class="mwb-intro__bottom-text-wrap ">
			<p>
				<?php esc_html_e( 'Don’t have an account yet . ', 'mwb-cf7-integration-with-zoho' ); ?>
				<a href="https://www.zoho.com/" target="_blank" class="mwb-btn__bottom-text">
					<?php esc_html_e( 'Create A Free Account', 'mwb-cf7-integration-with-zoho' ); ?>
				</a>
			</p>
			<p class="mwb-api-fields">
				<?php esc_html_e( 'Get Your Api Key here.', 'mwb-cf7-integration-with-zoho' ); ?>
				<a href="https://accounts.zoho.com/developerconsole" target="_blank" class="mwb-btn__bottom-text"><?php esc_html_e( 'Get Api Keys', 'mwb-cf7-integration-with-zoho' ); ?></a>
			</p>
			<p>
				<?php esc_html_e( 'Check app setup guide . ', 'mwb-cf7-integration-with-zoho' ); ?>
				<a href="javascript:void(0)" class="mwb-btn__bottom-text trigger-setup-guide"><?php esc_html_e( 'Show Me How', 'mwb-cf7-integration-with-zoho' ); ?></a>
			</p>
		</div>
		<!-- Info section end -->
	</div>

<?php else : ?>

	<!-- Successfull connection start -->
	<section class="mwb-sync">
		<div class="mwb-content-wrap">
			<div class="mwb-sync__header">
				<h2 class="mwb-section__heading">
					<?php
					echo sprintf(
						/* translators: %s: CRM name */
						esc_html__( 'Congrats! You’ve successfully set up the MWB CF7 Integration with %s Plugin.', 'mwb-cf7-integration-with-zoho' ),
						esc_html( $this->crm_title )
					);
					?>
				</h2>
			</div>
			<div class="mwb-sync__body mwb-sync__content-wrap">            
				<div class="mwb-sync__image">    
					<img src="<?php echo esc_url( ZOHO_CF7_INTEGRATION_URL . 'admin/images/congo.jpg' ); ?>" >
				</div>       
				<div class="mwb-sync__content">            
					<p> 
						<?php
						echo sprintf(
							/* translators: %s: CRM name */
							esc_html__( 'Now you can go to the dashboard and check for the synced data. You can check your feeds, edit them and resync the data if you want. If you do not see your data over %s CRM, you can check the logs for any possible error.', 'mwb-cf7-integration-with-zoho' ),
							esc_html( $this->crm_title )
						);
						?>
					</p>
					<div class="mwb-sync__button">
						<a href="javascript:void(0)" class="mwb-btn mwb-btn--filled mwb-onboarding-complete">
							<?php esc_html_e( 'View Dashboard', 'mwb-cf7-integration-with-zoho' ); ?>
						</a>
					</div>
				</div>             
			</div>       
		</div>
	</section>
	<!-- Successfull connection end -->

<?php endif; ?>
