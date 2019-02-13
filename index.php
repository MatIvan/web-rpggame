<?php
include('header.php');
include('navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
		Добро пожаловать в игру "RPG web game" !!!
	</div>
	<?php if( empty($_SESSION['user_id']) ): ?>
		<form class="all-forms all-forms_login-form" action="login/login.php" method="POST">
			<div class="all-forms__caption">Вход:</div>
			<input class="all-forms__input-text" type="text" name="login" placeholder="Логин">
			<input class="all-forms__input-text"type="password" name="password" placeholder="Пароль">
			<input class="all-forms__btn all-forms__btn_center" type="submit" value="OK" name="submit" >
		</form>
		<div class="navbar navbar_center">
			<a class="navbar__a" href="/login/registration.php">Регистрация</a>
		</div>
	<?php else: ?>
		<div class="all-forms all-forms_login-form">
			<div class="all-forms__caption">
				Привет, <?= $_SESSION['user_login'] ?> !!!
			</div>
			<div>
				на балансе: <strong> <?= $_SESSION['user_balance'] ?> </strong> очков.
			</div>
			<div class="navbar navbar_center">
				<a class="navbar__a" href="/game/warriors.php">Показать моих бойцов</a>
			</div>
		</div>
	<?php endif ?>
</main>

<?php
include('footer.php');
?>