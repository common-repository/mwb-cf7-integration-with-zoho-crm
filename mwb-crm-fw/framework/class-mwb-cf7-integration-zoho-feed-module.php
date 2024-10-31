<?php
/**
 * The complete management for the Zoho-CF7 feeds custom post type.
 *
 * @since      1.0.0
 * @package    Mwb_Cf7_Integration_With_Zoho
 * @subpackage Mwb_Cf7_Integration_With_Zoho/mwb-crm-fw
 * @author     MakeWebBetter <https://makewebbetter.com>
 */

/**
 * The complete management for the Zoho-CF7 feeds custom post type.
 *
 * @since      1.0.0
 * @package    Mwb_Cf7_Integration_With_Zoho
 * @subpackage Mwb_Cf7_Integration_With_Zoho/mwb-crm-fw
 * @author     MakeWebBetter <https://makewebbetter.com>
 */
class Mwb_Cf7_Integration_Zoho_Feed_Module {


	/**
	 * Current crm slug.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $crm_slug    The current crm slug.
	 */
	private $crm_slug;

	/**
	 * Current crm name.
	 *
	 * @since     1.0.0
	 * @access    private
	 * @var       string   $crm_name    The current crm name.
	 */
	private $crm_name;

	/**
	 * Current crm name.
	 *
	 * @since     1.0.0
	 * @access    public
	 * @var       string   $crm_name    The current crm name.
	 */
	public $crm_title;

	/**
	 * Feed CPT name/slug.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $feed_name    Feeds CPT name/slug.
	 */
	private $feed_name;

	/**
	 * Instance of the current class.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @var     object    $instance    Instance of the current class.
	 */
	protected static $_instance = null; // phpcs:ignore

	/**
	 * Instance of Connect manager class.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $connect_manager  Instance of the Connect manager class.
	 */
	private $connect_manager;

	/**
	 * Instance of the plugin main class.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      object   $core_class    Name of the plugin core class.
	 */
	public $core_class = 'Mwb_Cf7_Integration_With_Zoho';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		self::$_instance = $this;

		// Initialise CRM name and slug.
		$this->crm_slug  = $this->core_class::get_current_crm( 'slug' );
		$this->crm_title = $this->core_class::get_current_crm( 'title' );
		$this->crm_name  = $this->core_class::get_current_crm();

		// Initialise Feed CPT name/slug.
		$this->feed_name = 'mwb_' . $this->crm_slug . '_cf7';

