<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
		Регистрация нового пользователя.
	</div>
	<form class="all-forms all-forms_login-form" action="new_user.php" method="POST">
		<?php if( empty($_SESSION['user_id']) ) : ?>
			<div class="all-forms__caption">Анкета:</div>
			<input class="all-forms__input-text all-forms__input-text_center" type="text" name="login" placeholder="Логин">
			<input class="all-forms__input-text all-forms__input-text_center" type="password" name="password" placeholder="Пароль">
			<input class="all-forms__input-text all-forms__input-text_center" type="password" name="password2" placeholder="Повторите пароль">
			<input class="all-forms__btn all-forms__btn_center" type="submit" value="Зарегистрировать" name="submit" >
		<?php else: ?>
			<?php 
			echo "<meta http-equiv='Refresh' content='0; URL=/index.php'>";
			?>
		<?php endif ?>
	</form>
</main>

<?php
include('../footer.php');
?>