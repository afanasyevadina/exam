<?php
require_once('connect.php');
$schoolres=$pdo->query("SELECT * FROM `schools`");
$schools=$schoolres->fetchAll();
$subjectres=$pdo->query("SELECT * FROM `subjects`");
$subjects=$subjectres->fetchAll();
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
			<?php foreach($subjects as $subject) { ?>
				<div class="item">
					<input type="checkbox" id="<?=$subject['subject_id']?>">
					<div class="head">
						<p class="name"><?=$subject['subject_name']?></p>
						<label for="<?=$subject['subject_id']?>">></label>
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
							<label>Тесты</label>
							<input type="file" name="text" accept="text/plain">
						</div>
						<div>
							<label>Приложения (картинки)</label>
							<input type="file" name="image[]" accept="image/*" multiple>
						</div>
						<div>
							<input type="submit" class="ready" value="Сохранить">
						</div>
					</form>
				</div>
			<?php } ?>
		</div>
		<div class="schools">
			<p class="h">Школы</p>
		</div>
	</div>
</main>
<script src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	function Load(url, data, target) {
		$.ajax({
			url: url,
			method: 'POST',
			data: data,
			dataType: 'html',
			success: function(response) {
				console.log(response);
				target.html(response);
			}
		});
	}
	Load('a_folder/getresults.php', 'school='+$('#school_select').val()+'&subject='+$('#subject_select').val(), $('.results tbody'));
	$('#results_btn').click(function() {
		$('.panel a').removeClass('active');
		$(this).addClass('active');
		$('.content>div').css('transform', 'translateX(0)');
	});
	$('#schools_btn').click(function() {
		$('.panel a').removeClass('active');
		$(this).addClass('active');
		//Load('schools/getschools.php', '', $('.schools .data'));
		$('.content>div').css('transform', 'translateX(-200%)');
	});
	$('#subjects_btn').click(function() {
		$('.panel a').removeClass('active');
		$(this).addClass('active');
		//Load('subjects/getsubjects.php', '', $('.subjects .data'));
		$('.content>div').css('transform', 'translateX(-100%)');
	});
	$('.filter select').change(function(){
		Load('a_folder/getresults.php', 'school='+$('#school_select').val()+'&subject='+$('#subject_select').val(), $('.results tbody'));
	});

	$('input[type=range]').change(function(){
		$(this).parent().find('span').html($(this).val());
	});

	$('input[name=count]').change(function(){
		var max=$(this).val();
		$(this).parent().parent().find('input[type=range]').each(function(){
			$(this).attr('max', max);
		});
	});

	$('.minus').click(function(){
		var input=$(this).parent().find('input');
		var val=parseInt(input.val(),10);
		val--;
		if(parseInt(input.attr('min'),10)<=val) {
			input.val(val);
			$(this).parent().find('span').html(val);
		}
	});

	$('.plus').click(function(){
		var input=$(this).parent().find('input');
		var val=parseInt(input.val(),10);
		val++;
		if(parseInt(input.attr('max'),10)>=val) {
			input.val(val);
			$(this).parent().find('span').html(val);
		}
	});

</script>
</body>
</html>