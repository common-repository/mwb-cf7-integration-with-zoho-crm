<?php
/**
 * Base Api Class
 *
 * @link       https://makewebbetter.com/
 * @since      1.0.0
 *
 * @package    Mwb_Cf7_Integration_With_Zoho
 * @subpackage Mwb_Cf7_Integration_With_Zoho/includes
 */

/**
 * Base Api Class.
 *
 * This class defines all code necessary api communication.
 *
 * @since      1.0.0
 * @package    Mwb_Cf7_Integration_With_Zoho
 * @subpackage Mwb_Cf7_Integration_With_Zoho/includes
 * @author     MakeWebBetter <webmaster@makewebbetter.com>
 */
class Mwb_Cf7_Integration_Zoho_Api extends Mwb_Cf7_Integration_Zoho_Api_Base {

	/**
	 * Zoho access token.
	 *
	 * @since    1.0.0
	 * @var      string    $access_token    Zoho access token.
	 */
	private static $client_id;

	/**
	 * Zoho access token.
	 *
	 * @since    1.0.0
	 * @var      string    $access_token    Zoho access token.
	 */
	private static $client_secret;

	/**
	 * Zoho access token.
	 *
	 * @since    1.0.0
	 * @var      string    $access_token    Zoho access token.
	 */
	private static $redirect_uri;

	/**
	 * Access token data.
	 *
	 * @var     string   Stores access token
	 * @since   1.0.0
	 */
	private static $access_token;

	/**
	 * Refresh token data
	 *
	 * @var     string   Stores refresh token
	 * @since   1.0.0
	 */
	private static $refresh_token;

	/**
	 * Api domain data
	 *
	 * @var     string   Stores api domain.
	 * @since   1.0.0
	 */
	private static $api_domain;

	/**
	 * Access token expiry data
	 *
	 * @var     integer   Stores access token expiry data.
	 * @since   1.0.0
	 */
	private static $expiry;

	/**
	 * Owner name.
	 *
	 * @var string Stores owner name.
	 * @since 1.0.3
	 */
	public static $owner_name;

	/**
	 * Owner email.
	 *
	 * @var string Stores owner email.
	 * @since 1.0.3
	 */
	public static $owner_email;

	/**
	 * Creates an instance of the class
	 *
	 * @var     object $_instance    An instance of the class
	 * @since   1.0.0
	 */
	protected static $_instance = null; // phpcs:ignore

	/**
	 * Main Mwb_Cf7_Integration_Zoho_Api Instance.
	 *
	 * Ensures only one instance of Mwb_Cf7_Integration_Zoho_Api is loaded or can be loaded.
	 *
	 * @since    1.0.0
	 * @return   Mwb_Cf7_Integration_Zoho_Api - Main instance.
	 */
	public static function get_instance() {

		if ( is_null( self::$_instance ) ) {

			self::$_instance = new self();
		}
		self::initialize();
		return self::$_instance;
	}

	/**
	 * Initalize the api class.
	 *
	 * @param     array $token_data   An array of access token data.
	 * @since     1.0.0
	 * @return    void
	 */
	private static function initialize( $token_data = array() ) {

		if ( empty( $token_data ) ) {
			$token_data = get_option( 'mwb_zcf7_zoho_token_data', array() );
		}

		$domain  = get_option( 'mwb-zcf7-domain', false );
		$own_app = get_option( 'mwb-zcf7-own-app', false );

		if ( false != $own_app && 'yes' == $own_app ) { // phpcs:ignore
			self::$client_id     = get_option( 'mwb-zcf7-client-id', '' );
			self::$client_secret = get_option( 'mwb-zcf7-secret-id', '' );
			self::$redirect_uri  = rtrim( admin_url(), '/' );
		} else {
			if ( false !== $domain && 'com.cn' == $domain ) { //phpcs:ignore
				self::$client_id     = '1000.T8QDVP4L47W1LMB607YGWZYUQ6JZDI';
				self::$client_secret = '3ea5940728055d03a45cb6bbf5a86ca12ba0065f7f';
			} else {
				self::$client_id     = '1000.G7PZKOKZUXKY8YSLC3U9NSQX5ILT9W';
				self::$client_secret = 'e625643302bd4b60a3d5e50e7652dfbce47514be90';
			}
			self::$redirect_uri = 'https://auth.makewebbetter.com/integration/zoho-auth/';
		}

		self::$access_token  = isset( $token_data['access_token'] ) ? $token_data['access_token'] : '';
		self::$refresh_token = isset( $token_data['refresh_token'] ) ? $token_data['refresh_token'] : '';
		self::$expiry        = isset( $token_data['expiry'] ) ? $token_data['expiry'] : '';
		self::$api_domain    = isset( $token_data['api_domain'] ) ? $token_data['api_domain'] : '';

		$owner_data = get_option( 'mwb-zcf7-user-info', false );

		self::$owner_name  = isset( $owner_data['user_name'] ) ? $owner_data['user_name'] : '';
		self::$owner_email = isset( $owner_data['email'] ) ? $owner_data['email'] : '';

	}

