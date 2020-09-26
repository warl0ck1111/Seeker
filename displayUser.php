<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="css/settingsstyle.css">
    <style>
        .cont span {
            padding-right: 30px;
        }


        .cont .delete {
            color: orangered;
            text-align: center;

        }

        div .menu a {
            text-decoration: none;
            color: black;
        }

        .side a {
            text-decoration: none;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="side">
            <?php

            include('config.php');
            include_once("includes/registration_login.php");
            
            if (empty($_SESSION['user'])) die("<h3>Sorry, You must Be <a href=login.php>Logged in </a>First</h2></div></body></html>");
            $details = $_SESSION['user'];
            $username = $details['u_name'];
            
            ?>
            <a href="myProfile.php">
                <div class="header">
                    <div class="avatar">
                        <img src=<?php echo "static/images/" . $details['profile_image'] ?> alt="<?php echo $username ?>" />
                    </div>
                    <div class="title"><?php echo $details['u_name'] ?></span> &nbsp; &nbsp; <a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a></div>


            </a>
            <!-- <span><?php echo $_SESSION['user']['u_name'] ?> -->
        </div>

        <div class="menu">
            <ul>
                <li><a href="people.php">People</a></li>
                <li class="active"><a href="settings.php">Settings</a></li>
            </ul>
        </div>


        <div class="contT"><strong>User Details</strong></div>
        <div class="cont"><span>Email</span> <span class="conti" id="email"><?php echo $details['email'] ?></span></div>
        <div class="cont"><span>Phone</span> <span id="phone"> <?php echo $details['phone'] ?></span></div>
        <div class="cont"><span>Location</span> <span id="location"> <?php echo $details['state'] ?></span></div>
        <div class="cont"><span>Gender</span> <span id="gender"><?php echo $details['gender'] ?></span></div>
        <div class="cont"><span>Preference</span> <span id="preferance"><?php echo $details['preference'] ?></span></div>
        <div class="cont"> <span>Username</span> <span id="username"><?php echo $details['u_name'] ?></span></div>
        <div class="cont"><span>Age</span> <span id="age"><?php echo $details['age'] ?></span></div>
        <div class="cont"><span>Bio</span> <textarea name="bio" id="bio" cols="30" rows="2"> <?php echo $details['bio'] ?></textarea></div>
        <div class="contT"><span><strong>Contact</strong></span></span></div>
        <div class="cont"><span>Help & Support</span></div>
        <div class="contT"><span><strong>Legal</strong></span></div>
        <div class="cont"><span><a href="privacypolicy.html">Privacy Policy</a></span></div>
        <div class="cont"><span><a href="t&c.html">Terms & Condition</a></span></div>
        <div class="cont"><span><a href="licence.html">License</a></span></div>
         

    </div>



    <div class="content">
        <div class="card">
            <div class="user">
                <img class="user" src=<?php echo "static/images/" . $details['profile_image'] ?> alt="<?php echo $details['profile_image'] ?>" />

                <div class="profile">
                    <div class="name"><?php echo $details['f_name'] . " " . $details['l_name'] ?> <span><?php echo $details['age'] ?></span></div>
                    <div class="local">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo $details['state'] ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="buttons">
        <a href="editprofile.php" style="text-decoration:none">
            
                <div class="star">
                    <i class="fas fa-edit fa"></i>
    </a>
            
        </div>
    </div>

    </div>

</body>

</html>