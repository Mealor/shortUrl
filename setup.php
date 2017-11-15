<?php

$db = "база";
$dsn = "mysql:host=localhost";
$login = "Логин";
$pass = "пароль";
try {
	$pdo = new PDO($dsn, $login, $pass);
}
catch (PDOException $e){
	echo $e->getMessage();
}