	/**
	 * Get Client id.
	 *
	 * @return string Api domain.
	 */
	public function get_client_id() {
		return self::$client_id;
	}

	/**
	 * Get Client secret.
	 *
	 * @return string Api domain.
	 */
	public function get_client_secret() {
		return self::$client_secret;
	}

	/**
	 * Get redirect url.
	 *
	 * @return string Api domain.
	 */
	public function get_redirect_uri() {
		return self::$redirect_uri;
	}

	/**
	 * Get api domain
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	public function get_api_domain() {
		return self::$api_domain;
	}

	/**
	 * Get access token
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	public function get_access_token() {
		return self::$access_token;
	}

	/**
	 * Get refresh token
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	public function get_refresh_token() {
		return self::$refresh_token;
	}

	/**
	 * Retrieve access token expiry
	 *
	 * @since     1.0.0
	 * @return    integer
	 */
	public function get_access_token_expiry() {
		return self::$expiry;
	}

	/**
	 * Access token validation
	 *
	 * @since     1.0.0
	 * @return    bool
	 */
	public function is_access_token_valid() {
		return ( self::$expiry > time() );
	}

	/**
	 * Get owner name.
	 *
	 * @since 1.0.3
	 * @return string
	 */
	public function get_owner_name() {
		return self::$owner_name;
	}

	/**
	 * Get owner_email.
	 *
	 * @since 1.0.3
	 * @return string
	 */
	public function get_owner_email() {
		return self::$owner_email;
	}


	/**
	 * Renew access token.
	 *
	 * @since     1.0.0
	 * @return    bool
	 */
	public function renew_access_token() {

		$endpoint       = '/oauth/v2/token';
		$client_id      = $this->get_client_id();
		$client_secret  = $this->get_client_secret();
		$domain         = get_option( 'mwb-zcf7-domain', 'in' );
		$acc_url        = 'https://accounts.zoho.' . $domain;
		$refresh_token  = $this->get_refresh_token();
		$params         = array(
			'grant_type'    => 'refresh_token',
			'client_id'     => $client_id,
			'client_secret' => $client_secret,
			'refresh_token' => $refresh_token,
		);
		$this->base_url = $acc_url;
		$response       = $this->post( $endpoint, $params );
		if ( 200 == $response['code'] && $this->check_response_error( $response ) ) { // phpcs:ignore
			$this->save_token_data( $response['data'] );
			return true;
		}
		return false;
	}

	/**
	 * Save token data in an option.
	 *
	 * @param     array $token_data    An array of token data to save.
	 * @since     1.0.0
	 * @return    void
	 */
	public function save_token_data( $token_data ) {
		$old_token_data = get_option( 'mwb_zcf7_zoho_token_data' );
		foreach ( $token_data as $key => $value ) {
			$old_token_data[ $key ] = $value;
			if ( 'expires_in' == $key ) { // phpcs:ignore
				$old_token_data['expiry'] = time() + $value;
			}
		}
		$this->initialize( $old_token_data );
		update_option( 'mwb_zcf7_zoho_token_data', $old_token_data );
		update_option( 'mwb_is_crm_active', true );
	}

