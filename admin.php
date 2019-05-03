<?php
require_once('connect.php');

$hash=$_COOKIE['hash'] ?? $_SESSION['hash'];
$ur=$pdo->prepare("SELECT * FROM `users` WHERE `hash`=?");
$ur->execute(array($hash));
$user=$ur->fetch();

if(!$user) {
	header('Location: /');
}

$schoolres=$pdo->query("SELECT * FROM `schools`");
$schools=$schoolres->fetchAll();
$subjectres=$pdo->query("SELECT * FROM `subjects`");
$subjects=$subjectres->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Админ-панель</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
<body>
<?php require_once('layout.php'); ?>
<main>
	<div class="panel">
		<a href="#" id="results_btn" class="active">Результаты</a>
		<a href="#" id="subjects_btn">Предметы</a>
		<a href="#" id="schools_btn">Школы</a>
	</div>
	<div class="content">
		<div class="results">
			<p class="h">Результаты тестирования</p>
			<div class="filter">
				<select id="subject_select">
					<?php foreach($subjects as $sbj) { ?>
						<option value="<?=$sbj['subject_id']?>"><?=$sbj['subject_name']?></option>
					<?php } ?>
				</select>
				<select id="school_select">
					<option value="" selected>Все школы</option>
					<?php foreach($schools as $sch) { ?>
						<option value="<?=$sch['school_id']?>"><?=$sch['school_name']?></option>
					<?php } ?>
				</select>
				<a href="a_folder/download.php" class="download"><img src="img/download.svg" alt="download"></a>
				<a class="clear"><img src="img/delete.svg" alt="delete"></a>
			</div>
			<table border="1">
				<thead>
					<th>Номер</th>
					<th>Фамилия</th>
					<th>Имя</th>
					<th>Школа</th>
					<th>Предмет</th>
					<th>Результат</th>
					<th>Дата</th>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		<div class="subjects">
			<p class="h">Предметы</p>
			<a class="add_subject" href="#">+ Добавить новый</a>
			<?php foreach($subjects as $subject) { ?>
				<div class="item">
					<input type="checkbox" id="sbj-<?=$subject['subject_id']?>">
					<div class="head">
						<p class="name"><?=$subject['subject_name']?></p>
						<label for="sbj-<?=$subject['subject_id']?>">></label>
					</div>
					<form action="a_folder/update_sbj.php" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?=$subject['subject_id']?>">
						<div>
							<label>Название предмета</label>
							<input type="text" name="name" value="<?=$subject['subject_name']?>">
						</div>
						<div>
							<label>Всего вопросов</label>
							<input type="number" name="count" min="0" max="100" value="<?=$subject['count']?>">
						</div>
						<div>
							<label>На оценку "5"</label>
							<button class="minus" type="button">-</button>
							<input type="range" name="five" min="0" max="<?=$subject['count']?>" value="<?=$subject['five']?>">
							<button class="plus" type="button">+</button>
							<span><?=$subject['five']?></span>
						</div>
						<div>
							<label>На оценку "4"</label>
							<button class="minus" type="button">-</button>
							<input type="range" name="four" min="0" max="<?=$subject['count']?>" value="<?=$subject['four']?>">
							<button class="plus" type="button">+</button>
							<span><?=$subject['four']?></span>
						</div>
						<div>
							<label>На оценку "3"</label>
							<button class="minus" type="button">-</button>
							<input type="range" name="three" min="0" max="<?=$subject['count']?>" value="<?=$subject['three']?>">
							<button class="plus" type="button">+</button>
							<span><?=$subject['three']?></span>
						</div>
						<div>
							<label>
								<input type="radio" name="lang" value="kz" <?=$subject['lang']=='kz'?'checked':''?>>Казахский</label>
							<label>
								<input type="radio" name="lang" value="ru" <?=$subject['lang']=='ru'?'checked':''?>>Русский</label>
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
							<button type="button" class="btn delete" data-id="<?=$subject['subject_id']?>">Удалить</button>
						</div>
					</form>
				</div>
			<?php } ?>
		</div>
		<div class="schools">
			<p class="h">Школы</p>
			<a class="add_school" href="#">+ Добавить новую</a>
			<?php foreach ($schools as $school) { ?>
				<div class="item">
					<input type="checkbox" id="sch-<?=$school['school_id']?>">
					<div class="head">
						<p class="name"><?=$school['school_name']?></p>
						<label for="sch-<?=$school['school_id']?>">></label>
					</div>
					<form action="a_folder/update_sch.php" method="POST">
						<input type="hidden" name="id" value="<?=$school['school_id']?>">
						<div>
							<label>Название</label>
							<input type="text" name="name" value="<?=$school['school_name']?>">
						</div>
						<div>
							<input type="submit" class="btn add" value="Сохранить">
							<button type="button" class="btn delete" data-id="<?=$school['school_id']?>">Удалить</button>
						</div>
					</form>
				</div>
			<?php } ?>
		</div>
	</div>
</main>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/admin.js"></script>
</body>
</html>