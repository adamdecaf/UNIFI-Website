<?php
/**
 * UNIFI Website
 * Adam Shannon
 * 2010-11-21
 */
 
$tag = MySQL::clean($_GET['addBlogTag']);
$post = MySQL::clean($_GET['blog_post']);

$exists = MySQL::single("SELECT `tag_id` FROM `{$database}`.`blog-tags` WHERE `post_id` = '{$post}' AND `tag_id` = '{$tag}' LIMIT 1");

if (empty($exists['tag_id'])) {
	MySQL::query("INSERT INTO `{$database}`.`blog-tags` (`post_id`,`tag_id`) VALUES ('{$post}','{$tag}');");
	echo 'add';
} else {
	MySQL::query("DELETE FROM `{$database}`.`blog-tags` WHERE `blog-tags`.`post_id` = '{$post}' AND `blog-tags`.`tag_id` = '{$tag}' LIMIT 1");
	echo 'delete';
}