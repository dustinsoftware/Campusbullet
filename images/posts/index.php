<?php

$file = @($_GET['q']);
if ($file == "") {
	header('Location: /');
} else {

	$file = preg_replace("/[^0-9\-]/", "", $file) . ".jpg";

	header('Content-Type: image/jpeg');
	if (file_exists($file)) {
		echo file_get_contents($file);
	} else {
		header("HTTP/1.0 404 Not Found");
		header('Content-Type: image/jpeg');
		echo file_get_contents("noimage.jpg");
	}

}
