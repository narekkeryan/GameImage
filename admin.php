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
		?>
			<div class="row form_div">
				<div>
					<?php
					if(isset($_GET['msg']) && $_GET['msg'] == 'wuop') {
						?>
						<div class="alert alert-danger">
							Wrong Username or Password
						</div>
						<?php
					}
					?>
					<form method="post" action="actions/login.php">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Username" />
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Password" />
						</div>
						<button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
					</form>
				</div>
			</div>
		<?php 
		} else { 
			$user_id = $_SESSION['user_id'];
			$sql = "SELECT * FROM `users` WHERE `id` = '$user_id'";
			$user = $connection->query($sql);
			$userData = $user->fetch_assoc();
		?>
			<p>Welcome <strong><?php echo $userData['username']; ?></strong>.</p>
			<div><a href="console.php">Console</a></div>
			<div><a href="upload.php">Upload</a></div>
			<div><a href="actions/logout.php">Log out</a></div>
		<?php } ?>
	</div>
</body>
</html>