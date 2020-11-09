<?php
require_once 'config.php';
$errors = array();
if (isset($_POST['liked_uid'])) { // of using isset must be from an ajax call
  $liked_id = escs($_POST['liked_uid']);
  $user_id = escs($_POST['uid']);
  //$uname = escs($_POST['uname']);


  $sql = "select * from likes where user_id = '$user_id' and liked_id = '$liked_id' limit 1 ";
  $run = mysqli_query($conn, $sql,);

  //TODO: check if user is matched using ajax 
  //check if users have already been liked before
  if ($run->num_rows < 1) {
    echo $user_id . "    " . escs($_POST['liked_uid']);
    $query = "INSERT into likes ( user_id, liked_id,timestamp) values( '$user_id', '$liked_id', now()) ";
              //this code needs checking
    // $sql2 = "DELETE from unlikes where user_id = '$user_id' and unliked_uid = '$unliked_id' "; // OR  user_id = '$unliked_id' and liked-id='$user_id'
    // $res1 = mysqli_query($conn, $sql2);
    $res = mysqli_query($conn, $query);
    if (!$res) {
      array_push($errors, "There was an error inserting data");
      echo mysqli_error($conn);
      exit();
    } else {
     // echo  '<script>alert("user: $user_id liked")</script>';
    }
  } else {
    echo '<script>alert("user already liked")</script>';
  }
}

/// escape value from form
function escs(String $value)
{
  // bring the global db connect object into function
  global $conn;

  $val = trim($value); // remove empty space sorrounding string
  $data = stripslashes($val);
  $data = htmlspecialchars($data);
  $val = mysqli_real_escape_string($conn, $value);

  return $data;
}

function queryMysql($query)
{
  global $conn;
  $result = $conn->query($query);
  if (!$result) die("Fatal Error");
  return $result;
}


function showLikes($user_id)
{
  global $conn;
  $likes_arr = array();

   
  //$uname = escs($_POST['uname']);
  $query = "SELECT * from likes where liked_id = '$user_id'";
  $result = mysqli_query($conn, $query);
  //check if query executed succesfulyy
  if ($result) {

    if ($result->num_rows > 0) {

      $likes_arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
  } else {
    array_push($errors, 'there was a problem ');
  }
  return $likes_arr;
}


function showPpleILiked($user_id)
{
  global $conn;
  if (isset($_POST['liked_uid'])) { // if using isset must be from an ajax call
    $liked_id = escs($_POST['liked_uid']);
    $user_id = escs($_POST['uid']);
    //$uname = escs($_POST['uname']);
    $query = "SELECT liked_id from likes where user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {

      $res_arr = mysqli_fetch_all(MYSQLI_ASSOC);
      return $res_arr;
    } else {
      return false;
    }
  }
}


function getMatches($user_id)
{
  global $conn;

  $likes_arr = showLikes($user_id);
  //$user_id = escs($user_id);
  $matches = array();
  $matchFound = 0;

  for ($i = 0; $i < sizeof($likes_arr); $i++) {
    $pos = $likes_arr[$i]["user_id"];
    $query = "SELECT * from likes where user_id = '$user_id' and liked_id = '$pos'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
      array_push($errors, mysqli_error($conn));
      //echo mysqli_error($conn);
      exit();
    }
    if ($result->num_rows > 0) {

      //$res_arr = mysqli_fetch_all(MYSQLI_ASSOC);
       
        array_push($matches, $likes_arr[$i]);
        $matchFound += 1;
        continue;
      
    }
  }
  return $matches;
}


