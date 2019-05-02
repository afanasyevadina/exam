<?php
require_once('../connect.php');
$res=$pdo->prepare("DELETE FROM `subjects` WHERE `subject_id`=?");
$res->execute(array($_POST['id']));
?>