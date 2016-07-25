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
	<?php
	require_once 'actions/db.php';
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header('Location: index.php');
		exit;
	}

	$sql = "SELECT * FROM `images`";
	$images = $connection->query($sql);
	?>
	<div class="container-fluid">
		<div class="uploadmsg">
			<?php
			if(isset($_GET['msg']) && $_GET['msg'] === "cdi") {
				?>
				<div class="upl alert alert-danger">
					<p>Can't delete image</p>
				</div>
				<?php
			}
			?>
		</div>
		<p><a href="admin.php">Admin home</a></p>
		<?php
		if($images->num_rows >= 1) {
		?>
			<form method="post" action="actions/delete.php">
				<table border="1">
					<?php
					while($imageData = $images->fetch_assoc()) {
						$imgUserId = $imageData['user_id'];
						$sql = "SELECT * FROM `users` WHERE `id` = '$imgUserId'";
						$user = $connection->query($sql);
						$userData = $user->fetch_assoc();
					?>
						<tr>
							<td><input type="checkbox" name="images[]" value="<?php echo $imageData['id']; ?>" /></td>
							<td><?php echo $userData['username']; ?></td>
							<td><img src="<?php echo $imageData['bname']; ?>" width="200"></td>
							<td><?php echo $imageData['sex']; ?></td>
							<td><a href="actions/delete.php?imageId=<?php echo $imageData['id']; ?>">Delete</a></td>
						</tr>
					<?php
					}
					?>
				</table>
				<script type="text/javascript">
					function toggle(source) {
						checkboxes = document.getElementsByName('images[]');
						for(var i=0, n=checkboxes.length;i<n;i++) {
							checkboxes[i].checked = source.checked;
						}
					}
				</script>
				<label><input type="checkbox" name="images[]" value="all" id="check_all" onclick="toggle(this);" /> Check all</label>
				<button type="submit" name="delete" id="delete_all">Delete</button>
			</form>
		<?php
		} else {
		?>
			<p>There are no images. You can <a href="upload.php">upload.</a></p>
		<?php
		}
		?>
	</div>
</body>
</html>