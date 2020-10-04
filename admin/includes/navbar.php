
<div class="header">
	<div class="logo">
		<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
			<h1>Courtship Seeker  - Admin</h1>
		</a>
	</div>
	<div class="user-info">
		<span><?php echo $_SESSION['user']['u_name']?></span> &nbsp; &nbsp; <a href="<?php echo ROOT_PATH . '/logout.php'; ?>" class="logout-btn">logout</a>
	</div>
</div>