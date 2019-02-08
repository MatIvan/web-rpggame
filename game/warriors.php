<?php
include('../header.php');
include('../navbar.php');
?>

<main>
	<div class="caption">
	Бойцы:
	</div>
	
	<?php if( empty($_SESSION['user_id']) ): ?>
		<section class="form" id="login_error_form">
			Необходимо войти на сайт.";
			<br><br>
			<a href="/index.php">Вернуться на главную</a>
			<br><br>
		</section>
	<?php else: ?>
		<section class="form" id="warriors_form">
			<?php 
				$warriors = get_user_warriors( $_SESSION['user_id'] );
			?>
			<?php if( count($warriors) === 0): ?>
				Ещё не создано ни одного бойца.
			<?php else: ?>
				<table id="warriors_table">
					<tr>
						<th>Имя бойца</th>
						<th>Баланс</th>
						<th>Жизнь</th>
						<th>Атака</th>
						<th>Защита</th>
						<th>#</th>
						<th>#</th>
					</tr>
					<?php foreach($warriors as $warrior): ?>
						<tr>
							<td><?= $warrior["name"] ?></td>
							<td><?= $warrior["balance"] ?></td>
							<td><?= $warrior["hp"] ?></td>
							<td><?= $warrior["attack"] ?></td>
							<td><?= $warrior["shield"] ?></td>
							<td>edit</td>
							<td>в бой</td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php endif ?>
			<form action="/game/new_warrior.php" method="post" id="btn_new_war">
				<input type="submit" value="Создать нового бойца" />
			</form>
		</section>
	<?php endif ?>

	
</main>

<?php
include('../footer.php');
?>