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


    if ($_SESSION['user']) {

        $sql = "Select * from users where u_name != '$username' and prefrence = 
        'male'";
    
        $query_result = mysqli_query($conn, $sql);
    
        $num_of_people = mysqli_num_rows($query_result);


        if (!$query_result) {
            array_push($errors, "there was an error");
        }
        $persons = mysqli_fetch_all($query_result, MYSQLI_ASSOC);

    
    } else {
        die("You must Be <a href=login.php>Logged in </a>First</div></body></html>");
    }


    if($num_of_people == 0){ echo "<h2> There are no People that match Your Preference \n Try Adjusting Your 
    Location or Preferences</h2>";
    }
 
    for($i = 0; $i < $num_of_people; $i++): ?>
		<div id=<?php echo 'userInfoView' . $i ?>  class="content" style="margin-right: 20px ;">
			<div class="card">
				<div class="user">
					<div>
						<img class="user" id=<?php echo 'userProfileImg' . $i ?> src=<?php echo 
                        "static/images/" . $persons[$i]['profile_image'] ?> alt="<?php echo $persons[$i]['profile_image'] ?>" />
						<div  style="position: absolute; top:0; left:0; z-index:-1;">
						<label for="fname">First Name:</label><span id="fname" > <?php echo $persons[$i] ['f_name'] ?></span></br>
						<label for="lname">Last Name:</label><span id="lname" > <?php echo $persons[$i] ['l_name'] ?></span></br>
						<label for="phone">Phone:</label><span id="phone" > <?php echo $persons[$i] ['phone'] ?></span></br>
						<label for="state">State:</label><span id="state" > <?php echo $persons[$i] ['state'] ?></span></br>
						<label for="bio">Bio</label><span id="bio"> <?php echo $persons[$i]['bio'] ?> 
                        </span>

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
			<div class="buttons">
				<div id=<?php echo 'unlike' . $i ?> class="no">
					<i class="fas fa-times"></i>
				</div>
				<div class="info" id="<?php echo 'info' . $i ?>">
					<i class="fas fa-info fa"></i>
				</div>
				<div id=<?php echo 'like' . $i ?> class="heart">
					<i class="fas fa-heart"></i>
				</div>
			</div>
        </div>

        <script>
            CURRENT_ARR_POS = <?php echo $i ?>
			$('#info' + CURRENT_ARR_POS).click(function() {
                
				$('#userProfileImg' + CURRENT_ARR_POS).toggle('slow', 'linear')
			})


			$('#unlike'+ CURRENT_ARR_POS).click(function() {
                //use ajax to update unlike table
				$('#userInfoView'+ CURRENT_ARR_POS).hide('fast', 'linear')
				 
			})

			$('#like'+ CURRENT_ARR_POS).click(function() {
                //use ajax to update like table
                $('#userInfoView'+ CURRENT_ARR_POS).hide('fast', 'linear')
			})
		</script>
 <?php endfor ?>
        </div>
        

    </div>




</body>


</html>