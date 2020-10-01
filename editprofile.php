<?php
include('config.php');
include_once("includes/editUserProfile.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;1,500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="css/settingsstyle.css">
<link rel="stylesheet" href="css/public_styling.css">

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

            if (empty($_SESSION['user'])) die("You must Be <a href=login.php>Logged in </a>First</div></body></html>");

            $details = $_SESSION['user'];
            //$username = $details['u_name'];
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
        <label id="used"></label>
        <?php include('includes/errors.php');
        $gender = "";
        if (isset($_GET['gender'])) {
            $gender = $_GET['gender'];
        }if (isset($_GET['state'])) {
            $state = $_GET['state'];
        }if (isset($_GET['pref'])) {
            $pref = $_GET['pref'];
        }
        ?>


        <form action="editprofile.php" method="POST">

            <div class="contT"><strong>Account Setings</strong></div>
            <div class="cont">
                <span>First Name</span>
                <input onBlur='updateUser(this)' type=text class="conti" name="fname" value=<?php echo $details['f_name'] ?> required>
            </div>
            <div class="cont">
                <span>Last Name</span>
                <input type=text class="conti" name="lname" value=<?php echo $details['l_name'] ?> required>
            </div>
            <div class="cont">
                <span>Email</span>
                <input type=email class="conti" name="email" value=<?php echo $details['email'] ?> required>
            </div>
            <div class="cont"><span>Phone</span> <input type=number name="phone" value=<?php echo  $details['phone'] ?> required> </div>
            <div class="cont"><span>Location</span> <input type=text name="location" value=<?php echo $details['state'] ?>>
            </div>

            <div class="cont"><span>Gender</span>
                <select name="gender">
                    <option selected="selected" value="0">Select...</option>

                    <option <?php if (isset($gender) && $gender == "m") echo "selected"; ?> value="m">male</option>
                    <option <?php if (isset($gender) && $gender == "f") echo "selected"; ?> value="f">female</option>
                </select></div>
            <div class="cont"><span>Looking for</span>
                <select name="preferences">
                    <option   value="0">Select...</option>

                    <option <?php if (isset($pref) && $pref == "Male") echo "selected"; ?> value="m">male</option>
                    <option <?php if (isset($pref) && $pref == "Female") echo "selected"; ?> value="f">female</option>
                    <option <?php if (isset($pref) && $pref == "mf") echo "selected"; ?> value="mf">Both</option>
                </select></div>
            <div class="cont"> <span>Username</span> <input type=text name="username" value=<?php echo $details['u_name'] ?> required>
            </div>
            <div class="cont"><span>Age</span> <input onBlur='updateUser(this)' type="number" name="age" value=<?php echo $details['age'] ?>></div>
            <div class="cont"><span>State</span> <select name="state">
                    <option selected="selected" value="0">Select State...</option>
                    <option <?php if (isset($state) && $state == "Abia") echo "selected"; ?> value="Abia">Abia</option>
                    <option <?php if (isset($state) && $state == "Adamawa") echo "selected"; ?> value="Adamawa">Adamawa</option>
                    <option <?php if (isset($state) && $state == "Akwa-Ibom") echo "selected"; ?> value="Akwa-Ibom">Akwa-Ibom</option>
                    <option <?php if (isset($state) && $state == "Anambra") echo "selected"; ?> value="Anambra">Anambra</option>
                    <option <?php if (isset($state) && $state == "Bauchi") echo "selected"; ?> value="Bauchi">Bauchi</option>
                    <option <?php if (isset($state) && $state == "Bayelsa") echo "selected"; ?> value="Bayelsa">Bayelsa</option>
                    <option <?php if (isset($state) && $state == "Benue") echo "selected"; ?> value="Benue">Benue</option>
                    <option <?php if (isset($state) && $state == "Borno") echo "selected"; ?> value="Borno">Borno</option>
                    <option <?php if (isset($state) && $state == "Cross-River") echo "selected"; ?> value="Cross-River">Cross-River</option>
                    <option <?php if (isset($state) && $state == "Delta") echo "selected"; ?> value="Delta">Delta</option>
                    <option <?php if (isset($state) && $state == "Ebonyi") echo "selected"; ?> value="Ebonyi">Ebonyi</option>
                    <option <?php if (isset($state) && $state == "Edo") echo "selected"; ?> value="Edo">Edo</option>
                    <option <?php if (isset($state) && $state == "Ekiti") echo "selected"; ?> value="Ekiti">Ekiti</option>
                    <option <?php if (isset($state) && $state == "Enugu") echo "selected"; ?> value="Enugu">Enugu</option>
                    <option <?php if (isset($state) && $state == "FCT-Abuja") echo "selected"; ?> value="FCT-Abuja">FCT-Abuja</option>
                    <option <?php if (isset($state) && $state == "Gombe") echo "selected"; ?> value="Gombe">Gombe</option>
                    <option <?php if (isset($state) && $state == "Imo") echo "selected"; ?> value="Imo">Imo</option>
                    <option <?php if (isset($state) && $state == "Jigawa") echo "selected"; ?> value="Jigawa">Jigawa</option>
                    <option <?php if (isset($state) && $state == "Kaduna") echo "selected"; ?> value="Kaduna">Kaduna</option>
                    <option <?php if (isset($state) && $state == "Kano") echo "selected"; ?> value="Kano">Kano</option>
                    <option <?php if (isset($state) && $state == "Katsina") echo "selected"; ?> value="Katsina">Katsina</option>
                    <option <?php if (isset($state) && $state == "Kebbi") echo "selected"; ?> value="Kebbi">Kebbi</option>
                    <option <?php if (isset($state) && $state == "Kogi") echo "selected"; ?> value="Kogi">Kogi</option>
                    <option <?php if (isset($state) && $state == "Kwara") echo "selected"; ?> value="Kwara">Kwara</option>
                    <option <?php if (isset($state) && $state == "Lagos") echo "selected"; ?> value="Lagos">Lagos</option>
                    <option <?php if (isset($state) && $state == "Nasarawa") echo "selected"; ?> value="Nasarawa">Nasarawa</option>
                    <option <?php if (isset($state) && $state == "Niger") echo "selected"; ?> value="Niger">Niger</option>
                    <option <?php if (isset($state) && $state == "Ogun") echo "selected"; ?> value="Ogun">Ogun</option>
                    <option <?php if (isset($state) && $state == "Ondo") echo "selected"; ?> value="Ondo">Ondo</option>
                    <option <?php if (isset($state) && $state == "Osun") echo "selected"; ?> value="Osun">Osun</option>
                    <option <?php if (isset($state) && $state == "Oyo") echo "selected"; ?> value="Oyo">Oyo</option>
                    <option <?php if (isset($state) && $state == "Plateau") echo "selected"; ?> value="Plateau">Plateau</option>
                    <option <?php if (isset($state) && $state == "Rivers") echo "selected"; ?> value="Rivers">Rivers</option>
                    <option <?php if (isset($state) && $state == "Sokoto") echo "selected"; ?> value="Sokoto">Sokoto</option>
                    <option <?php if (isset($state) && $state == "Taraba") echo "selected"; ?> value="Taraba">Taraba</option>
                    <option <?php if (isset($state) && $state == "Yobe") echo "selected"; ?> value="Yobe">Yobe</option>
                    <option <?php if (isset($state) && $state == "Zamfara") echo "selected"; ?> value="Zamfara">Zamfara</option>

                </select></div>

            <div class="cont"><span>Bio</span> <textarea name="bio" id="bio" cols="30" rows="2"> <?php echo $details['bio'] ?></textarea></div>


            <div class="cont"> <a href="change_pwd.php"> Change Password</a></div>
            <div class="cont"><a href="deleteAcc.php">
                    <div class=".delete"><input type="submit" name="save_edit" value="Save Edit"></span></div>
                </a></div>
        </form>
        <form id="formUpload" action="editprofile.php" method="POST" enctype="multipart/form-data">
            <div class="cont"><span>Profile Image</span><input type="file" required name="profile_image"></div>
            <input type="submit" name="img_Upload" value="Change Display Image">
        </form>
        <?php include('includes/errors.php') ?>
    </div>


    <div class="content">
        <div class="card">
            <div class="user">
                <img class="user" src=<?php echo "static/images/" . $details['profile_image'] ?> alt="<?php echo $username ?>" />

                <div class="profile">
                    <div class="name"><?php echo $details['f_name'] . " " . $details['l_name'] ?>
                        <span><?php echo $details['age'] ?></span>
                    </div>
                    <div class="local">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo $details['state'] ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="buttons">


            <!-- TOdo <div class="star">
                <i class="fas fa-check fa"></i>
            </div> -->

        </div>
    </div>

    </div>

    <script>
        Fname = $('fname').html();
        Fname = $('fname').blur(updateUser)
        Lname = $('lname').html()
        Age = $('age').html()

        function updateUser(details) {

            $.post(
                'ajaxEdit.php', {
                    Fname: Fname.value,
                    Lname: Fname.value,
                    Age: Fname.value,

                },
                function(data) {
                    $('#used').html(data)
                }
            )


        }
    </script>

</body>

</html>