<nav class="navbar">
	<a class="navbar__a" href="/index.php">Главная</a>
	<a class="navbar__a" href="#">Правила</a>
	<?php if( empty($_SESSION['user_id']) ): ?>
		<a class="navbar__a" href="/login/registration.php">Регистрация</a>
	<?php else: ?>
		<a class="navbar__a" href="/game/warriors.php">Бойцы</a>
		<a class="navbar__a" href="/game/select_apponent.php">Сразиться</a>
		<a class="navbar__a" href="/game/history.php">История</a></li>
		<a class="navbar__a" href="/login/logout.php">Выход</a>
	<?php endif ?>
</nav>