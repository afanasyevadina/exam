<?php
require_once('../connect.php');
$res=$pdo->query("INSERT INTO `subjects` (`subject_name`) VALUES ('New subject')");
$id=$pdo->lastInsertId();
?>
<div class="item">
	<input type="checkbox" id="<?=$id?>">
	<div class="head">
		<p class="name">New subject</p>
		<label for="<?=$id?>">></label>
	</div>
	<form action="a_folder/update_sbj.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$id?>">
		<div>
			<label>Название предмета</label>
			<input type="text" name="name" value="New subject">
		</div>
		<div>
			<label>Всего вопросов</label>
			<input type="number" name="count" min="0" max="100" value="0">
		</div>
		<div>
			<label>На оценку "5"</label>
			<button class="minus" type="button">-</button>
			<input type="range" name="five" min="0" max="0" value="0">
			<button class="plus" type="button">+</button>
			<span><?=$subject['five']?></span>
		</div>
		<div>
			<label>На оценку "4"</label>
			<button class="minus" type="button">-</button>
			<input type="range" name="four" min="0" max="0" value="0">
			<button class="plus" type="button">+</button>
			<span><?=$subject['four']?></span>
		</div>
		<div>
			<label>На оценку "3"</label>
			<button class="minus" type="button">-</button>
			<input type="range" name="three" min="0" max="0" value="0">
			<button class="plus" type="button">+</button>
			<span><?=$subject['three']?></span>
		</div>
		<div>
			<label>Тесты</label>
			<input type="file" name="text" accept="text/plain">
		</div>
		<div>
			<label>Приложения (картинки)</label>
			<input type="file" name="image[]" accept="image/*" multiple>
		</div>
		<div>
			<input type="submit" class="btn add" value="Сохранить">
			<button type="button" class="btn delete" data-id="<?=$id?>">Удалить</button>
		</div>
	</form>
</div>