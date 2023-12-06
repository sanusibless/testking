<?php ob_start(); ?>
<?php include("init.php"); 

if(!isset($_SESSION['user'])) {
	header("location: ../pages/login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title ?? "Home"?></title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<?php if(isset($links)) { foreach ($links as $file) { ?>
		<link rel="stylesheet" type="text/css" href="..\public\css\<?= $file ?>.css">
	<?php } } ?>
</head>
<body>