	/**
	 * Get referesh token data form zoho.
	 *
	 * @param     mixed $code    Status code.
	 * @since     1.0.0
	 * @return    bool
	 */
	public function get_refresh_token_data( $code ) {

		$endpoint       = '/oauth/v2/token';
		$client_id      = $this->get_client_id();
		$client_secret  = $this->get_client_secret();
		$domain         = get_option( 'mwb-zcf7-domain', 'in' );
		$acc_url        = 'https://accounts.zoho.' . $domain;
		$redirect_uri   = $this->get_redirect_uri();
		$params         = array(
			'grant_type'    => 'authorization_code',
			'client_id'     => $client_id,
			'client_secret' => $client_secret,
			'redirect_uri'  => $redirect_uri,
			'code'          => $code,
		);
		$this->base_url = $acc_url;
		$response       = $this->post( $endpoint, $params );

		if ( 200 == $response['code'] && $this->check_response_error( $response ) ) { // phpcs:ignore
			$this->save_token_data( $response['data'] );
			return true;
		}
		return false;
	}

	/**
	 * Get account authorization URL.
	 *
	 * @since      1.0.0
	 * @return     string
	 */
	public function get_auth_code_url() {

		$client_id     = $this->get_client_id();
		$client_secret = $this->get_client_secret();
		$redirect_uri  = $this->get_redirect_uri();
		$domain        = get_option( 'mwb-zcf7-domain', 'in' );
		$own_app       = get_option( 'mwb-zcf7-own-app', false );

		if ( ! $client_id || ! $client_secret || ! $domain ) {
			return false;
		}

		$acc_url     = 'https://accounts.zoho.' . $domain . '/oauth/v2/auth';
		$auth_params = array(
			'scope'         => $this->get_oauth_scopes( $own_app ),
			'client_id'     => $client_id,
			'response_type' => 'code',
			'access_type'   => 'offline',
			'redirect_uri'  => $redirect_uri,
		);

		if ( 'yes' !== $own_app ) {
			$auth_params['state'] = $this->get_oauth_state();
		}

		$auth_url = add_query_arg( $auth_params, $acc_url );
		return $auth_url;
	}

	/**
	 * Get oauth scopes.
	 *
	 * @param string $own_app   Method of integration.
	 * @since 1.0.3
	 */
	public function get_oauth_scopes( $own_app ) {

		if ( empty( $own_app ) ) {
			return;
		}

		$scope = '';
		switch ( $own_app ) {
			case 'yes':
				$scope = 'ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,ZohoCRM.users.Read,ZohoCRM.coql.READ';
				break;

			case 'no':
				$scope = 'ZohoCRM.modules.READ,ZohoCRM.modules.CREATE,ZohoCRM.modules.UPDATE,ZohoCRM.settings.ALL,ZohoCRM.users.Read,ZohoCRM.coql.READ';
				break;
		}

		return $scope;
	}

	/**
	 * Get user info.
	 *
	 * @since 1.0.3
	 * @return array
	 */
	public function get_user_info() {

		// Get new access token if current token is expired.
		if ( ! $this->is_access_token_valid() ) {
			$this->renew_access_token();
		}

		$owner_info = array();

		$this->base_url = $this->get_api_domain();
		$endpoint       = '/crm/v2/users?type=CurrentUser';
		$headers        = $this->get_auth_header();
		$response       = $this->get( $endpoint, '', $headers );

		if ( isset( $response['code'] ) && 200 == $response['code'] && 'OK' == $response['message'] ) { // phpcs:ignore
			if ( ! empty( $response['data'] ) && ! empty( $response['data']['users'] ) ) {
				foreach ( $response['data']['users'] as $user ) {
					if ( isset( $user['personal_account'] ) && true == $user['personal_account'] ) { // phpcs:ignore
						$owner_info['user_name'] = $user['full_name'];
						$owner_info['email']     = $user['email'];
					}
				}
			}
		}

		update_option( 'mwb-zcf7-user-info', $owner_info );
		return $response;

	}

	/**
	 * Get oauth state with current instance redirect url.
	 *
	 * @return string State.
	 */
	public function get_oauth_state() {
		$admin_redirect_url = rtrim( admin_url(), '/' );

		$args = array(
			'mwb_nonce'  => $this->mwb_zcf7_create_nonce(),
			'mwb_source' => 'zoho',
		);

		$admin_redirect_url = add_query_arg( $args, $admin_redirect_url );
		return urlencode( $admin_redirect_url ); // phpcs:ignore
	}

