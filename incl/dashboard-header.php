<?php
	session_start();
	require_once '../src/functions.php'; 

	if(!isset($_SESSION['user'])) {
		header('location: ./login.php');
	}
?>
<?php 
$filePath = basename($_SERVER['PHP_SELF']);
$file = explode('.', $filePath)[0];
view('header',[
	'title' => "TestKing - Home",
	'links' => ['footer','dashboard', $file]
]);

?>
<section class="dashboard">
	<div class="menu">
		<div class="profile">
			<div class="img-div">
				<img src="../public/images/Picture9.png">
				<h5 class="name"><?= $_SESSION['user']['name'] ?></h5>
			</div>
			<div class="">
				<ul class="lists">
					<li class="list-item"><a href="../pages/dashboard.php">Dashboard</a></li>
					<li class="list-item"><a href="../pages/performance.php">Performance Review</a></li>
					<li class="list-item"><a href="../pages/exclusive.php">Exclusive Practise Test</a></li>
					<li class="list-item"><a href="../pages/manage.php">Manage Account</a></li>
				</ul>
			</div>
			<div class="logout">
				<a href="">Log out</a>
			</div>
		</div>
	</div>