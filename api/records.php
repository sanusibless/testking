<?php
	session_start();
	$userID = $_SESSION['user']['id'];

	try {
	  $pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
	  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	  $stmt = $pdo->prepare('SELECT DISTINCT batch, subject, mode, category.name AS categoryName, category.code as categoryCode, (SELECT COUNT(*) FROM results WHERE status = 1 AND batch IN (SELECT DISTINCT batch FROM results WHERE user_id = :userID) AND subject in (SELECT DISTINCT subject FROM results)) AS score FROM results JOIN category ON results.category = category.code WHERE user_id = :userID');

	  $stmt->bindValue(":userID", $userID);

	  $stmt->execute();

	  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	  echo json_encode($result);
	} catch (PDOException $e) {
		json_encode([
			'error' => $e->getMessage() . ' on line ' . $e->getLine() . " in " . $e->getFile()
		]);
	}
?>