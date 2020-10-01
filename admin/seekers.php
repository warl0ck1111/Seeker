 <?php include('../config.php'); ?>   	
 <?php include(ROOT_PATH . '/admin/includes/seeker_functions.php'); ?>
 <?php
	// Get all seeker users from DB
	$seekers = getSeekers();
	$roles = ['Seeker'];
	?>
 <?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
 <title>Seeker | Manage Seekers</title>
 </head>

 <body>
 	<!-- seeker navbar -->
 	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
 	<div class="container content">
 		<!-- Left side menu -->
 		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

 		<!-- if user is not admin or Author -->
 		<?php if (!in_array($_SESSION['user']['role'], ['admin'])) {
				header('location:' . BASE_URL . 'index.php');
			} ?>

 		<!-- if usere is not an admin -->
 		<?php if (!in_array($_SESSION['user']['role'], ['admin', 'admin'])) {
				header('location:' . BASE_URL . '/admin/dashboard.php');
				array_push($errors, "you dont have that previllage");
			} ?>


 		<!-- Middle form - to create and edit  -->
 		<div class="action">
 			<h1 class="page-title">Create/Edit Seeker</h1>

 			<form method="post" action="<?php echo BASE_URL . 'admin/seekers.php'; ?>">

 				<!-- validation errors for the form -->
 				<?php include(ROOT_PATH . '/includes/errors.php') ?>

 				<!-- if editing user, the id is required to identify that user -->
 				<?php if ($isEditingUser === true) : ?>
 					<input type="hidden" name="seeker_id" value="<?php echo $seeker_id; ?>">
 				<?php endif ?>
 				<!-- TODO: ADD age gender preference feilds-->
 				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
 				<input type="text" name="fname" value="<?php echo $fname; ?>" placeholder="First Name">
 				<input type="text" name="lname" value="<?php echo $lname; ?>" placeholder="Last Name">
 				<input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="Phone">
 				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
 				<input type="text" name="age" value="<?php echo $age; ?>" placeholder="age">
 				<!-- <input type="text" name="gender" value="<?php echo $gender; ?>" placeholder="gender"> -->
 				<select name="gender">
 					<option value="" selected disabled>Select Gender</option>
 					<option <?php if ($gender == "m") echo "selected"; ?> value="Male">Male</option>
 					<option <?php if ($gender == "f") echo "selected"; ?> value="Female">Female</option>

 				</select>
 				<select name="preference">
 					<option value="" selected disabled>Select preference</option>
 					<option <?php if ($preference == "m") echo "selected"; ?> value="Male">Male</option>
 					<option <?php if ($preference == "f") echo "selected"; ?> value="Female">Female</option>
 					<option <?php if ($preference == "mf") echo "selected"; ?> value="Male & Female">Male & Female</option>
 				</select>
 				<!-- <input type="text" name="preference" value="<?php echo $preference; ?>" placeholder="preference"> -->
 				<select name="state">
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

 				</select>
 				<input required type="password" value="<?php echo $fgt_pwd; ?>" name="password" placeholder="Password">
 				<input required type="password" value="<?php echo $fgt_pwd; ?>"  name="passwordConfirmation" placeholder="Password confirmation">
 				<select name="role">
 					<option value="" >Assign role</option>
 					<?php foreach ($roles as $key => $role) : ?>
 						<option selected value="<?php echo $role; ?>"><?php echo $role; ?></option>
 					<?php endforeach ?>
 				</select>

 				<!-- if editing user, display the update button instead of create button -->
 				<?php if ($isEditingUser === true) : ?>
 					<button type="submit" class="btn" name="update_seeker">UPDATE</button>
 				<?php else : ?>
 					<button type="submit" class="btn" name="create_seeker">Save User</button>
 				<?php endif ?>
 			</form>
 		</div>
 		<!-- // Middle form - to create and edit -->

 		<!-- Display records from DB-->
 		<div class="table-div">
 			<!-- Display notification message -->
 			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<form method="post" action="<?php echo BASE_URL . 'admin/seekers.php'; ?>">
			 <input type="text" name="key" value="<?php echo $keyword; ?>" placeholder="Search Seekers"> <button type="submit" class="btn" name="search">Search</button>
			 </form> 
 			<?php if (empty($seekers)) : ?>
 				<h1>No seekers in the database.</h1>
 			<?php else : ?>
 				<table class="table">
 					<thead>
 						<th>N</th>
 						<th>Username</th>
 						<th>Password</th>
 						<th> Date Registered</th>
 						<th>Phone</th>
 						<!-- <th>Email</th> -->
 						<!-- <th>Role</th> -->
 						<th colspan="4">Action</th>
 					</thead>
 					<tbody>
 						<?php foreach ($seekers as $key => $seeker) : ?>
 							<tr <?php if ($seeker['suspended']==='true') echo "style='background: orangered'"; ?>>
 								<td><?php echo $key + 1; ?></td>
 								<td >
 									<?php echo $seeker['u_name']; ?> &nbsp;</td>
 								<td ><?php echo $seeker['forgot_pwd_code']; ?> &nbsp;</td>
 								<td ><?php  echo $seeker['created_at']; ?> &nbsp;</td>
 								<td ><?php echo $seeker['phone']; ?> &nbsp;</td>
 								<!-- <td ><?php echo $seeker['email']; ?> -->
 								</td>
 								<!-- <td><?php echo $seeker['role']; ?></td> -->
 								<td>
 									<a class="fa fa-pencil btn edit" href="seekers.php?edit-seeker=<?php echo $seeker['user_id'] ?>">
 									</a>
 								</td>
 								<td>
 									<a class="fa fa-trash btn delete" href="seekers.php?delete-seeker=<?php echo $seeker['user_id'] ?>">
 									</a>
								 </td>
								 <td>
 									<a class="fa fa-lock btn delete" href="seekers.php?suspend-seeker=<?php echo $seeker['user_id'] ?>">
 									</a>
								 </td>
								 <td>
 									<a class="fa fa-unlock btn unsuspend" href="seekers.php?unsuspend-seeker=<?php echo $seeker['user_id'] ?>">
 									</a>
 								</td>
 							</tr>
 						<?php endforeach ?>
 					</tbody>
 				</table>
 			<?php endif ?>
 		</div>
 		<!-- // Display records from DB -->
	 </div>
	 

	 
 </body>

 </html>