<?php
require_once('connect.php');
$schools=$pdo->query("SELECT * FROM `schools`");
$subjects=$pdo->query("SELECT * FROM `subjects`");
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
			<button class="ready" disabled="disabled">Приступить</button>
		</div>
		<div id="message"></div>
		<div class="test"></div>
	</form>
</main>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>