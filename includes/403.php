<!-- блок отображения данных -->
<div id="main">
	<h1><?php echo $SESSION['title'];?></h1>
	403. Доступ запрещён!
	<?php
		include_once INC . "services.php";
		refreshPage(INC . "../../index.php", 2);
	?>
</div>