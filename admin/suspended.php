<?php include('../config.php'); ?>
 <?php include(ROOT_PATH . '/admin/includes/seeker_functions.php'); ?>
 <?php
	// Get all seeker users from DB
	$seekers = getSuspendedSeekers();
	$roles = ['Seeker'];
	?>
 <?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
 <title>Seeker | Manage Seekers</title>
 <style>
	   #tr:hover{
		 color: white;
		 background-color: #b4b4b4;
	 }
 </style>
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
 		<!-- <div class="action">
 			<h1 class="page-title"></h1>

 			
 		</div> -->
 		<!-- // Middle form - to create and edit -->

 		<!-- Display records from DB-->
 		<div class="table-div">
 			<!-- Display notification message -->
 			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			 
 			<?php if (empty($seekers)) : ?>
 				<h1>No seekers in the database.</h1>
 			<?php else : ?>
 				<table class="table">
 					<thead>
 						<th>N</th>
 						<th>Username</th>
 						<th>First Name</th>
 						<th>Last Name</th>
 						<th>Gender</th>
 						<th>Password</th>
 						<th> Date Registered</th>
 						<th>Phone</th>
 						<th>Email</th>
 						<th>Age</th>
 						<!-- <th>Role</th> -->
 						<th colspan="4">Action</th>
 					</thead>
 					<tbody>
 						<?php foreach ($seekers as $key => $seeker) : ?>
 							<tr  id="tr" <?php if ($seeker['suspended']==='true') echo "style='background: orangered'"; ?>>
 								<td><?php echo $key + 1; ?></td>
 								<td >
 									<?php echo $seeker['u_name']; ?> &nbsp;</td>
 									<td ><?php echo $seeker['f_name']; ?> &nbsp;</td>
 									<td ><?php echo $seeker['l_name']; ?> &nbsp;</td>
 									<td ><?php echo $seeker['gender']; ?> &nbsp;</td>
 								<td ><?php echo $seeker['forgot_pwd_code']; ?> &nbsp;</td>
 								<td ><?php  echo $seeker['created_at']; ?> &nbsp;</td>
 								<td ><?php echo $seeker['phone']; ?> &nbsp;</td>
 								<td ><?php echo $seeker['email']; ?> &nbsp;
 								</td>
 								<td><?php echo $seeker['age']; ?>  &nbsp;</td>
 								<td>
 									<a class="fa fa-pencil btn edit" href="seekers.php?edit-seeker=<?php echo $seeker['user_id'] ?>">
 									</a>
 								</td>
 								<td>
 									<a class="fa fa-trash btn delete" href="seekers.php?delete-seeker=<?php echo $seeker['user_id'] ?>">
 									</a>
								 </td>
								 <td>
 									<a class="fa fa-lock btn suspend" href="seekers.php?suspend-seeker=<?php echo $seeker['user_id'] ?>">
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