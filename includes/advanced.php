<!-- блок отображения данных -->
<div id="main">
	<!-- заголовок страницы -->
	<h1><?php echo $SESSION['title'];?></h1>
	<!-- применение javascript кода -->
	<script type="text/javascript">
		function makeHidden(textarea_id){
			// скрытие подсказок и текста у блоков textarea
			let textareas = document.querySelectorAll('div');
			for (let elem of textareas){
				if (elem.id.indexOf('hint' + textarea_id)!= -1){
					document.getElementById('hint' + textarea_id).hidden = true;
					document.getElementById('area' + textarea_id).innerHTML = "";
				}
			}
		}
		function showHint(textarea_id){
			// показ подсказок и текста у блоков textarea
			let textareas = document.querySelectorAll('div');
			let hint_messages = ['Подсказка для поля 1', 'Подсказка для поля 2', 'Подсказка для поля 3']
			let textarea_messages = ['Содержимое поля 1', 'Содержимое поля 2', 'Содержимое поля 3']
			for (let elem of textareas){
				if (elem.id.indexOf('hint' + textarea_id)!= -1){
					document.getElementById('hint' + textarea_id).innerHTML = hint_messages[textarea_id-1];
					document.getElementById('area' + textarea_id).innerHTML = textarea_messages[textarea_id-1];
					document.getElementById('hint' + textarea_id).hidden = false;
				}

			}
		}
		function showFullImage(){
			// показ картинки в новом окне
		 	let width = main_image.naturalWidth;
		 	let height = main_image.naturalHeight;
		 	if (width >= screen.width){
		 		width = 0.9 * screen.width;
		 	}
		 	if (height >= screen.height){
		 		height = 0.9 * screen.height;
		 	}
		 	window.open(main_image.src, "Image", "width=" + width + ", height=" + height);
		}
	</script>
	<!-- блок текстовых элементов ввода -->
	<div id="text_edit">
		<!-- корень формы -->
		<form action="./index.php?content=Прочее" method="POST">
			<!-- формирование табличной вёрстки -->
			<div class="table-colgroup">
				<div class="table-col"></div>
				<div class="table-col"></div>
			</div>
			<div class="table-tbody">
				<div class="table-tr">
					<div class="table-td">
						<!-- зона текстового ввода -->
						<textarea class="textarea" id="area1" onclick="showHint(1)" onblur="makeHidden(1)"></textarea><br />
					</div>
					<div class="table-td">
						<!-- зона подсказки -->
						<div class="hint" id="hint1" hidden></div><br />
					</div>
				</div>
				<div class="table-tr">
					<div class="table-td">
						<!-- зона текстового ввода -->
						<textarea class="textarea" id="area2" onclick="showHint(2)" onblur="makeHidden(2)"></textarea><br />
					</div>
					<div class="table-td">
						<!-- зона подсказки -->
						<div class="hint" id="hint2" hidden></div><br />
					</div>
				</div>
				<div class="table-tr">
					<div class="table-td">
						<!-- зона текстового ввода -->
						<textarea class="textarea" id="area3" onclick="showHint(3)" onblur="makeHidden(3)"></textarea><br />
					</div>
					<div class="table-td">
						<!-- зона подсказки -->
						<div class="hint" id="hint3" hidden></div><br />
					</div>
				</div>
			</div>
		</form>
	</div>
	<hr>
	<!-- блок с изображением -->
	<div id="image_block" onclick="showFullImage()">
		<img id="main_image" width="100%"src="<?php echo IMG . "main.jpg";?>" alt="Main images"  />
	</div>
</div>