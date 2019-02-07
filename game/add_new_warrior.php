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
			}elseif(!is_numeric($_POST['balance'])){
				echo "Значение баланса должно быть числом.";
			}else{
				$new_warrior = array(
					'name' => $_POST['name'],
					'balance' => $_POST['balance'],
					'hp' => $_POST['hp'],
					'attack' => $_POST['attack'],
					'shield' => $_POST['shield'],
					'user_id' => $_SESSION['user_id']
				);
				add_new_warrior( $link, $new_warrior );
                echo "Вы успешно создали нового бойца!";
			}
		}
		
		?>
		<br><br>
		<a href="/game/new_warrior.php"> <<< назад </a>
		<br><br>
		<a href="/game/warriors.php">Вернуться к бойцам</a>
		<br><br>
	</section>
</main>

<?php
include('../footer.php');
?>