		// Initialise Connect manager class.
		$this->connect_manager = Mwb_Cf7_Integration_With_Zoho::get_integration_module( 'framework' );

	}

	/**
	 * Main Mwb_Cf7_Integration_Zoho_Feed_Module Instance.
	 *
	 * Ensures only one instance of Mwb_Cf7_Integration_Zoho_Feed_Module is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @static
	 * @return Mwb_Cf7_Integration_Zoho_Feed_Module - Main instance.
	 */
	public static function get_instance() {

		if ( null == self::$_instance ) { //phpcs:ignore

			self::$_instance = new self();
		}
		return self::$_instance;
	}



	/**
	 * Register custom post type for feeds.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	public function register_feeds_post_type() {

		// Set UI labels for Custom Post Type.
		$labels = array(
			'name'               => _x( 'Feeds', 'Post Type General Name', 'mwb-cf7-integration-with-zoho' ),
			'singular_name'      => _x( 'Feed', 'Post Type Singular Name', 'mwb-cf7-integration-with-zoho' ),
			'menu_name'          => _x( 'Crm Feeds', 'Admin menu name', 'mwb-cf7-integration-with-zoho' ),
			'parent_item_colon'  => __( 'Parent Feed', 'mwb-cf7-integration-with-zoho' ),
			'all_items'          => __( 'All Feeds', 'mwb-cf7-integration-with-zoho' ),
			'view_item'          => __( 'View Feed', 'mwb-cf7-integration-with-zoho' ),
			'add_new_item'       => __( 'Add New Feed', 'mwb-cf7-integration-with-zoho' ),
			'add_new'            => __( 'Add New', 'mwb-cf7-integration-with-zoho' ),
			'edit_item'          => __( 'Edit Feed', 'mwb-cf7-integration-with-zoho' ),
			'update_item'        => __( 'Update Feed', 'mwb-cf7-integration-with-zoho' ),
			'search_items'       => __( 'Search Feed', 'mwb-cf7-integration-with-zoho' ),
			'not_found'          => __( 'Not Found', 'mwb-cf7-integration-with-zoho' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'mwb-cf7-integration-with-zoho' ),
		);

		$args = array(
			'label'                => __( 'Feeds', 'mwb-cf7-integration-with-zoho' ),
			'description'          => __( 'Feeds for crm', 'mwb-cf7-integration-with-zoho' ),
			'labels'               => $labels,
			'supports'             => array( 'title' ),
			'hierarchical'         => false,
			'public'               => true,
			'menu_position'        => 5,
			'can_export'           => true,
			'has_archive'          => true,
			'show_in_rest'         => true,
			'exclude_from_search'  => false,
			'publicly_queryable'   => false,
			'show_in_menu'         => false,
			'show_in_nav_menus'    => false,
			'show_in_admin_bar'    => false,
			'register_meta_box_cb' => array( $this, 'add_feed_meta_box' ),
		);

		register_post_type( 'mwb_zoho_feeds', $args );
	}

	/**
	 * Callback :: Add feeds metabox.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	public function add_feed_meta_box() {

		global $post;
		$metaboxes = array();

		$metaboxes[] = array(
			'slug'     => 'mwb_' . $this->crm_slug . '_cf7_feeds_meta_box',
			'title'    => esc_html__( 'Feed details', 'mwb-cf7-integration-with-zoho' ),
			'callback' => 'feeds_mb_render',
			'screen'   => 'mwb_zoho_feeds',
			'context'  => '',
			'priority' => '',
		);

		$metaboxes[] = array(
			'slug'     => 'mwb_' . $this->crm_slug . '_cf7_feeds_condition_meta_box',
			'title'    => esc_html__( 'Conditional Statements', 'mwb-cf7-integration-with-zoho' ),
			'callback' => 'feeds_mb_condition_render',
			'screen'   => 'mwb_zoho_feeds',
			'context'  => '',
			'priority' => '',
		);

		$metaboxes = apply_filters( 'mwb_zcf7_feeds_pro_mb', $metaboxes );

		foreach ( $metaboxes as $key => $metabox ) {

			if ( class_exists( 'Cf7_Integration_With_' . $this->crm_name . '_Crm_Feed_Extension' ) && ! method_exists( $this, $metabox['callback'] ) ) {
				$metabox_content = $this->get_pro_callback( $key );
			} else {
				$metabox_content = '';
			}

			add_meta_box(
				$metabox['slug'],
				$metabox['title'],
				! empty( $metabox_content ) ? $metabox_content : array( $this, $metabox['callback'] ),
				$metabox['screen'],
				! empty( $metabox['context'] ) ? $metabox['context'] : 'advanced',
				! empty( $metabox['priority'] ) ? $metabox['priority'] : 'default'
			);

		}

	}

	/**
	 * Get meta-box call back for pro.
	 *
	 * @param     string $key    Meta box key.
	 * @since     1.0.0
	 * @return    mixed
	 */
	public function get_pro_callback( $key = '' ) {

		if ( empty( $key ) ) {
			return;
		}

		$pro       = 'Cf7_Integration_With_' . $this->crm_name . '_Crm_Feed_Extension';
		$pro_class = $pro::get_instance();
		$result    = '';
		switch ( $key ) {

			case 'pro-manual-sync':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_pro_manual_sync' );
				break;

			case 'pro-add-notes':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_pro_add_notes' );
				break;

			case 'pro-associate-account':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_associate_account' );
				break;

			case 'pro-associate-contact':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_associate_contact' );
				break;

			case 'pro-associate-campaign':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_associate_campaign' );
				break;

			case 'pro-add-lead':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_pro_add_lead' );
				break;

			case 'pro-add-attahcment':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_pro_add_attachments' );
				break;

			case 'pro-add-rimage':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_pro_add_rimage' );
				break;

			case 'pro-add-layout':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_pro_add_layout' );
				break;

			case 'pro-add-owner':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_pro_add_owner' );
				break;

			case 'pro-add-tags':
				$result = array( $pro_class, 'mwb_cf7_' . $this->crm_slug . '_feeds_add_tags' );
				break;

		}

		return $result;
	}

	/**
	 * Callback :: Post type feeds mapping metabox.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	public function feeds_mb_render() {

		global $post;
		$params                    = array();
		$params['objects']         = $this->connect_manager->get_available_crm_objects();
		$params['forms']           = $this->connect_manager->get_available_cf7_forms();
		$params['selected_form']   = $this->fetch_feed_data( $post->ID, 'mwb_zcf7_form', '' );
		$params['selected_object'] = $this->fetch_feed_data( $post->ID, 'mwb_zcf7_object', '' );
		$params['dependent_on']    = $this->fetch_feed_data( $post->ID, 'mwb-' . $this->crm_slug . '-cf7-dependent-on', '' );

		$this->render_mb_data( 'header' );
		$this->render_mb_data( 'select-form', $params );
		$this->render_mb_data( 'select-object', $params );
		$this->render_mb_data( 'footer' );
	}

	/**
	 * Callback :: Post type feeds conditional filter metabox.
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	public function feeds_mb_condition_render() {
		global $post;
		$params = array();

		$form_id                 = $this->fetch_feed_data( $post->ID, 'mwb_zcf7_form', '' );
		$params['enable_filter'] = $this->fetch_feed_data( $post->ID, 'mwb_zcf7_enable_filters', '' );
		$params['condition']     = $this->fetch_feed_data( $post->ID, 'mwb_zcf7_condtion_field', array() );
		$params['fields']        = $this->connect_manager->getMappingDataset( $form_id );
		$this->render_mb_data( 'opt-in-condition', $params );
	}

	/**
	 * Render html and data.
	 *
	 * @param     string $meta_box    Name of the meta box.
	 * @param     array  $params      An array of metabox params.
	 * @since     1.0.0
	 * @return    void
	 */
	private function render_mb_data( $meta_box = false, $params = array() ) {

		if ( empty( $meta_box ) ) {
			return;
		}
		$params['admin_class'] = 'Mwb_Cf7_Integration_With_' . $this->crm_name . '_Crm_Admin';

		$path = 'templates/meta-boxes/' . $meta_box . '.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . $path;
	}

	/**
	 * Fetch feeds data.
	 *
	 * @param      int    $post_id          Feed ID.
	 * @param      string $key              Data key.
	 * @param      string $default          Default value.
	 * @param      mixed  $selected_object  Chosen value.
	 * @since      1.0.0
	 * @return     mixed
	 */
	public function fetch_feed_data( $post_id, $key, $default, $selected_object = '' ) {

		if ( ! $post_id ) {
			$method = 'get_default_' . $key;
			if ( method_exists( $this, $method ) && '' != $selected_object ) { // phpcs:ignore
				$default = $this->$method( $selected_object );
			}
			return $default;
		}
		$feed_data = get_post_meta( $post_id, $key, true );
		$feed_data = ! empty( $feed_data ) ? $feed_data : $default;
		return $feed_data;
	}

	/**
	 * Save feeds data.
	 *
	 * @param     int $post_id    Feed ID.
	 * @since     1.0.0
	 * @return    void
	 */
	public function save_feeds_data( $post_id ) {

		if ( ! isset( $_POST['_wpnonce'] ) ) {
			return;
		}

		if ( ! isset( $_POST['meta_box_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['meta_box_nonce'] ) ), 'meta_box_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( isset( $_POST['post_type'] ) && 'mwb_zoho_feeds' == $_POST['post_type'] ) { // phpcs:ignore

			$crm_form         = isset( $_POST['crm_form'] ) ? sanitize_text_field( wp_unslash( $_POST['crm_form'] ) ) : '';
			$crm_object       = isset( $_POST['crm_object'] ) ? sanitize_text_field( wp_unslash( $_POST['crm_object'] ) ) : '';
			$crm_field_arr    = isset( $_POST['crm_field'] ) ? map_deep( wp_unslash( $_POST['crm_field'] ), 'sanitize_text_field' ) : array();
			$field_type_arr   = isset( $_POST['field_type'] ) ? map_deep( wp_unslash( $_POST['field_type'] ), 'sanitize_text_field' ) : array();
			$field_value_arr  = isset( $_POST['field_value'] ) ? map_deep( wp_unslash( $_POST['field_value'] ), 'sanitize_text_field' ) : array();
			$custom_value_arr = isset( $_POST['custom_value'] ) ? map_deep( wp_unslash( $_POST['custom_value'] ), 'sanitize_text_field' ) : array();
			$custom_field_arr = isset( $_POST['custom_field'] ) ? map_deep( wp_unslash( $_POST['custom_field'] ), 'sanitize_text_field' ) : array();
			$enable_filters   = isset( $_POST['enable_add_condition'] ) ? sanitize_text_field( wp_unslash( $_POST['enable_add_condition'] ) ) : '';
			$condition        = isset( $_POST['condition'] ) ? map_deep( wp_unslash( $_POST['condition'] ), 'sanitize_text_field' ) : array();
			$primary_field    = isset( $_POST['primary_field'] ) ? sanitize_text_field( wp_unslash( $_POST['primary_field'] ) ) : '';

			$mapping_data = array();
			if ( ! empty( $crm_field_arr ) && is_array( $crm_field_arr ) ) {
				foreach ( $crm_field_arr as $key => $field ) {
					$mapping_data[ $field ] = array(
						'field_type'   => $field_type_arr[ $key ],
						'field_value'  => $field_value_arr[ $key ],
						'custom_value' => $custom_value_arr[ $key ],
						'custom_field' => $custom_field_arr[ $key ],
					);
				}
			}

			update_post_meta( $post_id, 'mwb_zcf7_form', $crm_form );
			update_post_meta( $post_id, 'mwb_zcf7_object', $crm_object );
			update_post_meta( $post_id, 'mwb_zcf7_mapping_data', $mapping_data );
			update_post_meta( $post_id, 'mwb_zcf7_primary_field', $primary_field );
			update_post_meta( $post_id, 'mwb_zcf7_enable_filters', $enable_filters );
			update_post_meta( $post_id, 'mwb_zcf7_condtion_field', $condition );

			do_action( 'mwb_zcf7_save_feed_data', $_POST, $post_id );
		}
	}

	/**
	 * Create meta box section html via ajax.
	 *
	 * @param  string $meta_box Meta box key.
	 * @param  array  $params   Required params for meta box.
	 * @return string           Meta box section html.
	 */
	public function do_ajax_render( $meta_box, $params ) {

		if ( '' == $meta_box ) { // phpcs:ignore
			return;
		}

		ob_start();
		$this->render_mb_data( $meta_box, $params );
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	/**
	 * Check if filter applicable.
	 *
	 * @param   array $filters     Filters array.
	 * @since   1.0.0
	 * @return  bool.
	 */
	public function if_filter_applied( $filters = array() ) {

		if ( ! is_array( $filters ) ) {
			return;
		}

		foreach ( $filters as $or => $orvalues ) {
			foreach ( $orvalues as $index => $val ) {
				if ( '-1' == $val['field'] || '-1' == $val['option'] ) { // phpcs:ignore
					return false;
				} else {
					return true;
				}
			}
		}
	}

}
