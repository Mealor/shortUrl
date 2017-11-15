
<!DOCTYPE html>
	<head>     
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="js/jquery1.8.js"></script>
        <link rel="stylesheet" href="css/main.css">
	<title>Генератор ссылок</title>
	</head>
	<body>
		<form action="javascript:void(null);" method="POST" id="ShortURL" onsubmit="ShortURL()">
			Введите адрес, который хотите укоротить <br>
			<input name="url" placeholder = "Например: https://www.google.ru (до 500 символов)"><br>
			Введите желаемый код короткой ссылки,
			при пустом поле код будет сгенерирован автоматически <br>
			<input name="short_url" placeholder = "Например: MyCode (до 10 символов)"><br>
			<button>Сгенерировать</button><br>
		</form>
		<div id="output"></div>
	</body>
</html>