	/**
	 * Create unique nonce for authorization.
	 *
	 * @return string unique nonce.
	 */
	public function mwb_zcf7_create_nonce() {
		$timestamp  = time();
		$nonce_key  = 'mwb_zcf7_auth_nonce_' . $timestamp;
		$nonce      = wp_create_nonce( $nonce_key );
		$nonce_data = array( $timestamp => $nonce );
		update_option( 'mwb_zcf7_auth_nonce_data', $nonce_data );
		return $nonce;
	}

	/**
	 * Verify unique nonce.
	 *
	 * @param  string $nonce Nonce string to be verified.
	 * @return bool .
	 */
	public function mwb_zcf7_verify_nonce( $nonce ) {

		$nonce_data = get_option( 'mwb_zcf7_auth_nonce_data', array() );
		if ( empty( $nonce_data ) ) {
			return false;
		}

		$nonce_timestamp = array_search( $nonce, $nonce_data ); // phpcs:ignore
		if ( false === $nonce_timestamp ) {
			return false;
		}

		$nonce_key = 'mwb_zcf7_auth_nonce_' . $nonce_timestamp;
		if ( ! wp_verify_nonce( $nonce, $nonce_key ) ) {
			return false;
		}
		delete_option( 'mwb_zcf7_auth_nonce_data', $nonce_data );
		return true;
	}

	/**
	 * Get auth header data.
	 *
	 * @since     1.0.0
	 * @return    array
	 */
	public function get_auth_header() {
		$headers = array(
			'Authorization' => sprintf( 'Zoho-oauthtoken %s', $this->get_access_token() ),
		);
		return $headers;
	}

	/**
	 * Get selected module fields.
	 *
	 * @param     array $module    An array of module data.
	 * @param     bool  $force     True if refresh fields.
	 * @since     1.0.0
	 * @return    array
	 */
	public function get_module_fields( $module, $force = false ) {

		$data = array();

		// Get new access token if current token is expired.
		if ( ! $this->is_access_token_valid() ) {
			$this->renew_access_token();
		}

		$data = get_transient( 'mwb_zcf7_' . $module . '_fields' );
		if ( ! $force && false !== ( $data ) ) { // phpcs:ignore
			return $data;
		}

		$response = $this->get_fields( $module );

		if ( $this->is_success( $response ) ) {
			$data = $response['data'];
			set_transient( 'mwb_zcf7_' . $module . '_fields', $data );
		}

		return $data;
	}

	/**
	 * Get all zoho modules data.
	 *
	 * @param      bool $force    Whether to get data from api, or from db.
	 * @since      1.0.0
	 * @return     array
	 */
	public function get_modules_data( $force = false ) {

		$data = array();
		if ( ! $this->is_access_token_valid() ) {
			$this->renew_access_token();
		}

		if ( ! $force && false !== ( $data ) ) { // phpcs:ignore
			$data = get_transient( 'mwb_zcf7_modules_data' );
			if ( ! empty( $data ) ) {
				return $data;
			}
		}

		$response = $this->get_modules();
		if ( $this->is_success( $response ) ) {
			if ( ! empty( $response['data']['modules'] ) && is_array( $response['data']['modules'] ) ) {
				foreach ( $response['data']['modules'] as $key => $module ) {
					if ( isset( $module['api_supported'] ) && true == $module['api_supported'] && isset( $module['editable'] ) && true == $module['editable'] ) { // phpcs:ignore
						$data[ $module['api_name'] ] = $module['plural_label'];
					}
				}
			}
			set_transient( 'mwb_zcf7_modules_data', $data );
		}
		return $data;
	}

	/**
	 * Get records data
	 *
	 * @param     string  $module    Crm object.
	 * @param     boolean $force     Fetch from api.
	 * @since     1.0.0
	 * @return    array
	 */
	public function get_records_data( $module, $force = false ) {
		$data = array();
		if ( ! $this->is_access_token_valid() ) {
			$this->renew_access_token();
		}

		$data = get_transient( 'mwb_zcf7_' . $module . '_data' );
		if ( ! $force && false !== ( $data ) ) { // phpcs:ignore
			return $data;
		}

		$response = $this->get_records( $module );
		if ( $this->is_success( $response ) ) {
			$data = $response['data'];
			set_transient( 'mwb_zcf7_' . $module . '_data', $data );
		}
		return $data;
	}

