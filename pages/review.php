<?php 
session_start();
if(!isset($_SESSION['user'])) {
	header("location: ../pages/login.php");
}

require_once '../src/functions.php' ?>
<?php view('header',[
	'title' => 'Review - '  . $_GET['batch'],
	'links' => ['quiz', 'review']
]); ?>

	<div style="border: 3px solid #00aa50;">
	</div>
 <div class="intro">
	<div class="intro-header">
		<div>
			<a class="back" href="javascript:history.go(-1)" title="Back"><img src="../public/images/arrow-back-outline.svg" style="width: 20px" title="Back"/> <span>Back</span></a>
		</div>
		<h2><?= "Review : " . ucfirst($_GET['subject']) . ' Quiz '  . ucfirst($_GET['mode'] . " Mode - " . $_GET['batch']  ) ?></h3>
		<h4>Score : <span id='score'></span></h4>
	</div>
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

<?php scripts(['jquery', 'review']) ?>
<?php view('footer'); ?>
