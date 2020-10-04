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
            $_SESSION['message'] = "User unSuspended";

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
* - Returns all Reported seeker  and their corresponding roles
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getAllReports(){
    global $errors;
	if (in_array($_SESSION['user']['role'], ['admin'])) {
		global $conn, $roles, $keyword;
		$sql = "SELECT * FROM reportedusers WHERE U_name like '%$keyword%' or  rptr_u_name like '%$keyword%'  or reason like '%$keyword%' order by timestamp desc "; 
		if($result = mysqli_query($conn, $sql)){
            $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

            return $users;
        }else{
            array_push($errors, "there was a problem fetching Records");
        }

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
	$sql = "select * from users where U_name or rptr_u_name or reason like '%$keyword%';";
	$res = mysqli_query($conn, $sql);
	if ($res) {
		if ($res->num_rows < 1) {
			array_push($errors, "there are no record containing the keyword: '".$keyword."'");
		}
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
		return $data;
	} else {
		array_push($errors, "there was an error fetching data");
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


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Returns all seeker users and their corresponding roles
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getUser($id)
{
	if (in_array($_SESSION['user']['role'], ['admin'])) {
		global $conn, $roles;
		$sql = "SELECT * FROM users WHERE role = 'seeker' and u_name=$id limit 1"; //WHERE role IS NOT NULL
		$result = mysqli_query($conn, $sql);
		$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

		return $users;
	} else {
		return null;
	}
}
