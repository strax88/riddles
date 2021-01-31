<!-- блок отображения данных -->
<div id="main">
	<h1><?php echo $SESSION['title'];?></h1>
	404. Нет такой страницы!
	<?php
		include_once INC . "services.php";
		refreshPage("./index.php", 3);
	?>
</div>