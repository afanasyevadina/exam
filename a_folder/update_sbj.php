<?php
require_once('../connect.php');
if(!is_dir('../content/'.$_POST['id'])) {
	mkdir('../content/'.$_POST['id']);
}
if($_FILES['text']['tmp_name']) {
	$fn='content/'.$_POST['id'].'/text.txt';
	move_uploaded_file($_FILES['text']['tmp_name'], '../'.$fn);

	$text=file_get_contents('../'.$fn);
	$text=preg_replace('|<img src="(.*)">|isU', '<img src="/content/'.$_POST['id'].'/'."$1".'">', $text);
	file_put_contents('../'.$fn, $text);


	$res=$pdo->prepare("UPDATE `subjects` SET `subject_name`=?, `count`=?, `five`=?, `four`=?, `three`=?, `lang`=?, `subject_path`=? WHERE `subject_id`=?");
	$res->execute(array(
		$_POST['name'],
		$_POST['count'],
		$_POST['five'],
		$_POST['four'],
		$_POST['three'],
		$_POST['lang'],
		$fn,
		$_POST['id']
	));
} else {

	$res=$pdo->prepare("UPDATE `subjects` SET `subject_name`=?, `count`=?, `five`=?, `four`=?, `three`=?, `lang`=? WHERE `subject_id`=?");
	$res->execute(array(
		$_POST['name'],
		$_POST['count'],
		$_POST['five'],
		$_POST['four'],
		$_POST['three'],
		$_POST['lang'],
		$_POST['id']
	));
}


if($_FILES['image']) {
	foreach ($_FILES['image']['tmp_name'] as $key => $tmp) {
		move_uploaded_file($tmp, '../content/'.$_POST['id'].'/'.$_FILES['image']['name'][$key]);
	}
}

header('Location: /admin');
?>