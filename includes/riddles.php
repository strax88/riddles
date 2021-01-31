<!-- блок отображения данных -->
<div id="main">
	<h1><?php echo $SESSION['title'];?></h1>
	<?php
	// вставка служебной страницы
	include_once INC . 'services.php';
	// статусы кнопок формы
	$back_status = "";
	$OK_status = "";
	$forward_status = "";
	// создаём объект класса Загадка
	$riddle = new Riddle();
	// получаем номер загадки из заголовка
	$riddle_number = $_GET['number'];
	
	// показ следующей загадки
	if ($_POST['forward'] != NULL && $riddle_number + 1 < $riddle->getRiddlesCount()) {
		$riddle_number += 1;
		// обновление страницы
		refreshPage("./index.php?content=Загадки&number=" . $riddle_number);
	}
	// показ предыдущей загадки
	if ($_POST['back'] != NULL && $riddle_number - 1 >= 0) {
		$riddle_number -= 1;
		// обновление страницы
		refreshPage("./index.php?content=Загадки&number=" . $riddle_number);
	}
	// передаём в объект класса номер загадки
	$riddle->setRiddleNumber($riddle_number);	
	// изменение статуса кнопок формы
	if ($riddle->getRiddleNumber() + 1 >= $riddle->getRiddlesCount()){
		$forward_status = "disabled";
	}
	// изменение статуса кнопок формы
	if ($riddle->getRiddleNumber() <= 0){
		$back_status = "disabled";
	}
	// выполнение сценария в зависимости от наличия загадок в файле
	if ($riddle->getRiddlesCount() == 0 || $riddle->getRiddlesCount() <= $riddle_number){
		echo "<br /><font color='red'>";
		echo "К сожалению в системе на данный момент нет такого количества загадок";
		echo "</font><br />";

	} else {
		// выполнение сценария в зависимости от имеющихся резульятатов
		if ($riddle->getResult() !== NULL){
			// сброс информации об ответах и попытках
			if ($_POST['reset'] !== NULL) {
				for($i=0;$i<$riddle->getRiddlesCount();$i++){
					$riddle->setRiddleNumber($i);
					$riddle->saveResult(0);
					$riddle->setRiddleNumber($i);
					$riddle->saveAttempt(0);
				}
				// обновление страницы
				refreshPage("./index.php?content=Загадки&number=0");
			}
			// переключения статуса объектов формы при верном ответе на загадку
			$current_result = $riddle->getResult();
			if ($current_result[$riddle->getRiddleNumber()] == 1){
				$OK_status = "disabled";
			} else {
				$OK_status = "";
			}
			?>
			<!-- формирование формы -->
			<form action="./index.php?content=Загадки&number=<?php echo $riddle->getRiddleNumber();?>" method="POST">
			<?php
			// обработка кнопки завершения работы с загадками
			if ($_POST['END'] !== NULL) {
				// вывод статистики по загадкам
				for($i=0;$i<$riddle->getRiddlesCount();$i++){
					$result = $riddle->getResult();
					$attempt = $riddle->getAttempt();
					$r = $i + 1;
					if ($result[$i] == 1){
						echo "<br /><font color='red'>";
						echo "Для загадки " . $r . " было сделано: " . $attempt[$i] . " попыт" . endWord($attempt[$i]) . ". Загадка отгадана!";
						echo "</font><br />";
					} else {
						echo "<br /><font color='red'>";
						echo "Для загадки " . $r . " было сделано: " . $attempt[$i] . " попыт" . endWord($attempt[$i]) . ". Загадка не отгадана!";
						echo "</font><br />";
					}
				}
				?>
				<!-- кнопка очистки результатов -->
				<input type="submit" name="reset" value="Очистить результат" />


				<?php
			
			} elseif (array_sum($riddle->getResult()) < $riddle->getRiddlesCount()){
				// вывод загадки и формы ответа

				echo $riddle->getRiddleText();
				?>

				<div id="riddle_text"><?php echo $riddle_text;?></div>
				<input type="text" id="answer" placeholder="Ответ" name="answer"  <?php echo $OK_status;?> /><br />
				<input type="submit" name="back" <?php echo $back_status;?> value="<<" />
				<input type="submit" name="OK" <?php echo $OK_status;?> />
				<input type="submit" name="END"  value="Завершить" />
				<input type="submit" name="forward" <?php echo $forward_status;?> value=">>" />

				<?php

			} else {
				// вывод статистики по загадкам
				for($i=0;$i<$riddle->getRiddlesCount();$i++){
					$result = $riddle->getResult();
					$attempt = $riddle->getAttempt();
					$r = $i + 1;
					if ($result[$i] == 1){
						echo "<br /><font color='red'>";
						echo "Для загадки " . $r . " было сделано: " . $attempt[$i] . " попыт" . endWord($attempt[$i]) . ". Загадка отгадана!";
						echo "</font><br />";
					} else {
						echo "<br /><font color='red'>";
						echo "Для загадки " . $r . " было сделано: " . $attempt[$i] . " попыт" . endWord($attempt[$i]) . ". Загадка не отгадана!";
						echo "</font><br />";
					}
				}
				?>
				<input type="submit" name="reset" value="Очистить результат" />


				<?php
			}
		} else {
			// очистка данных
			for($i=0;$i<$riddle->getRiddlesCount();$i++){
					$riddle->setRiddleNumber($i);
					$riddle->saveResult(0);
					$riddle->setRiddleNumber($i);
					$riddle->saveAttempt(0);
				}
				refreshPage("./index.php?content=Загадки&number=0");
		}
	}
	// обработка непустого ответа
	if ($_POST['answer'] != NULL){
		$riddle->setAnswer($_POST['answer']);
		$attempt = $riddle->getAttempt()[$riddle->getRiddleNumber()] + 1;
		// обработка правильного ответа
		if ($riddle->checkAnswer()) {
			echo "<br /><font color='red'>ПОЗДРАВЛЯЮ! ОТВЕТ ВЕРНЫЙ. (" . $attempt . " попыт" . endWord($attempt) . ")</font><br />";

			refreshPage("./index.php?content=Загадки&number=" . $attempt, 3);
		} else {
			// обработка ошибочного ответа
			echo "<br /><font color='red'>ОТВЕТ НЕВЕРНЫЙ! (" . $attempt . " попыт" . endWord($attempt) . ")</font><br />";
		}
		?><?php
	} elseif ($_POST['OK'] != NULL) {
		// обработка пустого ответа
			$riddle->checkAnswer();
			$attempt = $riddle->getAttempt()[$riddle->getRiddleNumber()];
			echo "<br /><font color='red'>ВВЕДИТЕ ВАШ ОТВЕТ (" . $attempt . " попыт" . endWord($attempt) . ")</font><br />";
	}
	?>
	</form>
</div>