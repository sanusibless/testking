<?php
	
	$email = $_GET['email'];
	$password = password_hash($_GET['password'],PASSWORD_DEFAULT);

	try {
		$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



		$stmt = $pdo->prepare("UPDATE users SET users.password = :password WHERE email = :email");
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':password', $password);

		if($stmt->execute()) {

		echo json_encode([
			'success' => true,
			'status' => 200,
		]);
		header('status: 200');
		}

		} catch(PDOException $e) {
			echo json_encode([
				'error' => $e->getMessage()
			]);
		}
	

?>