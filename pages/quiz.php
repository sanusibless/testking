<?php 
session_start();
if(!isset($_SESSION['user'])) {
	header("location: ../pages/login.php");
}
$user = $_SESSION['user'];
if($user['status'] === true) {
	header("location: ../pages/result.php");
}
require_once '../src/functions.php' ?>
<?php view('header',[
	'title' => ucfirst($_GET['subject']) . ' - '  . ucfirst($_GET['mode']),
	'links' => ['quiz']
]); ?>

	<div style="border: 3px solid #00aa50;">
		
	</div>
 <div class="intro">
	<div class="intro-header">
		<h2><?= ucfirst($_GET['subject']) . ' Test : '  . ucfirst($_GET['mode'] . " Mode" ) ?> </h3>
	</div>
	<?php if($_GET['mode'] == 'exam' ): ?>
		<div id="time">
			<span id="min">00</span>&nbsp;:&nbsp;<span id="secs">00</span>
		</div>
	<?php endif; ?>
 </div>
	<div id="start">
		<P>Welcome <strong><?= ucwords($user['name']) ?></strong></p>
		<p>Click the <strong>Start</strong> button to start the test!</p>
		<a href="" id="link">
			Start
		</a>
	</div>
	<section id="question-sec"></section>
	<section>
		<div id="divButton">
			<button id="prev">
				Prev
			</button>
			<button id="next">
				Next
			</button>
			<button id="finish">
				Finish
			</button>
		</div>
	</section>
	<div id="overlay">
		  <div class="cv-spinner">
    		<span class="spinner"></span>
  		  </div>
	</div>

<?php scripts(['jquery', 'quiz']) ?>
<?php view('footer'); ?>
