
				$query2 = "Select liked_id from likes where user_id = '$uid' ";
				$query3 = "Select unliked_id from unlikes where user_id = '$uid' ";




				$query_result = mysqli_query($conn, $sql);
				$query2_result = mysqli_query($conn, $query2);
				$query3_result = mysqli_query($conn, $query2);

				$r1 = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
				//$r2 = mysqli_fetch_row($query2_result)[0];
				$r2 = array();
				$getids = array();
				while (mysqli_fetch_row($query2_result) != null) {
					array_push($r2, mysqli_fetch_row($query2_result)[0]);
				}

				$r3 = mysqli_fetch_all($query3_result, MYSQLI_ASSOC);
				$display = $filter1 = array();
				if ($r1 && $r2 && $r3) {

					$count1 =  mysqli_num_rows($query_result);

					for ($i = 0; $i < $count1; $i++) {


						
							if (!in_array($r1[$i]['user_id'], $r2)) {
								array_push($filter1, $i);
							}
					
					}
					// for ($j = 0; $j < sizeof($filter1); $j++) {

					// 	if (!in_array($filter1[$j]['user_id'], $r3)) {
					// 		array_push($display, $j);
					// 	}
					// }
				} else {
					array_push($errors, 'there was a problem ');
				}













###############################################################################################################################
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="css/peoplestyle.css" />
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,500&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
	<title>people</title>
	<script src="jquery.js"></script>
</head>

<body>
	<div class="container">
		<div class="side">

			<?php


			include('config.php');


			global $people;
			$clickCount = 1;
			$errors = array();

			if (!empty($_SESSION['user'])) {
				$details = $_SESSION['user'];
				$username = $details['u_name'];
				$uid = $details['user_id'];
				$pref = $details['preference'];
				$sql = '';

				if ($pref === 'mf') {
					$sql = "SELECT * FROM users WHERE u_name != '$username' AND  gender = 'm' OR gender ='f' ";
				} else {
					$sql = "Select * from users where u_name != '$username' and  gender = '$pref' and profile_image !=''";
				}


				$query2 = "Select liked_id from likes where user_id = '$uid' ";
				$query3 = "Select unliked_uid from unlikes where user_id = '$uid' ";




				$query_result = mysqli_query($conn, $sql);
				$query2_result = mysqli_query($conn, $query2);
				$query3_result = mysqli_query($conn, $query2);

				$r1 = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
				$r2 = mysqli_fetch_all($query2_result, MYSQLI_ASSOC);
				$r3 = mysqli_fetch_all($query3_result, MYSQLI_ASSOC);
				$display = $filter1 = array();
				if ($r1 && $r2 && $r3) {
$r11=$r21=$r31 = array();
					for($i=0; $i< sizeof($r1); $i++){
						array_push($r11, $r1[$i]['user_id']);
					}

					for($i = 0; $i<sizeof($r2); $i++){
						array_push($r21, $r2[$i]['liked_id']);
					}
					for($i = 0; $i<sizeof($r3); $i++){
						array_push($r31, $r3[$i]['unliked_uid']);
					}
					






					//$count1 =  mysqli_num_rows($r11);

					for ($i = 0; $i < sizeof($r11); $i++) {

						if (!in_array($r11[$i], $r21)) {
							array_push($filter1, $r1[$i]);

						}
					}
					//print_r($filter1);
					for ($j = 0; $j < sizeof($filter1); $j++) {

						if (!in_array($filter1[$j], $r31)) {
							array_push($display, $filter1[$j]);
						}
					}
				} else {
					array_push($errors, 'there was a problem ');
				}











				// $row = mysqli_fetch_assoc($query_result);
				//$likes  '= mysqli_fetch_all($query2,MYSQLI_ASSOC);


				//$num_of_people = mysqli_num_rows($query_result);
				$num_of_people = sizeof($filter1);


				// if (!$query_result) {
				// 	array_push($errors, mysqli_error($conn));
				// }
				// $persons = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
				$persons = $filter1;
			} else {
				die("You must Be <a href=login.php>Logged in </a>First</div></body></html>");
			}


			if ($num_of_people == 0) {
				array_push($errors, "<h2> There are no People that match Your Preference \n Try Adjusting Your Location or Preferences</h2>");
			} 
			?>
			<script>
				clickCount = 0;
				var clkCount = {

					/* Properties */
					v: "0",


					/* Getter methods */
					getV: function() {
						return this.v;
					},


					/* Setter methods */
					setV: function(newV) {
						this.v = newV;

					}
				};


				var json = <?php echo json_encode($persons); ?>;
				// for (var key in json) {
				//     if (json.hasOwnProperty(key)) {
				//         console.log(key + " -> " + json[key]);

				//     }
				// }
				var person = json[parseInt(clkCount.v)];
				name = person.f_name + " " + person.l_name;
				age = person.age;
				loc = person.state;
				img = person.profile_image;
				bio = person.bio

				uid = person.user_id;
			</script>

			<a href="settings.php">
				<div class="header">
					<div class="avatar">
						<img src=<?php echo "static/images/" . $details['profile_image'] ?> alt="<?php echo $username ?>" />
					</div>
					<div class="title"><?php echo $details['u_name'] ?></span> &nbsp; &nbsp; <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a></div>
