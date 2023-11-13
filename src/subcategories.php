<?php 
	$category = $_GET['category'];

	try {
		$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $pdo->prepare('SELECT * FROM subjects WHERE category_code = :code');
		$stmt->bindValue(":code", $category);

		$stmt->execute();

		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($res);

	} catch (PDOException $e) {
		echo json_encode([
			'error' => 'Server Error!'
		]);
	}
?>