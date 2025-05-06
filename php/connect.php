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


	function getDbConnection() {
		global $host, $user, $pass, $name;  // используем глобальные переменные
		$mysqli = new mysqli($host, $user, $pass, $name);
		if ($mysqli->connect_errno) {
			die("Ошибка подключения: " . $mysqli->connect_error);
		}
		$mysqli->set_charset("utf8mb4");
		return $mysqli;
	}