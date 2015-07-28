<?php

function getvars_admin_email($recipients_email,$comm_data){

	global $aj_comm;

	$template_data['name'] = 'admin_email'; // [slug] name or slug of a template that exists in the user's mandrill account
	$template_data['subject'] = 'Customer Registeration Notification';
	$template_data['from_email'] = 'surekha@ajency.in';
	$template_data['from_name'] = 'Skyi';

	$username   = $aj_comm->get_communication_meta($comm_data['id'],'username');
	$email   = $aj_comm->get_communication_meta($comm_data['id'],'email');

	$template_data['global_merge_vars'] = array();
	$template_data['global_merge_vars'][] = array('name' => 'USERNAME','content' => $username);
	$template_data['global_merge_vars'][] = array('name' => 'EMAIL','content' => $email);
	return $template_data;

}



function getvars_customer_email($recipients_email,$comm_data){

	global $aj_comm;

	$template_data['name'] = 'customer_email'; // [slug] name or slug of a template that exists in the user's mandrill account
	$template_data['subject'] = 'Customer Registration Notification';
	$template_data['from_email'] = 'surekha@ajency.in';
	$template_data['from_name'] = 'Skyi';

	$username   = $aj_comm->get_communication_meta($comm_data['id'],'username');
	$email   = $aj_comm->get_communication_meta($comm_data['id'],'email');

	$template_data['global_merge_vars'] = array();
	$template_data['global_merge_vars'][] = array('name' => 'USERNAME','content' => $username);
	$template_data['global_merge_vars'][] = array('name' => 'EMAIL','content' => $email);

	return $template_data;

}
