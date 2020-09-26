<?php
//include('utilities.php' ); TODO:  clean code
// variable declaration
$username = "";
$email    = "";
$errors = array();

// REGISTER USER
if (isset($_POST['reg_user'])) {

	// receive all input values from the form
	$fname = esc($_POST['fname']);
	$lname = esc($_POST['lname']);
	$username = esc($_POST['username']);
	$phone = esc($_POST['phone']);
	$state = $_POST['state'];
	$email = esc($_POST['email']);
	$password_1 = esc($_POST['password_1']);
	$password_2 = esc($_POST['password_2']);


	// form validation: ensure that the form is correctly filled
	if ($state === "0") {
		array_push($errors, "please select a state");
	}
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
	if (empty($password_1)) {
		array_push($errors, "uh-oh you forgot the password");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	// Ensure that no user is registered twice. 
	// the email and usernames should be unique
	$user_check_query = "SELECT * FROM users WHERE u_name='$username' 
								OR email='$email' LIMIT 1";
	$state = esc($_POST['state']);
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);

	if ($user) { // if user exists
		if ($user['u_name'] === $username) {
			array_push($errors, "Username already exists");
		}
		if ($user['email'] === $email) {
			array_push($errors, "Email already exists");
		}
	}

	// // Get image name
	// $profile_image = $_FILES['profile_image']['name'];
	// if (empty($profile_image)) { array_push($errors, "profile image is required"); }
	// // image file directory
	// $target = "static/images/" . basename($username,".jpg");
	// print_r($_FILES['profile_image']);
	// if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
	// 	array_push($errors, "Failed to upload image. Please check file settings for your server");
	// }

	$profile_image = setImg($_FILES['profile_image'], $username);


	// register user if there are no errors in the form
	if (count($errors) == 0) {

		$password = md5($password_1); //encrypt the password before saving in the database
		$query = "INSERT INTO users (f_name, l_name, u_name, phone, email, pwd, state, lga, preference,
					gender, profile_image, bio, forgot_pwd_code,  created_at,hobbies_id, age, role) 
					  VALUES('$fname','$lname','$username','$phone', '$email', '$password', '$state',null, 'mf',
					  'm','$profile_image','biohazard',null, now(), null, null,'seeker')";

		$res = mysqli_query($conn, $query);
		if (!$res) {
			array_push($errors, "There was an error inserting data");
			echo mysqli_error($conn);
			exit();
		}
		// get id of created user
		$reg_user_id = mysqli_insert_id($conn);

		// put logged in user into session array
		$_SESSION['user'] = getUserById($reg_user_id);

		// if user is admin, redirect to admin area
		if (in_array($_SESSION['user']['role'], ["admin", "seeker"])) {
			$_SESSION['message'] = "You are now logged in";
			// redirect to admin area
			header('location: ' . BASE_URL . '/admin/dashboard.php');
			exit(0);
		} else {
			$_SESSION['message'] = "You are now logged in";
			// redirect to public area
			header('location: settings.php');
			exit(0);
		}
	}
}

// LOG USER IN
if (isset($_POST['login_btn'])) {
	$username = esc($_POST['username']);
	$password = esc($_POST['password']);

	if (empty($username)) {
		array_push($errors, "Username required");
	}
	if (empty($password)) {
		array_push($errors, "Password required");
	}
	if (empty($errors)) {
		$password = md5($password); // encrypt password
		$sql = "SELECT * FROM users WHERE u_name='$username' and pwd='$password' LIMIT 1";

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			// get id of created user
			$reg_user_id = mysqli_fetch_assoc($result)['user_id'];
			if (getUserById($reg_user_id)['suspended'] === 'true') {
				$id = getUserById($reg_user_id)['user_id'];
				header('location: ' . BASE_URL . 'suspended.php?' . $id);
				exit();
			}

			// put logged in user into session array
			$_SESSION['user'] = getUserById($reg_user_id);

			// if user is admin, redirect to admin area
			if (in_array($_SESSION['user']['role'], ["admin", "user"])) {
				$_SESSION['message'] = "You are now logged in";
				// redirect to admin area

				header('location: ' . BASE_URL . 'admin/dashboard.php');
				exit(0);
			} else {
				$_SESSION['message'] = "You are now logged in";
				// redirect to public area
				header('location: ' . BASE_URL . 'people.php');
				exit(0);
			}
		} else {
			array_push($errors, 'Wrong credentials');
		}
	}
}

// escape value from form
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
	
	global $conn, $errors;
	if (!empty(esc($id)) || esc($id) != null) {
		$sql = "SELECT * FROM users WHERE user_id=$id LIMIT 1";

		if ($result = mysqli_query($conn, $sql)) {
			$user = mysqli_fetch_assoc($result);
			// returns user in an array format: 
			// ['id'=>1 'username' => 'Awa', 'email'=>'a@a.com', 'password'=> 'mypass']
			return $user;
		} else {
			array_push($errors, 'there was a problem');
		}
	}else{
		array_push($errors, 'input is empty');

	}
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
					$res = array_push($errors, "there was an error in the file upload. pls try again");
				}
			} else {
				$res = array_push($errors, "file size is too large, cannot be more than 2mb");
			}
		} else {
			$res = array_push($errors, "this file extention is not allowed \n allowed Extentions include: .jpg,.png,.jpeg");
		}
	}
	return $res;
}
