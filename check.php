<?php
require_once('connect.php');
$test=[];
$fn=$pdo->prepare("SELECT * FROM `subjects` WHERE `subject_id`=?");
$fn->execute(array($_POST['subject']));

$main=$fn->fetch();

$all=file_get_contents(__DIR__."\\".$main['subject_path']);

foreach(explode("\n", $all) as $key => $str) {
	if(mb_substr($str, 0,1)=='+') {
		$test[]=trim(mb_substr($str, 3));
	}
}
$sbj=$_POST['subject'];
$name=$_POST['name'];
$sname=$_POST['surname'];
$sch=$_POST['school'];
unset($_POST['subject']);
unset($_POST['name']);
unset($_POST['surname']);
unset($_POST['school']);
$balls=0;
foreach ($_POST as $key => $value) {
	if(trim($_POST[$key])==$test[$key]) {
		$balls++;		
	}
}
if($balls>=$main['five']) {
	$rating=5;
} else if($balls>=$main['four']) {
	$rating=4;
} else if($balls>=$main['three']) {
	$rating=3;
} else {
	$rating=2;
}
$res=$pdo->prepare("INSERT INTO `results` (`name`, `surname`, `school_id`, `subject_id`, `result`, `date`) VALUES (?,?,?,?,?, NOW())");
$res->execute(array($name, $sname, $sch, $sbj, $balls));
echo json_encode(array(
	'balls'=>$balls,
	'rating'=>$rating,
	'keys'=>$test
));
?>