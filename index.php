<?php
require_once('connect.php');
$schools=$pdo->query("SELECT * FROM `schools`");
$subjects=$pdo->query("SELECT * FROM `subjects`");
$hash=$_COOKIE['hash'] ?? $_SESSION['hash'];
$ur=$pdo->prepare("SELECT * FROM `users` WHERE `hash`=?");
$ur->execute(array($hash));
$user=$ur->fetch();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Пробное тестирование</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
<body>
<?php require_once('layout.php'); ?>
<main>
	<form action="check.php" method="POST" >
		<div class="personal">
			<div>
				<input type="text" name="name" autocomplete="off" required>
				<label>Фамилия</label>
			</div>
			<div>
				<input type="text" name="surname" autocomplete="off" required>
				<label>Имя</label>
			</div>
			<div>
				<select name="school">
					<?php while ($school=$schools->fetch()) { ?>
						<option value="<?=$school['school_id']?>"><?=$school['school_name']?></option>
					<?php } ?>
				</select>
				<label>Школа</label>
			</div>
			<?php while($subject=$subjects->fetch()) { ?>
				<input type="radio" name="subject" value="<?=$subject['subject_id']?>" id="<?=$subject['subject_id']?>" class="subject">
				<label for="<?=$subject['subject_id']?>" class="subject"><?=$subject['subject_name']?></label>
			<? } ?>
			<button class="ready" id="start" disabled="disabled">Приступить</button>
		</div>
		<div id="message">
			<p>Набрано баллов: <span class="balls"></span></p>
			<p>Оценка: <span class="rating"></span></p>
		</div>
		<div class="test"></div>
		<input type="submit" value="Проверить" class="ready" id="finish">
	</form>
</main>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>