<?php
include('../header.php');
include('../navbar.php');
?>

<main class="main-block">
	
	
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
		<form class="all-forms all-forms_warriors-form" action="/game/new_warrior.php" method="post">
			<div class="all-forms__caption">
				Бойцы:
			</div>
	
			<?php 
				$warriors = get_user_warriors( $_SESSION['user_id'] );
			?>
			<?php if( count($warriors) === 0): ?>
				Ещё не создано ни одного бойца.<br>
			<?php else: ?>
				<table class="all-forms__table all-forms__table_center">
					<tr class="all-forms__table__tr">
						<th class="all-forms__table__th">Имя бойца</th>
						<th class="all-forms__table__th"><img class='warrior-str__element__img' src='/img/hp16.png'>Жизнь</th>
						<th class="all-forms__table__th"><img class='warrior-str__element__img' src='/img/attack16.png'>Атака</th>
						<th class="all-forms__table__th"><img class='warrior-str__element__img' src='/img/shield16.png'>Защита</th>
						<th class="all-forms__table__th">#</th>
						<th class="all-forms__table__th">#</th>
					</tr>
					<?php foreach($warriors as $warrior): ?>
						<tr class="all-forms__table__tr">
							<td class="all-forms__table__td"><?= $warrior["name"] ?></td>
							<td class="all-forms__table__td"><?= $warrior["hp"] ?></td>
							<td class="all-forms__table__td"><?= $warrior["attack"] ?></td>
							<td class="all-forms__table__td"><?= $warrior["shield"] ?></td>
							<td class="all-forms__table__td"><a href="/game/new_warrior.php?id=<?= $warrior["id"] ?>">edit<a></td>
							<td class="all-forms__table__td">в бой</td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php endif ?>
			<input class="all-forms__btn all-forms__btn_center" type="submit" value="Создать нового бойца" name="submit" >
		</form>

		<!-- Панель только для Админа: Создать ботов -->
		<?php if( $_SESSION['user_status'] == 1 ): ?>
			<form class="all-forms all-forms_warriors-form" action="/game/add_bots.php" method="post">
				<div class="all-forms__caption">
					Создать ботов:
				</div>
				<input class="all-forms__input-text all-forms__input-text_center" type="text" name="lvl_min" placeholder="min уровень">
				<input class="all-forms__input-text all-forms__input-text_center" type="text" name="lvl_max" placeholder="max уровень">
				<input class="all-forms__input-text all-forms__input-text_center" type="text" name="value" placeholder="количество">
				<input class="all-forms__btn all-forms__btn_center" type="submit" value="Создать" name="submit" >
			</form>
			<br><br>
		<?php endif;?>

	<?php endif ?>

	
</main>

<?php
include('../footer.php');
?>