<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free Online Test Assessment Website">
	<meta name="keywords" content="CBT, Test, Online Exam">
	<title><?= $title ?? "Home"?></title>
	<?php if(isset($links)) { foreach ($links as $file) { ?>
		<link rel="stylesheet" type="text/css" href="..\public\css\<?= $file ?>.css">
	<?php } } ?>
</head>
<body>
<header class="header">
		<div class="logo">
			<a href="index.php">
				TestKing
			</a>
		</div>
		<div><a class="header-links" href="">Aptitude Test</a></div>
		<div><a class="header-links" href="">School Exams</a></div>
		<div><a class="header-links" href="">Advance Level Exams</a></div>
		<div><a class="header-links" href="">More Resources</a></div>
		<div>
			<form id="search">
				<input type="" name="search" placeholder="Search">
			</form>
		</div>
		<div class="account">
			<a href="./dashboard.php">Account</a>
		</div>
	</header>