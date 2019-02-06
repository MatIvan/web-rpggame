<?php
include('header.php');
include('navbar.php');
?>

<main>
	<div class="caption">
		Регистрация нового бойца.
	</div>
	
	<section class="form" id="registration_form">
		<?php if(empty($login) and empty($user_id)) : ?>
			<div class="caption">Анкета:</div>
			<form action="new_user.php" method="POST">
				<input type="text" name="login" placeholder="Логин">
				<input type="text" name="user_name" placeholder="Имя бойца">
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
include('footer.php');
?>