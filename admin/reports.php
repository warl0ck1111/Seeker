<?php include('../config.php'); ?>
 <?php include(ROOT_PATH . '/admin/includes/reports_functions.php'); ?>
 <?php
	// Get all seeker users from DB
	$seekers = getAllReports();
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
				header('location:' . ROOT_PATH . 'index.php');
			} ?>

 		<!-- if usere is not an admin -->
 		<?php if (!in_array($_SESSION['user']['role'], ['admin', 'admin'])) {
				header('location:' . ROOT_PATH . '/admin/dashboard.php');
				array_push($errors, "you dont have that previllage");
			} ?>


 		<!-- Middle form - to create and edit  -->
 		<div class="action">
 			<h1 class="page-title"> </h1>

 
 		</div>
 		<!-- // Middle form - to create and edit -->

 		<!-- Display records from DB-->
 		<div class="table-div">
 			<!-- Display notification message -->
 			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<form method="post" action="<?php echo ROOT_PATH . 'admin/seekers.php'; ?>">
			 <input type="text" name="key" value="<?php echo $keyword; ?>" placeholder="Search Seekers"> <button type="submit" class="btn" name="search">Search</button>
			 </form> 
 			<?php if (empty($seekers)) : ?>
 				<h1>No Reported Seekers at the Moment.</h1>
 			<?php else : ?>
 				<table class="table">
 					<thead>
 						<th>N</th>
 						<th>Username</th>
 						<th>Repoter</th>
 						<th>Reason</th>
 						<th> Date Reported</th>
 						<!-- <th>Email</th> -->
 						<!-- <th>Role</th> -->
 						<th colspan="4">Action</th>
 					</thead>
 					<tbody>
						 <?php foreach ($seekers as $key => $seeker) : ?>
							<?php  ?>
 							<tr id="tr">
 								<td><?php echo $key + 1; ?></td>
 								<td >
 									<?php echo $seeker['u_name']; ?> &nbsp;</td>
 								<td ><?php echo $seeker['rptr_u_name']; ?> &nbsp;</td>
 								<td ><?php echo $seeker['reason']; ?> &nbsp;</td>
 								<td ><?php  echo $seeker['timestamp']; ?> &nbsp;</td>
 								<!-- <td ><?php echo $seeker['email']; ?> -->
 								</td>
 								<!-- <td><?php echo $seeker['role']; ?></td> -->
 								
								 <td>
 									<a class="fa fa-lock btn suspend" href="reports.php?suspend-seeker=<?php echo $seeker['reported_user_id'] ?>">
 									</a>
								 </td>
								 <td>
 									<a class="fa fa-unlock btn unsuspend" href="reports.php?unsuspend-seeker=<?php echo $seeker['reported_user_id'] ?>">
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