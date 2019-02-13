<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
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
				if ( check_login( $_POST['login'] ) ) {
					$user = array(
						'login' => $_POST['login'],
						'password' => $_POST['password'],
						'balance' => 100 //По умолчанию всем новым пользователям 100 очков на баланс
					);
					add_new_user( $user );
                    echo "Вы успешно зарегистрировались!";
				}else{
                    echo "Пользователь с таким логином зарегистрирован!";
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