<?php include(ROOT_PATH .  "/includes/errors.php");?>

			</a>
			<!-- <span><?php echo $_SESSION['user']['u_name'] ?> -->
		</div>

		<div class="menu">
			<ul>
				<li class="active"><a href="people.php">People</a></li>
				<li><a href="messages.php">Messages</a></li>
			</ul>
		</div>

		<div class="messages">
			<div class="avatar">
				<img src="https://randomuser.me/api/portraits/women/38.jpg" alt="" />
			</div>
			<div class="message">
				<div class="user">Caroline</div>
				<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
			</div>
		</div>
		<div class="messages">
			<div class="avatar">
				<img src="https://randomuser.me/api/portraits/women/39.jpg" alt="" />
			</div>
			<div class="message">
				<div class="user">Caroline</div>
				<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
			</div>
		</div>


		<div class="messages">
			<div class="avatar">
				<img src="https://randomuser.me/api/portraits/women/39.jpg" alt="" />
			</div>
			<div class="message">
				<div class="user">Caroline</div>
				<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
			</div>
		</div>
		<div class="messages">
			<div class="avatar">
				<img src="https://randomuser.me/api/portraits/women/39.jpg" alt="" />
			</div>
			<div class="message">
				<div class="user">Caroline</div>
				<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
			</div>
		</div>


		<div class="messages">
			<div class="avatar">
				<img src="https://randomuser.me/api/portraits/women/39.jpg" alt="" />
			</div>
			<div class="message">
				<div class="user">Caroline</div>
				<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
			</div>
		</div>
		<div class="messages">
			<div class="avatar">
				<img src="https://randomuser.me/api/portraits/women/40.jpg" alt="" />
			</div>
			<div class="message">
				<div class="user">Caroline</div>
				<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
			</div>
		</div>
		<div class="messages">
			<div class="avatar">
				<img src="https://randomuser.me/api/portraits/women/41.jpg" alt="" />
			</div>
			<div class="message">
				<div class="user">Caroline</div>
				<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
			</div>
		</div>
		<div class="messages">
			<div class="avatar">
				<img src="https://randomuser.me/api/portraits/women/42.jpg" alt="" />
			</div>
			<div class="message">
				<div class="user">Caroline</div>
				<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
			</div>
		</div>
	</div>


	<?php
	for ($i = 0; $i < $num_of_people; $i++) : ?>
		<div id='<?php echo 'userInfoView' . $i ?>' class="content" style="margin-right: 20px ;">
			<div class="card">
				<div class="user">
					<div>
						<img class="user" id=<?php echo 'userProfileImg' . $i ?> src=<?php echo "static/images/" . $persons[$i]['profile_image'] ?> alt="<?php echo $persons[$i]['profile_image'] ?>" />
						<div style="position: absolute; top:0; left:0; z-index:-1;">
						<label for="mid">ID:</label><span id="mid"> <?php echo $persons[$i]['user_id'] ?></span></br>
							
							<label for="fname">First Name:</label><span id="fname"> <?php echo $persons[$i]['f_name'] ?></span></br>
							<label for="lname">Last Name:</label><span id="lname"> <?php echo $persons[$i]['l_name'] ?></span></br>
							<label for="phone">Phone:</label><span id="phone"> <?php echo $persons[$i]['phone'] ?></span></br>
							<label for="state">State:</label><span id="state"> <?php echo $persons[$i]['state'] ?></span></br>
							<label for="bio">Bio</label><span style="text-overflow:auto ;" id="bio"> <?php echo $persons[$i]['bio'] ?></span>

						</div>
					</div>

					<div class="profile">
						<div class="name"><?php echo $persons[$i]['f_name'] . " " . $persons[$i]['l_name'] ?> <span><?php echo $persons[$i]['age'] ?></span></div>
						<div class="local">
							<i class="fas fa-map-marker-alt"></i>
							<span id="userProfileState"><?php echo $persons[$i]['state'] ?></span>
							<span id="userProfileGender"><?php echo $persons[$i]['gender'] ?></span>
						</div>
					</div>
				</div>
			</div>
			<span id="ulmsg"></span>
			<div class="buttons">
				<div id=<?php echo 'unlike' . $i ?> class="no">
					<i class="fas fa-times"></i>
				</div>
				<div class="star" id="<?php echo 'info' . $i ?>">
					<i class="fas fa-info fa"></i>
				</div>
				<div id=<?php echo 'like' . $i ?> class="heart">
					<i class="fas fa-heart"></i>
				</div>
			</div>
		</div>

		<script>
			CURRENT_ARR_POS = parseInt(<?php echo $i ?>)

			//var uname = <?php echo $persons[$i]['u_name']; ?>

			$('#info' + <?php echo $i ?>).click(function() {
				$('#userProfileImg' + <?php echo $i ?>).toggle('slow', 'linear')


			})


			$('#unlike' + <?php echo $i ?>).click(function() {
				$.post('unlike.php', {
					uid: <?php echo $details['user_id'] ?>,
					unliked_uid: <?php echo $persons[$i]['user_id'] ?>
				}, function(data) {

					console.log("data  : " + data)

					$('#ulmsg').html(data)
				})

				$('#userInfoView' + <?php echo $i ?>).hide('slow', 'linear')
				clickCount = (parseInt(clkCount.v) - 1)
				clkCount.v = clickCount

				console.log("after minusing: " + clickCount)
				$('#userProfileName').html(name).fadeIn('fast')

				$('#UserProfileAge').html(age)
				$('#UserProfileState').html(loc)
				$("#userProfileImg").hide().attr("src", "static/images/" + img).fadeIn('fast').css("z-index", "-1");


			})

			$('#like' + <?php echo $i ?>).click(function() {
				// uid = parseInt(<?php echo $details['user_id'] ?>)
				// liked_uid = parseInt(<?php echo $persons[$i]['user_id'] ?>)

				$.post('like.php', {
					uid: <?php echo $details['user_id'] ?>,
					liked_uid: <?php echo $persons[$i]['user_id'] ?>
				}, function(data) {

					console.log("data  : " + data)

					$('#ulmsg').html(data)
				})

				$('#userInfoView' + <?php echo $i ?>).hide('slow', 'linear')
				clickCount = (parseInt(clkCount.v) + 1)
				clkCount.v = clickCount

				console.log("after adding: " + clickCount)
				console.log("CURRENT_ARR_POS  : " + <?php echo $i ?>)
			})

			$('#idddnfo').click(function() {
				location.href = "";
				var url = "http://userinfo.php";
				window.location(url);
			})
		</script>

	<?php

	endfor ?>
	</div>

	<script>
		/* Calling the setter accessor properties */



		//$('#userProfileName').html("kncdlskjbcdsjbcsdl")

		// // name = p.f_name + " " + p.l_name
		// $('#userProfileName').html(name)
		// $('#bio').html(bio)

		// $('#UserProfileAge').html(age)
		// $('#UserProfileState').html(loc)
		// $("#userProfileImg").attr("src", "static/images/" + img);

		function showInfo() {
			$('#userProfileImg').toggle('slow', 'linear')
		}



		//$('#side').offsetParent
		// 		pnode = newdiv.parentNode
		//  pnode.removeChild(newdiv)
		//  tmp = pnode.offsetTop
	</script>

	</div>
	<!-- // Page content -->

	<!-- footer -->
	<div class="footer">
		<p>CS_SEEKER &copy; <?php echo date('Y'); ?></p>
	</div>
	<!-- // footer -->

	</div>
	<!-- // container -->
	</div>
</body>

</html> 	