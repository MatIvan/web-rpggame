<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	<div class="main-block__caption">
		<?php if (isset($_GET["id"])): ?>
			Изменить параметры бойца:
		<?php else: ?>
			Создать нового бойца:
		<?php endif ?>
	</div>
	
	<?php if( empty($_SESSION['user_id']) ): ?>
		<section class="form" id="login_error_form">
			Необходимо войти на сайт.";
			<br><br>
			<a href="/index.php">Вернуться на главную</a>
			<br><br>
		</section>
	<?php else: ?>
		<section class="form" id="new_warrior">
			<div class="caption">Укажите характеристики:</div>
			<?php 
				if (isset($_GET["id"])){
					$warrior = get_warrior_by_id( $_GET["id"] );
					$bnt_val="Изменить";
				}else{
					$warrior = array(
					'id' => "0",
					'name' => "",
					'hp' => "",
					'attack' => "",
					'shield' => ""
					);
					$bnt_val="Создать";
				}
			?>
			<form action="add_new_warrior.php" method="POST">
				<input hidden="true" type="text" name="id" value= <?= $warrior["id"] ?>  >
				<input type="text" name="name" placeholder="Имя бойца" value= <?= $warrior["name"] ?> >
				<input type="text" name="hp" placeholder="Жизнь" value= <?= $warrior["hp"] ?> >
				<input type="text" name="attack" placeholder="Атака" value= <?= $warrior["attack"] ?> >
				<input type="text" name="shield" placeholder="Защита" value= <?= $warrior["shield"] ?> >
				<br><br>
				<input class="btn" type="submit" value="<?= $bnt_val ?>" name="submit" >
			</form>
			<br>
		</section>
	<?php endif ?>
</main>

<?php
include('../footer.php');
?>