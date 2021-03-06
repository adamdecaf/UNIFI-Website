<?php
/**
 * UNIFI Website
 * Adam Shannon
 * 2010-11-21
 */

// How do you want to handle errors?
error_reporting(E_ALL);

// Database Info
$hostname = '';
$username = '';
$password = '';
$database = '';

// The Facebook App info
define('FACEBOOK_APP_ID', '');
define('FACEBOOK_SECRET', '');

// Connect
MySQL::set_vars($hostname, $username, $password, $database);

// Set some settings
$config = array(
	'admin' => 'enabled',
	'web' => 'enabled',
	'i18n' => 'en.php',
	'i18n-admin' => 'en.php',
	'allowable_blog_tags' => '<strong><b><em><i><img><a><iframe>',
	'template' => 'epoch', // Don't include the trailing slash
	'admin_email' => ''
);
