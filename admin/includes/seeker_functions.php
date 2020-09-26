<?php
// Seeker user variables

use function PHPSTORM_META\type;

$seeker_id = 0;
$isEditingUser = false;
$username = "";
$fname = "";
$lname = "";
$age = "";
$gender = "";
$preference = "";
$phone = "";
$role = "";
$email = "";
// general variables
$errors = [];
$isSeeker = false;

/* - - - - - - - - - - 
-  Seeker users actions
- - - - - - - - - - -*/
// if user clicks the create Seeker button
if (isset($_POST['create_seeker'])) {
	createSeeker($_POST);
}
// if user clicks the Edit seeker button
if (isset($_GET['edit-seeker'])) {
	$isEditingUser = true;
	$seeker_id = $_GET['edit-seeker'];
	editSeeker($seeker_id);
}
// if user clicks the update seeker button
if (isset($_POST['update_seeker'])) {
	updateSeeker($_POST);
} // if user clicks the search seeker button
if (isset($_POST['search'])) {
	global $keyword;
	$keyword = esc($_POST['key']);
}
// if user clicks the Delete seeker button
if (isset($_GET['delete-seeker'])) {
	$seeker_id = $_GET['delete-seeker'];
	deleteSeeker($seeker_id);
}

// if user clicks the suspend-seeker button
if (isset($_GET['suspend-seeker'])) {
	$seeker_id = $_GET['suspend-seeker'];
	suspendSeeker($seeker_id);
}

