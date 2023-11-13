<?php 
	session_start();

	$user_id = $_SESSION['user']['id'];

	$subject = $_GET['subject'];
	$category = $_GET['category'];
	$batch = $_GET['batch'];

	try {
		$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// quering total question 

		$query = "SELECT COUNT(*) AS total, (SELECT COUNT(*) FROM results WHERE user_id = :user_id AND batch = :batch AND subject = :subject AND category = :category AND status = 1) as correct, mode FROM results WHERE user_id = :user_id AND batch = :batch AND subject = :subject AND category = :category";

		$stmt = $pdo->prepare($query);
		$stmt->bindValue(":user_id", $user_id);
		$stmt->bindValue(":subject", $subject);
		$stmt->bindValue(":category", $category);
		$stmt->bindValue(":batch", $batch);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $pdo->prepare("SELECT type,value FROM settings WHERE type = :passmark");
		$stmt->bindValue(":passmark", 'passmark');
		$stmt->execute();
		$result['passmark'] = $stmt->fetch(PDO::FETCH_ASSOC)['value'];

		$stmt = $pdo->prepare("SELECT type,value FROM settings WHERE type = :passmark");
		$stmt->bindValue(":passmark", 'passmark');
		$stmt->execute();

		$result['subject'] = $subject;
		$result['category'] = $category;

		echo json_encode($result);
	} catch (PDOException $e) {
		echo json_encode([
			'error' => $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile()
		]);
	}

?> 