<?php
require_once('../connect.php');
$res=$pdo->prepare("UPDATE `schools` SET `school_name`=? WHERE `school_id`=?");
$res->execute(array($_POST['name'], $_POST['id']));
header('Location: /admin');
?>