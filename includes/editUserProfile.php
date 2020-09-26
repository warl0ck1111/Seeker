<?php
// variable declaration
$username = "";
$email    = "";
$errors = array();


// $d = $_SESSION['user'];
// $fname =$d['f_name'];
// 	$lname = $d['l_name'];
// 	$email = $d['email'];
// 	$phone = $d['phone'];
// 	$location = $d['state'];
// 	$gender = $d['gender'];
// 	$preference = $d['preference'];
// 	$username = $d['u_name'];
// 	$age =  $d['age'] ;


##################################################################################################################
// UPDATE USER DETAILS
if (isset($_POST['save_edit'])) {



	$details = $_SESSION['user'];
	// receive all input values from the form
	$fname = esc($_POST['fname']);
	$lname = esc($_POST['lname']);
	$state = $_POST['state'];
	$email = esc($_POST['email']);
	$phone = esc($_POST['phone']);
	$state = $_POST['state'];
	$gender = $_POST['gender'];
	$preference = $_POST['preferences'];
	$age =  $_POST['age'];
	$username = esc($_POST['username']);
	$id = $details['user_id'];

	$bio = esc($_POST['bio']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) {
		array_push($errors, "Uhmm...We gonna need your username");
	}
	if (empty($fname)) {
		array_push($errors, "Uhmm...We gonna need your firstname");
	}
	if (empty($lname)) {
		array_push($errors, "Uhmm...We gonna need your last name");
	}
	if (empty($phone)) {
		array_push($errors, "Uhmm...We gonna need your phone");
	}
	if (empty($email)) {
		array_push($errors, "Oops.. Email is missing");
	}
	if ($state == "0") {
		array_push($errors, "please select a state");
	}
	if ($gender == "0") {
		array_push($errors, "please select a gender");
	}
	if ($preference == "0") {
		array_push($errors, "please select your preference");
	}

	// Ensure that no username is populates twice. 
	// both email and usernames should be unique and except me in query
	$user_check_query = "SELECT * FROM users WHERE user_id !='$id'  LIMIT 1";

	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);

	if ($user) { // if user exists
		if ($user['u_name'] === $username) {
			array_push($errors, "Username already exists");
		}
		if ($user['email'] === $email) {
			array_push($errors, "Email already exists");
		}
		if ($user['phone'] === $phone) {
			array_push($errors, "phone already exists");
		}
	}

	

// 	$preference ="";
// 	$gender ="";
// switch ($_POST['preferences'] || $_POST['gender']) {
//     case 'Male':
//         $preference = "m";
//         $gender = "m";
//         break;
//     case 'Female':
//         $preference = "f";
//         $gender = "f";
//         break;
//     case 'Male & Female':
//         $preference = "mf";
//         $gender = "mf";
//         break;
// }

 
	// Update user details if there are no errors in the form
	if (count($errors) == 0) {
		$query = "";

		if (($username === $details['u_name']) || ($email === $details['email']) || ($phone === $details['phone'])) {
			//if only username is the same
			if (($username === $details['u_name']) && ($email === $details['email'])) {
				$query = "UPDATE  users set f_name='$fname', l_name='$lname',
							phone='$phone',  state='$state',  preference='$preference',
							gender='$gender', bio='$bio', age='$age' where user_id= '$id' ";
			}
			if (($username === $details['u_name']) && ($email != $details['email']) && ($phone != $details['phone'])) {
				$query = "UPDATE  users set f_name='$fname', l_name='$lname',
							phone='$phone', email='$email', state='$state',  preference='$preference',
							gender='$gender', bio='$bio', age='$age' where user_id= '$id' ";
			}
			//if only email is the same
			elseif (($email === $details['email']) && ($username != $details['u_name']) && ($phone != $details['phone'])) {
				$query = "UPDATE  users set f_name='$fname', l_name='$lname',u_name='$username',
							phone='$phone', state='$state',  preference='$preference',
							gender='$gender', bio='$bio', age='$age' where user_id= '$id' ";
			}
			//if only phone is the same
			elseif (($phone === $details['phone']) && ($email != $details['email']) && ($username != $details['u_name'])) {
				$query = "UPDATE  users set f_name='$fname', l_name='$lname', u_name='$username',
							email='$email', state='$state',  preference='$preference',
							gender='$gender', bio='$bio', age='$age' where user_id= '$id' ";
			} elseif (($username === $details['u_name']) && ($email === $details['email']) && ($phone === $details['phone'])) {
				$query = "UPDATE  users set f_name='$fname', l_name='$lname',
							state='$state',  preference='$preference',
							gender='$gender', bio='$bio', age='$age' where user_id= '$id' ";
			}
		} else {
			//none are the same
			$query = "UPDATE  users set f_name='$fname', l_name='$lname', u_name='$username', 
				phone='$phone', email='$email', state='$state',  preference='$preference', 
				gender='$gender', bio='$bio', age='$age' where user_id= '$id' ";
		}


		$res = mysqli_query($conn, $query);

		if (!$res) {
			echo mysqli_error($conn);
			echo "opps You cant do that sorry :( ...exiting gracefully";
			exit();
		}




		// put updated user back into session array
		$_SESSION['user'] = getUserDetails($id);

		$_SESSION['message'] = "Profile Updated Successfully";
		// redirect to choice area
		header('location:  /seektest/settings.php');
		exit(0);
	}
}



