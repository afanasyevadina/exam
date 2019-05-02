<?php
require_once('connect.php');
$test=[];
$question=[];
$line=0;
$fn=$pdo->prepare("SELECT * FROM `subjects` WHERE `subject_id`=?");
$fn->execute(array($_POST['subject']));

$main=$fn->fetch();

$all=file_get_contents(__DIR__."\\".$main['subject_path']);
foreach(explode("\n", $all) as $str) {
	$line++;
	if($line%6==1) {
		$question=[];
		$question['question']=mb_substr($str, 3);
	} else {
		if(mb_substr($str, 0,1)=='+') {
			$str=mb_substr($str, 1);
			$key='true';
		} else {
			$key='false';
		}
		$question['answers'][]=['text'=>mb_substr($str, 3), 'key'=>$key];
	}	
	if($line%6==0) {
		$test[]=$question;
	}
}
$shuffleKeys = array_keys($test);
shuffle($shuffleKeys);
$newArray = array();
foreach($shuffleKeys as $key) {
    $newArray[$key] = $test[$key];
}
$num=0;
foreach (array_slice($newArray, 0, $main['count'], true) as $key => $question) {
	shuffle($question['answers']); ?>
	<p><?=++$num.'. '.$question['question']?></p>
	<label>
		<input type="radio" name="<?=$key?>" value="<?=trim($question['answers'][0]['text'])?>"><?=$question['answers'][0]['text']?>
	</label>
	<label>
		<input type="radio" name="<?=$key?>" value="<?=trim($question['answers'][1]['text'])?>"><?=$question['answers'][1]['text']?>
	</label>
	<label>
		<input type="radio" name="<?=$key?>" value="<?=trim($question['answers'][2]['text'])?>"><?=$question['answers'][2]['text']?>
	</label>
	<label>
		<input type="radio" name="<?=$key?>" value="<?=trim($question['answers'][3]['text'])?>"><?=$question['answers'][3]['text']?>
	</label>
	<label>
		<input type="radio" name="<?=$key?>" value="<?=trim($question['answers'][4]['text'])?>"><?=$question['answers'][4]['text']?>
	</label>
<?php } ?>
<input type="submit" value="Проверить" class="ready">