<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
	Создание нового бойца:
	</div>

	<form class="all-forms all-forms_login-form">
		<div class='all-forms__caption'>
		<?php
		if (isset($_POST['submit'])){
			if(empty($_POST['name']))  {
				echo "Укажите имя бойца!";
			} elseif (!preg_match("/^\w{3,}$/", $_POST['name'])) {
				echo "В поле <Имя бойца> введены недопустимые символы! <br> Только буквы, цифры и подчеркивание.";
			}elseif(!is_numeric($_POST['hp'])){
				echo "Значение жизни должно быть числом.";
			}elseif(!is_numeric($_POST['attack'])){
				echo "Значение уровня атаки должно быть числом.";
			}elseif(!is_numeric($_POST['shield'])){
				echo "Значение уровня защиты должно быть числом.";
			}else{
				$new_warrior = array(
					'id' => $_POST['id'],
					'name' => $_POST['name'],
					'hp' => $_POST['hp'],
					'attack' => $_POST['attack'],
					'shield' => $_POST['shield'],
					'user_id' => $_SESSION['user_id']
				);
				$new_balance = calculate_balance($new_warrior);
				if ( $new_balance >= 0 ) {

					//Новый боец или изменение старого ?
					if( $new_warrior['id']==="0" ){
						$res_war = add_new_warrior( $new_warrior );
					}else{
						$res_war = edit_warrior( $new_warrior );
					}

					//Результат сохранинея в БД
					if ( $res_war == -1 ){
						echo "Что-то пошло не так!";
					}else{
						echo "Вы успешно изменили бойца!";
					}

					//Обновить баланс в БД
					if ( set_user_balance( $_SESSION['user_id'], $new_balance ) ){
						echo "Ваш баланс обновлён.";
					}else{
						echo "Ошибка обновления баланса.";
					}

					$_SESSION['user_balance'] = get_user_balance( $_SESSION['user_id'] );


				}elseif ($new_balance === -99999 ){
					echo "Ошибка чтения Базы Данных";
				}else{
					echo "Сумма параметров не должна превышать остаток баланса.";
				}
			}
		}
		
		?>
		</div>
		<br><br>
		<div class="navbar navbar_center">
			<a class="navbar__a" href="/game/warriors.php">Вернуться к бойцам</a>
		</div>
	</form>
</main>

<?php
include('../footer.php');
?>