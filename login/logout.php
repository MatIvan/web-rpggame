<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
		Выход:
	</div>

	<form class="all-forms all-forms_login-form">
		<?php if ( empty($_SESSION['user_id']) ): ?>
			<div class='all-forms__caption'>
				Доступ на эту страницу разрешен только зарегистрированным пользователям.
			</div>
			Если вы зарегистрированы, то войдите на сайт под своим логином и паролем.
			<br><br>
		<?php else: 
			unset($_SESSION['user_id']);
			unset($_SESSION['user_login']);
			unset($_SESSION['user_balance']);
			unset($_SESSION['user_status']);
			?>
			<div class='all-forms__caption'>
				До скорой встречи! 
			</div>
			твои бойцы будут ждать новых сражений!
			<br><br>
		<?php endif ?>
		<div class="navbar navbar_center">
			<a class="navbar__a" href="/index.php">Вернуться на главную</a>
		</div>
	</form>
</main>

<?php
include('../footer.php');
?>