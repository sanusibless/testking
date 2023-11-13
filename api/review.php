<?php
	session_start();

	$batch = $_GET['batch'];

		try {
		$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $pdo->prepare("SELECT question_id, answer AS userAnswer, subject FROM results WHERE batch = :batch");
		$stmt->bindValue(':batch', $batch);

		$stmt->execute();

		$result['quiz'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$stmt = $pdo->prepare("SELECT (SELECT COUNT(*) FROM results WHERE batch = :batch AND status = 1) AS score, COUNT(*) AS total FROM results WHERE batch = :batch");
		$stmt->bindValue(':batch', $batch);
		$stmt->execute();

		$result['info'] = $stmt->fetch(PDO::FETCH_ASSOC);

		echo json_encode($result);

		} catch(PDOException $e) {
			echo json_encode([
				'error' => $e->getMessage()
			]);
		}
	
?>