if (isset($_POST['img_Upload'])) {
	$username = $_SESSION['user']['u_name'];
	$id = $_SESSION['user']['user_id'];
	$profile_image = setImg($_FILES['profile_image'], $username);

	if (count($errors) == 0) {
		$sql = "UPDATE users set profile_image='$profile_image' where u_name ='$username'";
		$res = mysqli_query($conn, $sql);

		if (!$res) {
			echo mysqli_error($conn);
			array_push($errors, "there was an error updating image, Try again :(");
			exit();
		} else {
			//echo "<script> alert('image upload successfully')</script>";

			// put updated user back into session array
			$_SESSION['user'] = getUserDetails($id);
			//TODO: delete old profile image FROM FILE DIR
			$_SESSION['message'] = "Profile image Updated Successfully";
			// redirect to choice area
			header('location:  /seektest/settings.php');
			exit(0);
		}
	} else {
		array_push($errors, "Image Failed to Upload");
	}
}
// Get user info from user id
function getUserDetails($id)
{
	global $conn;
	$sql = "SELECT * FROM users WHERE user_id=$id LIMIT 1";

	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);

	// returns user in an array format: 
	// ['id'=>1 'username' => 'bash', 'email'=>'a@a.com', 'password'=> 'mypass']
	return $user;
}

/// escape value from form
function esc(String $value)
{
	// bring the global db connect object into function
	global $conn;

	$val = trim($value); // remove empty space sorrounding string
	$data = stripslashes($val);
	$data = htmlspecialchars($data);
	//$val = mysqli_real_escape_string($conn, $value);

	return $data;
}

// Get user info from user id
function getUserById($id)
{
	global $conn;
	$sql = "SELECT * FROM users WHERE user_id=$id LIMIT 1";

	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);

	// returns user in an array format: 
	// ['id'=>1 'username' => 'bash', 'email'=>'a@a.com', 'password'=> 'mypass']
	return $user;
}


function setImg($profile_image = array(), $username)
{
	if (!empty($profile_image)) {
		$file = $profile_image; //get the file from global variable
		//print_r($file);
		$res = "";
		$errors = array();
		//getting appropriate data
		$fileName = $profile_image['name'];
		$fileTmpName = $profile_image['tmp_name'];
		$fileError = $profile_image['error'];
		$fileSize = $profile_image['size'];

		//get extention
		$fileExt = explode('.', $fileName);
		$actualExt = strtolower(end($fileExt));
		//create array of allowed ext
		$allowedExt = array("jpg", "png", "jpeg");

		if (in_array($actualExt, $allowedExt)) { //check if ext is allowed in_array()

			if ($fileSize <= 2621440) { //check if allowed file size

				if ($fileError === 0) { //check if there's error

					//create unique name for file with prefix and generated name and suffix extention
					$uniqueName = uniqid($username, false) . "." . $actualExt;

					//destination path + uniqueName
					$destination = "static/images/" . $uniqueName;


					//move file from temp location to destination
					move_uploaded_file($fileTmpName, $destination);
					$res = $uniqueName;

					//header("location: upload.html?UploadSuccessfull");


				} else {
					array_push($errors, "there was an error in the file upload. pls try again");
				}
			} else {
				array_push($errors, "file size is too large, cannot be more than 2mb");
			}
		} else {
			array_push($errors, "this file extention is not allowed \n allowed Extentions include: .jpg,.png,.jpeg");
		}
	}
	return $res;
}
