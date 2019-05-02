<?php
require_once('../connect.php');
if($_POST['school']) {
	$res=$pdo->prepare("SELECT * FROM `results` INNER JOIN `schools` ON `results`.`school_id`=`schools`.`school_id` INNER JOIN `subjects` ON `subjects`.`subject_id`=`results`.`subject_id` WHERE `results`.`subject_id`=? AND `results`.`school_id`=? ORDER BY `results`.`result` DESC");
	$res->execute(array($_POST['subject'], $_POST['school']));
} else {
	$res=$pdo->prepare("SELECT * FROM `results` INNER JOIN `schools` ON `results`.`school_id`=`schools`.`school_id` INNER JOIN `subjects` ON `subjects`.`subject_id`=`results`.`subject_id` WHERE `results`.`subject_id`=? ORDER BY `results`.`result` DESC");
	$res->execute(array($_POST['subject']));
}
$num=0;
while ($line=$res->fetch()) { ?>
	<tr>
		<td><?=++$num?></td>
		<td><?=$line['surname']?></td>
		<td><?=$line['name']?></td>
		<td><?=$line['school_name']?></td>
		<td><?=$line['subject_name']?></td>
		<td><?=$line['result']?></td>
		<td><?=$line['date']?></td>
	</tr>
<?php } ?>