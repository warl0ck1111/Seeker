<?php 
session_start();
// connect to database
$conn = mysqli_connect("localhost", "root", "", "seekerdb");

if (!$conn) {
    die("Error connecting to database: " . mysqli_connect_error());
}
$email= $phone= $location= $Gender= $username=
$age=$bio ;
$query = "select * from users where user_id='52'";
$result = mysqli_query($conn, $query);
	$user = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>settings</title>

    <link rel="stylesheet" href="css/settingsstyle.css">
    <style>
        .cont span {
            padding-right: 30px;
        }


        .cont .delete {
            color: orangered;
            text-align: center;

        }

        div .menu a{
            text-decoration: none;
            color: black;
        }
        .side a{
            text-decoration: none;
             
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="side">
           
            <a href="settings.php">
                <div class="header">
                    <div class="avatar">
                        <img src="https://randomuser.me/api/portraits/women/64.jpg" alt="" />
                    </div>
                    <div class="title">My Profile</div>
                </div>
            </a>

            <div class="menu">
                <ul>
                    <li><a href="people.php">People</a></li>
                    <li class="active"><a href="settings.php">Settings</a></li>
                </ul>
            </div>


            <div class="contT"><strong>Account Setings</strong></div>
            <div class="cont"><span>Email</span> <span class="conti" id="email"><?php $user['email'] ?></span></div>
            <div class="cont"><span>Phone</span> <span id="phone"> <?php $user['phone'] ?></span></div>
            <div class="cont"><span>Location</span> <span id="location"></span></div>
            <div class="cont"><span>Gender</span> <span id="gender"></span></div>
            <div class="cont"><span>Looking for</span> <span id="preferance"></span></div>
            <div class="cont"> <span>Username</span> <span id="username"></span></div>
            <div class="cont"><span>Age</span> <span id="age"></span></div>
            <div class="cont"><span>Bio</span> <textarea name="bio" id="bio" cols="30" rows="2"></textarea></div>
            <div class="contT"><span><strong>Contact</strong></span></span></div>
            <div class="cont"><span>Help & Support</span></div>
            <div class="contT"><span><strong>Legal</strong></span></div>
            <div class="cont"><span><a href="privacypolicy.html">Privacy Policy</a></span></div>
            <div class="cont"><span><a href="t&c.html">Terms & Condition</a></span></div>
            <div class="cont"><span><a href="licence.html">License</a></span></div>
            <div class="cont"></div>
            <div class="cont"><a href="deleteAcc.php">
                    <div class=".delete"><span></span>Delete Account</span></div>
                </a></div>

        </div>

   

    <div class="content">
        <div class="card">
            <div class="user">
                <img class="user"
                    src="https://images.unsplash.com/photo-1532910404247-7ee9488d7292?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=375&q=80"
                    alt="image here" />
                <div class="profile">
                    <div class="name">Rafaela <span>20</span></div>
                    <div class="local">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>a 20 quilômetros daqui</span>
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