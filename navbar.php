<nav>
	<ul>
		<li><a href="/index.php">Главная</a></li>
		<li><a href="#">Правила</a></li>
		
		<?php if( empty($_SESSION['user_id']) ): ?>
			<li><a href="/login/registration.php">Регистрация</a></li>
		<?php else: ?>
			<li><a href="/game/warriors.php">Бойцы</a></li>
			<li><a href="#">Сразиться</a></li>
			<li><a href="#">История</a></li>
			<li><a href="/login/logout.php">Выход</a></li>
		<?php endif ?>
  </ul>
</nav>