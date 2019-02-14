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
		<form class="all-forms all-forms_login-form">
			<div class="all-forms__caption">
				Необходимо войти на сайт.
			</div>
			<div class="navbar navbar_center">
				<a class="navbar__a" href="/index.php">Вернуться на главную</a>
			</div>
		</form>
	<?php else: ?>
		<form class="all-forms all-forms_login-form" action="add_new_warrior.php" method="post">
			<div class="all-forms__caption">Укажите характеристики:</div>
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
			<input hidden="true" type="text" name="id" value= <?= $warrior["id"] ?>  >
			<input class="all-forms__input-text all-forms__input-text_center" type="text" name="name" placeholder="Имя бойца" value= <?= $warrior["name"] ?> >
			<input class="all-forms__input-text all-forms__input-text_center" type="text" name="hp" placeholder="Жизнь" value= <?= $warrior["hp"] ?> >
			<input class="all-forms__input-text all-forms__input-text_center" type="text" name="attack" placeholder="Атака" value= <?= $warrior["attack"] ?> >
			<input class="all-forms__input-text all-forms__input-text_center" type="text" name="shield" placeholder="Защита" value= <?= $warrior["shield"] ?> >
			<input class="all-forms__btn all-forms__btn_center" type="submit" value="<?= $bnt_val ?>" name="submit" >
		</form>
	<?php endif ?>
</main>

<?php
include('../footer.php');
?>