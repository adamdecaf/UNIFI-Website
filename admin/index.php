<?php
/**
 * UNIFI Website
 * Adam Shannon
 * 2010-11-21
 */

// Load some libraries
require '../system/libs/mysql.class.php';
require '../system/libs/date.class.php';
require '../system/libs/sanitize.class.php';

// Load the config
require '../application/config/config.php';
require '../application/i18n/' . $config['i18n'];
if ($config['admin']!== 'enabled') {
	exit(WEB_ACCESS_DISABLED);
}

// Include the errors handler
require '../system/errors/errors.php';

// Load the user stuff. (Facebook)
require '../application/helpers/user.php';
//echo $fb_id . ' ' . $user_id . '<br />';

// Check the url
require '../application/helpers/url.php';
$url = check_url();
//print_r($url);

if ($url['post']) {
	//echo 'HTTP POST REQUEST';
	
	// Load the helper to change a user's details.
	if (!empty($_POST['type_of_user_change']) && $_POST['type_of_user_change'] == 'edit_user') {
		
		// First authenticate the user against the db.
		// echo $user_id;
		
		// Then, make sure that the user can edit members.
		$user_id = MySQL::clean($user_id);
		$tmp = MySQL::single("SELECT `edit_members` FROM `{$database}`.`user-permissions` WHERE `user_id` = '{$user_id}' LIMIT 1");
		if ($tmp['edit_members'] != '1') {
			exit(ADMIN_NOT_AUTHORIZED);
		}
		
		// Finally, submit the change.
		include 'application/helpers/form_edit_user.php';
		
		exit('');
	}
	
} else {
	// echo 'HTTP GET REQUEST';
	include 'templates/' . $config['template'] . '/html/header.html';
	
	// Clean the $user_id for each action. 
	$user_id = MySQL::clean($user_id);
	
	// Do a general check on viewing the dashbord.
	$can_view_dashbord = MySQL::single("SELECT `access_admin_dashbord` FROM `{$database}`.`user-permissions` WHERE `user_id` = '{$user_id}' LIMIT 1");
	if ($can_view_dashbord['access_admin_dashbord'] == '1') {
		$view_dashbord = true;
	} else {
		$view_dashbord = false;
	}
	
	switch ($url['page']) {
	
		case 'post':
		
			$can_post = MySQL::single("SELECT `post_to_blog` FROM `{$database}`.`user-permissions` WHERE `user_id` = '{$user_id}' LIMIT 1");
			if ($can_post['post_to_blog'] == 1) {
				
				// Feature still needed!!
				include 'application/helpers/post_to_blog.php';
				include 'templates/' . $config['template'] . '/html/post_to_blog.html';
				
			} else {
				exit(ADMIN_NOT_AUTHORIZED);
			}
			
		break;
		
		case 'list_members':
		
			$can_list = MySQL::single("SELECT `view_members` FROM `{$database}`.`user-permissions` WHERE `user_id` = '{$user_id}' LIMIT 1");
			if ($view_dashbord == '1' && $can_list['view_members'] == 1) {
			
				// Feature still needed!!
				include 'application/helpers/list_users.php';
				include 'templates/' . $config['template'] . '/html/list_users.html';
			
			} else {
			
				exit(ADMIN_NOT_AUTHORIZED);
			
			}
			
		break;
		
		case 'edit_user':
		
			$can_edit = MySQL::single("SELECT `edit_members` FROM `{$database}`.`user-permissions` WHERE `user_id` = '{$user_id}' LIMIT 1");
			if ($view_dashbord == '1' && $can_edit['edit_members'] == 1) {
			
				include 'application/helpers/edit_user.php';
				include 'templates/' . $config['template'] . '/html/edit_user.html';
			
			} else {
			
				exit(ADMIN_NOT_AUTHORIZED);
			
			}
		break;
		
		case 'create_event':
		
			$can_create_event = MySQL::single("SELECT `add_events` FROM `{$database}`.`user-permissions` WHERE `user_id` = '{$user_id}' LIMIT 1");
			if ($view_dashbord == '1' && $can_create_event['add_events'] == 1) {
			
				// Feature still needed!!
				include 'application/helpers/create_event.php';
				include 'templates/' . $config['template'] . '/html/create_event.html';
			
			} else {
			
				exit(ADMIN_NOT_AUTHORIZED);
			
			}
		
		break;
		
		case 'list_events':
		
			$list_events = MySQL::single("SELECT `list_events` FROM `{$database}`.`user-permissions` WHERE `user_id` = '{$user_id}' LIMIT 1");
			if ($view_dashbord == '1' && $list_events['list_events'] == 1) {
			
				// Feature still needed!!
				include 'application/helpers/list_events.php';
				include 'templates/' . $config['template'] . '/html/list_events.html';
			
			} else {
			
				exit(ADMIN_NOT_AUTHORIZED);
			
			}
			
		break;
		
		default:
			
			if ($view_dashbord) {
				include 'templates/' . $config['template'] . '/html/dashbord.html';
			} else {
				exit(ADMIN_NOT_AUTHORIZED);
			}
			
		break;
		
	}
	
	include 'templates/' . $config['template'] . '/html/footer.html';
}