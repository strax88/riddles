<!DOCTYPE html>
<!-- шаблон системы -->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!-- установка файла со стилями -->
	<link rel="stylesheet" type="text/css" href="<?php echo CSS . "main.css";?>?rev.1.4">
</head>
<body>
	<!-- заголовок страницы -->
	<header>Web программист / Стажер в компанию ИнвестТрейд</header>
	<!-- содержимое страницы -->
	<content><?php include INC . 'content.php'; ?>
	<!-- меню -->
	<div id="menu"><?php include_once INC . "menu.php";?></div>
	</content>
	<!-- подвал страницы -->
	<footer>Выполнил Стрелковский Кирилл &copy; 2021</footer>
</body>
</html>