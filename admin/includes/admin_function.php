<?php if (!in_array($_SESSION['user']['role'], ["admin"])) {
	header('location:' . BASE_URL . 'index.php');
} ?>

<?php
// Admin user variables
$admin_id = 0;
$isEditingUser = false;
$username = "";
$fname = "";
$lname = "";
$phone = "";
$role = "";
$email = "";
// general variables
$errors = [];
$isAdmin = false;

/* - - - - - - - - - - 
-  Admin users actions
- - - - - - - - - - -*/
// if user clicks the create admin button
if (isset($_POST['create_admin'])) {
	createAdmin($_POST);
}
// if user clicks the Edit admin button
if (isset($_GET['edit-admin'])) {
	$isEditingUser = true;
	$admin_id = $_GET['edit-admin'];
	editAdmin($admin_id);
}
// if user clicks the update admin button
if (isset($_POST['update_admin'])) {
	updateAdmin($_POST);
}
// if user clicks the Delete admin button
if (isset($_GET['delete-admin'])) {
	$admin_id = $_GET['delete-admin'];
	deleteAdmin($admin_id);
}
// // if user clicks the search seeker button
// if (isset($_POST['search'])) {
// 	global $keyword;
// 	$keyword = esc($_POST['key']);
// }

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Returns all admin users and their corresponding roles
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getAdminUsers()
{
	if (in_array($_SESSION['user']['role'], ['admin'])) {
		global  $keyword, $conn, $roles;
		$sql = "SELECT * FROM users WHERE role = 'admin'"; //   AND U_name or l_name or f_name like '%$keyword%'
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
-  Admin users functions
- - - - - - - - - - - - -*/
/* * * * * * * * * * * * * * * * * * * * * * *
* - Receives new admin data from form
* - Create new admin user
* - Returns all admin users with their roles 
* * * * * * * * * * * * * * * * * * * * * * */
function createAdmin($request_values)
{
	if (in_array($_SESSION['user']['role'], ['admin'])) {
		global $conn, $errors, $role, $username, $fname, $lname, $phone, $email;
		$username = esc($request_values['username']);
		$fname = esc($request_values['fname']);
		$lname = esc($request_values['lname']);
		$phone = esc($request_values['phone']);
		$email = esc($request_values['email']);
		$password = esc($request_values['password']);
		$passwordConfirmation = esc($request_values['passwordConfirmation']);
		if(! is_integer($phone)) array_push($errors, "Invalid Charated entered for phone");

		if (isset($request_values['role'])) {
			$role = esc($request_values['role']);
			$role =  strtolower($role);
		}

		// form validation: ensure that the form is correctly filled

		switch ($request_values) {
			case (empty($username)): {
					array_push($errors, "Uhmm...We gonna need the username");
					break;
				}
			case (empty($fname)): {
					array_push($errors, "Uhmm... you forgot the admin's First name");
					break;
				}
			case (empty($lname)): {
					array_push($errors, "Uhmm...you forgot the admin's Last name");
					break;
				}
			case (empty($phone)): {
					array_push($errors, "Uhmm...you forgot the admin's Phone Number");
					break;
				}
			case (empty($email)): {
					array_push($errors, "Oops.. Email is missing");
					break;
				}
			case (empty($role)): {
					array_push($errors, "Role is required for admin users");
					break;
				}
			case (empty($password)): {
					array_push($errors, "uh-oh you forgot the password");
					break;
				}
		}


		// if (empty($username)) { array_push($errors, "Uhmm...We gonna need the username"); break; }
		// if (empty($fname)) { array_push($errors, "Uhmm... you forgot the admin's First name"); break;  }
		// if (empty($lname)) { array_push($errors, "Uhmm...you forgot the admin's Last name"); break;  }
		// if (empty($phone)) { array_push($errors, "Uhmm...you forgot the admin's Phone Number"); break;  }
		// if (empty($email)) { array_push($errors, "Oops.. Email is missing");  break; }
		// if (empty($role)) { array_push($errors, "Role is required for admin users"); break; }
		// if (empty($password)) { array_push($errors, "uh-oh you forgot the password");  break; }
		if ($password != $passwordConfirmation) {
			array_push($errors, "The two passwords do not match");
		}
		// Ensure that no user is registered twice. 
		// the email and usernames should be unique
		$user_check_query = "SELECT * FROM users WHERE u_name='$username' 
							OR email='$email' OR phone='$phone' LIMIT 1";
		$result = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($result);
		if ($user > 0) {

			switch ($user) { // if user exists

				case ($user['u_name'] == $username): {
						array_push($errors, "Username already exists");
						break;
					}

				case ($user['email'] == $email): {
						array_push($errors, "Email already exists");
						break;
					}
				case ($user['phone'] == $phone): {
						array_push($errors, "Phone already exists");
						break;
					}
			}
		}
		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$fgt_pwd = $password;
			$password = md5($password); //encrypt the password before saving in the database
			$query = "INSERT INTO users (u_name, f_name, l_name, phone, email, role, pwd, forgot_pwd_code created_at) 
				  VALUES('$username','$fname','$lname','$phone', '$email', '$role', '$password', '$fgt_pwd', now())";
			$result = mysqli_query($conn, $query);

			if ($result) {
				$_SESSION['message'] = "Admin user created successfully";
				header('location: users.php');
				exit(0);
			} else {
				array_push($errors, 'There was a problem creating New Admin User' . mysqli_error($conn));
			}
		}
	} else {
		header("location:" . BASE_URL . "/admin/dashboard.php");
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Takes admin id as parameter
* - Fetches the admin from database
* - sets admin fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editAdmin($admin_id)
{
	global $conn, $username, $role, $isEditingUser, $admin_id, $email, $fname, $lname, $phone;

	$sql = "SELECT * FROM users WHERE user_id=$admin_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$admin = mysqli_fetch_assoc($result);

	// set form values ($username and $email) on the form to be updated
	$username = $admin['u_name'];
	$email = $admin['email'];
	$phone = $admin['phone'];
	$fname = $admin['f_name'];
	$lname = $admin['l_name'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Receives admin request from form and updates in database
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateAdmin($request_values)
{
	global $conn, $errors, $role, $username, $phone, $lname, $fname, $isEditingUser, $admin_id, $email;
	// get id of the admin to be updated
	$admin_id = $request_values['admin_id'];
	// set edit state to false
	$isEditingUser = false;


	$username = esc($request_values['username']);
	$phone = esc($request_values['phone']);
	$fname = esc($request_values['fname']);
	$lname = esc($request_values['lname']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if (isset($request_values['role'])) {
		$role = $request_values['role'];
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		//encrypt the password (security purposes)
		$password = md5($password);

		$query = "UPDATE users SET u_name='$username', f_name='$fname', l_name='$lname', phone='$phone', email='$email', role='$role', pwd='$password' WHERE user_id=$admin_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Admin user updated successfully";
		header('location: users.php');
		exit(0);
	}
}

// delete admin user 
function deleteAdmin($admin_id)
{
	global $conn, $uName, $errors;
	$query = "Select * from users where user_id=$admin_id";
	if ($res = mysqli_query($conn, $query)) {
		$uname = mysqli_fetch_all($res, MYSQLI_ASSOC);
	} else {
		array_push($errors, "Error fetching user details");
	}

	$sql = "DELETE FROM users WHERE user_id=$admin_id";

	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = $uname['u_name'] . " successfully deleted";
		header("location: users.php");
		exit(0);
	} else {
		array_push($errors, "Error:" . $conn->error);
	}
}

/**gets username of a particular record by ID */
function getUsername($id)
{
	global $conn, $errors;
	$sql = "select * from users where user_id =$id limit 1";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
		return $data['u_name'];
	}
}


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - GEt all suspended seekers
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
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