<?php
include "ShortURL.php";
include "setup.php";

$url = $_POST["url"];				//Конвертируемый адрес
$short_url = $_POST["short_url"];	//Код короткой ссылки

//Проверка является ли введенная строка url адресом
if (!filter_var($url, FILTER_VALIDATE_URL)) {
	echo "введенный адрес не является URL";		
	exit;
}
if (!preg_match("#^[aA-zZ0-9]+$#",$short_url) && !empty($short_url)) {
	echo "Используйте только цифры и латинские буквы";
	exit;
}
//Проверка длины введенных строк
if (strlen($url)>=500) {
	echo "Слишком длинный URL";	
	exit;
}
if (strlen($short_url)>=10) {
	echo "Слишком длинное слово";	
	exit;
}
//Если введен код то создать объект с дополнительным параметром
if ($short_url !== "" && $url !== "") {
	$gen = new ShortURL($pdo, $url, $short_url);
	//Проверка не занят ли код короткой ссыкли введенный пользователем
	if ($gen->code==false) {
		echo "Данная короткая ссылка занята, ввведите другую или очистите поле";
		exit;
	}
} else  {
	$gen = new ShortURL($pdo, $url); //иначе создаем обычный объект
}

//вывод информации
echo "Ваша короткая ссылка<br>";
echo "http://".$_SERVER['HTTP_HOST']."/".$gen->code;
?>
