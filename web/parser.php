<?php
	header('Content-language: pl');
	header('Content-type: text/html; charset=UTF-8');	
	
	$file = file('wku.txt');
	foreach ($file as $line) {
		$line = trim($line);
		echo "'$line' => '$line',\n";
	}
?>