<?php

require_once 'db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
	header('Location: ../index.php');
	exit;
}

if(!isset($_POST['delete'])) {
	if(!isset($_GET['imageId'])) {
		header('Location: ../admin.php');
		exit;
	} else {
		$imageId = $_GET['imageId'];
		$sql = "SELECT * FROM `images` WHERE `id` = '$imageId'";
		$image = $connection->query($sql);
		$imageData = $image->fetch_assoc();
		if(unlink('.' . $imageData['sname']) && unlink('.' . $imageData['bname'])) {
			$sql = "DELETE FROM `images` WHERE `id` = '$imageId'";
			$connection->query($sql);
			header('Location: ../console.php');
			exit;
		} else {
			header('Location: ../console.php?msg=cdi');
			exit;
		}
	}
} else {
	$images = $_POST['images'];
	
	if(end($images) === "all") {
		unset($images[count($images)-1]);
	}
	
	foreach($images as $imageId) {
		$sql = "SELECT * FROM `images` WHERE `id` = '$imageId'";
		$image = $connection->query($sql);
		$imageData = $image->fetch_assoc();
		unlink('.' . $imageData['sname']);
		unlink('.' . $imageData['bname']);
		$sql = "DELETE FROM `images` WHERE `id` = '$imageId'";
		$connection->query($sql);
	}

	header('Location: ../console.php');
	exit;
}

?>