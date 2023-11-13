<?php 
session_start();
if(!isset($_SESSION['user'])) {
	header("location: ../pages/login.php");
}

$user = $_SESSION['user'] ?? '';

if($user['status'] == 0) {
	header("location: ../pages/index.php");
}

require_once '../src/functions.php' ?>
<?php view('header',[
	'title' => "Result - ". $user['name'],
	'links' => ['result']
]); 
?>
	<div style="border: 10px solid #00aa50;">
	</div>
	<section id="result">
		<div id="result-header">
			<h3>Quiz Result: <?= $_GET['subject'] ?? "" ?> <span id="mode"></span> Mode</h3>
		</div>
		<div id="result-details">
			<div class="details-child">
				<div>Your Score:</div>
				<div>
					<span id="score"></span>
					<span></span>
				</div>
			</div>
			<div class="details-child">
				<div>Passing Score:</div>
				<div>
					<span id="passmark"></span>
					<span></span>
				</div>
			</div>
		</div>
		<hr>
		<div id="result-remark">
			<p><strong>Remark: </strong><span id="remark"></span></p>
		</div>
		<div class="review">
			<a href="">
				Review Quiz
			</a>
		</div>
	</section>
<?php scripts(['jquery', 'result']) ?>
<?php view('footer'); ?>
