<?php
/**
 * UNIFI Website
 * Adam Shannon
 */

$author = MySQL::clean(htmlentities($_POST['author']));
$title = MySQL::clean(htmlentities($_POST['title']));
$content = MySQL::clean(htmlentities($_POST['content']));
$timestamp = @time();

if (empty($author) && !empty($user_id)) {
	$author = $user_id;
} else {
	$author = 0;
}

$sql = "INSERT INTO `{$database}`.`blog-guest-submissions` (`id`,`author`,`timestamp`,`title`,`content`) VALUES ";
$sql .= "('0', '{$author}', '{$timestamp}', '{$title}', '{$content}');";
MySQL::query($sql);

header('Location: index.php');
exit();