	/**
	 * Get single record data.
	 *
	 * @param      string $module       Crm object.
	 * @param      int    $record_id    Record ID.
	 * @since      1.0.0
	 * @return     array
	 */
	public function get_single_record_data( $module, $record_id ) {
		$data = array();
		if ( ! $this->is_access_token_valid() ) {
			$this->renew_access_token();
		}
		$response = $this->get_single_record( $module, $record_id );
		if ( $this->is_success( $response ) ) {
			$data = $response['data'];
		}
		return $data;
	}

	/**
	 * Create single record.
	 *
	 * @param      string $module         Crm object.
	 * @param      array  $record_data    An array of data to be sent over crm.
	 * @param      bool   $is_bulk        Whether to send bulk data.
	 * @param      array  $log_data       An array of data to log.
	 * @param      bool   $manual_sync    If synced manually.
	 * @since      1.0.0
	 * @return     array
	 */
	public function create_single_record( $module, $record_data, $is_bulk = false, $log_data = array(), $manual_sync = false ) {

		$data = array();
		if ( ! $this->is_access_token_valid() ) {
			$this->renew_access_token();
		}
		$response = $this->create_or_update_record( $module, $record_data, $is_bulk, $log_data, $manual_sync );
		if ( $this->is_success( $response ) ) {
			$data = $response['data'];
		} else {
			$data = $response;
		}
		return $data;
	}

	/**
	 * Create or update a record.
	 *
	 * @param     string $module         Crm object.
	 * @param     array  $record_data    An array of data to be sent to zoho.
	 * @param     bool   $is_bulk        Whether to send bulk data.
	 * @param     array  $log_data       An array of data to log.
	 * @param     bool   $manual_sync    If synced manually.
	 * @since     1.0.0
	 * @return    array
	 */
	public function create_or_update_record( $module, $record_data, $is_bulk, $log_data, $manual_sync ) {

		$feed_id        = ! empty( $log_data['feed_id'] ) ? $log_data['feed_id'] : false;
		$this->base_url = $this->get_api_domain();
		$endpoint       = '/crm/v2/' . $module . '/upsert';

		if ( true == $is_bulk ) { // phpcs:ignore
			$request['data'] = $record_data;
		} else {
			$request['data'] = array( $record_data );
		}

		// To determine if manual sync or real time sync.
		if ( $manual_sync && ! empty( $log_data['method'] ) ) {
			$event = $log_data['method'];
		} else {
			$event = __FUNCTION__;
		}

		// If primary key is set.
		if ( $feed_id ) {
			$duplicate_check_fields = get_post_meta( $feed_id, 'mwb_zcf7_primary_field' );
			if ( ! empty( $duplicate_check_fields ) ) {
				$request['duplicate_check_fields'] = $duplicate_check_fields;
			}
		}
		$request_data = wp_json_encode( $request );
		$headers      = $this->get_auth_header();
		$response     = $this->post( $endpoint, $request_data, $headers );

		$this->log_request_in_db( $event, $module, $request, $response, $log_data );

		return $response;

	}

	/**
	 * Retrieve object ID from crm response.
	 *
	 * @param     array $response     An array of response data from crm.
	 * @since     1.0.0
	 * @return    integer
	 */
	public function get_object_id_from_response( $response ) {
		$id = '-';
		if ( isset( $response['data'] ) && isset( $response['data']['data'] ) ) {
			$data = $response['data']['data'];
			if ( isset( $data[0] ) && isset( $data[0]['details'] ) ) {
				return ! empty( $data[0]['details']['id'] ) ? $data[0]['details']['id'] : $id;
			}
		}
		return $id;
	}

	/**
	 * Insert log data in db.
	 *
	 * @param     string $event          Trigger event/ Feed .
	 * @param     string $zoho_object    Name of zoho module.
	 * @param     array  $request        An array of request data.
	 * @param     array  $response       An array of response data.
	 * @param     array  $log_data       Data to log.
	 * @return    void
	 */
	public function log_request_in_db( $event, $zoho_object, $request, $response, $log_data ) {
		$zoho_id = $this->get_object_id_from_response( $response );

		if ( '-' == $zoho_id ) { // phpcs:ignore
			if ( ! empty( $log_data['id'] ) ) {
				$zoho_id = $log_data['id'];
			}
		}

		$request  = serialize( $request ); // phpcs:ignore
		$response = serialize( $response ); // phpcs:ignore

		$feed        = ! empty( $log_data['feed_name'] ) ? $log_data['feed_name'] : false;
		$feed_id     = ! empty( $log_data['feed_id'] ) ? $log_data['feed_id'] : false;
		$event       = ! empty( $event ) ? $event : false;
		$zoho_object = ! empty( $log_data['zoho_object'] ) ? $log_data['zoho_object'] : false;

		$time     = time();
		$log_data = compact( 'event', 'zoho_object', 'request', 'response', 'zoho_id', 'feed_id', 'feed', 'time' );
		$this->insert_log_data( $log_data );

	}

