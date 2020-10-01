<?php require_once "config.php" ?>
<?php require_once(ROOT_PATH . '/includes/registration_login.php') ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Courtship Seeker</title>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat|Ubuntu" rel="stylesheet">

	<!-- CSS Stylesheets -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="css/indexStyle.css">

	<!-- Font Awesome -->
	<script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

	<!-- Bootstrap Scripts -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

	<section class="colored-section" id="title">

		<div class="container-fluid">

			<!-- Nav Bar -->

			<nav class="navbar navbar-expand-lg navbar-dark">

				<a class="navbar-brand" href="">Courtship Seeker</a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarTogglerDemo02">



				</div>
			</nav>


			<!-- Title -->

			<div class="row">

				<div class="col-lg-6">
					<h1 class="big-heading">Meet your Life Partner on Seeker</h1>
					<form action="index.php" method="post">
						<h2>Login</h2>
						<?php include(ROOT_PATH . '/includes/errors.php') ?>
						<input type="text" name="username" placeholder="Username">
						<input type="password" name="password" placeholder="Password">

						<div > <button class="btn btn-lg btn-block btn-outline-dark" style="width: 100px; display:block; margin-top:20px" type="submit" name="login_btn">Sign in</button>

							<a style="color: purple; margin-left:20px" href="register.php"><button class="btn btn-lg btn-block btn-outline-dark" style="width: 100px; text-decoration:none" class="btn" type="submit" name="login_btn">Join us</button></a>
						</div>
					</form>
				</div>

				<div class="col-md-3">

				</div>

			</div>

		</div>

	</section>


	<!-- Features -->

	<section class="white-section" id="features">

		<div class="container-fluid">

			<div class="row">
				<div class="feature-box col-lg-4">
					<i class="icon fas fa-check-circle fa-4x"></i>
					<h3 class="feature-title">Trusted</h3>
					<p>So easy to use, Pro Developer got your back</p>
				</div>

				<div class="feature-box col-lg-4">
					<i class="icon fas fa-bullseye fa-4x"></i>
					<h3 class="feature-title">Elite Clientele</h3>
					<p>We have all the profiles, the alumni too.</p>
				</div>

				<div class="feature-box col-lg-4">
					<i class="icon fas fa-heart fa-4x"></i>
					<h3 class="feature-title">Guaranteed to work.</h3>
					<p>Find the love of your life or get bored for four long years</p>
				</div>
			</div>


		</div>
	</section>


	<!-- Testimonials -->

	<section class="colored-section" id="testimonials">

		<div id="testimonial-carousel" class="carousel slide" data-ride="false">
			<div class="carousel-inner">
				<div class="carousel-item active container-fluid">
					<h2 class="testimonial-text">I no longer have to flirt for hours to know about someone's interest.I've found the hottest girl on Courtship Seeker.</h2>
					<!-- <img class="testimonial-image" src="images/jorde.jpg" alt="dog-profile">
					<em>Pebbles, New York</em> -->
				</div>

			</div>

		</div>

	</section>


	<!-- Press -->
	<!-- 
	<section class="colored-section" id="press">
		<img class="press-logo" src="images/techcrunch.png" alt="tc-logo">
		<img class="press-logo" src="images/tnw.png" alt="tnw-logo">
		<img class="press-logo" src="images/bizinsider.png" alt="biz-insider-logo">
		<img class="press-logo" src="images/mashable.png" alt="mashable-logo">

	</section> -->


	<!-- Pricing -->

	<section class="white-section" id="pricing">

		<h2 class="section-heading">A Plan for Everyone's Creepy Needs</h2>
		<p>Simple and affordable price plans for...no wait, It's Absolutly Free!!</p>

		<div class="row">

			<div class="pricing-column col-lg-4 col-md-6">
				<div class="card">
					<div class="card-header">
						<!-- <h3>Normal</h3> -->
					</div>
					<div class="card-body">
						<h2 class="price-text">FREE</h2>

						<p>Unlimited Matches</p>
						<p>Unlimited Messages</p>
						<p>Unlimited App Usage</p>
						<a style="color: purple; margin-left:20px" href="register.php"><button class="btn btn-lg btn-block btn-outline-dark" type="button">Sign Up</button></a>
					</div>
				</div>
			</div>






		</div>

	</section>


	<!-- Call to Action -->

	<section class="colored-section" id="cta">

		<div class="container-fluid">

			<h3 class="big-heading">Find the True Love of Your Life Today.</h3>

		</div>
	</section>


	<!-- Footer -->

	<footer class="white-section" id="footer">
		<div class="container-fluid">
			<i class="social-icon fab fa-facebook-f"></i>
			<i class="social-icon fab fa-twitter"></i>
			<i class="social-icon fab fa-instagram"></i>
			<i class="social-icon fas fa-envelope"></i>
			<p>© Copyright <?php echo date('Y'); ?> Courtship Seeker</p>
		</div>
	</footer>


</body>

</html>