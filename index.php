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
		if(isset($_POST['single'])) {
			if(isset($_POST['sex'][1])) {
				$sql = "SELECT * FROM `images`";
				$images = $connection->query($sql);
			} else if(isset($_POST['sex'][0])) {
				$sex = $_POST['sex'][0];
				$sql = "SELECT * FROM `images` WHERE `sex` = '$sex'";
				$images = $connection->query($sql);
			} else {
				echo 'Ara de mi ban nshi eli';
			}

			?>
			<style type="text/css">
				#buttons {
					display: none;
				}
				#winner_div {
					display: block;
				}
			</style>
			<?php
		}

		if(isset($_POST['win'])) {
			$sex = explode('|', $_POST['sex'][0]);
			if(isset($sex[1])) {
				$sql = "SELECT * FROM `images`";
				$images = $connection->query($sql);
			} else if(isset($sex[0])) {
				$sex = $_POST['sex'][0];
				$sql = "SELECT * FROM `images` WHERE `sex` = '$sex'";
				$images = $connection->query($sql);
			} else {
				echo 'Ara de mi ban nshi eli';
			}

			if(isset($_POST['winner'])) {
				$winnerByChose = $_POST['winner'];
			}

			$imageLength = $images->num_rows;
			$imageName = rand(1, $imageLength);
			?>
			<style type="text/css">
				#buttons {
					display: none;
				}
				#winner_div {
					display: none;
				}
				#single_main {
					display: flex;
				}
				.single_number_<?php echo $imageName;?> {
					display: block;
				}
			</style>
			<?php
			if(!isset($_POST['winner'])) {
				?>
				<script type="text/javascript">
					$(function() {
						var imgLength = <?php echo json_encode($imageLength); ?>;

						var imgName = <?php echo json_encode($imageName); ?>;
						var winnerImageName = '';

						var randomImg;
							
						$('#start_single').click(function() {
							if(winnerImageName != '') {
					            $('.single_number_' + winnerImageName).css('display', 'none');
					        }

							winnerImageName =  Math.floor((Math.random() * imgLength) + 1);

							randomImg = setInterval(function() {
								$('.single_number_' + imgName).css('display', 'none');
								imgName = Math.floor((Math.random() * imgLength) + 1);
								$('.single_number_' + imgName).css('display', 'block');
							}, 50);

							setTimeout(function() {
					            clearInterval(randomImg);
					       		$('.single_number_' + imgName).css('display', 'none');
					            $('.single_number_' + winnerImageName).css('display', 'block');
					        }, 8000);
						});
					});
				</script>
				<?php
			} else {
				?>
				<script type="text/javascript">
					$(function() {
						var imgLength = <?php echo json_encode($imageLength); ?>;

						var imgName = <?php echo json_encode($imageName); ?>;
						var winnerImageName = '';

						var randomImg;
							
						$('#start_single').click(function() {
							if(winnerImageName != '') {
					            $('.single_number_' + winnerImageName).css('display', 'none');
					        }

							winnerImageName =  <?php echo json_encode($_POST['winner']); ?>;

							randomImg = setInterval(function() {
								$('.single_number_' + imgName).css('display', 'none');
								imgName = Math.floor((Math.random() * imgLength) + 1);
								$('.single_number_' + imgName).css('display', 'block');
							}, 50);

							setTimeout(function() {
					            clearInterval(randomImg);
					       		$('.single_number_' + imgName).css('display', 'none');
					            $('.single_number_' + winnerImageName).css('display', 'block');
					        }, 8000);
						});
					});
				</script>
				<?php
			}
		}
		?>

		<div id="buttons" class="row">
			<form role="form" method="POST" action="" id="start_form">
				<div class="checkbox-inline"><label><input class="sex" type="checkbox" value="male" name="sex[]" checked /> Male</label></div>
				<div class="checkbox-inline"><label><input class="sex" type="checkbox" value="female" name="sex[]" checked /> Female</label></div>
				<br />
				<button id="single" class="btn btn-primary" name="single" type="submit">Start</button>
			</form>
		</div>

		<div id="winner_div" class="row">
			<p>Սպասի սաղ նկարները բացի ...</p>
			<p>Բացեցին ???</p>
			<p>Դե անցանք առաջ</p>
			<p>Ընտրի նկարը, եթե ուզում ես կոնկրետ մարդ հաղթի, կամ էլ կարաս չնտրես, պատահական կլնի: Եթե միամիտ սղմել ես ցանկացած նկարի վրա, բայց ուզում էիր պատահական լիներ, պետքա էջը ռեֆրեշ անես:</p>
			<form method="POST" target="_blank">
				<div class="img_to_win">
					<?php
					if(isset($_POST['single'])) {
						if(isset($_POST['sex'][1])) {
							?>
							<input type="hidden" name="sex[]" value="<?php echo $_POST['sex'][0] . '|' . $_POST['sex'][1]; ?>" />
							<?php
						} else {
							?>
							<input type="hidden" name="sex[]" value="<?php echo $_POST['sex'][0]; ?>" />
							<?php
						}
						foreach($images as $position => $image) {
						?>
						<div class="radio-inline"><label><img id="<?php echo $image['id']; ?>" onclick="bordercho(this.id);" src="<?php echo $image['bname']; ?>" height="128px"><input id="i<?php echo $image['id']; ?>" type="radio" value="<?php echo $position+1; ?>" name="winner" /></label></div>
						<?php
						}
					}
					?>
				</div>

				<br />
				<div class="bdiv"><button name="win" id="start_it" class="btn btn-primary" type="submit">Go !!!</button></div>
			</form>
		</div>

		<div id="single_main" class="row">
			<div>
				<?php
				if(isset($_POST['win'])) {
					foreach($images as $position => $image) {
					?>
					<img class="single_number single_number_<?php echo ($position + 1); ?>" src="<?php echo $image['bname']; ?>" width="400px" />
					<?php
					}
				}
				?>

				<br />

				<button id="start_single" class="btn btn-primary" type="button">Lets go</button>
			</div>
		</div>
	</div>
</body>
</html>