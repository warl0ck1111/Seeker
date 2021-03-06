<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="css/settingsstyle.css">
    <script src="jquery.js"></script>

    <style>
        .cont span {
            padding-right: 30px;
        }


        .cont .delete {
            color: orangered;
            text-align: center;

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

            if (empty($_SESSION['user'])) die("<br> <br> <br> <h3 style='color:  red' > Your account has been suspended!! <br> <br> <br>  </h2></div></body></html>");
            // if (empty($_SESSION['user'])) die("<h3 >Sorry, Your account has been suspended <br> <br> <br> <a style='color:  red';text-decoration: underline; href=contact.php>Contact Admin </a></h2></div></body></html>");
            $person = array();
            $username = $_SESSION['user']['u_name'];
            $details = $_SESSION['user'];
            $pref = '';

            if (isset($_GET['uid'])) {
                $uid = $_GET['uid'];
                $person = getUserById($uid);
            }
            switch ($person['preference'] || $person['gender']) {
                case 'm':
                    $pref = "Male";
                    $gender = "Male";
                    break;
                case 'f':
                    $pref = "Female";
                    $gender = "Female";
                    break;
                case 'mf':
                    $pref = "Male & Female";
                    $gender = "Male & Female";
                    break;
            }
            ?>
            <a href="settings.php">
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
        <div class="cont"><span>Email</span> <span class="conti" id="email"><?php echo $person['email'] ?></span></div>
        <div class="cont"><span>Phone</span> <span id="phone"> <?php echo $person['phone'] ?></span></div>
        <div class="cont"><span>Location</span> <span id="location"> <?php echo $person['state'] ?></span></div>
        <div class="cont"><span>Gender</span> <span id="gender"><?php echo $gender ?></span></div>
        <div class="cont"><span>Preference</span> <span id="preferance"><?php echo $pref ?></span></div>
        <div class="cont"> <span>Username</span> <span id="username"><?php echo $person['u_name'] ?></span></div>
        <div class="cont"><span>Age</span> <span id="age"><?php echo $person['age'] ?></span></div>
        <div class="cont"><span>Bio</span> <label name="bio" id="bio" cols="30" rows="2"> <?php echo $person['bio'] ?></label></div>
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
                <img class="user" src=<?php echo "static/images/" . $person['profile_image'] ?> alt="<?php echo $person['profile_image'] ?>" />

                <div class="profile">
                    <div class="name"><?php echo $person['f_name'] . " " . $person['l_name'] ?> <span><?php echo $person['age'] ?></span></div>
                    <div class="local">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo $person['state'] ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php include("includes/errors.php") ?>
        <span id="ulmsg"></span>
        <div class="buttons">
            <div id="unlike" class="no">
                <i class="fas fa-times"></i>
            </div>
            <div class="star" id="info">
                <i class="fas fa-info fa"></i>
            </div>
            <div id="like" class="heart">
                <i class="fas fa-heart"></i>
            </div>
        </div>
    </div>

    <script>
        //CURRENT_ARR_POS = parseInt( )



        $('#info').click(function() {
            $('#userProfileImg').toggle('slow', 'linear')


        })


        $('#unlike').click(function() {
            $.post('unlike.php', {
                uid: <?php echo $details['user_id'] ?>,
                unliked_uid: <?php echo $person['user_id'] ?>
            }, function(data) {

                console.log("data  : " + data)

                $('#ulmsg').html(data)
            })

            $('#userInfoView').hide('slow', 'linear')
            clickCount = (parseInt(clkCount.v) - 1)
            clkCount.v = clickCount

            console.log("after minusing: " + clickCount)
            $('#userProfileName').html(name).fadeIn('fast')

            $('#UserProfileAge').html(age)
            $('#UserProfileState').html(loc)
            $("#userProfileImg").hide().attr("src", "static/images/" + img).fadeIn('fast').css("z-index", "-1");


        })

        $('#like').click(function() {
            uid = parseInt(<?php echo $details['user_id'] ?>)
            liked_uid = parseInt(<?php echo $person['user_id'] ?>)

            $.post('like.php', {
                uid: <?php echo $details['user_id'] ?>,
                liked_uid: <?php echo $person['user_id'] ?>
            }, function(data) {

                console.log("data  : " + data)

                $('#ulmsg').html(data)
            })

            $('#userInfoView').hide('slow', 'linear')
            clickCount = (parseInt(clkCount.v) + 1)
            clkCount.v = clickCount

            console.log("after adding: " + clickCount)
            console.log("CURRENT_ARR_POS  : ")
        })

        $('#idddnfo').click(function() {
            location.href = "";
            var url = "http://userinfo.php";
            window.location(url);
        })
    </script>


    </div>

</body>

</html>