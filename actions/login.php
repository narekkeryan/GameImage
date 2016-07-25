<?php

require_once 'db.php';

session_start();

if(!isset($_POST['submit'])) {
	header('Location: ../index.php');
	exit;
}

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password'";
$user = $connection->query($sql);

if($user->num_rows <= 0) {
	header('Location: ../admin.php?msg=wuop');
	exit;
}

$userData = $user->fetch_assoc();
$_SESSION['user_id'] = $userData['id'];
header('Location: ../admin.php');
exit;

?>