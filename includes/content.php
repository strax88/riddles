<?php
// Перенаправление на страницы системы
	if (!$_GET) {
		$SESSION['title'] = "Главная";
		include INC . 'main.php';
	} elseif ($_GET && $_GET['content'] == "Главная") {
		$SESSION['title'] = "Главная";
		include INC . 'main.php';
	} elseif ($_GET && $_GET['content'] == "Загадки") {
		$SESSION['title'] = "Загадки";
		include INC . 'riddles.php';
	} elseif ($_GET && $_GET['content'] == "Прочее") {
		$SESSION['title'] = "Прочее";
		include INC . 'advanced.php';
	} elseif ($_GET && $_GET['content'] == "Службы") {
		$SESSION['title'] = "Службы";
		include INC . 'services.php';
	} elseif ($_GET && $_GET['content'] == "404") {
		$SESSION['title'] = "Ошибка 404";
		include INC . '404.php';
	} elseif ($_GET && $_GET['content'] == "403") {
		$SESSION['title'] = "Ошибка 403";
		include INC . '403.php';
	} else {
		$SESSION['title'] = "Ошибка";
		include INC . '404.php';
	}
// назначение заголовка страницы
if ($SESSION && $SESSION['title']){
	$title = $SESSION['title'];
} else {
	$title = 'Заголовок страницы';
}
?>

<title><?php echo $title; ?></title>



