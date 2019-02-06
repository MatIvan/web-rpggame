<nav>
	<ul>
		<li><a href="/index.php">Главная</a></li>
		<li><a href="#">Правила</a></li>
		
		<?php if(empty($login) and empty($user_id)): ?>
			<li><a href="/login/registration.php">Регистрация</a></li>
		<?php else: ?>
			<li><a href="#">Боец</a></li>
			<li><a href="#">Сразиться</a></li>
			<li><a href="#">История</a></li>
			<li><a href="#">Профиль</a></li>
			<li><a href="#">Выход</a></li>
		<?php endif ?>
  </ul>
</nav>