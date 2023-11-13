<?php
	$filePath = basename($_SERVER['PHP_SELF']);
	$file = explode('.', $filePath)[0];

 	scripts(['jquery', $file]);
	view('footer');
?>