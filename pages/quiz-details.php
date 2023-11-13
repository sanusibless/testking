<?php
	session_start();
	require_once '../src/functions.php'; 

	if(!isset($_SESSION['user'])) {
		header('location: ./login.php');
	}
?>
<?php 
view('home/header',[
	'title' => "TestKing - Free Practices",
	'links' => ['header','footer','quiz-details']
]);

?>
<section class="quiz-preamble">
	<div class="intro">
		<h2><?= $_GET['subject'] ?? '' ?> Practise Test</h2>
	</div>
	<div class="intro-header">
		<h3>Free <?= $_GET['subject'] ?? '' ?> Practise Test</h3>
	</div>
	<div class="intro-details">
		<div class="details-div">
		<p class="intro-details-text">This Free <?= $_GET['subject'] ?? '' ?> Practise Test comprises of <strong>questions</strong>, and you will have to answer correctly as many as you can within the allocated time</p>
		<p class="intro-details-text">Try to find time and place where you will not be interrupted during the test</p>
		<p class="intro-details-text">Once you are ready to start, click the <em>Start</em> button below to start the test</p> 
		<div class="rules">
			<ul>
				<li>Calculators are not Allowed</li>
				<li>Make sure you check your internet connection</li>
			</ul>
		</div>
	</div>
	<div class="promo">
		<h3 class="promo-header">This is a free sample of the our practise test</h3>
		<p class="promo-text">Click the button below to order the premium version of the test</p>
		<a class="promo-btn" href="">Get The Premium Version</a>
	</div>
	<div class="mode">
		<div class="practise">
			<h2 class="practise-header">Practise Mode</h2>
			<p class="practise-text">This step-by-step mode allows you to review each question and answer in details as you go through them</p>
			<a class="practise-btn" href="./quiz.php?category=<?= $_GET['category']?? ""?>&subject=<?= $_GET['subject'] ?? '' ?>&amp;mode=practise"><?= !isset($_SESSION['user']) ? 'Login to' : '' ?>start Practise</a>
		</div>
		<div class="exam">
			<h2 class="exam-header">Exam Mode</h2>
			<p class="exam-text">This timed-mode simulates the actual exam condition. Answers and Explanation will be available after you submit</p>
			<a class="exam-btn" href="./quiz.php?category=<?= $_GET['category']?? ""?>&subject=<?= $_GET['subject'] ?? '' ?>&amp;mode=exam"><?= !isset($_SESSION['user']) ? 'Login to' : '' ?>start Exam</a>
		</div>
	</div>
	</div>
</section>

<?php
	view('home/footer');
 ?>