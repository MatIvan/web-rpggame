<?php
include('../header.php');
include('../navbar.php');
?>

<main>
	<div class="caption">
	Выбор аппонента:
	</div>
	
	<?php if( empty($_SESSION['user_id']) ): ?>
		<section class="form" id="login_error_form">
			Необходимо войти на сайт.";
			<br><br>
			<a href="/index.php">Вернуться на главную</a>
			<br><br>
		</section>
	<?php else: ?>
		<section class="form" id="selection_form">
			<section id="my_warriors_form">
				<?php 
					$warriors = get_user_warriors( $_SESSION['user_id'] );
				?>
				<?php if( count($warriors) === 0): ?>
					Ещё не создано ни одного бойца.
				<?php else: ?>
					<table class="warriors_table small_table" id="my_warriors_table">
						Мои бойцы:
						<tr>
							<th>ID</th>
							<th>Имя бойца</th>
							<th>TTX</th>
						</tr>
						<?php foreach($warriors as $warrior): ?>
							<tr>
								<td><?= $warrior["id"] ?></td>
								<td><?= $warrior["name"] ?></td>
								<td>
									<?= $warrior["level"] ?> (
									<?= $warrior["hp"] ?> / 
									<?= $warrior["attack"] ?> / 
									<?= $warrior["shield"] ?> )
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php endif ?>
			</section>
			<section id="apponents_form">
				<?php 
					$apponents = get_user_apponents( $_SESSION['user_id'] );
				?>
				<?php if( count($apponents) === 0): ?>
					Нет подходящих аппонентов.
				<?php else: ?>
					<table class="warriors_table small_table" id="apponents_table">
						Аппоненты:
						<tr>
							<th>ID</th>
							<th>Имя бойца</th>
							<th>Уровень</th>
						</tr>
						<?php foreach($apponents as $apponent): ?>
							<tr>
								<td><?= $apponent["id"] ?></td>
								<td><?= $apponent["name"] ?></td>
								<td><?= $apponent["level"] ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php endif ?>
			</section>
		</section>
	<?php endif ?>

	
</main>

<?php
include('../footer.php');
?>