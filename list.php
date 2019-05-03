<?php
require_once('connect.php');
$res=$pdo->prepare("SELECT * FROM `subjects` WHERE `lang`=?");
$res->execute(array($_POST['lang']));
while($subject=$res->fetch()) { ?>
<input type="radio" name="subject" value="<?=$subject['subject_id']?>" id="<?=$subject['subject_id']?>" class="subject">
<label for="<?=$subject['subject_id']?>" class="subject"><?=$subject['subject_name']?></label>
<?php }
?>