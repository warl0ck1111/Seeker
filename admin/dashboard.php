<?php
include('../config.php'); ?>
<?php if (!in_array($_SESSION['user']['role'], ["admin"])) {
	header('location:' . BASE_URL . 'index.php');
} ?>

<?php include(ROOT_PATH . '/admin/includes/seeker_functions.php'); ?>

<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
 
<title>Admin | Dashboard</title>
</head>

<body>

	<div class="header">
		<div class="logo">
			<a href="<?php echo BASE_URL . 'admin/dashboard.php' ?>">
				<h1>Courship Seeker - Admin</h1>
			</a>
		</div>
		<?php if (isset($_SESSION['user'])) : ?>

			<!-- if user is not Admin or Author -->
			<?php if (in_array($_SESSION['user']['role'], ["seeker"])) {
				header('location:' . BASE_URL . 'index.php');
			} ?>

			<div class="user-info">
				<span><?php echo $_SESSION['user']['u_name'] ?></span> &nbsp; &nbsp;
				<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
			</div>
		<?php endif ?>
	</div>
	<div class="container dashboard">
		<h1>Welcome</h1>
		<!-- validation errors for the form -->
		<?php include(ROOT_PATH . '/includes/errors.php') ?>


		<div class="stats" >
			<a href="seekers.php" class="first" style='color:green'>

				<span><?php echo count(getSeekers()) ?></span> <br>
				<span>Registered seekers</span>
			</a>
			<a href="reports.php">
				<span>
					<?php if (getReports() != null) {
						echo count(getReports());
					} else {
						echo "0";
					} ?>
				</span> <br>
				<span>Reported Seekers</span>
			</a>
			<a href="suspended.php" style='color:red'>
				<span> <?php if (getSuspendedUsers() != null) {
							echo count(getSuspendedUsers());
						} else {
							echo "0";
						} ?>
				</span> <br>
				<span>Suspended Seekers</span>


			</a>
		</div>
		<br><br><br>
		<!-- DISABLE LINKS TO ACCESS ADMIN PREVILAGED SECTIONS -->
		<div class="buttons">
			<a href="users.php">Admin Control </a>
			<a href=  "../people.php"  >Go have Fun</a>
		</div>
	</div>
</body>

</html>