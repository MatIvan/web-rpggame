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
				Ещё не создано ни одного бойца.
			<?php else: ?>
				<table class="all-forms__table all-forms__table_center">
					<tr class="all-forms__table__tr">
						<th class="all-forms__table__th">Имя бойца</th>
						<th class="all-forms__table__th">Жизнь</th>
						<th class="all-forms__table__th">Атака</th>
						<th class="all-forms__table__th">Защита</th>
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
	<?php endif ?>

	
</main>

<?php
include('../footer.php');
?>