<!Doctype html>
<html lang="en">
<head>
	<title>YL Club Ranodm Image</title>

	<meta charset="UTF-8" />

	<link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="./assets/css/style.css" type="text/css" />

	<script type="text/javascript" src="./assets/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./assets/js/script.js"></script>
</head>
<body>
	<div class="container-fluid">
		<?php
		require_once 'actions/db.php';
		session_start();
		if(!isset($_SESSION['user_id'])) {
			header('Location: index.php');
			exit;
		}
		$user_id = $_SESSION['user_id'];
		$sql = "SELECT * FROM `users` WHERE `id` = '$user_id'";
		$user = $connection->query($sql);
		$userData = $user->fetch_assoc();
		?>
		<div><a href="admin.php">Admin home</a></div>
		<div class="row form_div">
			<div>
			<?php
				echo '<div class="uploadmsg">';
				if(isset($_GET['err']) && $_GET['err'] === 'eof') {
					?>
					<div class="alert alert-danger">
						You need to choose files.
					</div>
					<?php
				}
				if(isset($_GET['uploaded']) && !empty($_GET['uploaded'])) {
					?>
					<div class="upl alert alert-success">
					Uploaded
					<?php
					foreach($_GET['uploaded'] as $img_name) {
						?>
						<p><?php echo $img_name?></p>
						<?php
					}
					?>
				</div>
					<?php
				}
				if(isset($_GET['failed']) && !empty($_GET['failed'])) {
					?>
					<div class="upl alert alert-danger">
					Failed
					<?php
					foreach($_GET['failed'] as $img_name) {
						?>
						<p><?php echo $img_name?></p>
						<?php
					}
					?>
				</div>
					<?php
				}
				echo '</div>';
				?>
				<form method="post" action="actions/upload.php" enctype="multipart/form-data" id="file_upload">
					<div class="form-group">
						<label for="file">Upload files</label>
						<input type="file" class="form-control" id="file" name="files[]" multiple />
					</div>
					<div class="radio-inline">
						<label><input type="radio" name="sex" value="male" checked /> Male</label>
						
					</div>
					<div class="radio-inline">
						<label><input type="radio" name="sex" value="female" /> Female</label>
					</div>
					<button type="submit" class="btn btn-primary" name="submit" value="upload">Submit</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>