<?php
include('config.php');

include("like.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/msgstyle.css" />
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,500&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
	<title>Messages</title>
	<script src="jquery.js"></script>
</head>

<body>
	<div class="container">
		<div class="side">
			<?php
			global $people;
			$clickCount = 1;
			$errors = array();

			if (!empty($_SESSION['user'])) {
				$details = $_SESSION['user'];
				$username = $details['u_name'];
				$uid = $details['user_id'];
				$pref = $details['preference'];
				$sql = '';
			} else {
				die("You must Be <a href=login.php>Logged in </a>First</div></body></html>");
			}



			?>

			<a href="settings.php">
				<div class="header">
					<div class="avatar">
						<img src=<?php echo "static/images/" . $details['profile_image'] ?> alt="<?php echo $username ?>" />
					</div>
					<div class="title"><?php echo $details['u_name'] ?></span> &nbsp; &nbsp; <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a></div>
					<?php include(ROOT_PATH .  "/includes/errors.php"); ?>

			</a>
			<!-- <span><?php echo $_SESSION['user']['u_name'] ?> -->
		</div>

		<div class="menu">
			<ul>
				<li><a href="people.php">People</a></li>
				<li class="active"><a href="messages.php">Messages</a></li>
			</ul>

		</div>
		<?php

		$match_arr = getMatches($uid);

		echo " <span style='color: orangered; padding:0 8px '><strong>Matches</strong></span> ";
		$nol = sizeof($match_arr);
		if ($nol > 0) {
			//is_array($match_arr) ?	$nol = sizeof($nol) : $nol = 0;
			for ($i = 0; $i < $nol; $i++) {
				$POS = $match_arr[$i]['user_id'];

				$srctime =  $match_arr[$i]['timestamp'];
				$sql = "SELECT * from users where user_id = '$POS'";
				$result = mysqli_query($conn, $sql);
				if ($result) {

					$ppl = mysqli_fetch_all($result, MYSQLI_ASSOC);
					//  print_r($ppl);
					$srcImg = $ppl[0]['profile_image'];
					$srcName =  $ppl[0]['u_name'];
					// $srctime =  $ppl[0]['timestamp'];
					//print $srcImg;


					echo <<<END
				 
				<a href='userinfo.php?uid=$POS' style='color:black';>
						<div class="messages">
						<div class="avatar">
							<img src=static/images/$srcImg alt="" />
						</div>
						<div class="message">
							<div class="user">$srcName</div>
							<div class="text">$srctime</div>
						</div>
					</div>    
						</a>

				END;
				}
			}
		} else {
			echo <<<END
				<hr>
						
						<div class="message">
							<div class="user"></br><Strong>Sorry You Have No Matches Yet</Strong></div>
							<div class="text"></div>
						</div>
				END;
		}
		?>

	</div>
	<!-- footer -->
	<div class="footer">
		<p>CS_SEEKER &copy; <?php echo date('Y'); ?></p>
	</div>
	<!-- // footer -->


</body>

</html>