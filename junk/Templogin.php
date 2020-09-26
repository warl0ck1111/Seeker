<?php 

// Example 26-7: login.php


session_start();

$dbhost  = 'localhost';    // Unlikely to require changing
$dbname  = 'seekerdb';   // Modify these...
$dbuser  = 'root';   // ...variables according
$dbpass  = '';   // ...to your installation
$appname = "Seeker DB"; // ...and preference

$conn = mysqli_connect($dbhost, $dbuser, "", $dbname);

if (!$conn) {
  die("Error connecting to database: " . mysqli_connect_error());
}

// define ('ROOT_PATH', realpath(dirname(__FILE__))); //this defines the root path as the current directory folder of the running script
// define('BASE_URL', 'http://localhost/Courtship Seeker/');

// variable declaration
$username = "";
$email    = "";
$errors = array(); 

	// LOG USER IN
	if (isset($_POST['login_btn'])) {
		$username = esc($_POST['username']);
		$password = esc($_POST['password']);

		if (empty($username)) { array_push($errors, "Username required"); }
		if (empty($password)) { array_push($errors, "Password required"); }
		if (empty($errors)) {
			//$password = md5($password); // encrypt password
			$sql = "SELECT * FROM users WHERE u_name='$username' and pwd='$password' LIMIT 1";

			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) > 0) {
				// get id of created user
				$reg_user_id = mysqli_fetch_assoc($result)['id']; 

				// put logged in user into session array
				$_SESSION['user'] = getUserById($reg_user_id); 

				// if user is admin, redirect to admin area
				if ( in_array($_SESSION['user']['role'], ["Admin", "user"])) {
					$_SESSION['message'] = "You are now logged in";
					// redirect to admin area
					header('location: ' . BASE_URL . '/admin/dashboard.php');
					exit(0);
				} else {
					$_SESSION['message'] = "You are now logged in";
					// redirect to public area
					header('location: people.php');				
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
		global $conn;
		$sql = "SELECT * FROM users WHERE user_id=$id LIMIT 1";

		$result = mysqli_query($conn, $sql);
		$user = mysqli_fetch_assoc($result);

		// returns user in an array format: 
		// ['id'=>1 'username' => 'Awa', 'email'=>'a@a.com', 'password'=> 'mypass']
		return $user; 
	}
?>

<title> Sign in </title>
</head>
<body>
<div class="container">
	<!-- Navbar -->
	<!-- <?php include( ROOT_PATH . '/includes/navbar.php'); ?> -->
	<!-- // Navbar -->

	<div style="width: 40%; margin: 20px auto;">
		<form method="post" action="Templogin.php" >
			<h2>Login</h2>
			<?php include('C:\xampp\htdocs\seekTEst\includes/errors.php') ?>
			<input type="text" name="username" value="<?php echo $username; ?>" value="" placeholder="Username">
			<input type="password" name="password" placeholder="Password">
			<button type="submit" class="btn" name="login_btn">Login</button>
			<p>
				Not yet a member? <a href="register.php">Sign up</a>
			</p>
		</form>
	</div>