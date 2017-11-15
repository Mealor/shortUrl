<?php
	include 'setup.php';
	
	$target = $_GET['target']; //получаем код короткой ссылки
	$pdo->query("use ". $db);  
	
	//находим url соовтетствующий полученному коду
	$query = $pdo->prepare ("SELECT url FROM short_urls WHERE short_url = ?");
	$query->bindParam (1, $target);
	$query->execute();
	$result = $query->fetch();
	if (empty($result)) {
		echo "Ссылка отсутсутет";
		exit;
	}
	echo $target;
	
	Header('Status: 301 Moved Permanently');
	Header('Location: ' . $result["url"],true, 301 );
?>
