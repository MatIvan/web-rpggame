<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
		Ошибка авторизации:
	</div>
	<form class="all-forms all-forms_login-form">
		<?php
		if ( isset($_POST['login']) and isset($_POST['password']) ) {
			if ( $_POST['login'] =='' or $_POST['password'] == '' ) {
				echo "<div class='all-forms__caption'>Введите логин и пароль.</div>";
			} else {
				$_SESSION['user_id']=login_user( $_POST['login'], $_POST['password']);
				if ($_SESSION['user_id']==0){
					unset($_SESSION['user_id']);
					unset($_SESSION['user_login']);
					unset($_SESSION['user_balance']);
					echo "<div class='all-forms__caption'>Логин или пароль неверный.</div>";
				}
				else {
					$user = get_user_by_id( $_SESSION['user_id'] );
					$_SESSION['user_login'] = $user["login"];
					$_SESSION['user_balance'] = $user["balance"];
					echo "<meta http-equiv='Refresh' content='0; URL=/index.php'>";
				}
			}
		}else{
			echo "<div class='all-forms__caption'>Введите логин и пароль.</div>";
		}
		?>
		<div class="navbar navbar_center">
			<a class="navbar__a" href="/index.php">Вернуться на главную</a>
		</div>
	</form>
</main>

<?php
include('../footer.php');
?>