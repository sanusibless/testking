<?php 
	$res = [];
		try {
			$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt = $pdo->prepare("SELECT questions.id as id ,question,answer FROM questions JOIN answers ON questions.id = answers.question_id");
			$stmt->execute();
			
			$res['quiz'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

			for($i = 0; $i< count($res['quiz']); $i++) {
				$stmt = $pdo->prepare("SELECT option FROM options WHERE question_id = :question_id");

				$stmt->bindValue(":question_id", $res['quiz'][$i]['id']);

				$stmt->execute();
				$res['quiz'][$i]['options'] = $stmt->fetchAll(PDO::FETCH_COLUMN,0);
			}

			$stmt = $pdo->prepare("SELECT type,value FROM settings WHERE type = :duration");
			$stmt->bindValue(":duration", 'duration');
			$stmt->execute();

			$res['duration'] = $stmt->fetch(PDO::FETCH_ASSOC)['value'];

			echo json_encode($res);
		} catch(PDOException $e) {
			echo json_encode([
				'error' => $e->getMessage()
			]);
		}
?>