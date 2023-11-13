<?php
session_start(); 
require_once '../src/functions.php' ?>
<?php view('home/header',[
	'title' => "Create Account - Student",
	'links' => ['header','footer', 'login']
]); ?>
	<section class="form-section">
		<form method="POST" action="../auth/register.php">
			<div class="form-group">
				<label>First Name</label>
				<input type="text" name="first_name">
			</div>
			<div class="form-group">
				<label>Last Name</label>
					<input type="text" name="last_name">
			</div>
			<div class="form-group">
				<label>Email</label>
					<input type="email" name="email">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password">
				<?php if(isset($_SESSION['error']['register']) && gettype($_SESSION['error']['register']) === 'array') {
					foreach ($_SESSION['error']['register'] as $value) { ?>
						<p> <?php echo "$value" ?> </p>
				<?php } } else { ?>
					<p> <?php echo $_SESSION['error']['register'] ?? "" ?> </p>
				<?php } ?>
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" name="confirm_password">
			</div>
			<div class="form-submit">
				<button>Create</button>
			</div>
		</form>
		<div class="register">
			<h2 class="register-h2">Already have an account?</h2>
			<a href="./login.php">Sign In</a>
		</div>
	</section>
<?php view('home/footer'); ?>