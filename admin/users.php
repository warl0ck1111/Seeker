
<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_function.php'); ?>
<?php 
	// Get all admin users from DB
	$admins = getAdminUsers();
	$roles = ['Admin'];				
?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Manage users</title>
</head>
<body>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>
	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- if user is not Admin or Author -->
		<?php if (!in_array($_SESSION['user']['role'], [ 'admin']) ){header('location:'.BASE_URL .'index.php');} ?>
		
		<!-- if usere is not an admin -->
		<?php if (!in_array($_SESSION['user']['role'], ['admin','admin']) ){
			header('location:'.BASE_URL .'/admin/dashboard.php');
			array_push($errors, "you dont have that previllage");
			 } ?>


		<!-- Middle form - to create and edit  -->
		<div class="action">
			<h1 class="page-title">Create/Edit Admin User</h1>

			<form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>" >

				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				 
				<!-- if editing user, the id is required to identify that user -->
				<?php if ($isEditingUser === true): ?>
					<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="text" name="fname" value="<?php echo $fname; ?>" placeholder="First Name">
				<input type="text" name="lname" value="<?php echo $lname; ?>" placeholder="Last Name">
				<input type="text" name="phone" value="<?php echo $phone; ?>" placeholder="Phone">
				<input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<input type="password" name="passwordConfirmation" placeholder="Password confirmation">
				<select name="role">
					<option value="" >Assign role</option>
					<?php foreach ($roles as $key => $role): ?>
						<option selected value="<?php echo $role; ?>"><?php echo $role; ?></option>
					<?php endforeach ?>
				</select>

				<!-- if editing user, display the update button instead of create button -->
				<?php if ($isEditingUser === true): ?> 
					<button type="submit" class="btn" name="update_admin">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_admin">Save User</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Middle form - to create and edit -->

		<!-- Display records from DB-->
		<div class="table-div">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<!-- <form method="post" action="<?php echo BASE_URL . 'admin/users.php'; ?>">
			 <input type="text" name="key" value="<?php echo $keyword; ?>" placeholder="Search Admin"> <button type="submit" class="btn" name="search">Search</button>
			 </form> -->
			<?php if (empty($admins)): ?>
				<h1>No admins in the database.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th>N</th>
						<th>Admin</th>
						<th>Role</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
					<?php foreach ($admins as $key => $admin): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td>
								<?php echo $admin['u_name']; ?>, &nbsp;
								<!-- <?php echo $admin['f_name']; ?>, &nbsp;
								<?php echo $admin['l_name']; ?>, &nbsp; -->
								<?php echo $admin['phone']; ?>, &nbsp;
								<?php echo $admin['email']; ?>	
							</td>
							<td><?php echo $admin['role']; ?></td>
							<td>
								<a class="fa fa-pencil btn edit"
									href="users.php?edit-admin=<?php echo $admin['user_id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete" 
								    href="users.php?delete-admin=<?php echo $admin['user_id'] ?>">
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