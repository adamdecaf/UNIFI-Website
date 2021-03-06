<?php
/**
 * UNIFI Website
 * Adam Shannon
 * 2011-03-14
 */

function show_checked($permission) {
	if ($permission == '1') {
		echo 'checked';
	}
}

if (empty($_GET['user'])) {
	include 'templates/' . $config['template'] . '/html/edit_member_permissions_get_user.html';
} else {
	$user = MySQL::clean($_GET['user']);
	
	$sql = "SELECT `first_name`,`last_name` FROM `{$database}`.`users` WHERE `id` = '{$user}' LIMIT 1;";
	$data = MySQL::single($sql);
	
	$sql = "SELECT * FROM `{$database}`.`user-permissions` WHERE `user_id` = '{$user}' LIMIT 1";
	$permissions = MySQL::single($sql);

	include 'templates/' . $config['template'] . '/html/edit_member_permissions.html';
}
