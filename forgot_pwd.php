<?php
include("config.php");
include(ROOT_PATH . "/includes/utilities.php");
$errors = array();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $email = "";
    if (empty($_POST["username"])) {
        array_push($errors, "Name is required");
    } else {
        $username = esc($_POST["username"]);
    }

    if (empty($_POST["email"])) {
        array_push($errors, "Email is required");
    } else {
        $email = esc($_POST["email"]);
    }

    if (count($errors) == 0) {
        //check if users exists and details correct
        $query1 = "SELECT * from users where u_name = '$username' and email = '$email' limit 1";
        $qr1 = mysqli_query($conn, $query1);
        if(!$qr1){
            array_push($errors, 'there was an error...please try again');
            exit();

        }
        if ($qr1->num_rows > 0) {
            
            $gpwd = $username . rand(9999, 99999);
            $pwd = md5($gpwd);

            $query2 = "Update users set pwd='$pwd', forgot_pwd_code = '$gpwd' where u_name='$username' and email='$email'";
            $qr2 = mysqli_query($conn, $query2);
            if ($conn->affected_rows > 0) {
            array_push($errors, 'pwd changed successfully');
            
            array_push($errors, $pwd);

                echo "";
                echo <<<END
                         
                        "Your new Password is" . $gpwd . "\n 
                            
                            Go back and  <a href='index.php?uname=$username'>login</a>
                            "
                        END;
            }
        } else {
            array_push($errors, "No user with such Credentials ");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="jquery.js"></script>
</head>

<body>
    <form id="frm_check" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <?php

        include(ROOT_PATH .  "/includes/errors.php");
        ?>
        <input id="username" type="text" name="username" placeholder="username">

        <input id="email" type="text" name="email" placeholder="email">

        <input id="submit" type="submit" name="submit" value="check">
    </form>


</body>

</html>