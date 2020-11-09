<?php
include('config.php');

include("like.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/chatBoxTest.css">
	<link rel="stylesheet" href="css/msgstyle.css" />
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,500&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
	<title>Messages</title>
	<script src="jquery.js"></script>
	<style>
		.container {
			border: 2px solid #dedede;
			background-color: #f1f1f1;
			border-radius: 5px;
			padding: 10px;
			margin: 10px 0;
		}

		.darker {
			border-color: #ccc;
			background-color: #ddd;
		}

		.container::after {
			content: "";
			clear: both;
			display: table;
		}

		.container img {
			float: left;
			max-width: 60px;
			width: 100%;
			margin-right: 20px;
			border-radius: 50%;
		}

		.msgContainer {
			width: 70ex;
			height: 50ex;
			overflow: auto;
		}

		.container img.right {
			float: right;
			margin-left: 20px;
			margin-right: 0;
		}

		.time-right {
			float: right;
			color: #aaa;
		}

		.time-left {
			float: left;
			color: #999;
		}
	</style>
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
		$res_size = sizeof($match_arr);
		if ($res_size > 0) {
			//is_array($match_arr) ?	$res_size = sizeof($res_size) : $res_size = 0;
			for ($i = 0; $i < $res_size; $i++) {
				$matched_usr_id = $match_arr[$i]['user_id'];

				$srctime =  $match_arr[$i]['timestamp'];
				//get the matched users details from User table
				// TODO: join the likes table with users table so u dont have to do what you're about to do
				$sql = "SELECT * from users where user_id = '$matched_usr_id'";
				$result = mysqli_query($conn, $sql);
				if ($result) {

					$ppl = mysqli_fetch_all($result, MYSQLI_ASSOC);
					//  print_r($ppl);
					$srcImg = $ppl[0]['profile_image'];
					$srcName =  $ppl[0]['u_name'];
					// $srctime =  $ppl[0]['timestamp'];
					//print $srcImg;
					$d = date('M j Y g:i A', strtotime($srctime));

					echo <<<END
				 
				<a href='messages.php?rid=$matched_usr_id' style='color:black';>
						<div class="messages">
						<div class="avatar">
							<img src=static/images/$srcImg alt="" />
						</div>
						<div class="message">
							<div class="user">$srcName</div>
							<div class="text">$d</div>
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
	<!-- ////////////////////////////////chat section///////////////////////////////////////// -->

	<section class="msger">
		<header class="msger-header">
			<div class="msger-header-title">
				<i class="fas fa-comment-alt"></i> SimpleChat
			</div>
			<div class="msger-header-options">
				<span><i class="fas fa-cog"></i></span>
			</div>
		</header>

		<main class="msger-chat">
			<div class="msg left-msg">
				<div class="msg-img" style="background-image: url(https://image.flaticon.com/icons/svg/327/327779.svg)"></div>

				<div class="msg-bubble">
					<div class="msg-info">
						<div class="msg-info-name">SENDER</div>
						<div class="msg-info-time">12:45</div>
					</div>

					<div class="msg-text">
						Hi, welcome to SimpleChat! Go ahead and send me a message. 😄
					</div>
				</div>
			</div>

			<div class="jsjksk">

			</div>
			<div class="msg right-msg">
				<div class="msg-img" style="background-image: url(https://image.flaticon.com/icons/svg/145/145867.svg)"></div>

				<div class="msg-bubble">
					<div class="msg-info">
						<div class="msg-info-name">Sajad</div>
						<div class="msg-info-time">12:46</div>
					</div>

					<div class="msg-text">
						You can change your name in JS section!
					</div>
				</div>
			</div>
		</main>

		<form class="msger-inputarea" method="post" action="messages.php">

			<input type="hidden" id="userId" name="userId" value="<?php echo $uid; ?>">
			<input type="hidden" id="receiverId" name="receiverId" value="<?php if (isset($_GET['rid'])) {
																				echo $_GET['rid'];
																			} ?>">
			<input type="text" id="msg" name="msg" class="msger-input" placeholder="Enter your message...">
			<button type="submit" class="msger-send-btn">Send</button>
		</form>
	</section>





	<!-- ############################################################################################################ -->
	<!-- ############################################################################################################ -->
	<!-- ############################################################################################################ -->

	<script>
		const msgerForm = get(".msger-inputarea");
		const msgerInput = get(".msger-input");
		const msgerChat = get(".msger-chat");
 

		// Icons made by Freepik from www.flaticon.com
		const SENDER_IMG = "https://image.flaticon.com/icons/svg/327/327779.svg";
		const MY_IMG = "https://image.flaticon.com/icons/svg/145/145867.svg";
		const SENDER_NAME = "SENDER";
		const MY_NAME = "Me";

		//onclick Send or Submit
		msgerForm.addEventListener("submit", event => {
			event.preventDefault();

			const msgText = msgerInput.value;
			if (!msgText) return;

			appendMessage(MY_NAME, MY_IMG, "right", msgText);
			// msgerInput.value = "";

			if ($('#msg').val() !== "" && $('#userId').val() !== "" && $('#receiverId').val() !== "") {

				var msg = $('#msg').val();
				var sId = $('#userId').val();
				var rId = $('#receiverId').val();


				var data = {
					sId: sId,
					msg: msg,
					rId: rId

				}

				conn.send(JSON.stringify(data));
			} else {
				console.log("data feilds must not be empty!!");
			}
			if (!msg) return;

			document.getElementById("msg").value = "";
			// botResponse();
		});

		function appendMessage(name, img, side, text) {
			//   Simple solution for small apps
			const msgHTML = `
		<div class="msg ${side}-msg">
		<div class="msg-img" style="background-image: url(${img})"></div>

		<div class="msg-bubble">
			<div class="msg-info">
			<div class="msg-info-name">${name}</div>
			<div class="msg-info-time">${formatDate(new Date())}</div>
			</div>

			<div class="msg-text">${text}</div>
		</div>
		</div> `;

			msgerChat.insertAdjacentHTML("beforeend", msgHTML);
			msgerChat.scrollTop += 500;
		}

		function botResponse() {
			/**some code here */
		}

		// Utils
		function get(selector, root = document) {
			return root.querySelector(selector);
		}

		function formatDate(date) {
			const h = "0" + date.getHours();
			const m = "0" + date.getMinutes();

			return `${h.slice(-2)}:${m.slice(-2)}`;
		}

		function random(min, max) {
			return Math.floor(Math.random() * (max - min) + min);
		}

		/////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////

		$(document).ready(function() {

			conn = new WebSocket('ws://localhost:8080');
			conn.onopen = function(e) {

				console.log("Connection established!");
			};

			conn.onmessage = function(e) {
				console.log(e.data);
				data = JSON.parse(e.data);
				var sId = $('#userId').val();

				const msgText = data.msg;
				appendMessage(SENDER_NAME, SENDER_IMG, "left", msgText);

			}
		});

		$("#send").click(function(e) {


		});
	</script>


</body>


</html>