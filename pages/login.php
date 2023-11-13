<?php
session_start(); 
require_once '../src/functions.php';
$user = $_SESSION['user'] ?? "";
if($user) {
	header("location: ../pages/index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TestKing - Login</title>
	<link rel="stylesheet" href="../public/css/login.css">
</head>
<body>
	<section class="form-section">
		<h2>TestKing</h2>
		<form method="POST" action="../auth/login.php">
			<div class="form-group">
				<label>Username or Email *</label>
				<input type="email" name="email">
			</div>
			<div class="form-group">
				<label>Password *</label>
				<input type="password" name="password">
				<?php if(isset($_SESSION['error']['login']) && gettype($_SESSION['error']['login']) === 'array') {
			foreach ($_SESSION['error']['login'] as $key => $value) { ?>
				<small class="error"> <?php echo "$value" ?> </small>
		<?php } } else { ?>
			<small class="error"> <?= $_SESSION['error']['login'] ?? ""?> </small>
		<?php } ?>
			</div>
			<div class="forgot-password"><small ><a  href="">Forgot Password?</a></small></div>
			<div class="form-submit">
				<button>Sign in</button>
			</div>
		</form>
		<hr>
		<div class="register">
			<h2>Here for the first time? Click register to get started now</h2>
			<a href="./register.php">Register</a>
		</div>
	</section>
<?php scripts(['login']); ?>
<?php view('footer'); ?>