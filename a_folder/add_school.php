<?php
require_once('../connect.php');
$res=$pdo->query("INSERT INTO `schools` (`school_name`) VALUES ('New school')");
$id=$pdo->lastInsertId();
?>
<div class="item">
	<input type="checkbox" id="sch-<?=$id?>">
	<div class="head">
		<p class="name">New school</p>
		<label for="sch-<?=$id?>">></label>
	</div>
	<form action="a_folder/update_sch.php" method="POST">
		<input type="hidden" name="id" value="<?=$id?>">
		<div>
			<label>Название</label>
			<input type="text" name="name" value="New school">
		</div>
		<div>
			<input type="submit" class="btn add" value="Сохранить">
			<button type="button" class="btn delete" data-id="<?=$id?>">Удалить</button>
		</div>
	</form>
</div>