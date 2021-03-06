<?php
/**
 * UNIFI Website
 * Adam Shannon
 * 2010-11-21
 */

$post = MySQL::clean($_POST['post_id']);
$author = MySQL::clean($user_id);
$timestamp = MySQL::clean(@time());
$content = MySQL::clean(htmlentities($_POST['content']));

// Make sure that $user_id is set!!
if (!empty($user_id)) {
	// Insert the comment from the $user_id global variable.
	$sql = "INSERT INTO `{$database}`.`blog-comments` (`id`,`blog_post`,`author`,`timestamp`,`content`) VALUES ";
	$sql .= "('0','{$post}','{$author}','{$timestamp}','{$content}');";
	MySQL::query($sql);
} else {
	$post = $post . '&commentFail';
}

header('Location: index.php?page=post&id=' . $post);
exit();
