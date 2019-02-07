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
		if (isset($_POST['login'])) {
			$login = $_POST['login']; 
		}
		if (isset($_POST['password'])) {
			$password=$_POST['password']; 
		}
		
		if ( $password =='' or $login == '' ) {
			echo "<br><br>Введите пожалуйста логин и пароль!";
		} else {
			$login = stripslashes($login);
			$login = htmlspecialchars($login);
			$login = trim($login);
			 
			$password = stripslashes($password);
			$password = htmlspecialchars($password);
			$password = trim($password);
			$password = md5($password);//шифруем пароль
			 
			$result = mysqli_query($link, "SELECT id FROM users WHERE login='$login' AND password='$password'");
			$users = mysqli_fetch_array($result);
			
			if (empty($users['id'])){
				echo "<br><br>Извините, введённый вами логин или пароль неверный.";
			}
			else {
				$_SESSION['user_id']=$users['id'];
				echo "<meta http-equiv='Refresh' content='0; URL=/index.php'>";
			}
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