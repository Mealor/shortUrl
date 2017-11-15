<?php
include "setup.php";

try {
	
	$pdo->query ("CREATE DATABASE IF NOT EXISTS ".$db);
	$pdo->query ("use ".$db);
	$pdo->query ("CREATE TABLE IF NOT EXISTS `short_urls` (
				`id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
				`url` VARCHAR(500) NOT NULL,
				`short_url` VARCHAR(10) NOT NULL,
				`date` INTEGER UNSIGNED NOT NULL,
				PRIMARY KEY (`id`))
				ENGINE=InnoDB;"
);
}
catch (PDOException $e){
	echo $e->getMessage();
	exit;
}

?>