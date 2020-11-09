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
		.msger {
			height: 500px;
		}

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
				$sId = $_SESSION['user']['user_id'];
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
			

			<!-- End Div Side -->
		</div>

		<div class="menu">
			<ul>
				<li><a href="people.php">People</a></li>
				<li class="active"><a href="messages.php">Messages</a></li>
			</ul>

		</div>
		<?php
		//import users class to fetch user (receiver) details
		require "db/Users.php";
		$objUser = new users();
		$match_arr = getMatches($uid);

		echo " <span style='color: orangered; padding:0 8px '><strong>Matches</strong></span> ";
		$res_size = sizeof($match_arr);
		if ($res_size > 0) {
			//is_array($match_arr) ?	$res_size = sizeof($res_size) : $res_size = 0;
			for ($i = 0; $i < $res_size; $i++) {
				$matched_usr_id = $match_arr[$i]['user_id'];

				$objUser->setId($matched_usr_id);

				$recName = $objUser->getUserById()['u_name'];
				$srctime =  $match_arr[$i]['timestamp'];
				//get the matched users details from User table
				// TODO: join the likes table with users table so u dont have to do what you're about to do lol
				$sql = "SELECT * from users where user_id = '$matched_usr_id'";
				$result = mysqli_query($conn, $sql);
				if ($result) {

					$ppl = mysqli_fetch_all($result, MYSQLI_ASSOC);
					//  print_r($ppl);
					$srcImg = $ppl[0]['profile_image'];
					$srcName =  $ppl[0]['u_name'];
					// $srctime =  $ppl[0]['timestamp'];
					//print $srcImg;
					$dayMonth = date('M j Y g:i A', strtotime($srctime));


					echo <<<END
							<a href='messages.php?rid=$matched_usr_id&recName=$recName' style='color:black';>
									<div class="messages">
									<div class="avatar">
										<img src=static/images/$srcImg alt="" />
									</div>
									<div class="message">
										<div class="user">$srcName</div>
										<div class="text time">$dayMonth</div>
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
<?php 

if(isset($_GET['rid'])):
?>
<?php
$obj = new users();
$r =$obj->setId( $_GET['rid']);
$rdetails = $obj->getUserById();
?>
<!-- chat section header -->
<section class="msger">
		<a  href="userinfo.php?uid=<?php echo $rdetails["user_id"];?>">
			<header class="msger-header">
				<div class="header">
					<div class="avatar">
						<img src=<?php echo "static/images/" . $rdetails['profile_image'] ?> alt="<?php echo $rdetails['u_name'] ?>" />
					</div>
					<div class="title"><?php echo $rdetails['u_name'] ?></span> </div>


			</header>
		</a>
	<!--end  chat section header -->


		<main class="msger-chat">
			<?php
			require "db/chatrooms.php";
			$objChats = new Chatrooms();
			$tempRId = "";
			if (isset($_GET['rid'])) {
				$tempRId = $_GET['rid'];
			}
			$chats = $objChats->getChats($uid, $tempRId);
			//print_r($chats);




			foreach ($chats as $key => $chat) {
				$side = "left";
				$msg = $chat['messageString'];
				$name = $chat["u_name"];
				$time = date('M j Y g:i A', strtotime($chat["timestamp"]));
				$img = "static/images/" . $chat['profile_image'];

				if ($_GET['rid'] == $chat['receiver']) {
					$name = "Me";
					$side = "right";
				}
				// <div class="msg-img" style="background-image: url(' . $img . ')"></div>

				echo '
		<div class="msg ' . $side . '-msg">

		<div class="msg-bubble">
			<div class="msg-info">
			<div class="msg-info-name">' . $name . '</div>
			<div class="msg-info-time">' . $time . '</div>
			</div>

			<div class="msg-text">' . $msg . '</div>
		</div>
		</div> ';

				//echo $msgHTML;
			}
			?>


		</main>

		<form class="msger-inputarea" method="post" action="messages.php">

			<input type="hidden" id="userId" name="userId" value="<?php echo $sId; ?>">
			<input type="hidden" id="recName" name="recName" value="<?php if (isset($_GET['recName'])) {
																		echo $_GET['recName'];
																	} ?>">
			<input type="hidden" id="receiverId" name="receiverId" value="<?php if (isset($_GET['rid'])) {
																				echo $_GET['rid'];
																			} ?>">
			<input type="text" id="msg" name="msg" class="msger-input" placeholder="Enter your message...">
			<button type="submit" class="msger-send-btn">Send</button>
		</form>
	</section>
																		<?php else:?>
																			<div>Select a contact to chat with </div>
																			<?php endif?>




	<!-- ########################################## JAVA SCRIPT################################################################## -->
	<!-- ############################################################################################################ -->
	<!-- ############################################################################################################ -->

	<script>
		const msgerForm = get(".msger-inputarea");
		const msgerInput = get(".msger-input");
		const msgerChat = get(".msger-chat");


		// Icons made by Freepik from www.flaticon.com
		const RECEIVER_IMG = "https://image.flaticon.com/icons/svg/327/327779.svg";
		const MY_IMG = "https://image.flaticon.com/icons/svg/145/145867.svg";
		const RECEIVER_NAME = $('#recName').val();
		const MY_NAME = "Me";
		var msg = $('#msg').val();
		var sId = $('#userId').val();
		var rId = $('#receiverId').val();






		/////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////

		$(document).ready(function() {

			conn = new WebSocket('ws://localhost:8080');
			conn.onopen = function(e) {

				console.log("Connection established!");
			};

			conn.onmessage = function(e) {
				var sId = $('#userId').val();
				var rId = $('#receiverId').val();
				console.log(e.data);
				data = JSON.parse(e.data);
				const msgText = data.msg;

				if (data.sId == sId) {

					appendMessage(MY_NAME, MY_IMG, "right", msgText);
				} else {

					appendMessage(RECEIVER_NAME, RECEIVER_IMG, "left", msgText);
				}



			}
		});

		//onclick Send or Submit
		msgerForm.addEventListener("submit", event => {
			event.preventDefault();

			const msgText = msgerInput.value;
			if (!msgText) return;

			// appendMessage(MY_NAME, MY_IMG, "right", msgText);
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
				msgerInput.value = "";
			} else {
				console.log("data feilds must not be empty!!");
			}
			if (!msg) return;

			document.getElementById("msg").value = "";

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

		// Utils
		function get(selector, root = document) {
			return root.querySelector(selector);
		}

		function formatDate(date) {
			const h = "0" + date.getHours();
			const m = "0" + date.getMinutes();


			return `${h.slice(-2)}:${m.slice(-2)}`;
		}
	</script>


</body>


</html>