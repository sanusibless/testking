<?php 
session_start();
require_once '../src/functions.php';
if($_SERVER['REQUEST_METHOD'] === "POST") {
	$error = [];
	$input = [];
	
	if(filter_has_var(INPUT_POST, 'first_name')) {
		$first_name = sanitize($_POST['first_name']);
		$input['first_name'] = $first_name;
	} else {
		$error['first_name'] = "Please provide a name";
	}

	if(filter_has_var(INPUT_POST, 'last_name')) {
		$last_name = sanitize($_POST['last_name']);
		$input['last_name'] = $last_name;
	} else {
		$error['last_name'] = "Please provide a name";
	}

	if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
		$error['email'] = "Invalid Email Address";
	} else {
		$input['email'] = $_POST['email'];
	}


	if(filter_has_var(INPUT_POST, 'password') && filter_has_var(INPUT_POST, 'confirm_password')) {
		$password = $_POST['password'];
		$confirm_pass = $_POST['confirm_password'];

		if($password === $confirm_pass) {
			$input['password'] = password_hash($password, PASSWORD_DEFAULT);
		} else {
			$error['password'] = "Passwords do not match";
		}  
	} else {
		$error['password'] = "Please Provide password";
	}

	if(!empty($error)) {
		$_SESSION['error']['register'] = $error;
		header('location: ../pages/register.php');
	} else {
		try {
			echo 1;
			$pdo = new PDO('mysql:host=localhost;dbname=quiz;charset=utf8','root', '');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $pdo->prepare("INSERT INTO users(first_name, last_name, email, password, role, status) VALUES(:first_name,:last_name,:email,:password, :role, :status)");
			$stmt->bindValue(':first_name', $input['first_name']);
			$stmt->bindValue(':last_name', $input['first_name']);
			$stmt->bindValue(':email', $input['email']);
			$stmt->bindValue(':password', $input['password']);
			$stmt->bindValue(':role', "student");
			$stmt->bindValue(':status', "active");

			$is_success = $stmt->execute();
			if($is_success) {
				$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
				$stmt->bindValue(':email', $input['email']);
				$stmt->execute();
				$id= $stmt->fetch(PDO::FETCH_ASSOC)['id'];
				$_SESSION['success'] = "Success";
				$_SESSION['user'] =  [
				'id' => $id,
				'name' => $input['first_name'] . " " . $input['last_name'],
				'email' => $input['email'],
				'status' => 0,
				'password' => $input['password']
			];

			header("location: ../pages/index.php");
			} else {
				$_SESSION['error']['register']['connection'] =  "Unknown Error";
				header("location: ../pages/register.php");
			}
		} catch(PDOException $e) {
			$_SESSION['error']['register'] = $e->getMessage() . ' on line ' . $e->getLine() . ' in ' . $e->getFile(); ;
			header("location: ../pages/register.php");
		}
	}
} else {
	return json_encode([
		'error' => "Invalid Request"
	]);
}

?>