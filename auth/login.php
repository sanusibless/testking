<?php 
session_start();
$back = $_SERVER['HTTP_REFERER'];
if($_SERVER['REQUEST_METHOD'] === "POST") {
	$error = [];
	$input = [];
	if(filter_has_var(INPUT_POST, 'email') && filter_has_var(INPUT_POST, 'password')) {
		$input['email'] = $_POST['email'];
		$input['password'] = $_POST['password'];

		try {
		$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root','');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$stmt->bindValue(':email', $input['email']);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		$password_verified = password_verify($input['password'], $user['password']);
			if($password_verified) {
				session_regenerate_id();
				$_SESSION['user'] = [
					'id' => $user['id'],
					'name' => $user['first_name'] . " " . $user['last_name'],
					'email' => $user['email'],
					'password' => $user['password'],
					'status'=> $user['status']
				];
				if(isset($_POST['is_admin']) && $user['role'] === 'admin') {
					header('location: ../pages/admin/dashboard.php');
				} else {
					header('location: ../pages/index.php');
				}
			} else {
				$error['password'] = "Invalid password or email";
			}

			if(!empty($error)) {
				$_SESSION['error']['login'] = $error;
				header("location: ../pages/login.php");
			} 
		} catch (PDOException $e) {
			$_SESSION['error']['login'] = $e->getMessage();
			header("location: ../pages/login.php");
		}
		} else {
			$_SESSION['error']['login'] = "Please ensure all fields are filled";
		 	header("location: ../pages/login.php");
		}
} else {
	echo json_encode([
		'error' => "Invalid Request"
	]);
}

?>