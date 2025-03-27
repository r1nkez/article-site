<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $host = 'localhost';
	$user = 'root';
	$pass = '';
	$name = 'mydb';
	
	$link = mysqli_connect($host, $user, $pass, $name);
	mysqli_set_charset($link, 'utf8');