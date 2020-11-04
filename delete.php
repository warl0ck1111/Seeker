<?php 

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $user_id = $_GET['id'];
    deleteUser($user_id);
}
// delete   user 
function deleteUser($user_id)
{
	global $conn, $errors;
	$query = "Select * from users where user_id=$user_id limit 1";
	if ($res = mysqli_query($conn, $query)) {
		$uname = mysqli_fetch_all($res, MYSQLI_ASSOC);
	} else {
		echo ( "No user with such details details");
	}

	$sql = "DELETE FROM users WHERE user_id=$user_id";

	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = $uname['u_name'] . " successfully deleted";
		header("location: index.php");
		exit(0);
	} else {
		echo ("Error:" . $conn->error);
	}
}
?>