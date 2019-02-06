<?php
include('../header.php');
include('../navbar.php');
?>

<main>
	<div class="caption">
		Регистрация нового пользователя.
	</div>
	
	<section class="form" id="registration_form">
		<?php if( $_SESSION['user_id']==0 ) : ?>
			<div class="caption">Анкета:</div>
			<form action="new_user.php" method="POST">
				<input type="text" name="login" placeholder="Логин">
				<input type="password" name="password" placeholder="Пароль">
				<input type="password" name="password2" placeholder="Повторите пароль">
				<br><br>
				<input class="btn" type="submit" value="Зарегистрировать" name="submit" >
			</form>
			<br>
		<?php else: ?>
			<?php 
			include("welcome_form.php");
			?>
		<?php endif ?>
	</section>
</main>

<?php
include('../footer.php');
?>