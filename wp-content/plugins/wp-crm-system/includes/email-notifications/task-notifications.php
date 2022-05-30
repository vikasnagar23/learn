<?php
if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Send Email notifications for Tasks
function wp_crm_system_notify_email_tasks( $ID, $post ){
	include ( WP_PLUGIN_DIR.'/wp-crm-system/includes/wp-crm-system-vars.php' );
	$enable_email = '';
	$taskassigned = '';
	$taskmessage = '';
	if(get_option( $prefix . 'enable_email_notification' ) == 'yes' ) {
		$enable_email = get_option( $prefix . 'enable_email_notification' );
	}
	if( '' != trim( get_option( $prefix . 'email_task_message' ) ) ) {
		$taskmessage = get_option( $prefix . 'email_task_message' );
	}
	if( isset( $_POST[$prefix . 'task-assignment'] ) && $_POST[$prefix . 'task-assignment'] != '' ) {
		$taskassigned = $_POST[$prefix . 'task-assignment'];
	}
    if( '' == $enable_email || '' == $taskassigned || '' == $taskmessage ){
        return;
    }

	//Make sure post meta is updated before we use it
	if( isset( $_POST[$prefix . 'task-assignment'] ) && $_POST[$prefix . 'task-assignment'] != '' ) {
		update_post_meta( $ID, $prefix . 'task-assignment', sanitize_text_field( $_POST[$prefix . 'task-assignment'] ) );
	}
	if( isset( $_POST[$prefix . 'task-attach-to-organization'] ) && $_POST[$prefix . 'task-attach-to-organization'] != '' ) {
		update_post_meta( $ID, $prefix . 'task-attach-to-organization', sanitize_text_field( $_POST[$prefix . 'task-attach-to-organization'] ) );
	}
	if( isset( $_POST[$prefix . 'task-attach-to-contact'] ) && $_POST[$prefix . 'task-attach-to-contact'] != '' ) {
		update_post_meta( $ID, $prefix . 'task-attach-to-contact', sanitize_text_field( $_POST[$prefix . 'task-attach-to-contact'] ) );
	}
	if( isset( $_POST[$prefix . 'task-notify-contact'] ) && $_POST[$prefix . 'task-notify-contact'] != '' ) {
		update_post_meta( $ID, $prefix . 'task-notify-contact', sanitize_text_field( $_POST[$prefix . 'task-notify-contact'] ) );
	}
	if( isset( $_POST[$prefix . 'task-due-date'] ) && $_POST[$prefix . 'task-due-date'] != '' ) {
		update_post_meta( $ID, $prefix . 'task-due-date', sanitize_text_field( $_POST[$prefix . 'task-due-date'] ) );
	}
	if( isset( $_POST[$prefix . 'task-start-date'] ) && $_POST[$prefix . 'task-start-date'] != '' ) {
		update_post_meta( $ID, $prefix . 'task-start-date', sanitize_text_field( $_POST[$prefix . 'task-start-date'] ) );
	}
	if( isset( $_POST[$prefix . 'task-progress'] ) && $_POST[$prefix . 'task-progress'] != '' ) {
		update_post_meta( $ID, $prefix . 'task-progress', sanitize_text_field( $_POST[$prefix . 'task-progress'] ) );
	}
	if( isset( $_POST[$prefix . 'task-priority'] ) && $_POST[$prefix . 'task-priority'] != '' ) {
		update_post_meta( $ID, $prefix . 'task-priority', sanitize_text_field( $_POST[$prefix . 'task-priority'] ) );
	}
	if( isset( $_POST[$prefix . 'task-status'] ) && $_POST[$prefix . 'task-status'] != '' ) {
		update_post_meta( $ID, $prefix . 'task-status', sanitize_text_field( $_POST[$prefix . 'task-status'] ) );
	}

	//Specific data to send in email.
	$title	= $post->post_title;
	$edit	= get_edit_post_link( $ID, '' );

	$user	= get_post_meta( $ID, $prefix . 'task-assignment', true );
	if( $user != '' ){
		$assignedUsername = get_user_by( 'login', $user);
		$assigned = $assignedUsername->display_name;
		$email = $assignedUsername->user_email;
		if ( ! empty( $assignedUsername->first_name ) && ! empty( $assignedUsername->last_name ) ) {
			$name = $assignedUsername->first_name . ' ' . $assignedUsername->last_name;
		} else { $name = $assigned; }
	} else {
		$assigned	= __( 'Not assigned', 'wp-crm-system' );
		$email 		= __( 'Not assigned', 'wp-crm-system' );
		$name		= __( 'Not assigned', 'wp-crm-system' );
	}
	$org	= get_post_meta( $ID, $prefix . 'task-attach-to-organization', true );
	if( $org == '' ) {
		$org = __( 'Not set', 'wp-crm-system' );
	} else {
		$org = get_the_title( $org );
	}
	$contact = get_post_meta( $ID, $prefix . 'task-attach-to-contact', true );
	if( $contact == '' ) {
		$contact = __( 'Not set', 'wp-crm-system' );
	} else {
		$contact_email = get_post_field( "_wpcrm_contact-email", $contact );
		$contact = get_the_title( $contact );
	}
	$due = get_post_meta( $ID, $prefix . 'task-due-date', true );
	if( $due != '' ) {
		$duedate = $due;
	} else {
		$duedate = __( 'No due date set', 'wp-crm-system' );
	}
	$start = get_post_meta( $ID, $prefix . 'task-start-date', true );
	if( $start != '' ) {
		$startdate = $start;
	} else {
		$startdate = __( 'No start date set', 'wp-crm-system' );
	}

	$progress = get_post_meta( $ID, $prefix . 'task-progress', true ) . '%';

	$priority = get_post_meta( $ID, $prefix . 'task-priority', true );
	$priorityargs = array( ''=>__( 'Not set', 'wp-crm-system' ), 'low'=>_x( 'Low', 'Not of great importance', 'wp-crm-system' ), 'medium'=>_x( 'Medium', 'Average priority', 'wp-crm-system' ), 'high'=>_x( 'High', 'Greatest importance', 'wp-crm-system' ) );
	if( isset( $priorityargs[$priority] ) ) {
		$sendpriority = $priorityargs[$priority];
	}
	$status = get_post_meta( $ID, $prefix . 'task-status', true );
	$statusargs = array( 'not-started'=>_x( 'Not Started', 'Work has not yet begun.', 'wp-crm-system' ), 'in-progress'=>_x( 'In Progress', 'Work has begun but is not complete.', 'wp-crm-system' ), 'complete'=>_x( 'Complete', 'All tasks are finished. No further work is needed.', 'wp-crm-system' ), 'on-hold'=>_x( 'On Hold', 'Work may be in various stages of completion, but has been stopped for one reason or another.', 'wp-crm-system' ) );
	if( isset( $statusargs[$status] ) ) {
		$sendstatus = $statusargs[$status];
	}

	$vars = array(
		'{title}' 			=> $title,
		'{url}'				=> $edit,
		'{titlelink}'		=> "<a href='" . $edit . "'>" . $title . "</a>",
		'{assigned}'		=> $assigned,
		'{organization}'	=> $org,
		'{contact}'			=> $contact,
		'{due}'				=> $duedate,
		'{start}'			=> $startdate,
		'{progress}'		=> $progress,
		'{priority}'		=> $sendpriority,
		'{status}'			=> $sendstatus,
	);
	// Setup wp_mail
	$to			= esc_html( $email );
	$subject	= $title . ' Update';
    $message	= strtr( $taskmessage, $vars );
    if( get_option( $prefix . 'enable_html_email' ) == 'yes' ) {
		$headers = 'Content-type: text/html';
	} else {
		$headers = '';
	}

	if ( isset( $contact_email ) && ! empty( $contact ) ) {
		$to_contact	= esc_html( $contact_email );
	}

	$send_email	= array(
		'send'		=> true,
		'vars'		=> $vars,
		'to'		=> $to,
		'subject'	=> $subject,
		'message'	=> $message,
		'headers'	=> $headers,
		'id'		=> $ID,
		'post'		=> $post,
	);

	$send_email_contact	= $send_email;
	$send_email_contact['to'] = $to_contact;
	
	$send_email = apply_filters( 'wp_crm_system_email_notifications_task', $send_email );
	$send_email_contact = apply_filters( 'wp_crm_system_email_notifications_task', $send_email_contact );
	
	$notify_contact = get_post_meta( $ID, $prefix . 'task-notify-contact', true );

	if( $send_email['send'] ){
		wp_mail( $send_email['to'], $send_email['subject'], $send_email['message'], $send_email['headers'] );
	}
	if( $send_email_contact['send'] && $notify_contact == 'on' ){
		wp_mail( $send_email_contact['to'], $send_email['subject'], $send_email['message'], $send_email['headers'] );
	}
    return;
}
add_action( 'publish_wpcrm-task', 'wp_crm_system_notify_email_tasks', 10, 2 );