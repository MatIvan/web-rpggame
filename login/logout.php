<?php
include('../header.php');
include('../navbar.php');
?>

<main>
	<div class="caption">
	Выход:
	</div>

	<section class="form" id="login_error_form">
		<?php
		
		if ( empty($_SESSION['user_id']) ) {
			echo "Доступ на эту страницу разрешен только зарегистрированным пользователям. Если вы зарегистрированы, то войдите на сайт под своим логином и паролем";
		}else{
			unset($_SESSION['user_id']);
			echo "До скорой встречи, <br> твои бойцы будут ждать новых сражений!";
		}
		?>
		<br><br>
		<a href="/index.php">Вернуться на главную</a>
		<br><br>
	</section>
</main>

<?php
include('../footer.php');
?>