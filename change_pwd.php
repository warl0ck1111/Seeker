<?php

include("config.php");
include("includes/utilities.php");

$errors = array();

 $title = "Change password";
 require "includes/head_section.php";
?>


</head>

<body>
    <?php 
    // escape value from form
function escs(String $value)
{
	// bring the global db connect object into function
	global $conn;

	//$val = trim($value); // remove empty space sorrounding string
	$data = stripslashes($value);
	$data = htmlspecialchars($data);
	$val = mysqli_real_escape_string($conn, $value);

	return $data;
}
    
    if(empty( $_SESSION['user']['u_name'])) die("You must Be <a href=login.php>Logged in </a>First</div></body></html>");
    
    $username = $_SESSION['user']['u_name'];
    
    if(isset($_POST['submit'])){
    $oldPwd = escs($_POST['oldpwd']); 
    $newPwd = escs($_POST['newpwd']); 
    $confPwd = escs($_POST['confpwd']); 
    
    if (empty($oldPwd)) {
		array_push($errors, "Old Password field Can't be Empty");
	}
	if (empty($newPwd)) {
		array_push($errors, "entere New Password");
    }
    if (empty($confPwd)) {
		array_push($errors, "please Confirm Your New Password");
    }
    
    if ($newPwd != $confPwd) {
		array_push($errors, "The two passwords do not match");
    }
    if ($newPwd === $oldPwd) {
		array_push($errors, "The two passwords are the same");
    }
    if(count($errors) == 0){
        
        //check if old password is corect
        $chkdpwd = md5($oldPwd);
        $newnewPwd = md5($newPwd);
        $query = "SELECT * from users where u_name='$username' and pwd = '$chkdpwd' limit 1";
        $result = $conn->query($query);
        
        if($conn->affected_rows > 0){
            $query2 = "Update users set pwd='$newnewPwd' where u_name='$username' ";
            $result = mysqli_query($conn,$query2);
           
            if($conn->affected_rows > 0 )
            array_push($errors,"Password changed successfully  <a href='settings.php'>go back</a>");
            
            else{
                error_reporting(E_ALL);
                array_push($errors, "there was an error " );}
        }else{
            array_push($errors, "wrong old password");
        }
    }

    }

    ?>
    
    <div style="width: 40%; margin: 20px auto;">
    <h2>Change password</h2>
    <form action="change_pwd.php" method="POST">
        <?php include( 'includes/errors.php') ?>
    <div class="cont"><span></span> <input required placeholder="enter Old Password" type=password name="oldpwd"></div>
    <div class="cont"><span> </span> <input required placeholder="new password" type=password name="newpwd"></div>
    <div class="cont"><span></span> <input required placeholder="confirm New Password" type=password name="confpwd"></div>
    <button type="submit" class="btn"  name="submit" value="change Password">Change Password</button>
    </form></div>
</body>

</html>