	/**
	 * Insert data to db.
	 *
	 * @param      array $data    Data to log.
	 * @since      1.0.0
	 * @return     void
	 */
	public function insert_log_data( $data ) {

		$connect         = 'Mwb_Cf7_Integration_Connect_Zoho_Framework';
		$connect_manager = $connect::get_instance();

		if ( 'yes' != $connect_manager->get_settings_details( 'logs' ) ) { // phpcs:ignore
			return;
		}

		global $wpdb;
		$table    = $wpdb->prefix . 'mwb_zcf7_log';
		$response = $wpdb->insert( $table, $data ); // phpcs:ignore
	}

	/**
	 * Create record over crm
	 *
	 * @param     string $module         Crm object.
	 * @param     array  $record_data    An array of data to be sent over crm.
	 * @since     1.0.0
	 * @return    array
	 */
	public function create_record( $module, $record_data ) {
		$this->base_url  = $this->get_api_domain();
		$endpoint        = '/crm/v2/' . $module;
		$request['data'] = array( $record_data );
		$request_data    = wp_json_encode( $request );
		$headers         = $this->get_auth_header();
		return $this->post( $endpoint, $request_data, $headers );
	}

	/**
	 * Retrieve records of an object.
	 *
	 * @param     string $module   Crm object.
	 * @since     1.0.0
	 * @return    array
	 */
	public function get_records( $module ) {
		$this->base_url = $this->get_api_domain();
		$endpoint       = '/crm/v2/' . $module;
		$data           = array();
		$headers        = $this->get_auth_header();
		$response       = $this->get( $endpoint, $data, $headers );
		return $response;
	}

	/**
	 * Retrieve single record.
	 *
	 * @param     string $module       Crm object.
	 * @param     int    $record_id    Record ID.
	 * @since     1.0.0
	 * @return    array
	 */
	public function get_single_record( $module, $record_id ) {
		$this->base_url = $this->get_api_domain();
		$endpoint       = '/crm/v2/' . $module . '/' . $record_id;
		$data           = array();
		$headers        = $this->get_auth_header();
		return $this->get( $endpoint, $data, $headers );
	}

	/**
	 * Get modules from zoho.
	 *
	 * @since     1.0.0
	 * @return    array
	 */
	public function get_modules() {
		$this->base_url = $this->get_api_domain();
		$endpoint       = '/crm/v2/settings/modules';
		$data           = array();
		$headers        = $this->get_auth_header();
		$response       = $this->get( $endpoint, $data, $headers );
		return $response;
	}

	/**
	 * Get fields
	 *
	 * @param     string $module   Zoho module.
	 * @return    array
	 * @since     1.0.0
	 */
	public function get_fields( $module ) {

		$this->base_url = $this->get_api_domain();
		$endpoint       = '/crm/v2/settings/fields';
		$data           = array( 'module' => $module );
		$headers        = $this->get_auth_header();
		$response       = $this->get( $endpoint, $data, $headers );
		return $response;
	}

	/**
	 * Check if response is a success response.
	 *
	 * @param     array $response    An array of response data.
	 * @since     1.0.0
	 * @return    bool
	 */
	public function is_success( $response ) {
		if ( isset( $response['code'] ) ) {
			return in_array( $response['code'], array( 200, 201, 204, 202 ) ); // phpcs:ignore
		}
		return false;
	}

	/**
	 * Validate error response.
	 *
	 * @param     array $response   An array of response data.
	 * @return    bool
	 * @since     1.0.0
	 */
	public function check_response_error( $response ) {

		if ( ! empty( $response['data'] ) ) {
			if ( ! empty( $response['data']['error'] ) ) {
				return false;
			} else {
				return true;
			}
		}
		return false;
	}

}
