<?php
session_start();

$dbhost  = 'localhost';    // Unlikely to require changing
$dbname  = 'seekerdb';   // Modify these...
$dbuser  = 'root';   // ...variables according
$dbpass  = '';   // ...to your installation
$appname = "Seeker DB"; // ...and preference

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) die($connection->connect_error);

function createTable($name, $query)
{
  queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
  echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query)
{
  global $connection;
  $result = $connection->query($query);
  if (!$result) die($connection->error);
  return $result;
}
  //require_once 'functions.php';

  $userstr = ' (Guest)';

  if (isset($_SESSION['details']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;
 
//require_once 'header.php';



echo <<<_END

 <!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/peoplestyle.css" />
		<link
			href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,500&display=swap"
			rel="stylesheet"
		/>
		<link
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
		/>
		<title>Document</title>
	</head>
	<body>
		<div class="container">
			<div class="side">
			   
				<a href="settings.php">
					<div class="header">
						<div class="avatar">
							<img src="https://randomuser.me/api/portraits/women/64.jpg" alt="" />
						</div>
						<div class="title">$user</div>
					</div>
				</a>
	
				<div class="menu">
					<ul>
						<li class="active"><a href="people.php">People</a></li>
						<li ><a href="messages.php">Messages</a></li>
					</ul>
				</div>

				<div class="messages">
					<div class="avatar">
						<img src="https://randomuser.me/api/portraits/women/38.jpg" alt="" />
					</div>
					<div class="message">
						<div class="user">Caroline</div>
						<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
					</div>
				</div>
				<div class="messages">
					<div class="avatar">
						<img src="https://randomuser.me/api/portraits/women/39.jpg" alt="" />
					</div>
					<div class="message">
						<div class="user">Caroline</div>
						<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
					</div>
				</div>
				
				
				<div class="messages">
					<div class="avatar">
						<img src="https://randomuser.me/api/portraits/women/39.jpg" alt="" />
					</div>
					<div class="message">
						<div class="user">Caroline</div>
						<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
					</div>
				</div><div class="messages">
					<div class="avatar">
						<img src="https://randomuser.me/api/portraits/women/39.jpg" alt="" />
					</div>
					<div class="message">
						<div class="user">Caroline</div>
						<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
					</div>
				</div>
				
				
				<div class="messages">
					<div class="avatar">
						<img src="https://randomuser.me/api/portraits/women/39.jpg" alt="" />
					</div>
					<div class="message">
						<div class="user">Caroline</div>
						<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
					</div>
				</div>
				<div class="messages">
					<div class="avatar">
						<img src="https://randomuser.me/api/portraits/women/40.jpg" alt="" />
					</div>
					<div class="message">
						<div class="user">Caroline</div>
						<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
					</div>
				</div>
				<div class="messages">
					<div class="avatar">
						<img src="https://randomuser.me/api/portraits/women/41.jpg" alt="" />
					</div>
					<div class="message">
						<div class="user">Caroline</div>
						<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
					</div>
				</div>
				<div class="messages">
					<div class="avatar">
						<img src="https://randomuser.me/api/portraits/women/42.jpg" alt="" />
					</div>
					<div class="message">
						<div class="user">Caroline</div>
						<div class="text">Lorem ipsum dolor sit amet consectetur adipisicing</div>
					</div>
				</div>
			</div>
			
			<div class="content">
				<div class="card">
					<div class="user">
						<img
							class="user"
							src="https://images.unsplash.com/photo-1532910404247-7ee9488d7292?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=375&q=80"
							alt="image here"
						/>
						<div class="profile">
							<div class="name">$user<span>$age</span></div>
							<div class="local">
								<i class="fas fa-map-marker-alt"></i>
								<span>a$location</span>
							</div>
						</div>
					</div>
				</div>
				<div class="buttons">
					<div class="no">
						<i class="fas fa-times"></i>
					</div>
					<div class="star">
						<i class="fas fa-info fa"></i>
					</div>
					<div class="heart">
						<i class="fas fa-heart"></i>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

_END;

