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
  
	<?php if( !empty($_SESSION['user_id']) ): ?>
		<div class="user-data">
			<?= $_SESSION['user_login'] ?> (<?= $_SESSION['user_balance'] ?> очков.)
		</div>
	<?php endif ?>
</nav>