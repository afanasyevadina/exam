<header>
	<nav>
		<a href="/">Тестирование</a>
		<?php if($user) { ?>
		<a href="/admin">Админ-панель</a>
	<?php } ?>
		<a href="/login"><?=$user?'Выход':'Войти'?></a>
	</nav>
	<div class="lang">
		<a href="/<?=basename($_SERVER['REQUEST_URL'])?>">RU</a>
		<span>/</span>
		<a href="/kz/<?=basename($_SERVER['REQUEST_URL'])?>">KZ</a>
	</div>
</header>