<?php
/**
 * Displays category dropdown
 *
 * Depending on the data types, the category field will vary
 *
 * @since 3.2.3.2
 * @package wp-crm-system
 */
//var_dump( get_current_screen() );
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<p><label for="type"><?php esc_attr_e( 'Type', 'wp-crm-system' ); ?></label></p>
<?php
$user = wp_get_current_user();
if ( $user->has_cap( get_option( 'wpcrm_system_select_user_role' ) ) ) {

	/**
	 * Determine what type of tab we are in
	 * 
	 * This will tell on what kind of category we should pull
	 * 
	 * @since 3.2.3.2
 	 * @package wp-crm-system
	 */
	$screen = get_current_screen();
	if( 'wp-crm-system_page_wpcrm-reports' === $screen->id ) {

		$tab = sanitize_text_field( $_GET['tab'] );
		$results = '';
		$tax = '';
		switch( $tab ) {
			case 'contact':
				$results = get_terms( 'contact-type', array(
					'hide_empty' => false,
				) );
				$tax = 'contact-type';
				break;
			case 'organization':
				$results = get_terms( 'organization-type', array(
					'hide_empty' => false,
				) );
				$tax = 'organization-type';
				break;
			case 'opportunity':
				$results = get_terms( 'opportunity-type', array(
					'hide_empty' => false,
				) );
				$tax = 'opportunity-type';
				break;
			case 'task':
				$results = get_terms( 'task-type', array(
					'hide_empty' => false,
				) );
				$tax = 'task-type';
				break;
			case 'project':
				$results = get_terms( 'project-type', array(
					'hide_empty' => false,
				) );
				$tax = 'project-type';
				break;
			case 'campaign':
				$results = get_terms( 'campaign-type', array(
					'hide_empty' => false,
				) );
				$tax = 'campaign-type';
				break;
		}
		
		if ( $results ) {
			?>
			<select id="type" name="wp-crm-system-type">
				<option value="all"
				<?php
					$val = isset( $_POST['wp-crm-system-type'] ) ? sanitize_text_field( wp_unslash( $_POST['wp-crm-system-type'] ) ) : '';
					if ( 'all' === $val ) {
						echo 'selected="selected"';
					}
				?>
				><?php esc_attr_e( 'All', 'wp-crm-system' ); ?></option>
				<option value=""
				<?php
					$val = isset( $_POST['wp-crm-system-type'] ) ? sanitize_text_field( wp_unslash( $_POST['wp-crm-system-type'] ) ) : '';
					if ( '' === $val ) {
						echo 'selected="selected"';
					}
				?>
				><?php esc_attr_e( 'Not set', 'wp-crm-system' ); ?></option>
				<?php
				foreach ( $results as $result ) {
					$opt_out = '';
					$opt_out = '<option value="' . esc_attr( $result->slug ) . '"';
						$val = isset( $_POST['wp-crm-system-type'] ) ? sanitize_text_field( wp_unslash( $_POST['wp-crm-system-type'] ) ) : '';
						if ( esc_attr( $result->slug ) === $val ) {
							$opt_out .= 'selected="selected"';
						}
					$opt_out .= '>' . esc_attr( $result->name ) . '</option>';
					echo $opt_out;
				}
				?>
			</select>
			<?php
			/**
			 * Hidden field for the taxonomy/category name
			 * 
			 * which was set on the setup
			 * 
			 * @since 3.2.3.2
			 * @package wp-crm-system
			 */
			echo '<input type="hidden" name="wp-crm-system-tax-name" value="' . $tax . '"/>';
		} else {
			esc_attr_e( 'No types to display', 'wp-crm-system' );
		}
	}
}
