<?php

include('config.php');
include_once("includes/registration_login.php");

$errors = array();
$id = "";

//get id from GET header
if (isset($_GET['uid'])) {

    $_SESSION['rpt_id'] = $_GET['uid']; //put id in session since it keeps clearing each time i refresh

}
// if user clicks the Report button
if (isset($_POST['reason'])) {

    $reason = $_POST['reason'];
    $id = $_SESSION['rpt_id'];
    reportUser($id, $reason);
}


function reportUser($id, $reason)
{
    global $conn, $errors;

    if (isset($_SESSION['user'])) {
        $rpt_u_name = getUserById($id)['u_name'];
        $rptr_id = $_SESSION['user']['user_id'];

        $reporter_u_name = $_SESSION['user']['u_name'];
        

        $sql = "select * from reportedusers where reported_user_id = '$id' and reporter_id = '$rptr_id' limit 1 ";
        $run = mysqli_query($conn, $sql,);


        //check if users have already been liked before
        if ($run->num_rows < 1) {
           
            $sql = "Insert into reportedusers (reported_user_id, reporter_id, reason,timestamp,
            u_name, rptr_u_name) value('$id','$rptr_id','$reason', now(),'$rpt_u_name','$reporter_u_name')";
            if ($result = mysqli_query($conn, $sql)) {
                $_SESSION['message'] = "User Reported";
                echo "<script>alert('Thank You, User   has been logged and will be treated accourdingly')</script>";
                header("location: people.php");
            } else {
                array_push($errors, "there was an error reporting");
            }
        } else {
            echo '<script>confirm("You have already Reported This User, Thank You")</script>';
            // header("Location: userinfo.php?uid=$id");

        }
    }
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report user</title>
    <link rel="stylesheet" href="css/public_styling.css">
</head>

<body>
    <?php include(ROOT_PATH . '/includes/messages.php') ?>
    <?php include(ROOT_PATH . '/includes/errors.php') ?>

    <div>
        <form method="post" action="<?php echo BASE_URL . '/reportuser.php'; ?>">
            <input type="text" name="reason" placeholder="Reason"> <button type="submit" class="btn" name="report">Report</button>
        </form>

    </div>

    <script>
        
</script>

</body>

</html>