<?php

require_once 'db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
	header('Location: ../index.php');
	exit;
}

if(!empty($_FILES['files']['name'][0])) {
	$user_id = $_SESSION['user_id'];
	$sex = $_POST['sex'];

	$files = $_FILES['files'];

	$uploaded = array();
	$failed = array();

	$allowed = array('png', 'jpg', 'jpeg');

	foreach($files['name'] as $position => $file_name) {
		echo $position;
		$file_tmp = $files['tmp_name'][$position];
		$file_size = $files['size'][$position];
		$file_error = $files['error'][$position];

		$file_ext = explode('.', $file_name);
		$file_ext = strtolower(end($file_ext));

		if(in_array($file_ext, $allowed)) {
			if($file_error === 0) {
				if($file_size <= 26214400) {
					$file_name_new = uniqid('', true) . '.' . $file_ext;
					$file_src = './uploads/big/' . $file_name_new;
					$file_small_src = './uploads/small/' . $file_name_new;
					$file_destination = '../uploads/big/' . $file_name_new;
					$file_small_destination = '../uploads/small/' . $file_name_new;

					if(move_uploaded_file($file_tmp, $file_destination)) {
						$uploaded[$position] = $file_name;

						$sql = "INSERT INTO `images` (`user_id`, `sname`, `bname`, `sex`) VALUES ('$user_id', '$file_small_src', '$file_src', '$sex')";
						$connection->query($sql);
					} else {
						$failed[$position] = "[{$file_name}] failes to upload";
					}
				} else {
					$failed[$position] = "[{$file_name}] is too large. Max size is 25mb.";
				}
			} else {
				$failed[$position] = "[{$file_name}] errored with code {$file_error}";
			}
		} else {
			$failed[$position] = "[{$file_name}] file extension '{$file_ext}' is not allowed.";
		}
	}

	$url = '../upload.php?msg=usu';

	if(!empty($uploaded)) {
		$url .= '&uploaded[]=' . implode('&uploaded[]=', array_map('urlencode', $uploaded));
	}

	if(!empty($failed)) {
		$url .= '&failed[]=' . implode('&failed[]=', array_map('urlencode', $failed));
	}

	header('Location: ' . $url);
	exit;
} else {
	header('Location: ../upload.php?msg=usu&err=eof');
	exit;
}
?>