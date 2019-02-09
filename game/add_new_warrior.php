<?php
include('../header.php');
include('../navbar.php');
?>

<main>
	<div class="caption">
	Создание нового бойца:
	</div>

	<section class="form" id="new_warrior">
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
				
				if( $new_warrior['id']==="0" ){
					if ( add_new_warrior( $new_warrior ) === 0 ){
						echo "Что-то пошло не так: Боец не был создан!!!";
					}else{
						echo "Вы успешно создали нового бойца!";
					}
				}else{
					if ( edit_warrior( $new_warrior ) === 0 ){
						echo "Что-то пошло не так: Боец не был изменен!!!";
					}else{
						echo "Вы успешно изменили бойца!";
					}
				}
			}
		}
		
		?>
		<br><br>
		<a href="/game/warriors.php">Вернуться к бойцам</a>
		<br><br>
	</section>
</main>

<?php
include('../footer.php');
?>