<header>
	<nav>
		<a href="/kz/">Тестілеу</a>
		<?php if($user) { ?>
		<a href="/kz/admin">Админ-панель</a>
	<?php } ?>
		<a href="/kz/login"><?=$user?'Шығу':'Кіру'?></a>
	</nav>
	<div class="lang">
		<a href="/<?=basename($_SERVER['REQUEST_URL'])?>">RU</a>
		<span>/</span>
		<a href="/kz/<?=basename($_SERVER['REQUEST_URL'])?>">KZ</a>
	</div>
</header>