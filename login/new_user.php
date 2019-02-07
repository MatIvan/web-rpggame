<?php
include('../header.php');
include('../navbar.php');
?>

<main>
	<div class="caption">
	Регистрация нового пользователя:
	</div>

	<section class="form" id="login_error_form">
		<?php
		if (isset($_POST['submit'])){
			if(empty($_POST['login']))  {
				echo "Введите логин!";
			} elseif (!preg_match("/^\w{3,}$/", $_POST['login'])) {
				echo "В поле <Логин> введены недопустимые символы! <br> Только буквы, цифры и подчеркивание.";
			} elseif(empty($_POST['password'])) {
				echo "Введите пароль!";
			}elseif (!preg_match("/\A(\w){6,20}\Z/", $_POST['password'])) {
				echo "Пароль слишком короткий! <br> Пароль должен быть не менее 6 символов!";
			}elseif(empty($_POST['password2'])) {
				echo "Введите подтверждение пароля!";
			}elseif($_POST['password'] != $_POST['password2']) {
				echo "Введенные пароли не совпадают!";
			}else{
				$login = $_POST['login'];
				$password = $_POST['password'];
				$mdPassword = md5($password);
				$password2 = $_POST['password2'];
              
				$sql = "SELECT id FROM users WHERE login='$login'";
				$result = mysqli_query($link, $sql) or die(mysqli_error());
            
				if (mysqli_num_rows($result) > 0) {
					echo "Пользователь с таким логином зарегистрирован!";
				}else{
                    $sql = "INSERT INTO users ( login, password ) VALUES ('$login', '$mdPassword' )";
                    $result = mysqli_query($link, $sql) or die(mysqli_error());;
                    echo "Вы успешно зарегистрировались!";
				}
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