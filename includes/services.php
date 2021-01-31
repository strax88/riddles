<?php

function refreshPage($url, $time = 0){
	// функция обновления/перенаправления страницы
	echo '<META HTTP-EQUIV="Refresh" Content="'. $time .'; URL='.$url.'">'; 
}

function endWord($var){
	// функция определения окончания слова по количеству
	$var = abs($var);
	if (in_array($var%100 , array(10, 11, 12, 13, 14))){
		return "ок";
	} elseif (in_array($var%10 , array(2, 3, 4))) {
		return "ки";
	} elseif ($var%10 == 1) {
		return "ка";
	} else {
		return "ок";
	}
}

/**
 * Класс Загадка
 Основные функции класса:
 - формирование текста загадки по номеру из файла с загадками data.csv;
 - получение ответа на загадку;
 - сравнение ответа с указанными вариантами в файле data.csv;
 - чтение и сохранение результатов ответов в файл result.csv;
 - чтение и сохранение данных о попытках в файл attempt.csv;
 - плучение информации о количестве загадок.
 Формат файла "data.csv":
 %ПОРЯДКОВЫЙ_НОМЕР_ЗАГАДКИ
 ТЕКСТ_ЗАГАДСК;С_ПЕРЕНОСОМ;СТРОК;ЧЕРЕЗ_ТОЧКУ;С_ЗАПЯОЙ
 ВАРИАНТЫ;ОТВЕТОВ_ЧЕРЕЗ_ТОЧКУ;С_ЗАПЯТОЙ
 Формат файла "result.csv":
 0;0;..количество_загадок
 где 0 - неверный ответ, 1 - верный ответ
 Формат файла "attempt.csv":
 0;0;..количество_загадок
 где число - количество попыток на загадку
 */
class Riddle
{
	private $file; //файл с загадками
	private $list; // массив с данными по загадкам
	private $answer; // ответ от пользователя
	private $answers_list; // список ответов на загадку
	private $number; // номер загадки
	
	function __construct()
	{
		// конструктор класса
		$this->file = INC . 'data.csv';
		// формирование списка заявок
		$this->getRiddlesData();
	}

	public function setAnswer($answer){
		// установка ответа от пользователя
		$this->answer = $answer;
	}

	public function getAnswer(){
		// просмотр ответа от пользователя
		return $this->answer;
	}

	public function setRiddleNumber($number){
		// установка номера загадки
		$this->number = $number;
	}

	public function getRiddleNumber(){
		// получение номера загадки
		return $this->number;
	}

	public function getRiddleText(){
		// получение текста загадки
		if ($this->number !== NULL && $this->number >=0 && $this->number < count($this->list)){
			return implode("<br />", $this->list[$this->number][0]);
		}
		return FALSE;
	}

	public function checkAnswer(){
		// проверка ответа на загадку
		if ($this->number !== NULL){
			foreach ($this->list[$this->number][1] as $answer) {
				if (mb_strtolower($answer, "UTF-8") == mb_strtolower($this->answer, "UTF-8")){
					$this->saveResult(1);
					$this->saveAttempt(1);
					return TRUE;
				}
			}
		}
		$this->saveAttempt(1);
		$this->saveResult(0);
		return FALSE;
	}

	private function getRiddlesData(){
		// формирование массива данных о загадках из файла
		$tmp_list = array();
		$count = 0;
		if (($fp = fopen($this->file, "r")) !== FALSE) {
			while (($data = fgetcsv($fp, 0, ";")) !== FALSE) {
				if (strpos($data[0], "%") !== FALSE){
					$this->list[$count] = array();
					$count += 1;

				} else {
					$this->list[$count - 1][] = $data; 
				}
			}
			fclose($fp);
		}
	}

	public function getRiddlesCount(){
		// получение информации о количестве загадок
		try {
			if (gettype($this->list) == 'array'){
				return count($this->list);
			} else {
				return 0;
			}
		} catch (Exception $e) {
			return 0;
		}
	}


	public function getResult(){
		// чтение результатов из файла
		$result_file = INC . "result.csv";
		if (($fp = fopen($result_file, "r")) == FALSE){
			return FALSE;
		} else {
			while (($data = fgetcsv($fp, 0, ";")) !== FALSE) {
				return $data;

			}
		}
	}

	public function saveResult($result){
		// запись результатов в файл
		$result_file = INC . "result.csv";
		if ($this->getResult() !== NULL){
			$current_result = $this->getResult();
		}
		if ($current_result == NULL || count($current_result) < $this->getRiddlesCount()){
			// формирование пустого массива, при отсутствии файла или информации о результатах
			$current_result = array_fill(0, $this->getRiddlesCount(), 0);
		}
		$current_result[$this->number] = $result;
		if (($fp = fopen($result_file, "w")) !== FALSE){
			fputcsv($fp, $current_result, ";");
		}
		fclose($fp);
	}

	public function getAttempt(){
		// чтение попыток из файла
		$attempt_file = INC . "attempt.csv";
		if (($fp = fopen($attempt_file, "r")) == FALSE){
			return FALSE;
		} else {
			while (($data = fgetcsv($fp, 0, ";")) !== FALSE) {
				return $data;

			}
		}
	}

	public function saveAttempt($var){
		// запись попыток в файл
		$attempt_file = INC . "attempt.csv";
		if ($this->getAttempt() !== NULL){
			$current_attempt = $this->getAttempt();
		}
		if ($current_attempt == NULL || count($current_attempt) < $this->getRiddlesCount()){
			// формирование пустого массива, при отсутствии файла или информации о попытках
			$current_attempt = array_fill(0, $this->getRiddlesCount(), 0);
		}
		if ($var !== 0){
			$current_attempt[$this->number] += 1;
		} else {
			$current_attempt[$this->number] = 0;
		}

		if (($fp = fopen($attempt_file, "w")) !== FALSE){
			fputcsv($fp, $current_attempt, ";");
		}
		fclose($fp);
	}
}