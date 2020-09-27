<?php 
session_start();
// connect to database
$conn = mysqli_connect("localhost", "root", "", "seekerdb");

if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error());
}

define ('ROOT_PATH', realpath(dirname(__FILE__))); //this defines the root path as the current directory folder of the running script
define('BASE_URL', 'http://localhost/seektest/');


function createTable($name, $query)
{
  queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
  echo "Table '$name' created or already exists.<br>";
}


?>