<?php
// главная страница
	include_once 'config.php';
	session_start();
	$SESSION['title'] = 'Главная страница';
	include INC . 'template.php';
	session_destroy();