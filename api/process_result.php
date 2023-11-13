<?php
	session_start();
	require '../src/functions.php';
	// check if request method is post;
	// check if inputs are availale
	// if user is log in

	$quiz = $_POST['quiz'];

	foreach($quiz as $q) {
		try {
		$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $pdo->prepare("INSERT INTO results(user_id,question_id,answer,status,subject,category,batch,mode) VALUES(:user_id, :question_id, :answer, :status, :subject, :category, :batch, :mode)");
		$stmt->bindValue(':user_id', $_SESSION['user']['id']);
		$stmt->bindValue(':question_id', $q['id']);
		$stmt->bindValue(':answer', $q['userAnswer']);
		$stmt->bindValue(':status', $q['answer'] == $q['userAnswer'] ? 1 : 0);
		$stmt->bindValue(':subject', $q['subject']);
		$stmt->bindValue(':category', $q['category']);
		$stmt->bindValue(':batch', $q['batch']);
		$stmt->bindValue(':mode', $q['mode']);
		$stmt->execute();

		$stmt = $pdo->prepare("UPDATE users SET status = 1 WHERE users.id = :user_id");
		$stmt->bindValue(':user_id', $_SESSION['user']['id']);
		$stmt->execute();

		

		} catch(PDOException $e) {
			echo json_encode([
				'error' => $e->getMessage()
			]);
		}

	}
	$_SESSION['user']['status'] = 1;
	echo json_encode([
		'complete' => true
	])
	
?>