// if user clicks the unsuspend-seeker button
if (isset($_GET['unsuspend-seeker'])) {
	$seeker_id = $_GET['unsuspend-seeker'];
	UnSuspendSeeker($seeker_id);
}


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - UnSuspends seeker
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function UnSuspendSeeker($id){
    if (in_array($_SESSION['user']['role'], ['admin'])) {
        global $conn , $errors;
        $sql = "update users set suspended='false' where user_id =$id";
        if($result = mysqli_query($conn, $sql)){
            $_SESSION['message'] = "User UnSuspended";

        }else{
            array_push($errors, "there was an error");
        }
    }
}


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Suspends seeker
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function suspendSeeker($id)
{
	global $conn, $errors;
	if (in_array($_SESSION['user']['role'], ['admin'])) {
		global $conn, $errors;
		$sql = "update users set suspended='true' where user_id =$id";
		if ($result = mysqli_query($conn, $sql)) {
			$_SESSION['message'] = "User Suspended";
		} else {
			array_push($errors, "there was an error" . mysqli_error($conn));
		}
	}
}


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Returns all seeker users and their corresponding roles
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getSeekers()
{
	if (in_array($_SESSION['user']['role'], ['admin'])) {
		global $keyword, $conn, $roles;

		$sql = "SELECT * FROM users WHERE role = 'seeker' AND U_name or l_name or f_name like '%$keyword%' order by created_at desc "; //WHERE role IS NOT NULL
		$result = mysqli_query($conn, $sql);
		$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

		return $users;
	} else {
		return null;
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Escapes form submitted value, hence, preventing SQL injection
* * * * * * * * * * * * * * * * * * * * * */
// escape value from form
function esc(String $value)
{
	// bring the global db connect object into function
	global $conn;

	$val = trim($value); // remove empty space sorrounding string
	$data = stripslashes($val);
	$data = htmlspecialchars($data);
	$val = mysqli_real_escape_string($conn, $value);

	return $data;
}
// Receives a string like 'Some Sample String'
// and returns 'some-sample-string'
function makeSlug(String $string)
{
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}

/* - - - - - - - - - - - -
-  seeker users functions
- - - - - - - - - - - - -*/
/* * * * * * * * * * * * * * * * * * * * * * *
* - Receives new seeker data from form
* - Create new seeker user
* - Returns all seeker users with their roles 
* * * * * * * * * * * * * * * * * * * * * * */
function createSeeker($request_values)
{
	if (in_array($_SESSION['user']['role'], ['admin'])) {
		global $conn, $errors, $role, $username, $email;
		$username = esc($request_values['username']);
		$fname = esc($request_values['fname']);
		$lname = esc($request_values['lname']);
		$phone = esc($request_values['phone']);
		$email = esc($request_values['email']);
		$age = esc($request_values['age']);
		$state =  esc($request_values['state']);
		$password = esc($request_values['password']);
		$passwordConfirmation = esc($request_values['passwordConfirmation']);

		if(! is_integer($phone)) array_push($errors, "Invalid Charated entered for phone");
		switch ($request_values['gender']) {
			case ("Male"):
				$gender = 'm';
				break;
			case ("Female"):
				$gender = 'f';
				break;
			default:
				array_push($errors, 'please input a valid gender');
		}
		switch ($request_values['preference']) {
			case ("male"):
				$preference = 'm';
				break;
			case ("female"):
				$preference = 'f';
				break;
			case ("Male & Female"):
				$preference = 'mf';
				break;
			default:
				$preference = 'mf';
		}

		switch ($request_values) {
			case (isset($request_values['role'])): {
					$role = esc($request_values['role']);
					break;
				}

			case (isset($request_values['gender'])): {
					$gender = esc($request_values['gender']);
					break;
				}

			case (isset($request_values['state'])): {
					$state = esc($request_values['state']);
					break;
				}

			case (isset($request_values['preference'])): {
					$preference = esc($request_values['preference']);
					break;
				}
		}


		// form validation: ensure that the form is correctly filled
		if (empty($username)) {
			array_push($errors, "Uhmm...We gonna need the username");
		}
		if (empty($fname)) {
			array_push($errors, "Uhmm... you forgot the seeker's First name");
		}
		if (empty($lname)) {
			array_push($errors, "Uhmm...you forgot the seeker's Last name");
		}
		if (empty($phone)) {
			array_push($errors, "Uhmm...you forgot the seeker's Phone Number");
		}
		if (empty($email)) {
			array_push($errors, "Oops.. Email is missing");
		}
		if (empty($age)) {
			array_push($errors, "Oops.. you missed the age");
		}
		if (empty($gender)) {
			array_push($errors, "Oops.. Gender please");
		}
		if ($state === '0') {
			array_push($errors, "Please Select a State");
		}
		if (empty($preference)) {
			array_push($errors, "please select a preference");
		}
		if (empty($role)) {
			array_push($errors, "Role is required for seeker users");
		}
		if (empty($password)) {
			array_push($errors, "uh-oh you forgot the password");
		}
		if ($password != $passwordConfirmation) {
			array_push($errors, "The two passwords do not match");
		}
		// Ensure that no user is registered twice. 
		// the email and usernames should be unique
		$user_check_query = "SELECT * FROM users WHERE u_name='$username' 
							OR email='$email' OR phone='$phone' LIMIT 1";
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
				array_push($errors, "Phone already exists");
			}
		}
		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password); //encrypt the password before saving in the database
			$query = "INSERT INTO users (u_name, f_name, l_name, phone, email, role, state, pwd, age, gender,preference, created_at) 
				  VALUES('$username','$fname','$lname','$phone', '$email', '$role','$state', '$password', '$age', '$gender', '$preference',  now())";
			$result = mysqli_query($conn, $query);

			if ($result) {
				$_SESSION['message'] = "Seeker created successfully login to add Profile Image And Bio";
				header('location: seekers.php');
				exit(0);
			} else {
				array_push($errors, 'There was a problem creating New Seeker');
			}
		}
	} else {
		header("location:" . BASE_URL . "/admin/dashboard.php");
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Takes seeker id as parameter
* - Fetches the seeker from database
* - sets seeker fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editSeeker($seeker_id)
{
	global $conn, $errors, $username, $role, $isEditingUser, $state, $seeker_id, $email,
	 $age, $gender, $preference, $fname, $lname, $phone;

	$sql = "SELECT * FROM users WHERE user_id=$seeker_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$seeker = mysqli_fetch_assoc($result);

	// set form values ($username and $email) on the form to be updated
	$username = $seeker['u_name'];
	$email = $seeker['email'];
	$age = $seeker['age'];
	$gender = $seeker['gender'];

	$state = $seeker['state'];
	$preference = $seeker['preference'];




	
	$phone = $seeker['phone'];
	$fname = $seeker['f_name'];
	$lname = $seeker['l_name'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Receives seeker request from form and updates in database
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateSeeker($request_values)
{
	global $conn, $errors, $role, $state, $username, $phone, $age, $gender,
		$preference, $lname, $fname, $isEditingUser, $seeker_id, $email;
	// get id of the seeker to be updated
	$seeker_id = $request_values['seeker_id'];
	// set edit state to false
	$isEditingUser = false;



	$username = esc($request_values['username']);
	$phone = esc($request_values['phone']);
	$fname = esc($request_values['fname']);
	$lname = esc($request_values['lname']);
	$state = esc($request_values['state']);
	$email = esc($request_values['email']);
	$age = esc($request_values['age']);
	$gender = $request_values['gender'];
	$preference = $request_values['preference'];
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);



	switch ($request_values['gender']) {
		case ("Male"):
			$gender = 'm';
			break;
		case ("Female"):
			$gender = 'f';
			break;
		default:
			array_push($errors, 'please input a valid gender');
	}
	switch ($request_values['preference']) {
		case ("Male"):
			$preference = 'm';
			break;
		case ("Female"):
			$preference = 'f';
			break;
		case ("Male & Female"):
			$preference = 'mf';
			break;
		default:
			$preference = 'mf';
	}


	if (isset($request_values['role'])) {
		$role = $request_values['role'];
	}
	if ($password != $passwordConfirmation) {
		array_push($errors, "The two passwords do not match");
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		//encrypt the password (security purposes)
		$password = md5($password);

		$query = "UPDATE users SET u_name='$username',state='$state', f_name='$fname', age='$age', gender='$gender', preference='$preference', l_name='$lname', phone='$phone', email='$email', role='$role', pwd='$password' WHERE user_id=$seeker_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Seeker updated successfully";
		header('location: seekers.php');
		exit(0);
	}
}

// delete seeker  
function deleteSeeker($seeker_id)
{
	global $conn, $uName, $errors;
	$query = "Select u_name from users where user_id=$seeker_id";
	$res = mysqli_query($conn, $query);
	// $uName = mysqli_fetch_all($res, MYSQLI_ASSOC);
	$uName = getUsername($seeker_id)['u_name'];
array_push($errors, $uName);
	$sql = "DELETE FROM users WHERE user_id=$seeker_id";

	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = $uName . " successfully deleted";
		header("location: seekers.php");
		exit(0);
	} else {
		array_push($errors, "Error:" . $conn->error);
	}
}

function getUsername($id)
{
	global $conn, $errors;
	$sql = "select * from users where user_id =$id limit 1";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
		return $data['u_name'];
	} else {
		array_push($errors, "there was an error fetching username");
	}
}

function searchSeekers($keyword)
{
	global $conn, $errors;
	$sql = "select * from users where U_name or l_name or f_name like '%$keyword%';";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		if ($res->num_rows < 1) {
			array_push($errors, "there are no user with such record");
		}
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
		return $data['u_name'];
	} else {
		array_push($errors, "there was an error fetching username");
	}
}

function getSuspendedUsers()
{
	global $conn, $errors;
	if (in_array($_SESSION['user']['role'], ['admin'])) {
		global $conn, $errors;
		$sql = "select * from users where suspended ='true'";
		if ($result = mysqli_query($conn, $sql)) {
			$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
			return $result;
		} else {
			array_push($errors, "there was an error" . mysqli_error($conn));
		}
	}
}