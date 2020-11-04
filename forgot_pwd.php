<?php
include("config.php");
include(ROOT_PATH . "/includes/utilities.php");
$errors = array();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secAnswer = $email = "";

    switch ($_POST) {
        case empty($_POST["sec_answer"]) && empty($_POST["email"]):
            array_push($errors, "Security Answer & Email field can not be empty ");
            break;


        case empty($_POST["sec_answer"]):
            array_push($errors, "Security answer is required");
            break;

        case empty($_POST["email"]):
            array_push($errors, "Email is required");
            break;
    }
    $secAnswer = esc($_POST["sec_answer"]);
    $email = esc($_POST["email"]);


    // if (empty($_POST["username"]) && empty($_POST["email"])) {
    //     array_push($errors, "Name Email is required");
    // }

    // if (empty($_POST["username"])) {
    //     array_push($errors, "Name is required");
    // } else {
    //     $username = esc($_POST["username"]);
    // }

    // if (empty($_POST["email"])) {
    //     array_push($errors, "Email is required");
    // } else {
    //     $email = esc($_POST["email"]);
    // }

    if (count($errors) == 0) {
        //check if users exists and details correct
        $query1 = "SELECT * from users where  security_answer = '$secAnswer' and email = '$email' limit 1";
        $qr1 = mysqli_query($conn, $query1);
        if (!$qr1) {
            array_push($errors, 'there was an error...please try again');
            exit();
        }
        if ($qr1->num_rows > 0) {

            $gpwd = "seeker" . rand(9999, 99999);
            $pwd = md5($gpwd);

            $query2 = "Update users set pwd='$pwd', forgot_pwd_code = '$gpwd' where email='$email'";
            $qr2 = mysqli_query($conn, $query2);
            if ($conn->affected_rows > 0) {
                array_push($errors, 'pwd changed successfully');



                echo "";
                echo <<<END
                         
                        "Your new Password is "$gpwd"\n 
                            
                            Go back and  <a href='index.php'>login</a>
                            "
                        END;
            }
        } else {
            array_push($errors, "wrong email or answer");
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
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="css/public_styling.css">


    <!-- TODO: style button -->
</head>

<body>
    <div style="width: 40%; margin: 20px auto;">
        <h2>Forgot Password</h2>
        <form id="frm_check" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <?php

            include(ROOT_PATH .  "/includes/errors.php");
//             $body = "Your password to log into <whatever site> has been
// temporarily changed to '$gpwd'. Please log in using that password and
// this email address. Then you may change your password to something
// more familiar.";
//             mail("bashirokala@gmail.com", 'Your temporary password.', $body, 'From:
// admin@example.com');

// $receiver = "receiver email address here";
// $subject = "Email Test via PHP using Localhost";
// $body = "Hi, there...This is a test email send from Localhost.";
// $sender = "From:sender email address here";
// ini_set("SMTP","tls://smtp.gmail.com");
// ini_set("smtp_port","465");
 
// if(mail($receiver, $subject, $body, $sender)){
//     array_push($errors, "Email sent successfully to $receiver");
// }else{
//     array_push($errors,"Sorry, failed while sending mail!");
// }

            ?>
            <input id="sec_answer" type="text" name="sec_answer"
                placeholder="what was the name of your childhood best friend?">

            <input id="email" type="text" name="email" placeholder="email">

            <input id="submit" type="submit" name="submit" value="Generate new password">
        </form>
        <a class="fa fa-lock btn suspend" href="login.php">Back</a>

    </div>


</body>

</html>