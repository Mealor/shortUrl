<?php
class ShortURL 
{
	protected $url;	    //Базовый url
	protected $pdo;	    //Объект PDO для базы данных
	
	public $code;		//Генерируемый случайный код для короткого url
	public $time;		//Время создания объекта
	
	//Конструктор
	public function __construct (PDO $pdo, $url, $short_url=null) 
	{
		$this->time = $_SERVER["REQUEST_TIME"];
		$this->pdo = $pdo; //подключение к базе данных
		$this->pdo->query("use u0421965_default"); //выбор базы данных
		$this->url = $url;
		//проверяем существует ли базовый url в базе данных
		if ($this->IsURLExists() && !isset($short_url)) {
			//запрос к базе данных с параметрами
			$query = $this->pdo->prepare("SELECT `short_url`
			FROM `short_urls` WHERE `url` = ? LIMIT 1");
			$query->bindParam(1,$this->url);
			$query->execute();
			//вывод найденого кода в переменную
			$result = $query->fetch();
			$this->code = $result['short_url'];	
		} elseif (isset($short_url)) { //если введено слово пользователя
			//проверка не занят ли код
			if ($this->IsCodeExists($short_url)) {
				$this->code = false; 
			} else {
				$this->code = $short_url;
				$this->AddURL();
			}	
		} else {  //Если такой ссылки нет
			$this->GenerateURL();
			$this->AddURL();			
		}
	}
	
	//Генерация короткого URL адреса
	private function GenerateURL() {
		//набор символов из которого будет состоять коротка ссылка
		static $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$length = strlen($chars);	
		for ($i=0; $i <= 5; $i++ ){
			$random = rand(0, $length - 1);	
			$this->code .=$chars[$random];
		}	
		if ($this->IsCodeExists($this->code)) { //Если код присутствует в базе данных
			$this->code = $this->GenerateURL(); //Вызвать себя для новой генерации
		} 
	}
	
	//функция проверки присутствия базового URL в базе
	private function IsURLExists () 
	{
		//ищем такие же url в базе
		try {
			$query = $this->pdo->prepare("SELECT * FROM `short_urls` WHERE `url` = :url LIMIT 1");
			$query->bindParam(":url",$this->url);
			$query->execute();
		}
		catch (PDOException $e){
			echo $e->getMessage();
			exit;
		}
		if ($query->rowCount()==0) {
			return false;
		} else {
			return true;
		}	
	}
	
	//функция проверки присутствия короткого кода URL в базе
	private function IsCodeExists($code) {
		try {
			$query = $this->pdo->prepare("SELECT * FROM `short_urls` WHERE `short_url` = :code LIMIT 1");
			$query->bindParam(":code",$code);
			$query->execute();
		}
		catch (PDOException $e){
			echo $e->getMessage();
			exit;
		}
		if ($query->rowCount() == 0) {
			return false;
		} else {
			return true;
		}
	}
	
	//функция добавления url в базу
	private function AddURL () {
		try {
			$query = $this->pdo->prepare("INSERT INTO short_urls
			(url, short_url, date) VALUES (?, ?, ?);");
			$query->bindParam(1,$this->url);
			$query->bindParam(2,$this->code);
			$query->bindParam(3,$this->time);
			$query->execute();	
		}
		catch (PDOException $e){
			echo $e->getMessage();
			exit;
		}
	}	
}
