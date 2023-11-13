<?php
session_start(); 
require_once '../src/functions.php' ?>
<?php view('home/header',[
	'title' => "TestKing - Home",
	'links' => ['header','footer','home']
]); 
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $pdo->prepare('SELECT * FROM category');
		$stmt->execute();

		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

	} catch (PDOException $e) {
		echo $e->getMessage();
	}
?>

<section class="banner">
	<div>
		<div class="banner-inner">
			<h1>Exam Prep Designed for <Span class="emphasy">Mastery</Span></h1>
			<h2>Ge unlimited access to the most frequently updated past & practice questions bank,
				on Nigeria's #1 Online Test Prep Platform</h2>
			<div class="banner-items">
				<ul>
					<?php foreach ($res as $r): ?>
						<li><a href="?category=<?=$r['code']?>"><?= $r['name']?></a></li>	
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="popular">
		<h3>Popular Exams</h3>
		<div class="popular-inner">
				<?php foreach ($res as $r): ?>
						<div class="popular-items">
							<div class="items-text"><a class="category-link" href="?category=<?= $r['code'] ?>"><?= $r['name'] ?></a></div>
							<div>
								<img src="../public/images/popular/work.webp">
							</div>
						</div>	
				<?php endforeach; ?>			
		</div>
	</div>
	<div class="sample-container">
		<div id="overlay-index">
			<div class="cv-spinner">
	    		<span class="spinner"></span>
	  		</div>
		</div>
		<div class="samples">

		</div>
	</div>
	</div>
</section>
<?php scripts(['jquery', 'index']); ?>
<?php view('home/footer'); ?>