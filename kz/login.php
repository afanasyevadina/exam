<?php
require_once('../connect.php');
setcookie('hash', '', time()-3600);
$_SESSION['hash']='';
if(!empty($_POST)) {
	$res=$pdo->prepare("SELECT * FROM `users` WHERE `login`=? AND `password`=?");
	$res->execute(array($_POST['login'], $_POST['password']));
	if($user=$res->fetch()) {
		setcookie('hash', $user['hash']);
		$_SESSION['hash']=$user['hash'];
		header('Location: /kz/admin');
	} else {
		$message="Дұрыс емес!";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Вход</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../css/style.css">
	</head>
<body>
<?php require_once('layout.php'); ?>
<main>
	<form action="login.php" method="POST" >
		<div class="personal">
			<p class="h">Кіру</p>
			<p class="error"><?=$message?></p>
			<div>
				<input type="text" name="login" autocomplete="off" required>
				<label>Логин</label>
			</div>
			<div>
				<input type="password" name="password" autocomplete="off">
				<label>Пароль</label>
			</div>
			<input class="ready" type="submit" value="Кіру">
		</div>
	</form>
</main>
</body>
</html>