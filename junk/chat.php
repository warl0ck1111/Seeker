
	<h2>Chat Messages</h2>
	<div class="rightSide">

		<div class="msgContainer">

			<?php
			require "db/chatrooms.php";
			$objChats = new Chatrooms();
			$tempRId = "";
			if (isset($_GET['rid'])) {
				$tempRId = $_GET['rid'];
			}
			$chats = $objChats->getChats($uid,$tempRId);
			 

 

			foreach ($chats as $key => $chat) {
				echo  '<div class="container ><img src="https://image.flaticon.com/icons/svg/145/145867.svg" alt="Avatar" style="width:100%;"> <p>' . $chat["messageString"] .
					'</p> <span class="time-right">' . $chat["timestamp"] . '</span> </div>';
			}
			?>
			<div class="container darker" id="lst">
			</div>

		</div>
		<form class="msger-inputarea" method="post" action="messages.php">

			<input type="hidden" id="userId" name="userId" value="<?php echo $uid; ?>">
			<input type="hidden" id="receiverId" name="receiverId" value="<?php if (isset($_GET['rid'])) {
																				echo $_GET['rid'];
																			} ?>">
			<input type="text" id="msg" name="msg" class="msger-input" placeholder="Enter your message...">
			<input type="button" name="send" id="send" class="msger-send-btn" value="Send">
		</form>

	</div>
	</div>


    
    
    
    <script>
		$(document).ready(function() {

			conn = new WebSocket('ws://localhost:8080');
			conn.onopen = function(e) {
				var connId = conn.resourceId();
				console.log("Connection established!");
			};

			conn.onmessage = function(e) {
				console.log(e.data);
				data = JSON.parse(e.data);
				var sId = $('#userId').val();

				$('.container').append( '<div class="container ><img src="https://image.flaticon.com/icons/svg/145/145867.svg" alt="Avatar" style="width:100%;"> <p>' + data.msg+
					'</p> <span class="time-right"> today </span> </div>');



			}
		});

		$("#send").click(function(e) {
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

		});


		const SENDER_IMG = "https://image.flaticon.com/icons/svg/327/327779.svg";
		const MY_IMG = "https://image.flaticon.com/icons/svg/145/145867.svg";

		// MY_NAME = "";

		function formatDate(date) {
			const h = "0" + date.getHours();
			const m = "0" + date.getMinutes();

			return `${h.slice(-2)}:${m.slice(-2)}`;
		}
    </script>
    




































