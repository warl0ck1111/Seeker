<?php
require_once 'config.php';

$errors = array();
if (isset($_POST['unliked_uid'])) {
  $unliked_id = escs($_POST['unliked_uid']);
  $user_id = escs($_POST['uid']);
  
  // 
  $sql = "SELECT * from unlikes where user_id = '$user_id' and unliked_uid = '$unliked_id' limit 1 ";
  
  $res = mysqli_query($conn, $sql);
  
  $numrow = mysqli_num_rows($res);
  
  echo "number of rows: $numrow  \n";
  
  //check if users have already been unliked before
  if ($numrow == 0) {
    $sql2 = "DELETE from likes where user_id = '$user_id' and liked_id = '$unliked_id' "; // OR  user_id = '$unliked_id' and liked-id='$user_id'
    $run2 = mysqli_query($conn, $sql2);
    echo $user_id . "    " . $unliked_id . "\n";
    $query = "INSERT into unlikes ( user_id, unliked_uid,timestamp) values( '$user_id', '$unliked_id',now())  ";
   
    
    $res = mysqli_query($conn, $query);


    if (!$run2) {
      echo "there was an error removing user from liked";
    }

    if (!$res) {
      echo "There was an error inserting data";
      echo mysqli_error($conn);
      exit();
    } else {

      // echo  '<script>alert("user: $user_id unliked_id")</script>';
    }
  } else {
    echo "$user_id";
    echo '  <script> alert("user already unliked")  </script>';
  }
}


function unmatch()
{
  if (isset($_POST['unmatched_id'])) {
    $unmatched_id = escs($_POST['unmatched_id']);
    $user_id = escs($_POST['uid']);

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
function escs(String $value)
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
