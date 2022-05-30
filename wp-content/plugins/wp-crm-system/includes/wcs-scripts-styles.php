<?php
/* Prevent direct access to the plugin */
if ( !defined( 'ABSPATH' ) ) {
	die( "Sorry, you are not allowed to access this page directly." );
}
//Include scripts and styles
function wpcrm_scripts_styles($hook) {
	global $post_type;
	include( WP_CRM_SYSTEM_PLUGIN_DIR . '/includes/wcs-vars.php' );
	$active_page = isset( $_GET[ 'page' ] ) ? $_GET[ 'page' ] : '';
	// for some reason the global $wpcrm_active_tab was returning NULL here
	$wpcrm_active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'dashboard';

	wp_enqueue_script( 'jquery' );
	wp_register_script( 'wp-crm-system-datepicker', WP_CRM_SYSTEM_URL . '/assets/dist/scripts/datepicker.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION );
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_localize_script( 'wp-crm-system-datepicker', 'wpcrm_system_datepicker_vars', array(
		'append_text'				=> apply_filters( 'wpcrm_system_datepicker_append_text', '' ),
		'auto_size'					=> apply_filters( 'wpcrm_system_datepicker_auto_size', false ),
		'button_image'				=> apply_filters( 'wpcrm_system_datepicker_button_image', '' ),
		'button_image_only'			=> apply_filters( 'wpcrm_system_datepicker_button_image_only', false ),
		'change_month'				=> apply_filters( 'wpcrm_system_datepicker_change_month', true ),
		'change_year'				=> apply_filters( 'wpcrm_system_datepicker_change_year', true ),
		'close_text'				=> apply_filters( 'wpcrm_system_datepicker_close_text', 'Done' ),
		'constrain_input'			=> apply_filters( 'wpcrm_system_datepicker_constrain_input', true ),
		'current_text'				=> apply_filters( 'wpcrm_system_datepicker_current_text', 'Today' ),
		'date_format'				=> apply_filters( 'wpcrm_system_datepicker_date_format', get_option( 'wpcrm_system_date_format' ) ),
		'day_names'					=> apply_filters( 'wpcrm_system_datepicker_day_names', array( 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ) ),
		'day_names_min'				=> apply_filters( 'wpcrm_system_datepicker_day_names_min', array( 'Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa' ) ),
		'day_names_short'			=> apply_filters( 'wpcrm_system_datepicker_day_names_short', array( 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ) ),
		'default_date'				=> apply_filters( 'wpcrm_system_datepicker_default_date', null ),
		'duration'					=> apply_filters( 'wpcrm_system_datepicker_duration', 'normal' ),
		'first_day'					=> apply_filters( 'wpcrm_system_datepicker_first_day', 0 ),
		'go_to_current'				=> apply_filters( 'wpcrm_system_datepicker_go_to_current', false ),
		'hide_if_no_prev_next'		=> apply_filters( 'wpcrm_system_datepicker_hide_if_no_prev_next', false ),
		'is_rtl'					=> apply_filters( 'wpcrm_system_datepicker_is_rtl', false ),
		'max_date'					=> apply_filters( 'wpcrm_system_datepicker_max_date', null ),
		'min_date'					=> apply_filters( 'wpcrm_system_datepicker_min_date', null ),
		'month_names'				=> apply_filters( 'wpcrm_system_datepicker_month_names', array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ) ),
		'month_names_short'			=> apply_filters( 'wpcrm_system_datepicker_month_names_short', array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ) ),
		'navigation_as_date_format'	=> apply_filters( 'wpcrm_system_datepicker_navigation_as_date_format', false ),
		'next_text'					=> apply_filters( 'wpcrm_system_datepicker_next_text', 'Next' ),
		'number_of_months'			=> apply_filters( 'wpcrm_system_datepicker_number_of_months', array( 1, 1 ) ),
		'prev_text'					=> apply_filters( 'wpcrm_system_datepicker_prevText', 'Prev' ),
		'select_other_months'		=> apply_filters( 'wpcrm_system_datepicker_select_other_months', false ),
		'short_year_cutoff'			=> apply_filters( 'wpcrm_system_datepicker_short_year_cutoff', '+10' ),
		'show_anim'					=> apply_filters( 'wpcrm_system_datepicker_show_anim', 'show' ),
		'show_button_panel'			=> apply_filters( 'wpcrm_system_datepicker_show_button_panel', false ),
		'show_current_at_pos'		=> apply_filters( 'wpcrm_system_datepicker_show_current_at_pos', 0 ),
		'show_month_after_year'		=> apply_filters( 'wpcrm_system_datepicker_show_month_after_year', false ),
		'show_on'					=> apply_filters( 'wpcrm_system_datepicker_show_on', 'focus' ),
		'show_other_months'			=> apply_filters( 'wpcrm_system_datepicker_show_other_months', false ),
		'show_week'					=> apply_filters( 'wpcrm_system_datepicker_show_week', false ),
		'step_months'				=> apply_filters( 'wpcrm_system_datepicker_step_months', 1 ),
		'week_header'				=> apply_filters( 'wpcrm_system_datepicker_week_header', 'Wk' ),
		'year_range'				=> apply_filters( 'wpcrm_system_datepicker_year_range', '1900:2100' ),
		'year_suffix'				=> apply_filters( 'wpcrm_system_datepicker_year_suffix', '' ),
	));
	wp_enqueue_script( 'wp-crm-system-datepicker' );

	wp_register_style( 'jquery-ui-datepicker', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/css/jquery-ui.min.css' );
	wp_enqueue_style( 'jquery-ui-datepicker' );

	wp_register_style( 'gmap-style', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/css/gmap.css' );
	wp_enqueue_style( 'gmap-style' );

	wp_register_style( 'wpcrm-style', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/css/wp-crm.css' );
	wp_enqueue_style( 'wpcrm-style' );

	if ( $active_page == 'wpcrm-email' ) {
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'wpcrm-system-accordion', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/accordion.js' );
	}

	if( 'client-area-upsell' == $wpcrm_active_tab || 'custom-fields-upsell' == $wpcrm_active_tab || 'importers-upsell' == $wpcrm_active_tab || 'invoicing-upsell' == $wpcrm_active_tab  ){
		wp_register_style( 'wpcrm-system-lightbox', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/css/lightbox.css' );
		wp_enqueue_style( 'wpcrm-system-lightbox' );
	}

	wp_enqueue_script( 'jquery-ui-tooltip' );
	wp_register_style( 'wp_crm_system_tooltips_css', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/css/tooltip.css' );
	wp_enqueue_style( 'wp_crm_system_tooltips_css' );

	wp_register_script( 'wp_crm_system_tooltips_js', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/tooltip.js', WP_CRM_SYSTEM_VERSION, false );
	wp_enqueue_script( 'wp_crm_system_tooltips_js' );

	if ( in_array( $post_type, $postTypes ) || 'wpcrm-invoice' == $post_type || 'wpcrm-settings' == $active_page ) {
		wp_register_script( 'wp_crm_system_edit_js', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/edit.js', WP_CRM_SYSTEM_VERSION, false );
		wp_enqueue_script( 'wp_crm_system_edit_js' );

		//Searchable Dropdown
		wp_register_script( 'wp_crm_chosen_core_js', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/chosen_v1.6.2/chosen.jquery.min.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION, false );
		wp_enqueue_script( 'wp_crm_chosen_core_js' );

		wp_register_script( 'wp_crm_searchable', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/wpCRMSystemSearchable.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION, false );
		wp_enqueue_script( 'wp_crm_searchable' );

		wp_register_style( 'wp_crm_system_chosen_core_css', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/chosen_v1.6.2/chosen.min.css' );
		wp_enqueue_style( 'wp_crm_system_chosen_core_css' );
	}
	if ( 'wpcrm-settings' == $active_page && ( '' == $wpcrm_active_tab || 'dashboard' == $wpcrm_active_tab ) ) {
		wp_register_script( 'wp_crm_system_dashboard_height', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/wp-crm-system-dashboard.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION, false );
		wp_enqueue_script( 'wp_crm_system_dashboard_height' );
	}

	wp_enqueue_script('wpcrm-ajax', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/wpcrm-update.js', array('jquery'));
	wp_localize_script('wpcrm-ajax', 'wpcrm_vars', array(
			'wpcrm_nonce' => wp_create_nonce('wpcrm-nonce')
		)
	);

	if ( 'wpcrm-contact' === $post_type ) {
		wp_enqueue_script( 'wp_crm_system_contact', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/wp-crm-system-contact.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION, false );
		wp_localize_script(
			'wp_crm_system_contact',
			'wp_crm_system_contact',
			array(
				'i18n' => array(
					'error_message' => array(
						'first_name'  => __( 'First name is required', 'wp-crm-system' ),
						'last_name'   => __( 'Last name is required', 'wp-crm-system' ),
						'email'       => __( 'Email is required', 'wp-crm-system' ),
						'email_valid' => __( 'Please enter a valid email address', 'wp-crm-system' ),
						'phone'       => __( 'Please enter a valid phone number', 'wp-crm-system' ),
						'mobile'      => __( 'Please enter a valid mobile number', 'wp-crm-system' ),
						'url'         => __( 'Please enter a valid URL adress', 'wp-crm-system' ),
					),
				),
			)
		);
	}
	if( 'wpcrm-task' === $post_type ) {
		wp_enqueue_script( 'wp_crm_system_task', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/wp-crm-system-task.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION, false );
		wp_localize_script(
			'wp_crm_system_task',
			'wp_crm_system_task',
			array(
				'i18n' => array(
					'error_message' => array(
						'task_title'  => __( 'Please provide a name for this task', 'wp-crm-system' ),
					),
				),
			)
		);
	}
	if( 'wpcrm-organization' === $post_type ) {
		wp_enqueue_script( 'wp_crm_system_organization', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/wp-crm-system-organization.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION, false );
		wp_localize_script(
			'wp_crm_system_organization',
			'wp_crm_system_organization',
			array(
				'i18n' => array(
					'error_message' => array(
						'title'       => __( 'Please provide title for this organisation', 'wp-crm-system' ),
						'email'       => __( 'Email is required', 'wp-crm-system' ),
						'email_valid' => __( 'Please enter a valid email address', 'wp-crm-system' ),
						'phone'       => __( 'Please enter a valid phone number', 'wp-crm-system' ),
						'url'         => __( 'Please enter a valid URL adress', 'wp-crm-system' ),
					),
				),
			)
		);
	}
	if( 'wpcrm-opportunity' === $post_type ) {
		wp_enqueue_script( 'wp_crm_system_opportunity', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/wp-crm-system-opportunity.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION, false );
		wp_localize_script(
			'wp_crm_system_opportunity',
			'wp_crm_system_opportunity',
			array(
				'i18n' => array(
					'error_message' => array(
						'title'    => __( 'Please provide title for this organisation', 'wp-crm-system' ),
						'required' => __( 'This field is required', 'wp-crm-system' ),
						'invalid'  => __( 'Please provide valid format', 'wp-crm-system' ),
					),
				),
			)
		);
	}
	if( 'wpcrm-project' === $post_type ) {
		wp_enqueue_script( 'wp_crm_system_project', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/wp-crm-system-project.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION, false );
		wp_localize_script(
			'wp_crm_system_project',
			'wp_crm_system_project',
			array(
				'i18n' => array(
					'error_message' => array(
						'title'    => __( 'Please provide title for this project', 'wp-crm-system' ),
						'required' => __( 'This field is required', 'wp-crm-system' ),
						'invalid'  => __( 'Please provide valid format', 'wp-crm-system' ),
					),
				),
			)
		);
	}
	if( 'wpcrm-campaign' === $post_type ) {
		wp_enqueue_script( 'wp_crm_system_campaign', WP_CRM_SYSTEM_PLUGIN_URL . '/assets/dist/scripts/wp-crm-system-campaign.js', array( 'jquery' ), WP_CRM_SYSTEM_VERSION, false );
		wp_localize_script(
			'wp_crm_system_campaign',
			'wp_crm_system_campaign',
			array(
				'i18n' => array(
					'error_message' => array(
						'title'    => __( 'Please provide title for this campaign', 'wp-crm-system' ),
						'required' => __( 'This field is required', 'wp-crm-system' ),
						'invalid'  => __( 'Please provide valid format', 'wp-crm-system' ),
					),
				),
			)
		);
	}
}
add_action( 'admin_enqueue_scripts', 'wpcrm_scripts_styles' );
