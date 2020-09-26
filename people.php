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

			include("like.php");



			global $people;
			$clickCount = 1;
			$errors = array();
			if($_SESSION['user']['suspended'] === 'true') {
				$id = $_SESSION['user']['user_id'];
				header('location: ' . BASE_URL . 'suspended.php?'.$id);
				exit();
			}
			if (!empty($_SESSION['user'])) {
				$details = $_SESSION['user'];
				$username = $details['u_name'];
				$uid = $details['user_id'];
				$pref = $details['preference'];
				$sql = '';

				if ($pref === 'mf') {
					$sql = "SELECT * FROM users WHERE u_name != '$username' AND  gender = 'm' OR gender ='f' ";
				} else {
					$sql = "SELECT * from users where u_name != '$username' and  gender = '$pref' and profile_image !=''";
				}


				$query2 = "SELECT liked_id from likes where user_id = '$uid' ";
				$query3 = "SELECT unliked_uid from unlikes where user_id = '$uid' ";




				$query_result = mysqli_query($conn, $sql);
				$query2_result = mysqli_query($conn, $query2);
				$query3_result = mysqli_query($conn, $query3);


				if ($query_result && $query2_result && $query3_result) {

					$r1 = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
					$r2 = mysqli_fetch_all($query2_result, MYSQLI_ASSOC);
					$r3 = mysqli_fetch_all($query3_result, MYSQLI_ASSOC);
					$display = $filter1 = array();
					$r11 = array();
					$r21 = array();
					$r31 = array();

					for ($i = 0; $i < sizeof($r1); $i++) {
						array_push($r11, $r1[$i]['user_id']);
					}

					for ($i = 0; $i < sizeof($r2); $i++) {
						array_push($r21, $r2[$i]['liked_id']);
					}
					for ($i = 0; $i < sizeof($r3); $i++) {
						array_push($r31, $r3[$i]['unliked_uid']);
					}

					for ($i = 0; $i < sizeof($r1); $i++) {
						if (in_array($r1[$i]['user_id'], $r21) || in_array($r1[$i]['user_id'], $r31)) continue;
							
						
							array_push($filter1, $r1[$i]);
						
					}

					// $diff1 = array_diff($r21,$r31);
					// $diff2 = array_diff($r31,$r21);
					// $merge = array_merge($diff1,$diff2);
					// // print_r($r11);



					// 					//$count1 =  mysqli_num_rows($r11);

					// 					for ($i = 0; $i < sizeof($r11); $i++) {

					// 						if (!in_array($r11[$i], $merge)) {
					// 							array_push($filter1, $r11[$i]);
					// 						}
					// 					}
					// 					print_r($filter1);
					// 					// for ($j = 0; $j < sizeof($filter1); $j++) {

					// 					// 	if (!in_array($filter1[$j], $r31)) {
					// 					// 		array_push($display, $filter1[$j]);
					// 					// 	}
					// 					// }
				} else {
					array_push($errors, 'there was a problem ');
				}


				//$num_of_people = mysqli_num_rows($query_result);
				$num_of_people = sizeof($filter1);

				$persons = $filter1;
			} else {
				die("You must Be <a href=login.php>Logged in </a>First</div></body></html>");
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
					<?php include(ROOT_PATH .  "/includes/errors.php"); ?>

			</a>
			<!-- <span><?php echo $_SESSION['user']['u_name'] ?> -->
		</div>

		<div class="menu">
			<ul>
				<li class="active"><a href="people.php">People</a></li>
				<li><a href="messages.php">Messages</a></li>
			</ul>

		</div>
		<?php
if ($num_of_people == 0) {
	array_push($errors, "<h2> There are no more match for ur preferance</h2>");
}
		$likes_arr = showLikes($uid);
		 
		echo " <span style='color: orangered; margin:0 8px '><strong>Likes</strong></span> ";
		$nol = sizeof($likes_arr);
		if($nol >0){
			//is_array($likes_arr) ?	$nol = sizeof($nol) : $nol = 0;
		for ($i = 0; $i < $nol; $i++) {
			$POS = $likes_arr[$i]['user_id'];

			$srctime =  $likes_arr[$i]['timestamp'];
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
				</hr>
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
		}else{
			echo <<<END
				<hr>
						
						<div class="message">
							<div class="user"></br><Strong>Sorry You Have No Likes Yet</Strong></div>
							<div class="text"></div>
						</div>
				END;
		}
		?>

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