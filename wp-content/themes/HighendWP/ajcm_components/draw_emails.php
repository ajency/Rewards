<?php

function getvars_winner_email($recipients_email,$comm_data){

	global $aj_comm;

	$template_data['name'] = 'winner_email'; // [slug] name or slug of a template that exists in the user's mandrill account
	$template_data['subject'] = 'Customer Registeration Notification';
	$template_data['from_email'] = 'surekha@ajency.in';
	$template_data['from_name'] = 'Skyi';

	$username   = $aj_comm->get_communication_meta($comm_data['id'],'username');
	$product_name   = $aj_comm->get_communication_meta($comm_data['id'],'product_name');

	$template_data['global_merge_vars'] = array();
	$template_data['global_merge_vars'][] = array('name' => 'USERNAME','content' => $username);
	$template_data['global_merge_vars'][] = array('name' => 'product_name','content' => $product_name);
	return $template_data;

}



function getvars_non_winner_email($recipients_email,$comm_data){

	global $aj_comm;

	$template_data['name'] = 'non_winner_email'; // [slug] name or slug of a template that exists in the user's mandrill account
	$template_data['subject'] = 'Customer Registration Notification';
	$template_data['from_email'] = 'surekha@ajency.in';
	$template_data['from_name'] = 'Skyi';

	$username   = $aj_comm->get_communication_meta($comm_data['id'],'username');
	$product_name   = $aj_comm->get_communication_meta($comm_data['id'],'product_name');

	$template_data['global_merge_vars'] = array();
	$template_data['global_merge_vars'][] = array('name' => 'USERNAME','content' => $username);
	$template_data['global_merge_vars'][] = array('name' => 'product_name','content' => $product_name);

	return $template_data;

}
