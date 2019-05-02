<?php
require_once('../connect.php');
$res=$pdo->prepare("DELETE FROM `schools` WHERE `school_id`=?");
$res->execute(array($_POST['id']));
?>