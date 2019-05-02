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
<header></header>
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
<script type="text/javascript">

	$('.subject').change(function() {
		$('.personal .ready').removeAttr('disabled');
	});

	$('.ready').click(function(e){
		e.preventDefault();
		var subject;
		$('.subject').each(function(){
			if($(this).prop('checked')) {
				subject=$(this).val();
			}
		});
		$.ajax({
			url: 'test.php',
			method: 'POST',
			data: 'subject='+subject,
			dataType: 'html',
			success: function(response) {
				$('.personal').fadeOut();
				$('.test').html(response);
				setTimeout(function(){
					$('.test').fadeIn();
				},400);
			}
		});
		return false;
	});
	$('form').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			dataType: 'html',
			method: $(this).attr('method'),
			data: $(this).serialize(),
			success: function(response) {
				var result=$.parseJSON(response);
				$('#message').html(result.text);
				$('.test input').each(function(){
					if($(this).val()==result.keys[$(this).attr('name')]) {
						$(this).parent().css('background-color', '#B6FFB4');
					} else if($(this).prop('checked')) {
						$(this).parent().css('background-color', '#FFC9C9');
					}
				});
				$(window).scrollTop(0);
				$('input[type=submit]').remove();
			}
		});
		return false;
	});
</script>
</body>
</html>