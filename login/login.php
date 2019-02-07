<?php
include('../header.php');
include('../navbar.php');
?>

<main>
	<div class="caption">
	Ошибка авторизации:
	</div>

	<section class="form" id="login_error_form">
		<?php
		if ( isset($_POST['login']) and isset($_POST['password']) ) {
			if ( $_POST['login'] =='' or $_POST['password'] == '' ) {
				echo "<br><br>Введите пожалуйста логин и пароль!";
			} else {
				$_SESSION['user_id']=login_user($link, $_POST['login'], $_POST['password']);
				if ($_SESSION['user_id']==0){
					unset($_SESSION['user_id']);
					echo "<br><br>Извините, введённый вами логин или пароль неверный.";
				}
				else {
					echo "<meta http-equiv='Refresh' content='0; URL=/index.php'>";
				}
			}
		}else{
			echo "<br><br>Нет логина или пароля!";
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