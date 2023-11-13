<?php 
	function view($file, $array = []): void {
		foreach ($array as $key => $value) {
			$$key = $value;
		}
		include_once '../incl/' . $file . '.php';
	}

	function sanitize($string) {
		$data = trim($string);
		$data = strip_tags($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function scripts($array) {
		foreach($array as $file) {
			echo "\n<script src=\"..\\public\\js\\$file.js\"></script>";
		}
	}
?>