<?php
require_once 'config.php';

$errors = array();
if (isset($_POST['unliked_uid'])) {
  $unliked_id = esc($_POST['unliked_uid']);
  $user_id = esc($_POST['uid']);

  // 
  $sql = "SELECT * from unlikes where user_id = '$user_id' and unliked_uid = '$unliked_id' limit 1 ";

  $run = mysqli_query($conn, $sql,);

  //check if users have already been unliked before
  if (mysqli_num_rows($run) < 1) {
    echo $user_id . "    " . esc($_POST['unliked_uid']);
    $query = "INSERT into unlikes ( user_id, unliked_uid,timestamp) values( '$user_id', '$unliked_id',now())  ";
    $sql2 = "DELETE from likes where user_id = '$user_id' and liked_id = '$unliked_id' "; // OR  user_id = '$unliked_id' and liked-id='$user_id'
    $res = mysqli_query($conn, $query);

    $run2 = mysqli_query($conn, $sql2,);

    if (!$run2) {
      array_push($errors, "there was an error removing user from liked");
    }

    if (!$res) {
      array_push($errors, "There was an error inserting data");
      echo mysqli_error($conn);
      exit();
    } else {

      // echo  '<script>alert("user: $user_id unliked_id")</script>';
    }
  } else {
    echo '<script>alert("user already unliked, ")</script>';
  }
}


function unmatch()
{
  if (isset($_POST['unmatched_id'])) {
    $unmatched_id = esc($_POST['unmatched_id']);
    $user_id = esc($_POST['uid']);

    $query = "drop from matches where user_id = '$user_id' and matched_id = '$unmatched_id' or user_id = '$unmatched_id' and matched_id = '$user_id' ";
    $res = queryMysql($query);
    if (!$res) {
      array_push($errors, "There was an error inserting data");
      echo $res->error_get_last();
      exit();
    } else {
      echo 'success';
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

function queryMysql($query)
{
  global $conn;
  $result = $conn->query($query);
  if (!$result) die("Fatal Error");
  return $result;
}
