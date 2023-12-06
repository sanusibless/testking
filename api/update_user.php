<?php 
	require_once("../incl/init.php");
	if($_POST['password'] !== $_POST['confirm_password']) {
		$_SESSION['update']['error']['password'] = "Passwords do not match";
		header("location: ../pages/manage.php");
	};

	$db->updateRecord("user", [
		'id' => $_SESSION['user']['id'],
		'first_name' => $_POST['first_name'],
		'last_name' => $_POST['last_name'],
		'password' => !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : ''
	]);
?>