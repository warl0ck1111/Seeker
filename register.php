<?php  include('config.php'); ?>
<!-- Source code for handling registration and login -->
<?php  include('includes/registration_login.php'); ?>

<!-- <?php include('includes/head_section.php'); ?> -->

<title>Courtship Seeker | Sign up </title>
</head>
<body>
<body>
<div class="container">
	<!-- Navbar -->
		<!-- <?php include( ROOT_PATH . '/includes/navbar.php'); ?> -->
	<!-- // Navbar -->

	<div style="width: 40%; margin: 20px auto;">
		<form method="post" action="register.php" enctype="multipart/form-data" >
			<h2>Register on Courtship Seeker</h2>
			<?php include(ROOT_PATH . '/includes/errors.php')  ?>
			<input  type="text" name="username" value="<?php echo $username; ?>"  placeholder="Username">
			<input  type="text" name="fname"    placeholder="First name">
			<input  type="text" name="lname"    placeholder="Last name">
			<input  type="number" name="phone"    placeholder="Phone">
			
			<select name="state">
			<option  selected="selected" value="0">Select State...</option>
				<option value="Abia">Abia</option>
				<option value="Adamawa">Adamawa</option>
				<option value="Akwa-Ibom">Akwa-Ibom</option>
				<option value="Anambra">Anambra</option>
				<option value="Bauchi">Bauchi</option>
				<option value="Bayelsa">Bayelsa</option>
				<option value="Benue">Benue</option>
				<option value="Borno">Borno</option>
				<option value="Cross-River">Cross-River</option>
				<option value="Delta">Delta</option>
				<option value="Ebonyi">Ebonyi</option>
				<option value="Edo">Edo</option>
				<option value="Ekiti">Ekiti</option>
				<option value="Enugu">Enugu</option>
				<option value="FCT-Abuja">FCT-Abuja</option>
				<option value="Gombe">Gombe</option>
				<option value="Imo">Imo</option>
				<option value="Jigawa">Jigawa</option>
				<option value="Kaduna">Kaduna</option>
				<option value="Kano">Kano</option>
				<option value="Katsina">Katsina</option>
				<option value="Kebbi">Kebbi</option>
				<option value="Kogi">Kogi</option>
				<option value="Kwara">Kwara</option>
				<option value="Lagos">Lagos</option>
				<option  value="Nasarawa">Nasarawa</option>
				<option value="Niger">Niger</option>
				<option value="Ogun">Ogun</option>
				<option value="Ondo">Ondo</option>
				<option value="Osun">Osun</option>
				<option value="Oyo">Oyo</option>
				<option value="Plateau">Plateau</option>
				<option value="Rivers">Rivers</option>
				<option value="Sokoto">Sokoto</option>
				<option value="Taraba">Taraba</option>
				<option value="Yobe">Yobe</option>
				<option value="Zamfara">Zamfara</option>
			</select>
			
			<input type="email" name="email"  placeholder="Email">
			<input type="password" name="password_1" placeholder="Password">
			<input type="password" name="password_2" placeholder="Password confirmation">
			<input type="file" name="profile_image" >

			<button type="submit" class="btn" name="reg_user">Register</button>
			<p>
				Already a member? <a href="login.php">Sign in</a>
			</p><p>
				 <a href="forgot_pwd.php">Forgot Password?</a>
			</p>
		</form>
	</div>
</div>
</body>
</html>

